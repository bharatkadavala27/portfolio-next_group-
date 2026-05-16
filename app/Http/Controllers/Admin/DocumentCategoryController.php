<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DocumentCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentCategoryFormRequest;

class DocumentCategoryController extends Controller
{
    public function view()
    {
        $categories = DocumentCategory::with('parentCategory')->whereNull('parent_id')->get();
        return view('admin.document-category.index', compact('categories'));
    }

    public function getCategories()
    {
        // Fetch parent categories
        $categories = DocumentCategory::whereNull('parent_id')->get(); // Parent categories where parent_id is null

        // Structure categories with information about whether they have children
        $categories = $categories->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'has_children' => $category->children()->exists(),
            ];
        });

        return response()->json(['categories' => $categories]);
    }

    public function getChildren($categoryId)
    {
        // Find the category
        $category = DocumentCategory::find($categoryId);

        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        // Fetch children of the category
        $children = $category->children->map(function ($child) {
            return [
                'id' => $child->id,
                'name' => $child->name,
                'has_children' => $child->children()->exists(),
            ];
        });

        return response()->json(['children' => $children]);
    }

    public function index()
    {
        $parentCategories = DocumentCategory::with('children')->whereNull('parent_id')->get();
        return view('admin.document-category.index', compact('parentCategories'));
    }

    public function show($id)
    {
        $category = DocumentCategory::find($id);
        if (!$category) {
            return redirect()->route('admin.document-category.index')->with('error', 'Category not found');
        }
        return view('admin.document-category.show', compact('category'));
    }

    public function create()
    {
        $parentCategories = DocumentCategory::whereNull('parent_id')->get();
        return view('admin.document-category.create', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:document_categories,name',
                'description' => 'nullable|string',
                'serial_number' => 'nullable|integer|min:1',
                'parent_id' => 'nullable|exists:document_categories,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $data = $request->except('image');
            $data['slug'] = Str::slug($request->name); // Always auto-generate slug from name

            // Get the maximum serial number from the database
            $maxSerialNumber = DocumentCategory::max('serial_number');
            $serialNumber = $request->serial_number;

            // If the requested serial number already exists, use the next available number
            if (DocumentCategory::where('serial_number', $serialNumber)->exists()) {
                $serialNumber = $maxSerialNumber + 1;
            }

            $data['serial_number'] = $serialNumber;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('document_categories'), $filename); // Save file in the correct directory
                $data['image'] = $filename; // Save file name in the database
            }

            DocumentCategory::create($data);

            return redirect()
                ->route('admin.document-categories.index')
                ->with('success', 'Document Category created successfully with serial number ' . $serialNumber);

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error creating document category: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $category = DocumentCategory::find($id);
        if (!$category) {
            return redirect()->route('admin.document-categories.index')->with('error', 'Category not found');
        }

        $parentCategories = DocumentCategory::whereNull('parent_id')->where('id', '!=', $id)->get();
        return view('admin.document-category.edit', compact('category', 'parentCategories'));
    }

    public function update(Request $request, $id)
    {
        try {
            $category = DocumentCategory::find($id);
            if (!$category) {
                return redirect()->route('admin.document-categories.index')->with('error', 'Category not found');
            }

            $request->validate([
                'name' => 'required|string|max:255',
                // 'slug' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'serial_number' => 'integer|min:1',
                'parent_id' => 'nullable|exists:document_categories,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $data = $request->except('image');
            $data['slug'] = $request->slug ?: Str::slug($request->name);

            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($category->image && file_exists(public_path('document_categories/' . $category->image))) {
                    unlink(public_path('document_categories/' . $category->image));
                }

                $file = $request->file('image');
                $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('document_categories'), $filename);
                $data['image'] = $filename;
            }

            $category->update($data);

            return redirect()
                ->route('admin.document-categories.index')
                ->with('success', 'Document Category updated successfully');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error updating document category: ' . $e->getMessage());
        }
    }

    // Delete a category
    public function destroy(DocumentCategory $category)
    {
        if ($category->children()->count() > 0) {
            return redirect()->route('admin.document-category.index')->with('message', 'Cannot delete a category that has subcategories. Please delete subcategories first.');
        }
        if (!$category) {
            return redirect()->route('admin.document-category.index')->with('error', 'Category not found');
        }
        // Delete category image if exists
        if ($category->image && file_exists(public_path('uploads/category/' . $category->image))) {
            unlink(public_path('uploads/category/' . $category->image));
        }

        // Delete the category record
        $category->delete();

        // Redirect with success message
        return redirect()->route('admin.document-category.index')->with('success', 'Document Category deleted successfully.');
    }

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

    public function fetchDocumentCategories()
    {
        $categories = DocumentCategory::select('id', 'name')->get(); // Fetch only 'id' and 'name'
        return response()->json(['documentCategories' => $categories]);
    }

    public function checkLive(Request $request)
    {
        return response()->json([
            'name_exists' => DocumentCategory::where('name', $request->name)
                ->when($request->id, fn($q) => $q->where('id', '!=', $request->id))
                ->exists(),

            'serial_exists' => $request->serial_number
                ? DocumentCategory::where('serial_number', $request->serial_number)
                    ->when($request->id, fn($q) => $q->where('id', '!=', $request->id))
                    ->exists()
                : false
        ]);
    }

    public function checkSerial(Request $request)
    {
        // 1. Check for exact match
        $existsQuery = DocumentCategory::where('serial_number', $request->serial_number);
        if ($request->id) {
            $existsQuery->where('id', '!=', $request->id);
        }
        $exists = $existsQuery->exists();

        // 2. Fetch matches for autocomplete list
        $matchesQuery = DocumentCategory::where('serial_number', 'LIKE', "{$request->serial_number}%");
        if ($request->id) {
            $matchesQuery->where('id', '!=', $request->id);
        }
        $taken_serials = $matchesQuery->orderBy('serial_number')->limit(20)->pluck('serial_number')->toArray();

        return response()->json([
            'exists' => $exists,
            'taken_serials' => $taken_serials
        ]);
    }
}
