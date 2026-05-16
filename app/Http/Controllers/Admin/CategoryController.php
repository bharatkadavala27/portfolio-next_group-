<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache; // ADDED: caching
use Illuminate\Support\Facades\Log;   // ADDED: optional logging (safe to keep)
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryFormRequest;

class CategoryController extends Controller
{
    public function view()
    {
        $categories = Category::with('parentCategory')->whereNull('parent_id')->get();
        return view('frontend.category.index', compact('categories'));
    }

    /**
     * GET /api/categories
     * Returns top-level categories with minimal payload, with pagination + caching.
     *
     * Response:
     * {
     *   "categories": [{id, name, parent_id, has_children}, ...],
     *   "has_more": bool
     * }
     */
    public function getCategories(Request $request)
    {
        // Read pagination params (defaults)
        $perPage = (int) $request->query('per_page', 10);
        $page = (int) $request->query('page', 1);

        // Cache key (per page)
        $cacheKey = "categories:root:pp{$perPage}:p{$page}";

        // Cache for 1 hour (3600 seconds). Uses your configured cache driver (database per .env).
        $result = Cache::remember($cacheKey, 3600, function () use ($perPage, $page) {
            // Query: select only necessary columns and add children_count to avoid N+1
            $paginator = Category::select('id', 'name', 'parent_id')
                ->withCount('children')
                ->whereNull('parent_id')
                ->orderBy('name')
                ->paginate($perPage, ['*'], 'page', $page);

            // Map to minimal shape expected by frontend
            $categories = $paginator->getCollection()->map(function ($cat) {
                return [
                    'id' => $cat->id,
                    'name' => $cat->name,
                    'parent_id' => $cat->parent_id,
                    'has_children' => ($cat->children_count ?? 0) > 0,
                ];
            })->values()->all();

            return [
                'categories' => $categories,
                'has_more' => $paginator->hasMorePages(),
            ];
        });

        return response()->json($result);
    }

    /**
     * GET /api/categories/{categoryId}/children
     * Returns immediate children of a category with minimal payload, pagination + caching.
     *
     * Response:
     * {
     *   "children": [{id, name, parent_id, has_children, image, description}, ...],
     *   "parent": {id, name},
     *   "has_more": bool
     * }
     */
    public function getChildren($categoryId)
    {
        // Use request() helper so signature remains compatible with routes
        $perPage = (int) request()->query('per_page', 10);
        $page = (int) request()->query('page', 1);

        $cacheKey = "categories:{$categoryId}:children:pp{$perPage}:p{$page}";

        try {
            $result = Cache::remember($cacheKey, 3600, function () use ($categoryId, $perPage, $page) {
                // Ensure category exists (will throw ModelNotFoundException if not)
                $parent = Category::select('id', 'name')->findOrFail($categoryId);

                // Query children with minimal columns and children_count
                $paginator = Category::select('id', 'name', 'parent_id', 'image', 'description')
                    ->withCount('children')
                    ->where('parent_id', $categoryId)
                    ->orderBy('name')
                    ->paginate($perPage, ['*'], 'page', $page);

                $children = $paginator->getCollection()->map(function ($child) {
                    return [
                        'id' => $child->id,
                        'name' => $child->name,
                        'parent_id' => $child->parent_id,
                        'has_children' => ($child->children_count ?? 0) > 0,
                        // Keep image & description (same shape as your previous implementation)
                        'image' => $child->image ? asset('uploads/category/' . $child->image) : null,
                        'description' => $child->description,
                    ];
                })->values()->all();

                return [
                    'children' => $children,
                    'parent' => [
                        'id' => $parent->id,
                        'name' => $parent->name,
                    ],
                    'has_more' => $paginator->hasMorePages(),
                ];
            });

            return response()->json($result);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Parent category not found.'], 404);
        } catch (\Exception $e) {
            // Log unexpected error for debugging; return generic message to client
            Log::error('Error fetching subcategories: ' . $e->getMessage(), [
                'category_id' => $categoryId,
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Error fetching subcategories.'], 500);
        }
    }

    public function index()
    {
        $parentCategories = Category::with('children')->whereNull('parent_id')->get();
        return view('admin.category.index', compact('parentCategories'));
    }

    public function show($id)
    {

        $category = Category::findOrFail($id);  // Change this line to find by ID
        return view('frontend.category.show', compact('category'));
    }

    public function create()
    {

        $parentCategories = Category::with('children')->whereNull('parent_id')->get();
        return view('admin.category.create', compact('parentCategories'));
    }

    public function store(CategoryFormRequest $request)
    {
        $validated = $request->validated();

        $category = new Category;
        $category->name = $validated['name'];
        $category->slug = Str::slug($validated['name']); // ✅ fixed
        $category->parent_id = $validated['parent_id'];
        $category->serial_number = $validated['serial_number'] ?? null;
        $category->description = $validated['description'] ?? null;
        $category->show_on_footer = $request->has('show_on_footer') ? 1 : 0;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $path = public_path('uploads/category');
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            $file->move($path, $filename);
            $category->image = $filename;
        }

        $category->save();

        // IMPORTANT: invalidate simple related cache keys when categories change.
        // Since you requested no new files/migrations, we'll do a conservative flush:
        try {
            // Using Cache::flush() would clear all cache (dangerous in shared env).
            // Instead, remove likely keys—here we remove root and this parent's children pages.
            Cache::forget("categories:root:pp10:p1"); // common default; adjust if needed
            Cache::forget("categories:{$category->parent_id}:children:pp10:p1");
        } catch (\Exception $ex) {
            // ignore cache invalidation failures (don't break the request)
            Log::warning('Cache invalidation issue on category store: ' . $ex->getMessage());
        }

        return redirect()->route('admin.categories.index')->with('message', 'Category added successfully!');
    }


    // Show the category editing form
    public function edit(Category $category)
    {
        // Retrieve the parent categories, including their children
        $parentCategories = Category::with('children')->whereNull('parent_id')->get();

        if ($parentCategories->isEmpty()) {
            // Handle case where no parent categories are found
            return redirect()->route('admin.categories.index')->with('error', 'No parent categories found.');
        }

        // Return the edit view with the category and parentCategories data
        return view('admin.category.edit', compact('category', 'parentCategories'));
    }

    // Update an existing category
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'serial_number' => 'required|unique:categories,serial_number,' . $category->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,avif,webp|max:2048',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $category->name = $validated['name'];
        $category->slug = Str::slug($validated['name']); // ✅ auto-generate slug
        $category->description = $validated['description'] ?? null;
        $category->serial_number = $validated['serial_number'];
        $category->parent_id = $validated['parent_id'] ?? null;
        $category->show_on_footer = $request->has('show_on_footer') ? 1 : 0;

        if ($request->hasFile('image')) {
            if ($category->image && file_exists(public_path('uploads/category/' . $category->image))) {
                unlink(public_path('uploads/category/' . $category->image));
            }

            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $path = public_path('uploads/category');
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            $file->move($path, $filename);
            $category->image = $filename;
        }

        $category->save();

        // Invalidate some cache keys conservatively (so changes become visible)
        try {
            Cache::forget("categories:root:pp10:p1");
            Cache::forget("categories:{$category->id}:children:pp10:p1");
            Cache::forget("categories:{$category->parent_id}:children:pp10:p1");
        } catch (\Exception $ex) {
            Log::warning('Cache invalidation issue on category update: ' . $ex->getMessage());
        }

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }


