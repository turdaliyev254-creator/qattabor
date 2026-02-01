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
            
            $query = Subcategory::with(['category', 'children' => function($q) {
                $q->withCount('places')->ordered();
            }])->withCount(['places', 'children']);
            
            // Filter by category if provided (nested route)
            if ($category && $category->id) {
                $category->load(['subcategories' => function($q) {
                    $q->withCount('places');
                }]);
                $query->where('category_id', $category->id);
            }
            
            // Only show parent subcategories (not children) - children are shown nested within their parent
            $query->whereNull('parent_id');
            
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
        
        // Get parent subcategories (only parents, not sub-subcategories)
        $parentSubcategories = collect();
        if ($category && $category->id) {
            $parentSubcategories = Subcategory::where('category_id', $category->id)
                ->parents()
                ->orderBy('name')
                ->get();
        }
        
        return view('admin.subcategories.create', compact('category', 'categories', 'parentSubcategories'));
    }

    /**
     * Show the form for creating a child subcategory.
     */
    public function createChild()
    {
        $categories = Category::orderBy('name')->get();
        
        return view('admin.subcategories.create-child', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Category $category = null)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'name_uz' => 'nullable|string|max:255',
            'name_ru' => 'nullable|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'category_id' => $category ? 'nullable' : 'required|exists:categories,id',
            'parent_id' => 'nullable|exists:subcategories,id',
        ]);

        // Use first available language for name if main name not provided
        if (empty($validated['name'])) {
            $validated['name'] = $validated['name_uz'] ?? $validated['name_ru'] ?? $validated['name_en'] ?? 'Unnamed';
        }

        $validated['slug'] = Str::slug($validated['name']);
        
        // If parent_id is provided, validate it
        if ($request->parent_id) {
            $parent = Subcategory::findOrFail($request->parent_id);
            $categoryId = $category ? $category->id : $request->category_id;
            
            // Must belong to same category
            if ($parent->category_id != $categoryId) {
                return back()->withErrors(['parent_id' => 'Parent subcategory must belong to the same category.'])->withInput();
            }
            
            // Ensure parent doesn't already have a parent (limit to 2 levels)
            if ($parent->parent_id) {
                return back()->withErrors(['parent_id' => 'Cannot create more than 2 levels of subcategories.'])->withInput();
            }
        }
        
        // Use category from route parameter if available, otherwise from form
        $categoryId = $category ? $category->id : $validated['category_id'];
        $validated['category_id'] = $categoryId;
        
        // Generate unique slug
        $baseSlug = \Illuminate\Support\Str::slug($validated['name']);
        if ($validated['parent_id'] ?? null) {
            // For nested subcategories, append parent slug to make it unique
            $parent = Subcategory::find($validated['parent_id']);
            $slug = $parent->slug . '-' . $baseSlug;
        } else {
            $slug = $baseSlug;
        }
        
        // Ensure uniqueness by appending number if needed
        $originalSlug = $slug;
        $count = 1;
        while (Subcategory::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }
        $validated['slug'] = $slug;
        
        $validated['order'] = (Subcategory::where('category_id', $categoryId)->max('order') ?? 0) + 1;

        Subcategory::create($validated);

        // Redirect based on which route was used
        if ($category) {
            return redirect()->route('admin.categories.subcategories.index', $category)
                ->with('success', 'Subcategory created successfully.');
        }
        
        return redirect()->route('admin.subcategories.index')
            ->with('success', 'Subcategory created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subcategory $subcategory)
    {
        // Load children with places count
        $subcategory->load(['children' => function($query) {
            $query->withCount('places')->ordered();
        }, 'category']);
        
        return view('admin.subcategories.show', compact('subcategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subcategory $subcategory)
    {
        $categories = Category::all();
        
        // Get parent subcategories (only parents, not sub-subcategories)
        $parentSubcategories = Subcategory::where('category_id', $subcategory->category_id)
            ->where('id', '!=', $subcategory->id)  // Exclude current subcategory
            ->parents()
            ->orderBy('name')
            ->get();
        
        return view('admin.subcategories.edit', compact('subcategory', 'categories', 'parentSubcategories'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subcategory $subcategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_uz' => 'nullable|string|max:255',
            'name_ru' => 'nullable|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'icon' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:subcategories,id',
        ]);

        // If parent_id is provided, validate it
        if ($request->parent_id) {
            // Can't set itself as parent
            if ($request->parent_id == $subcategory->id) {
                return back()->withErrors(['parent_id' => 'A subcategory cannot be its own parent.'])->withInput();
            }
            
            $parent = Subcategory::findOrFail($request->parent_id);
            
            // Must belong to same category
            if ($parent->category_id != $request->category_id) {
                return back()->withErrors(['parent_id' => 'Parent subcategory must belong to the same category.'])->withInput();
            }
            
            // Ensure parent doesn't already have a parent (limit to 2 levels)
            if ($parent->parent_id) {
                return back()->withErrors(['parent_id' => 'Cannot create more than 2 levels of subcategories.'])->withInput();
            }
            
            // Can't set a child as parent (prevent circular reference)
            if ($parent->parent_id == $subcategory->id) {
                return back()->withErrors(['parent_id' => 'Cannot set a child subcategory as parent.'])->withInput();
            }
        }

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

    /**
     * Get parent subcategories for a category (AJAX endpoint)
     */
    public function getParents(Request $request)
    {
        $categoryId = $request->input('category_id');
        $excludeId = $request->input('exclude_id'); // To exclude current subcategory when editing
        
        $query = Subcategory::where('category_id', $categoryId)
            ->parents()  // Only parent subcategories
            ->orderBy('name');
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        $subcategories = $query->get(['id', 'name']);
        
        return response()->json($subcategories);
    }
}
