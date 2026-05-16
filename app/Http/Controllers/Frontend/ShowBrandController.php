<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\Controller;

class ShowBrandController extends Controller
{
    public function index()
    {
        $brands = Brand::with('products')->get();
        return view('brand.index', compact('brands'));
    }

    public function show($id)
    {
        $brand = Brand::findOrFail($id);
        return view('brand.show', compact('brand'));
    }

    public function showProducts($id)
    {
        $brand = Brand::findOrFail($id);
        $allBrands = Brand::all();

        // Always define a default mainCategory object
        $mainCategory = (object) [
            'name' => ($brand->name ?? 'Products') . ' Products',
            'description' => 'Browse products from ' . ($brand->name ?? ''),
            'children' => collect(),
        ];

        // Bottom-up ancestry approach: works for any depth of category nesting
        // Step 1: Find all category IDs that have products for this brand
        $categoryIdsWithProducts = Product::where('brand_id', $id)
            ->pluck('category_id')
            ->unique();

        // Step 2: Walk up each category's parent chain to collect all ancestor IDs
        $allRelevantIds = collect($categoryIdsWithProducts);
        foreach ($categoryIdsWithProducts as $catId) {
            $parent = Category::find($catId);
            while ($parent && $parent->parent_id) {
                $allRelevantIds->push($parent->parent_id);
                $parent = Category::find($parent->parent_id);
            }
        }
        $allRelevantIds = $allRelevantIds->unique();

        // Step 3: Get root categories in relevant paths
        $rootCategories = Category::whereNull('parent_id')
            ->whereIn('id', $allRelevantIds)
            ->get();

        $organizedCategories = collect();
        $categories = collect();

        foreach ($rootCategories as $root) {
            // Get direct children of root that are in the relevant ancestry path
            $children = Category::where('parent_id', $root->id)
                ->whereIn('id', $allRelevantIds)
                ->with([
                    'children',
                    'products' => function ($q) use ($id) {
                        $q->where('brand_id', $id);
                    }
                ])
                ->get();

            if ($children->isNotEmpty()) {
                $organizedCategories->push([
                    'main' => $root,
                    'children' => $children->map(function ($child) use ($id) {
                        return [
                            'category' => $child,
                            'children' => $child->children,
                            'products' => $child->children->isEmpty() ? $child->products : collect()
                        ];
                    })
                ]);
                $categories = $categories->merge($children);
            }
        }

        // Get all products for this brand, regardless of category
        $products = Product::with(['category.parent', 'brand'])
            ->where('brand_id', $id)
            ->get();

        $recentlyViewedIds = session('recently_viewed_items', []);
        $recentlyViewedItems = Product::whereIn('id', $recentlyViewedIds)
            ->with(['category', 'brand'])
            ->get()
            ->sortBy(function ($item) use ($recentlyViewedIds) {
                return array_search($item->id, $recentlyViewedIds);
            })
            ->values();

        // Build breadcrumb
        $breadcrumb = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Brands', 'url' => route('brand')],
            ['name' => $brand->name, 'url' => null]
        ];

        $latestNews = \App\Models\News::orderBy('created_at', 'desc')->take(3)->get();

        return view('brand.products', compact(
            'brand',
            'products',
            'categories',
            'organizedCategories',
            'allBrands',
            'recentlyViewedItems',
            'mainCategory',
            'breadcrumb',
            'latestNews'
        ));
    }

    public function showCategoryWithBrand($brand_id, $category_id)
    {
        $brand = Brand::findOrFail($brand_id);
        $category = Category::with(['children', 'products'])->findOrFail($category_id); // Changed $mainCategory to $category
        $allBrands = Brand::all();

        // If the category has children, show subcategories in products view
        if ($category->children->isNotEmpty()) {
            // Build organized categories structure
            $organizedCategories = collect([
                [
                    'main' => $category,
                    'children' => $category->children->map(function ($subcat) use ($brand_id) {
                        return [
                            'category' => $subcat,
                            'children' => $subcat->children,
                            'products' => $subcat->products->where('brand_id', $brand_id)
                        ];
                    }),
                    'products' => collect()
                ]
            ]);

            $breadcrumb = [
                ['name' => 'Home', 'url' => route('home')],
                ['name' => 'Brands', 'url' => route('brand')],
                ['name' => $brand->name, 'url' => route('brand.products', $brand_id)],
                ['name' => $category->name, 'url' => null]
            ];

            // Pass children for sidebar/category cards
            $categories = $category->children()->with(['children'])->get();

            // No products to show at this level, only subcategories
            $products = collect();

            $recentlyViewedIds = session('recently_viewed_items', []);
            $recentlyViewedItems = Product::whereIn('id', $recentlyViewedIds)
                ->with(['category', 'brand'])
                ->get()
                ->sortBy(function ($item) use ($recentlyViewedIds) {
                    return array_search($item->id, $recentlyViewedIds);
                })
                ->values();

            $latestNews = \App\Models\News::orderBy('created_at', 'desc')->take(3)->get();

            return view('brand.products', compact(
                'brand',
                'category', // Changed from $mainCategory
                'organizedCategories',
                'products',
                'breadcrumb',
                'allBrands',
                'recentlyViewedItems',
                'categories',
                'latestNews'
            ));
        } else {
            // If no children, show products in show.blade.php
            $products = $category->products()->where('brand_id', $brand_id)->get();

            $categories = collect(); // Initialize categories as empty collection

            $breadcrumb = [
                ['name' => 'Home', 'url' => route('home')],
                ['name' => 'Brands', 'url' => route('brand')],
                ['name' => $brand->name, 'url' => route('brand.products', $brand_id)],
                ['name' => $category->name, 'url' => null]
            ];

            $recentlyViewedIds = session('recently_viewed_items', []);
            $recentlyViewedItems = Product::whereIn('id', $recentlyViewedIds)
                ->with(['category', 'brand'])
                ->get()
                ->sortBy(function ($item) use ($recentlyViewedIds) {
                    return array_search($item->id, $recentlyViewedIds);
                })
                ->values();

            return view('brand.show', compact(
                'brand',
                'category', // Changed from $mainCategory
                'products',
                'breadcrumb',
                'allBrands',
                'recentlyViewedItems',
                'categories'
            ));
        }
    }
    // Helper function to fetch all child category IDs recursively
    private function getAllChildCategoryIds($categoryIds)
    {
        $childCategoryIds = Category::whereIn('parent_id', $categoryIds)->pluck('id');
        if ($childCategoryIds->isEmpty()) {
            return $categoryIds;
        }
        return $categoryIds->merge($this->getAllChildCategoryIds($childCategoryIds));
    }
}
