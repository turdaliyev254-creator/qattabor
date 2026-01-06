<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Place;
use App\Models\Location;
use App\Models\Banner;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Show only categories that have subcategories
        $categories = Category::has('subcategories')
            ->withCount('subcategories')
            ->take(10)
            ->get();
        
        // Filter popular places by region if selected
        $popularPlacesQuery = Place::where('is_popular', true)->with(['category', 'location']);
        
        if ($request->has('region') && $request->region) {
            $popularPlacesQuery->whereHas('location', function($query) use ($request) {
                $query->where('region', $request->region);
            });
        }
        
        $popularPlaces = $popularPlacesQuery->take(6)->get();
        $locations = Location::all();
        $banners = Banner::active()->get();

        return view('welcome', compact('categories', 'popularPlaces', 'locations', 'banners'));
    }

    public function allCategories()
    {
        // Show only categories that have subcategories
        $categories = Category::has('subcategories')
            ->withCount('subcategories')
            ->get();
        
        return view('categories', compact('categories'));
    }
}
