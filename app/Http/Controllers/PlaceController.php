<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Location;
use App\Models\Region;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    public function popularPlaces(Request $request)
    {
        $query = Place::with(['category', 'subcategory', 'location'])
            ->withCount(['approvedComments as reviews_count' => function($query) {
                $query->whereNotNull('rating');
            }])
            ->where('is_popular', true);

        // Get region from request or use default (first region)
        $regionName = $request->input('region');
        
        // If no region specified, use the first active region as default
        if (!$regionName) {
            $defaultRegion = Region::where('is_active', true)->orderBy('order')->first();
            if ($defaultRegion) {
                $regionName = $defaultRegion->localized_name;
            }
        }
        
        // Filter by region name
        if ($regionName) {
            $region = Region::where('name', $regionName)
                ->orWhere('name_uz', $regionName)
                ->orWhere('name_ru', $regionName)
                ->orWhere('name_en', $regionName)
                ->first();
            
            if ($region) {
                $locationIds = Location::where('region_id', $region->id)->pluck('id');
                $query->whereIn('location_id', $locationIds);
            }
        }

        $places = $query->latest()->paginate(12);
        $locations = Location::orderBy('name')->get();

        return view('places.popular', compact('places', 'locations'));
    }

    public function byCategory(Request $request, Category $category)
    {
        // Get region from request or use default (first region)
        $regionName = $request->input('region');
        
        // If no region specified, use the first active region as default
        if (!$regionName) {
            $defaultRegion = Region::where('is_active', true)->orderBy('order')->first();
            if ($defaultRegion) {
                $regionName = $defaultRegion->localized_name;
            }
        }
        
        // Find region and get location IDs
        $locationIds = [];
        if ($regionName) {
            $region = Region::where('name', $regionName)
                ->orWhere('name_uz', $regionName)
                ->orWhere('name_ru', $regionName)
                ->orWhere('name_en', $regionName)
                ->first();
            
            if ($region) {
                $locationIds = Location::where('region_id', $region->id)->pluck('id')->toArray();
            }
        }
        
        // Get subcategories with place count filtered by location
        $subcategories = $category->subcategories()
            ->withCount(['places' => function($query) use ($locationIds) {
                if (!empty($locationIds)) {
                    $query->whereIn('location_id', $locationIds);
                }
            }])
            ->orderBy('name')
            ->get();
        
        $placesQuery = $category->places()
            ->with(['subcategory', 'location'])
            ->withCount(['approvedComments as reviews_count' => function($query) {
                $query->whereNotNull('rating');
            }]);
        
        // Filter places by location
        if (!empty($locationIds)) {
            $placesQuery->whereIn('location_id', $locationIds);
        }
        
        $places = $placesQuery->latest()->paginate(12);

        return view('places.by-category', compact('category', 'subcategories', 'places'));
    }

    public function bySubcategory(Request $request, Category $category, Subcategory $subcategory)
    {
        $placesQuery = $subcategory->places()
            ->with(['category', 'location'])
            ->withCount(['approvedComments as reviews_count' => function($query) {
                $query->whereNotNull('rating');
            }]);
        
        // Get region from request or use default (first region)
        $regionName = $request->input('region');
        
        // If no region specified, use the first active region as default
        if (!$regionName) {
            $defaultRegion = Region::where('is_active', true)->orderBy('order')->first();
            if ($defaultRegion) {
                $regionName = $defaultRegion->localized_name;
            }
        }
        
        // Filter by region name
        if ($regionName) {
            $region = Region::where('name', $regionName)
                ->orWhere('name_uz', $regionName)
                ->orWhere('name_ru', $regionName)
                ->orWhere('name_en', $regionName)
                ->first();
            
            if ($region) {
                $locationIds = Location::where('region_id', $region->id)->pluck('id');
                $placesQuery->whereIn('location_id', $locationIds);
            }
        }
        
        $places = $placesQuery->latest()->paginate(12);

        return view('places.by-subcategory', compact('category', 'subcategory', 'places'));
    }

    public function show(Request $request, Place $place)
    {
        $place->load(['category', 'subcategory', 'location', 'images' => function($query) {
            $query->orderBy('order');
        }]);
        
        // Track recently viewed places in session
        $recentlyViewed = session()->get('recently_viewed', []);
        $recentlyViewed = array_diff($recentlyViewed, [$place->id]);
        array_unshift($recentlyViewed, $place->id);
        $recentlyViewed = array_slice($recentlyViewed, 0, 10);
        session()->put('recently_viewed', $recentlyViewed);
        
        // Get related places from same subcategory or category AND same location
        $relatedPlaces = Place::where('id', '!=', $place->id)
            ->where('location_id', $place->location_id)  // Filter by same location
            ->where(function($query) use ($place) {
                if ($place->subcategory_id) {
                    $query->where('subcategory_id', $place->subcategory_id);
                } else {
                    $query->where('category_id', $place->category_id);
                }
            })
            ->with(['category', 'subcategory', 'location'])
            ->withCount(['approvedComments as reviews_count' => function($query) {
                $query->whereNotNull('rating');
            }])
            ->limit(6)
            ->get();

        // Check if place is saved by current user
        $isSaved = auth()->check() && auth()->user()->savedPlaces()->where('place_id', $place->id)->exists();

        return view('places.show', compact('place', 'relatedPlaces', 'isSaved'));
    }

    public function map(Request $request)
    {
        $placesQuery = Place::with(['category', 'subcategory', 'location'])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude');

        // Get region from request or use default (first region)
        $regionName = $request->input('region');
        
        // If no region specified, use the first active region as default
        if (!$regionName) {
            $defaultRegion = Region::where('is_active', true)->orderBy('order')->first();
            if ($defaultRegion) {
                $regionName = $defaultRegion->localized_name;
            }
        }
        
        // Filter by region name
        if ($regionName) {
            $region = Region::where('name', $regionName)
                ->orWhere('name_uz', $regionName)
                ->orWhere('name_ru', $regionName)
                ->orWhere('name_en', $regionName)
                ->first();
            
            if ($region) {
                $locationIds = Location::where('region_id', $region->id)->pluck('id');
                $placesQuery->whereIn('location_id', $locationIds);
            }
        }

        $places = $placesQuery->get();

        return view('map.index', compact('places'));
    }

    public function savedPlaces()
    {
        $places = auth()->user()
            ->savedPlaces()
            ->with(['category', 'subcategory', 'location'])
            ->latest('saved_places.created_at')
            ->paginate(12);

        return view('places.saved', compact('places'));
    }

    public function save(Place $place)
    {
        auth()->user()->savedPlaces()->attach($place->id);

        return response()->json([
            'success' => true,
            'message' => __('Place saved successfully')
        ]);
    }

    public function unsave(Place $place)
    {
        auth()->user()->savedPlaces()->detach($place->id);

        return response()->json([
            'success' => true,
            'message' => __('Place removed from saved')
        ]);
    }
}
