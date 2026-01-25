<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Category $category = null)
    {
        try {
            $sort = $request->get('sort', 'manual');
            
            $query = Subcategory::with(['category'])->withCount('places');
            
            // Filter by category if provided (nested route)
            if ($category && $category->id) {
                $category->load(['subcategories' => function($q) {
                    $q->withCount('places');
                }]);
                $query->where('category_id', $category->id);
            }
            
            // Search functionality (context-aware)
            if ($request->has('search') && $request->search) {
                $search = $request->search;
                $query->where(function($q) use ($search, $category) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('slug', 'like', '%' . $search . '%');
                    
                    // Only search across all categories if not in nested context
                    if (!$category || !$category->id) {
                        $q->orWhereHas('category', function($q) use ($search) {
                            $q->where('name', 'like', '%' . $search . '%');
                        });
                    }
                });
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
            
            $subcategories = $query->paginate(10);
            return view('admin.subcategories.index', compact('subcategories', 'sort', 'category'));
            
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Category not found or has been deleted.');
        }
    }

    /**
     * Reorder subcategories
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*' => 'required|integer|exists:subcategories,id',
        ]);

        foreach ($request->orders as $order => $id) {
            Subcategory::where('id', $id)->update(['order' => $order + 1]);
        }

        return response()->json(['success' => true, 'message' => 'Subcategories reordered successfully']);
    }

    /**
     * Update single subcategory order
     */
    public function updateOrder(Request $request, Subcategory $subcategory)
    {
        $request->validate([
            'order' => 'required|integer|min:1',
        ]);

        $newOrder = $request->order;
        $oldOrder = $subcategory->order;
        $categoryId = $subcategory->category_id;

        if ($newOrder !== $oldOrder) {
            // Shift other items within the same category
            if ($newOrder < $oldOrder) {
                // Moving up
                Subcategory::where('category_id', $categoryId)
                    ->whereBetween('order', [$newOrder, $oldOrder - 1])
                    ->increment('order');
            } else {
                // Moving down
                Subcategory::where('category_id', $categoryId)
                    ->whereBetween('order', [$oldOrder + 1, $newOrder])
                    ->decrement('order');
            }

            $subcategory->order = $newOrder;
            $subcategory->save();

            Subcategory::renumberOrders($categoryId);
        }

        // Redirect back to the referring page or default to index
        $referer = $request->headers->get('referer');
        if ($referer && str_contains($referer, 'categories/')) {
            return redirect()->back()->with('success', 'Subcategory order updated successfully.');
        }

        return redirect()->route('admin.subcategories.index')
            ->with('success', 'Subcategory order updated successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Category $category)
    {
        $category->load('subcategories');
        $categories = Category::orderBy('name')->get();
        return view('admin.subcategories.create', compact('category', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['category_id'] = $category->id;
        $validated['order'] = Subcategory::where('category_id', $category->id)->max('order') + 1;

        Subcategory::create($validated);

        return redirect()->route('admin.categories.subcategories.index', $category)
            ->with('success', 'Subcategory created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subcategory $subcategory)
    {
        $categories = Category::all();
        return view('admin.subcategories.edit', compact('subcategory', 'categories'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subcategory $subcategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'icon' => 'nullable|string|max:255',
        ]);

        if ($subcategory->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $subcategory->update($validated);

        return redirect()->route('admin.subcategories.index')
            ->with('success', 'Subcategory updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subcategory $subcategory)
    {
        try {
            $subcategory->delete();
            
            return redirect()->route('admin.subcategories.index')
                ->with('success', 'Subcategory deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.subcategories.index')
                ->with('error', 'Cannot delete subcategory: ' . $e->getMessage());
        }
    }
}
