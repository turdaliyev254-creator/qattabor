<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Subcategory;
use App\Services\BrandIconService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    protected $brandIconService;

    public function __construct(BrandIconService $brandIconService)
    {
        $this->brandIconService = $brandIconService;
    }

    /**
     * Display a listing of brands for a subcategory.
     */
    public function index(Subcategory $subcategory)
    {
        $subcategory->load('category');
        $brands = $subcategory->brands()->withCount('places')->ordered()->get();
        
        return view('admin.brands.index', compact('subcategory', 'brands'));
    }

    /**
     * Show the form for creating a new brand.
     */
    public function create(Subcategory $subcategory)
    {
        $subcategory->load('category');
        return view('admin.brands.create', compact('subcategory'));
    }

    /**
     * Store a newly created brand in storage.
     */
    public function store(Request $request, Subcategory $subcategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_uz' => 'nullable|string|max:255',
            'name_ru' => 'nullable|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'icon' => 'required|image|mimes:svg,png,jpg,jpeg|max:2048',
        ]);

        // Handle icon upload
        $iconFilename = $this->brandIconService->upload($request->file('icon'));
        
        $brand = new Brand($validated);
        $brand->subcategory_id = $subcategory->id;
        $brand->icon = $iconFilename;
        $brand->save();

        return redirect()->route('admin.subcategories.brands.index', $subcategory)
            ->with('success', 'Brand created successfully.');
    }

    /**
     * Show the form for editing the specified brand.
     */
    public function edit(Brand $brand)
    {
        $subcategory = $brand->subcategory;
        $subcategory->load('category');
        return view('admin.brands.edit', compact('subcategory', 'brand'));
    }

    /**
     * Update the specified brand in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        $subcategory = $brand->subcategory;
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_uz' => 'nullable|string|max:255',
            'name_ru' => 'nullable|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'icon' => 'nullable|image|mimes:svg,png,jpg,jpeg|max:2048',
        ]);

        // Handle icon upload if provided
        if ($request->hasFile('icon')) {
            // Delete old icon
            if ($brand->icon) {
                $this->brandIconService->delete($brand->icon);
            }
            
            $validated['icon'] = $this->brandIconService->upload($request->file('icon'));
        }

        $brand->update($validated);

        return redirect()->route('admin.subcategories.brands.index', $subcategory)
            ->with('success', 'Brand updated successfully.');
    }

    /**
     * Remove the specified brand from storage.
     */
    public function destroy(Brand $brand)
    {
        $subcategory = $brand->subcategory;
        
        // Check if brand has places assigned
        if ($brand->places()->exists()) {
            return redirect()->back()
                ->with('error', 'Cannot delete brand. Please reassign or delete the associated places first.');
        }

        // Delete icon file
        if ($brand->icon) {
            $this->brandIconService->delete($brand->icon);
        }

        $brand->delete();

        // Renumber remaining brands
        Brand::renumberOrders($subcategory->id);

        return redirect()->route('admin.subcategories.brands.index', $subcategory)
            ->with('success', 'Brand deleted successfully.');
    }

    /**
     * Reorder brands via drag and drop.
     */
    public function reorder(Request $request, Subcategory $subcategory)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*' => 'required|integer|exists:brands,id',
        ]);

        foreach ($request->orders as $order => $id) {
            Brand::where('id', $id)
                ->where('subcategory_id', $subcategory->id)
                ->update(['order' => $order + 1]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Brands reordered successfully'
        ]);
    }

    /**
     * Update single brand order.
     */
    public function updateOrder(Request $request, Brand $brand)
    {
        $request->validate([
            'order' => 'required|integer|min:1',
        ]);

        $newOrder = $request->order;
        $oldOrder = $brand->order;
        $subcategoryId = $brand->subcategory_id;

        if ($newOrder !== $oldOrder) {
            // Shift other items within the same subcategory
            if ($newOrder < $oldOrder) {
                // Moving up
                Brand::where('subcategory_id', $subcategoryId)
                    ->whereBetween('order', [$newOrder, $oldOrder - 1])
                    ->increment('order');
            } else {
                // Moving down
                Brand::where('subcategory_id', $subcategoryId)
                    ->whereBetween('order', [$oldOrder + 1, $newOrder])
                    ->decrement('order');
            }

            $brand->order = $newOrder;
            $brand->save();

            Brand::renumberOrders($subcategoryId);
        }

        return redirect()->back()
            ->with('success', 'Brand order updated successfully.');
    }

    /**
     * Get brands for a subcategory (API endpoint).
     */
    public function getBrands(Subcategory $subcategory)
    {
        $brands = $subcategory->brands()
            ->ordered()
            ->get(['id', 'name', 'name_uz', 'name_ru', 'name_en']);

        return response()->json($brands);
    }
}
