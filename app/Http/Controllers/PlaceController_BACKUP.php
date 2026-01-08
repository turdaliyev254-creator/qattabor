<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Location;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    public function popularPlaces(Request $request)
    {
        $query = Place::with(['category', 'subcategory', 'location'])
            ->where('is_popular', true);

        // Filter by location if selected
        if ($request->has('location') && $request->location) {
            $query->where('location_id', $request->location);
        }

        $places = $query->latest()->paginate(12);
        $locations = Location::orderBy('name')->get();

        return view('places.popular', compact('places', 'locations'));
    }

    public function byCategory(Request $request, Category $category)
    {
        $subcategories = $category->subcategories()
            ->withCount('places')
            ->orderBy('name')
            ->get();
        
        $placesQuery = $category->places()->with(['subcategory', 'location']);
        
        // Filter by region if provided
        if ($request->has('region') && $request->region) {
            $placesQuery->whereHas('location', function($query) use ($request) {
                $query->where('region', $request->region);
            });
        }
        
        $places = $placesQuery->latest()->paginate(12);

        return view('places.by-category', compact('category', 'subcategories', 'places'));
    }

    public function bySubcategory(Request $request, Category $category, Subcategory $subcategory)
    {
        $placesQuery = $subcategory->places()->with(['category', 'location']);
        
        // Filter by region if provided
        if ($request->has('region') && $request->region) {
            $placesQuery->whereHas('location', function($query) use ($request) {
                $query->where('region', $request->region);
            });
        }
        
        $places = $placesQuery->latest()->paginate(12);

        return view('places.by-subcategory', compact('category', 'subcategory', 'places'));
    }

    public function show(Place $place)
    {
        $place->load(['category', 'subcategory', 'location']);
        
        // Track recently viewed places in session
        $recentlyViewed = session()->get('recently_viewed', []);
        
        // Remove if already exists (to move it to front)
        $recentlyViewed = array_diff($recentlyViewed, [$place->id]);
        
        // Add to beginning of array
        array_unshift($recentlyViewed, $place->id);
        
        // Keep only last 10
        $recentlyViewed = array_slice($recentlyViewed, 0, 10);
        
        // Save back to session
        session()->put('recently_viewed', $recentlyViewed);
        
        // Get related places from same subcategory or category
        $relatedPlaces = Place::where('id', '!=', $place->id)
            ->where(function($query) use ($place) {
                if ($place->subcategory_id) {
                    $query->where('subcategory_id', $place->subcategory_id);
                } else {
                    $query->where('category_id', $place->category_id);
                }
            })
            ->with(['category', 'subcategory', 'location'])
            ->limit(6)
            ->get();

        // Check if place is saved by current user
        $isSaved = auth()->check() && auth()->user()->savedPlaces()->where('place_id', $place->id)->exists();

        return view('places.show', compact('place', 'relatedPlaces', 'isSaved'));
    }

    public function map()
    {
        $places = Place::with(['category', 'subcategory', 'location'])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

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
