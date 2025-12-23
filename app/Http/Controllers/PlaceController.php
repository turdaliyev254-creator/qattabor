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

    public function byCategory(Category $category)
    {
        $subcategories = $category->subcategories()
            ->withCount('places')
            ->orderBy('name')
            ->get();
        
        $places = $category->places()
            ->with(['subcategory', 'location'])
            ->latest()
            ->paginate(12);

        return view('places.by-category', compact('category', 'subcategories', 'places'));
    }

    public function bySubcategory(Category $category, Subcategory $subcategory)
    {
        $places = $subcategory->places()
            ->with(['category', 'location'])
            ->latest()
            ->paginate(12);

        return view('places.by-subcategory', compact('category', 'subcategory', 'places'));
    }

    public function show(Place $place)
    {
        $place->load(['category', 'subcategory', 'location']);
        
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
