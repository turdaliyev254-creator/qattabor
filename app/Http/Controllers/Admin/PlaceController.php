<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Location;
use App\Models\Place;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $places = Place::with(['category', 'subcategory', 'location', 'owner'])->latest()->paginate(10);
        return view('admin.places.index', compact('places'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::with('subcategories')->get();
        $locations = Location::all();
        $users = User::orderBy('name')->get();
        return view('admin.places.create', compact('categories', 'locations', 'users'));
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
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'location_id' => 'required|exists:locations,id',
            'owner_id' => 'nullable|exists:users,id',
            'address' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'phone' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'navigate_link' => 'nullable|url|max:255',
            'working_hours' => 'nullable|json',
            'instagram' => 'nullable|url|max:255',
            'telegram' => 'nullable|url|max:255',
            'facebook' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'image_url' => 'nullable|url',
            'images.*' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
            'is_popular' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        // Handle checkbox boolean values if not present in request
        $validated['is_popular'] = $request->has('is_popular');
        $validated['is_featured'] = $request->has('is_featured');
        
        // Decode working_hours JSON string
        if (isset($validated['working_hours'])) {
            $validated['working_hours'] = json_decode($validated['working_hours'], true);
        }

        $place = Place::create($validated);

        // Handle multiple images upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $imagePath = $image->store('places', 'public');
                $place->images()->create([
                    'image_path' => $imagePath,
                    'order' => $index,
                ]);
            }
        }

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
        $categories = Category::with('subcategories')->get();
        $locations = Location::all();
        $users = User::orderBy('name')->get();
        return view('admin.places.edit', compact('place', 'categories', 'locations', 'users'));
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
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'location_id' => 'required|exists:locations,id',
            'owner_id' => 'nullable|exists:users,id',
            'address' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'phone' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'navigate_link' => 'nullable|url|max:255',
            'working_hours' => 'nullable|json',
            'instagram' => 'nullable|url|max:255',
            'telegram' => 'nullable|url|max:255',
            'facebook' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
            'images.*' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
            'is_popular' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        if ($place->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        
        // Decode working_hours JSON string
        if (isset($validated['working_hours'])) {
            $validated['working_hours'] = json_decode($validated['working_hours'], true);
        }
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($place->image_url && \Storage::disk('public')->exists($place->image_url)) {
                \Storage::disk('public')->delete($place->image_url);
            }
            $imagePath = $request->file('image')->store('places', 'public');
            $validated['image_url'] = $imagePath;
        }
        
        // Handle multiple images upload
        if ($request->hasFile('images')) {
            $existingCount = $place->images()->count();
            foreach ($request->file('images') as $index => $image) {
                $imagePath = $image->store('places', 'public');
                $place->images()->create([
                    'image_path' => $imagePath,
                    'order' => $existingCount + $index,
                ]);
            }
        }
        
        $validated['is_popular'] = $request->has('is_popular');
        $validated['is_featured'] = $request->has('is_featured');

        unset($validated['image'], $validated['images']);
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

    public function deleteImage($imageId)
    {
        $image = \App\Models\PlaceImage::findOrFail($imageId);
        
        // Delete the file
        if (\Storage::disk('public')->exists($image->image_path)) {
            \Storage::disk('public')->delete($image->image_path);
        }
        
        // Delete the record
        $image->delete();

        return response()->json(['success' => true]);
    }
}
