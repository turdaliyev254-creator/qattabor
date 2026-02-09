<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Location;
use App\Models\Place;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Subcategory $subcategory = null)
    {
        try {
            $sort = $request->get('sort', 'manual');
            
            $query = Place::with(['category', 'subcategory', 'location', 'owner']);
            
            // Filter by subcategory if provided (nested route)
            if ($subcategory && $subcategory->id) {
                $subcategory->load('category');
                $query->where('subcategory_id', $subcategory->id);
            }
            
            switch ($sort) {
                case 'newest':
                    $query->latest();
                    break;
                case 'oldest':
                    $query->oldest();
                    break;
                case 'alphabetical':
                    $query->orderBy('name', 'asc');
                    break;
                case 'alphabetical_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'manual':
                default:
                    $query->ordered();
                    break;
            }
            
            $places = $query->paginate(10);
            return view('admin.places.index', compact('places', 'sort', 'subcategory'));
            
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.subcategories.index')
                ->with('error', 'Subcategory not found or has been deleted.');
        }
    }

    /**
     * Reorder places
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*' => 'required|integer|exists:places,id',
        ]);

        foreach ($request->orders as $order => $id) {
            Place::where('id', $id)->update(['order' => $order + 1]);
        }

        return response()->json(['success' => true, 'message' => 'Places reordered successfully']);
    }

    /**
     * Update single place order
     */
    public function updateOrder(Request $request, Place $place)
    {
        $request->validate([
            'order' => 'required|integer|min:1',
        ]);

        $newOrder = $request->order;
        $oldOrder = $place->order;
        $subcategoryId = $place->subcategory_id;

        if ($newOrder !== $oldOrder) {
            // Shift other items within the same subcategory
            if ($newOrder < $oldOrder) {
                // Moving up
                Place::where('subcategory_id', $subcategoryId)
                    ->whereBetween('order', [$newOrder, $oldOrder - 1])
                    ->increment('order');
            } else {
                // Moving down
                Place::where('subcategory_id', $subcategoryId)
                    ->whereBetween('order', [$oldOrder + 1, $newOrder])
                    ->decrement('order');
            }

            $place->order = $newOrder;
            $place->save();

            Place::renumberOrders($subcategoryId);
        }

        // Redirect back to the referring page or default to index
        $referer = $request->headers->get('referer');
        if ($referer && str_contains($referer, 'subcategories/')) {
            return redirect()->back()->with('success', 'Place order updated successfully.');
        }

        return redirect()->route('admin.places.index')
            ->with('success', 'Place order updated successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Subcategory $subcategory)
    {
        $subcategory->load('category');
        $categories = Category::with('subcategories')->get();
        $locations = Location::all();
        $users = User::orderBy('name')->get();
        return view('admin.places.create', compact('subcategory', 'categories', 'locations', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Subcategory $subcategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_uz' => 'nullable|string|max:255',
            'name_ru' => 'nullable|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'description_uz' => 'nullable|string',
            'description_ru' => 'nullable|string',
            'description_en' => 'nullable|string',
            'location_id' => 'required|exists:locations,id',
            'brand_id' => 'nullable|exists:brands,id',
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
            'videos.*' => 'nullable|file|mimes:mp4,mov,avi,wmv|max:51200',
            'is_popular' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['category_id'] = $subcategory->category_id;
        $validated['subcategory_id'] = $subcategory->id;
        
        // Handle checkbox boolean values if not present in request
        $validated['is_popular'] = $request->has('is_popular');
        $validated['is_featured'] = $request->has('is_featured');
        
        // Decode working_hours JSON string
        if (isset($validated['working_hours'])) {
            $validated['working_hours'] = json_decode($validated['working_hours'], true);
        }

        // Handle main image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('places', 'public');
            $validated['image_url'] = $imagePath;
        }

        $place = Place::create($validated);

        // Handle multiple images upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $imagePath = $image->store('places', 'public');
                $place->images()->create([
                    'image_path' => $imagePath,
                    'media_type' => 'image',
                    'order' => $index,
                ]);
            }
        }
        
        // Handle multiple videos upload
        if ($request->hasFile('videos')) {
            $existingCount = $place->images()->count();
            foreach ($request->file('videos') as $index => $video) {
                $videoPath = $video->store('places/videos', 'public');
                $place->images()->create([
                    'image_path' => $videoPath,
                    'media_type' => 'video',
                    'order' => $existingCount + $index,
                ]);
            }
        }

        return redirect()->route('admin.subcategories.places.index', $subcategory)
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
            'name_uz' => 'nullable|string|max:255',
            'name_ru' => 'nullable|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'description_uz' => 'nullable|string',
            'description_ru' => 'nullable|string',
            'description_en' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'brand_id' => 'nullable|exists:brands,id',
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
            'videos.*' => 'nullable|file|mimes:mp4,mov,avi,wmv|max:51200',
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
                    'media_type' => 'image',
                    'order' => $existingCount + $index,
                ]);
            }
        }
        
        // Handle multiple videos upload
        if ($request->hasFile('videos')) {
            $existingCount = $place->images()->count();
            foreach ($request->file('videos') as $index => $video) {
                $videoPath = $video->store('places/videos', 'public');
                
                // Generate thumbnail (optional - requires FFMpeg)
                // For now, we'll use a default video icon
                $place->images()->create([
                    'image_path' => $videoPath,
                    'media_type' => 'video',
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
