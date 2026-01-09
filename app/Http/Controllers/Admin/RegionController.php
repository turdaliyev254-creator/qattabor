<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $regions = Region::orderBy('order')->paginate(20);
        return view('admin.regions.index', compact('regions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.regions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:regions',
            'name_uz' => 'required|string|max:255',
            'name_ru' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:regions',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        Region::create($validated);

        return redirect()->route('admin.regions.index')
            ->with('success', 'Region created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Region $region)
    {
        $region->load(['locations', 'places']);
        return view('admin.regions.show', compact('region'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Region $region)
    {
        return view('admin.regions.edit', compact('region'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Region $region)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:regions,name,' . $region->id,
            'name_uz' => 'required|string|max:255',
            'name_ru' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:regions,slug,' . $region->id,
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        $region->update($validated);

        return redirect()->route('admin.regions.index')
            ->with('success', 'Region updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Region $region)
    {
        // Check if region has locations
        if ($region->locations()->count() > 0) {
            return redirect()->route('admin.regions.index')
                ->with('error', 'Cannot delete region with associated locations.');
        }

        $region->delete();

        return redirect()->route('admin.regions.index')
            ->with('success', 'Region deleted successfully.');
    }
}
