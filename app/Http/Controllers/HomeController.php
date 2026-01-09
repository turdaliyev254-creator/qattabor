<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Place;
use App\Models\Location;
use App\Models\Region;
use App\Models\Banner;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Show all categories
        $categories = Category::withCount('subcategories')
            ->take(10)
            ->get();
        
        // Filter popular places by region if selected
        $popularPlacesQuery = Place::where('is_popular', true)->with(['category', 'location']);
        
        // Get region from request or use default (first region)
        $regionName = $request->input('region');
        
        // If no region specified, use the first active region as default
        if (!$regionName) {
            $defaultRegion = Region::where('is_active', true)->orderBy('order')->first();
            if ($defaultRegion) {
                $regionName = $defaultRegion->localized_name;
            }
        }
        
        // Filter by region name (localized name from frontend)
        if ($regionName) {
            // Find region by any of its localized names
            $region = Region::where('name', $regionName)
                ->orWhere('name_uz', $regionName)
                ->orWhere('name_ru', $regionName)
                ->orWhere('name_en', $regionName)
                ->first();
            
            if ($region) {
                // Get all location IDs for this region
                $locationIds = Location::where('region_id', $region->id)->pluck('id');
                $popularPlacesQuery->whereIn('location_id', $locationIds);
            }
        }
        
        $popularPlaces = $popularPlacesQuery->take(6)->get();
        $locations = Location::all();
        $banners = Banner::active()->get();

        return view('welcome', compact('categories', 'popularPlaces', 'locations', 'banners'));
    }

    public function allCategories()
    {
        // Show all categories
        $categories = Category::withCount('subcategories')
            ->get();
        
        return view('categories', compact('categories'));
    }
}
