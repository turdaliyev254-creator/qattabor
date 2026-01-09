<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LocationController extends Controller
{
    /**
     * Detect region from coordinates using Yandex Maps API
     */
    public function detectRegion(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric|between:-90,90',
            'lon' => 'required|numeric|between:-180,180',
        ]);

        $lat = $request->input('lat');
        $lon = $request->input('lon');

        try {
            // Use Yandex Maps Geocoder API
            $response = Http::get('https://geocode-maps.yandex.ru/1.x/', [
                'geocode' => "{$lon},{$lat}",
                'format' => 'json',
                'kind' => 'province',
                'lang' => app()->getLocale(),
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Extract region name from Yandex response
                $geoObject = $data['response']['GeoObjectCollection']['featureMember'][0]['GeoObject'] ?? null;
                
                if ($geoObject) {
                    $addressComponents = $geoObject['metaDataProperty']['GeocoderMetaData']['Address']['Components'] ?? [];
                    
                    // Find province/region in address components
                    $detectedRegion = null;
                    foreach ($addressComponents as $component) {
                        if ($component['kind'] === 'province') {
                            $detectedRegion = $component['name'];
                            break;
                        }
                    }
                    
                    // Also check country to ensure we're in Uzbekistan
                    $country = null;
                    foreach ($addressComponents as $component) {
                        if ($component['kind'] === 'country') {
                            $country = $component['name'];
                            break;
                        }
                    }
                    
                    // Check if user is in Uzbekistan
                    $isInUzbekistan = stripos($country, 'Uzbekistan') !== false || 
                                     stripos($country, 'Узбекистан') !== false ||
                                     stripos($country, 'Oʻzbekiston') !== false;
                    
                    if (!$isInUzbekistan) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Location is outside Uzbekistan',
                            'region' => null,
                            'country' => $country,
                        ]);
                    }
                    
                    if ($detectedRegion) {
                        // Match detected region name with database
                        $region = $this->matchRegionToDatabase($detectedRegion);
                        
                        if ($region) {
                            return response()->json([
                                'success' => true,
                                'region' => $region->localized_name,
                                'region_data' => [
                                    'name' => $region->name,
                                    'name_uz' => $region->name_uz,
                                    'name_ru' => $region->name_ru,
                                    'name_en' => $region->name_en,
                                ],
                            ]);
                        }
                    }
                }
            }
            
            // Fallback: Use distance-based matching
            $region = Region::findByCoordinates($lat, $lon);
            
            if ($region) {
                return response()->json([
                    'success' => true,
                    'region' => $region->localized_name,
                    'region_data' => [
                        'name' => $region->name,
                        'name_uz' => $region->name_uz,
                        'name_ru' => $region->name_ru,
                        'name_en' => $region->name_en,
                    ],
                    'method' => 'distance-based',
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Could not determine region',
                'region' => null,
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Geocoding service error: ' . $e->getMessage(),
                'region' => null,
            ], 500);
        }
    }
    
    /**
     * Match detected region name to database region
     */
    private function matchRegionToDatabase($detectedRegion)
    {
        $normalized = mb_strtolower(trim($detectedRegion));
        
        // Remove common suffixes
        $normalized = preg_replace('/(region|oblast|viloyat|viloyati)/i', '', $normalized);
        $normalized = trim($normalized);
        
        // Search in all language variants
        return Region::where('is_active', true)
            ->where(function($query) use ($normalized) {
                $query->whereRaw('LOWER(name) LIKE ?', ["%{$normalized}%"])
                      ->orWhereRaw('LOWER(name_uz) LIKE ?', ["%{$normalized}%"])
                      ->orWhereRaw('LOWER(name_ru) LIKE ?', ["%{$normalized}%"])
                      ->orWhereRaw('LOWER(name_en) LIKE ?', ["%{$normalized}%"]);
            })
            ->orderBy('order')
            ->first();
    }
}