    // Delete a category
    public function destroy(Category $category)
    {
        if ($category->children()->count() > 0) {
            return redirect()->route('admin.categories.index')->with('message', 'Cannot delete a category that has subcategories. Please delete subcategories first.');
        }
        // Delete category image if exists
        if ($category->image && file_exists(public_path('uploads/category/' . $category->image))) {
            unlink(public_path('uploads/category/' . $category->image));
        }

        // Delete the category record
        $category->delete();

        // Invalidate cache keys related to this category
        try {
            Cache::forget("categories:root:pp10:p1");
            Cache::forget("categories:{$category->id}:children:pp10:p1");
            Cache::forget("categories:{$category->parent_id}:children:pp10:p1");
        } catch (\Exception $ex) {
            Log::warning('Cache invalidation issue on category delete: ' . $ex->getMessage());
        }

        // Redirect with success message
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }

    // NEW
    // In your controller (e.g., CategoryController.php)
    public function filter(Request $request)
    {
        $categories = $request->input('categories', []);
        $brands = $request->input('brands', []);
        $parentId = $request->input('parent_id');

        // Fetch subcategories and products based on filters
        $subcategories = Subcategory::whereIn('id', $categories)->get();
        $products = Product::where('category_id', $parentId)
            ->when(!empty($brands), function ($query) use ($brands) {
                return $query->whereIn('brand_id', $brands); // Filter by brands
            })
            ->get();

        return response()->json([
            'subcategories' => $subcategories,
            'products' => $products,
        ]);
    }
    public function checkSerial(Request $request)
    {
        // 1. Check for exact match (for validation error)
        $existsQuery = Category::where('serial_number', $request->serial_number);
        if ($request->category_id) {
            $existsQuery->where('id', '!=', $request->category_id);
        }
        $exists = $existsQuery->exists();

        // 2. Fetch matches for autocomplete list (show similar existing numbers)
        // Adjust the query to finding numbers that START with or CONTAIN the input
        // Since serial_number is likely integer, we cast or just search.
        $matchesQuery = Category::where('serial_number', 'LIKE', "{$request->serial_number}%");
        if ($request->category_id) {
            $matchesQuery->where('id', '!=', $request->category_id);
        }
        $taken_serials = $matchesQuery->orderBy('serial_number')->limit(20)->pluck('serial_number')->toArray();

        // If exact match AND matches list is empty (unlikely if exists is true), ensure we return it? 
        // Actually if exists is true, it should satisfy the LIKE check too.

        return response()->json([
            'exists' => $exists,
            'taken_serials' => $taken_serials
        ]);
    }


}
