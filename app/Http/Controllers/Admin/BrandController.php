<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::orderBy('serial_number', 'asc')->get();
        return view('admin.brands.index', compact('brands'));

    }


    public function form($id = null)
    {
        $existingSerialNumbers = Brand::orderBy('serial_number', 'asc')->pluck('serial_number')->toArray();

        $nextSerialNumber = $this->getNextAvailableSerialNumber($existingSerialNumbers);
        if ($nextSerialNumber === null) {
            $lastSerialNumber = Brand::max('serial_number') ?? 0;
            $nextSerialNumber = $lastSerialNumber + 1;
        }
        $brand = $id ? Brand::findOrFail($id) : null;

        return view('admin.brands.create', compact('brand', 'nextSerialNumber'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'serial_number' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
        ]);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->description = $request->description;
        $brand->category_id = $request->category_id;
        $brand->serial_number = $request->serial_number;
        $brand->show_on_footer = $request->has('show_on_footer') ? 1 : 0;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('brands', 'public');
            $brand->image = $imagePath;
        }

        $brand->save();

        return redirect()->route('admin.brands.index')->with('success', 'Brand created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'serial_number' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
        ]);

        $brand = Brand::findOrFail($id);
        $brand->name = $request->name;
        $brand->description = $request->description;
        $brand->category_id = $request->category_id;
        $brand->serial_number = $request->serial_number;
        $brand->show_on_footer = $request->has('show_on_footer') ? 1 : 0;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('brands', 'public');
            $brand->image = $imagePath;
        }

        $brand->save();

        return redirect()->route('admin.brands.index')->with('success', 'Brand updated successfully.');
    }

    public function save(Request $request, $id = null)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'serial_number' => 'required|integer|unique:brands,serial_number,' . $id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,webp',
        ]);

        $brand = $id ? Brand::find($id) : new Brand();

        if (!$brand) {
            return redirect()->route('admin.brands.index')
                ->with('error', 'Brand not found!');
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = 'brands/' . uniqid() . '.' . $image->getClientOriginalExtension();

            if (!$image->move(public_path('brands'), $imagePath)) {
                return redirect()->route('admin.brands.index')
                    ->with('error', 'Failed to upload the image. Please try again.');
            }

            if ($id && $brand->image) {
                File::delete(public_path('brands/' . $brand->image));
            }

            $brand->image = $imagePath;
        }

        $brand->name = $request->name;
        $brand->description = $request->description;
        $brand->category_id = $request->category_id;
        $brand->serial_number = $request->serial_number;
        $brand->show_on_footer = $request->has('show_on_footer') ? 1 : 0;
        $brand->save();

        $existingSerialNumbers = Brand::orderBy('serial_number', 'asc')->pluck('serial_number')->toArray();
        $nextSerialNumber = $this->getNextAvailableSerialNumber($existingSerialNumbers);

        return redirect()->route('admin.brands.index')->with('message', $id ? 'Brand updated successfully!' : 'Brand created successfully!');
    }


    public function delete($id)
    {
        $brand = Brand::findOrFail($id);
        if ($brand->image) {
            Storage::delete('public/' . $brand->image);
        }
        $brand->delete();
        return redirect()->route('admin.brands.index')->with('error', 'Brand deleted successfully!');
    }


    protected function getNextAvailableSerialNumber(array $existingSerialNumbers)
    {
        $nextSerialNumber = null;
        $expected = 1;
        foreach ($existingSerialNumbers as $serialNumber) {
            if ($serialNumber != $expected) {
                $nextSerialNumber = $expected;
                break;
            }
            $expected++;
        }

        return $nextSerialNumber;
    }

    // NEW
    public function show($id)
    {
        $category = Category::findOrFail($id);
        $childCategories = Category::where('parent_id', $id)->get();
        $relatedBrands = Brand::whereIn('id', $category->products->pluck('brand_id'))->get();

        \Log::info('Related Brands:', $relatedBrands->toArray());

        return view('categories.show', [
            'category' => $category,
            'childCategories' => $childCategories,
            'relatedBrands' => $relatedBrands,
        ]);
    }


    public function filterCategories(Request $request)
    {
        $categoryIds = $request->has('categories') ? explode(',', $request->categories) : [];
        $brandIds = $request->has('brands') ? explode(',', $request->brands) : [];

        $productsQuery = Product::query();

        // Filter by categories (if selected)
        if (!empty($categoryIds)) {
            $productsQuery->whereIn('category_id', $categoryIds);
        }

        // Filter by brands (if selected)
        if (!empty($brandIds)) {
            $productsQuery->whereIn('brand_id', $brandIds);
        }

        $products = $productsQuery->get();

        \Log::info('Filtered Brands:', $brandIds); // Debugging line
        \Log::info('Products:', $products->toArray()); // Debugging line

        return response()->json([
            'products' => $products
        ]);
    }

    public function checkSerial(Request $request)
    {
        $exists = Brand::where('serial_number', $request->serial_number)
            ->when($request->brand_id, fn($q) => $q->where('id', '!=', $request->brand_id))
            ->exists();

        $taken_serials = [];
        if ($exists) {
            $taken_serials = Brand::orderBy('serial_number')->pluck('serial_number')->toArray();
        }

        return response()->json([
            'exists' => $exists,
            'taken_serials' => $taken_serials
        ]);
    }

}
