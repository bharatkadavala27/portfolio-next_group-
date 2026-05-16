<?php

namespace App\Http\Controllers\Frontend;

use Log;
use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::with(['category', 'subcategory'])->findOrFail($id);

        // Update recently viewed items in session
        $recentlyViewed = session('recently_viewed_items', []);

        // Remove the product if it exists in the array
        if (($key = array_search($id, $recentlyViewed)) !== false) {
            unset($recentlyViewed[$key]);
        }

        // Add the product to the beginning of the array
        array_unshift($recentlyViewed, $id);

        // Keep only the last 3 items
        $recentlyViewed = array_slice($recentlyViewed, 0, 3);

        // Store back in session
        session(['recently_viewed_items' => $recentlyViewed]);

        // Get the category (main category)
        $category = $product->category;

        // Initialize breadcrumb array
        $breadcrumb = [];

        // If there's a subcategory, include it and its ancestors
        if ($product->subcategory_ids) {
            $subcategoryIds = is_array($product->subcategory_ids) ? $product->subcategory_ids : json_decode($product->subcategory_ids, true);
            if (!empty($subcategoryIds)) {
                // Get the first subcategory (or adjust logic to handle multiple)
                $subcategory = Category::find($subcategoryIds[0]);
                if ($subcategory) {
                    // Collect ancestors of the subcategory
                    $ancestors = $this->getCategoryAncestors($subcategory);
                    $breadcrumb = $ancestors;
                    // Ensure the subcategory itself is in the breadcrumb
                    if (!in_array($subcategory, $breadcrumb)) {
                        $breadcrumb[] = $subcategory;
                    }
                }
            }
        } elseif ($category) {
            // If no subcategory, include the main category and its ancestors
            $ancestors = $this->getCategoryAncestors($category);
            $breadcrumb = $ancestors;
            // Ensure the category itself is in the breadcrumb
            if (!in_array($category, $breadcrumb)) {
                $breadcrumb[] = $category;
            }
        }
         Log::debug(['data' => $product, 'status' => 'success']);

        return view('frontend.product.show', compact('product', 'category', 'breadcrumb'));
    }


public function filter(Request $request)
    {
        $brandId = $request->query('brand_id');
        $categories = json_decode($request->query('categories', '[]'), true);
        $brands = json_decode($request->query('brands', '[]'), true);
        $page = $request->query('page', 1);

        $query = Product::with(['category', 'brand']);

        if ($brandId) {
            $query->where('brand_id', $brandId);
        }

        if (!empty($categories)) {
            $query->whereIn('category_id', $categories);
        }

        if (!empty($brands)) {
            $query->whereIn('brand_id', $brands);
        }

        $products = $query->paginate(12, ['*'], 'page', $page);

        return response()->json([
            'products' => $products->map(function ($product) {
                $images = json_decode($product->images, true);
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'serial_number' => $product->serial_number,
                    'image_path' => !empty($images) && is_array($images) ? $images[0] : null,
                ];
            }),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'total' => $products->total(),
            ]
        ]);
    }


    private function getCategoryAncestors($category)
    {
        $ancestors = [];
        $current = $category;

        while ($current && $current->parent_id) {
            $current = Category::find($current->parent_id);
            if ($current) {
                array_unshift($ancestors, $current); // Add to the beginning
            }
        }

        return $ancestors;
    }
}
