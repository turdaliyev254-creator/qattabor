<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Location;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $places = Place::with(['category', 'location'])->latest()->paginate(10);
        return view('admin.places.index', compact('places'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $locations = Location::all();
        return view('admin.places.create', compact('categories', 'locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'required|exists:locations,id',
            'address' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'phone' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'image_url' => 'nullable|url',
            'is_popular' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        // Handle checkbox boolean values if not present in request
        $validated['is_popular'] = $request->has('is_popular');
        $validated['is_featured'] = $request->has('is_featured');

        Place::create($validated);

        return redirect()->route('admin.places.index')
            ->with('success', 'Place created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Place $place)
    {
        return view('admin.places.show', compact('place'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Place $place)
    {
        $categories = Category::all();
        $locations = Location::all();
        return view('admin.places.edit', compact('place', 'categories', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Place $place)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'required|exists:locations,id',
            'address' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'phone' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'image_url' => 'nullable|url',
            'is_popular' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        if ($place->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        
        $validated['is_popular'] = $request->has('is_popular');
        $validated['is_featured'] = $request->has('is_featured');

        $place->update($validated);

        return redirect()->route('admin.places.index')
            ->with('success', 'Place updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Place $place)
    {
        $place->delete();

        return redirect()->route('admin.places.index')
            ->with('success', 'Place deleted successfully.');
    }
}
