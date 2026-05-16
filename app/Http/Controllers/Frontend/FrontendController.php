<?php
namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use App\Models\Category;
use App\Models\Document;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Brand;
use Illuminate\Support\Facades\Log; // Added for logging

class FrontendController extends Controller
{
    public function showProduct($id)
    {
        $product = Product::with('category.parent')->findOrFail($id);
        $breadcrumb = $this->getBreadcrumb($product->category);
        // Assuming product image paths are like 'Uploads/products/image.jpg'
        // asset() helper correctly prepends scheme, host, and '/public/' if needed.
        $productImage = $product->image ? asset($product->image) : asset('images/default-product.png'); // Adjusted default

        return view('frontend.product.show', compact('product', 'breadcrumb', 'productImage'));
    }

    private function getBreadcrumb($category)
    {
        $breadcrumb = [];
        while ($category) {
            array_unshift($breadcrumb, $category);
            $category = $category->parent;
        }
        return $breadcrumb;
    }

    public function aboutpage()
    {
        return view('frontend.pages.about-us');
    }

    public function contactpage()
    {
        return view('frontend.pages.contact-us');
    }

    public function getChildren(Category $category)
    {
        return response()->json($category->children()->with('children')->get());
    }

    public function products()
    {
        $products = Product::with(['brand', 'category', 'attributes.short_attributes'])
            ->whereNotNull('image') // Or handle image presence appropriately
            ->get();

        return view('frontend.product.index', compact('products'));
    }

    public function view()
    {
        $categories = Category::with('children')->whereNull('parent_id')->get();
        return view('frontend.category.index', compact('categories'));
    }

    public function getCategories()
    {
        $categories = Category::whereNull('parent_id')->get()->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'has_children' => $category->children()->exists(),
            ];
        });

        return response()->json(['categories' => $categories]);
    }

    public function index()
    {
        $parentCategories = Category::with('children')->whereNull('parent_id')->get();
        return view('admin.category.index', compact('parentCategories'));
    }

    public function main($id)
    {
        $category = Category::with([
            'products.brand',
            'products.mainDocuments',
            'products.documents.documentType',
            'products.attributes.shortAttributes',
            'products.filters', // Load product filters
            'children.children.children', // Load nested children (3 levels deep)
            'children.products.brand',
            'children.products.documents.documentType',
            'children.products.filters', // Load filters for children products
            'children.children.products.brand', // Ensure grandchildren products are loaded
            'children.children.products.filters' // Load filters for grandchildren products
        ])->findOrFail($id);

        // Get direct children with their relationships
        $childCategories = $category->children()->with([
            'children.products.brand', // Load products of grandchildren
            'children.products.documents.documentType',
            'children.products.filters', // Load filters for grandchildren products
            'children.children.products.filters', // Load filters for great-grandchildren products
            'products.brand',
            'products.documents.documentType',
            'products.filters' // Load filters for child category products
        ])->get();

        // Attach related brand IDs to each child category AND their children (grandchildren) for filtering
        $childCategories->each(function ($child) {
            // Top level subcategory brand IDs and Filter Option IDs
            $brands = $this->getRelatedBrands($child);
            $child->related_brand_ids = $brands->pluck('id')->values()->toArray();
            $child->related_filter_option_ids = $this->getRelatedFilterOptionIds($child);

            // Grandchildren brand IDs and Filter Option IDs
            if ($child->children) {
                $child->children->each(function ($grandchild) {
                    $grandchildBrands = $this->getRelatedBrands($grandchild);
                    $grandchild->related_brand_ids = $grandchildBrands->pluck('id')->values()->toArray();
                    $grandchild->related_filter_option_ids = $this->getRelatedFilterOptionIds($grandchild);
                });
            }
        });

        // Get all brands from this category and its descendants
        $relatedBrands = $this->getRelatedBrands($category);

        // Get all filters (system + product) ordered by sequence
        $orderedFilters = \App\Models\Filter::orderBy('sequence', 'asc')->get();

        // Process filters to attach necessary data
        $orderedFilters->transform(function ($filter) use ($category, $childCategories, $relatedBrands) {
            if ($filter->key === 'category_system') {
                $filter->data = [
                    'childCategories' => $childCategories,
                    'isVisible' => $childCategories->count() > 0 || ($category->products && $category->products->count() > 0)
                ];
            } elseif ($filter->key === 'brand_system') {
                $filter->data = [
                    'relatedBrands' => $relatedBrands,
                    'isVisible' => $relatedBrands->count() > 0
                ];
            } elseif ($filter->type === 'product' || $filter->type === 'both') {
                // Determine if this dynamic filter has relevant options for current products
                $productIds = collect();
                if ($category->products) {
                    $productIds = $productIds->merge($category->products->pluck('id'));
                }
                // Recursively gather product IDs (reusing existing logic or accessing loaded relations)
                // Note: deeply nested product ID gathering might be heavy here if not careful.
                // Re-using getProductFilters logic logic simplified:

                $hasOptions = $filter->options()->whereHas('products', function ($q) use ($category) {
                    // This check is a bit simplified; ideally we check against the exact set of products in this category tree
                    // For now, we can rely on the fact that if we just fetched 'productFilters', we could match IDs.
                    // Or, we can reuse the logic from getProductFilters but applied per filter.

                    // Check if *any* product in this category's tree has this option.
                    // This query might be expensive inside a loop.
                    // Better approach: Use the previously fetched $productFilters and match ids.
                    return true;
                })->exists();

                // Optimization: Filter the already fetched $productFilters
                // We fetched $productFilters = $this->getProductFilters($category);
                // We can check if this $filter->id exists in $productFilters collection

                // Let's rely on getProductFilters for dynamic ones
                $filter->data = [
                    'options' => $filter->options, // This might be all options, we need filtered options
                    'isVisible' => false // Will be set below
                ];
            }
            return $filter;
        });

        // Re-merge with properly filtered dynamic filters
        // The $productFilters variable explicitly contains only relevant filters with relevant options.
        // We should map $orderedFilters to use that data.

        $relevantProductFilters = $this->getProductFilters($category);
        $productFilters = $relevantProductFilters; // Alias for view compatibility
        $orderedFilters = $orderedFilters->map(function ($systemFilter) use ($relevantProductFilters, $childCategories, $relatedBrands, $category) {

            if ($systemFilter->key === 'category_system') {
                // Check visibility
                $hasChildCategories = $childCategories->count() > 0;
                $hasCategoryProducts = $category->products && $category->products->count() > 0;
                $isVisible = $hasChildCategories || $hasCategoryProducts; // Logic from blade

                $systemFilter->formattedData = [
                    'type' => 'category_system',
                    'items' => $childCategories,
                    'isVisible' => $isVisible
                ];
            } elseif ($systemFilter->key === 'brand_system') {
                $hasRelatedBrands = $relatedBrands->count() > 0;
                $isVisible = $hasRelatedBrands;

                $systemFilter->formattedData = [
                    'type' => 'brand_system',
                    'items' => $relatedBrands,
                    'isVisible' => $isVisible
                ];
            } else {
                // It's a dynamic filter. Check if it is in $relevantProductFilters
                $match = $relevantProductFilters->firstWhere('id', $systemFilter->id);
                if ($match) {
                    $systemFilter->formattedData = [
                        'type' => 'dynamic',
                        'items' => $match->options, // usage: $option->name, $option->id
                        'isVisible' => true
                    ];
                } else {
                    $systemFilter->formattedData = [
                        'type' => 'dynamic',
                        'items' => [],
                        'isVisible' => false
                    ];
                }
            }
            return $systemFilter;
        });


        $breadcrumb = $this->getBreadcrumb($category);

        $recentlyViewedIds = session('recently_viewed_items', []);
        $recentlyViewedItems = Product::whereIn('id', $recentlyViewedIds)
            ->with(['category', 'brand'])
            ->get()
            ->sortBy(function ($item) use ($recentlyViewedIds) {
                return array_search($item->id, $recentlyViewedIds);
            })
            ->values();

        $latestNews = \App\Models\News::orderBy('created_at', 'desc')->take(3)->get();

        return view('frontend.category.main', compact(
            'category',
            'relatedBrands',
            'childCategories',
            'breadcrumb',
            'recentlyViewedItems',
            'latestNews',
            'productFilters',
            'orderedFilters' // Pass the new ordered list
        ));

    }

    // Replace your existing show() method with this updated version
    public function show($id)
    {
        $category = Category::with([
            'products.brand',
            'products.mainDocuments',
            'products.documents.documentType',
            'products.attributes.shortAttributes',
            'products.filters', // Load product filters
            'children.children.children', // Load nested children
            'children.products.brand',
            'children.products.documents.documentType',
            'children.products.filters', // Load filters for children products
            'parent.parent.parent' // For breadcrumb building
        ])->findOrFail($id);

        // Get direct children with their relationships
        // Get direct children with their relationships
        $childCategories = $category->children()->with([
            'children.products.brand', // Load products of grandchildren
            'children.products.documents.documentType',
            'children.products.filters', // Load filters for grandchildren products
            'products.brand',
            'products.documents.documentType',
            'products.filters' // Load filters for child category products
        ])->get();

        // Attach related brand IDs and filter option IDs to each child category and grandchildren for filtering
        $childCategories->each(function ($child) {
            $brands = $this->getRelatedBrands($child);
            $child->related_brand_ids = $brands->pluck('id')->values()->toArray();
            $child->related_filter_option_ids = $this->getRelatedFilterOptionIds($child);

            if ($child->children) {
                $child->children->each(function ($grandchild) {
                    $grandchildBrands = $this->getRelatedBrands($grandchild);
                    $grandchild->related_brand_ids = $grandchildBrands->pluck('id')->values()->toArray();
                    $grandchild->related_filter_option_ids = $this->getRelatedFilterOptionIds($grandchild);
                });
            }
        });

        // Get brands from this category and descendants
        $relatedBrands = $this->getRelatedBrands($category);
        $brands = $relatedBrands; // Keep both for backward compatibility

        // Get product filters for this category
        $productFilters = $this->getProductFilters($category);

        $breadcrumb = $this->getBreadcrumb($category);

        $recentlyViewedIds = session('recently_viewed_items', []);
        $recentlyViewedItems = Product::whereIn('id', $recentlyViewedIds)
            ->with(['category', 'brand'])
            ->get()
            ->sortBy(function ($item) use ($recentlyViewedIds) {
                return array_search($item->id, $recentlyViewedIds);
            })
            ->values();

        // Get all filters (system + product) ordered by sequence
        $orderedFilters = \App\Models\Filter::orderBy('sequence', 'asc')->get();

        // Process filters to attach necessary data
        // Use $brands for relatedBrands as per show method variable naming
        $orderedFilters->transform(function ($filter) use ($category, $childCategories, $brands) {
            if ($filter->key === 'category_system') {
                $filter->data = [
                    'childCategories' => $childCategories,
                    'isVisible' => $childCategories->count() > 0
                ];
            } elseif ($filter->key === 'brand_system') {
                $filter->data = [
                    'relatedBrands' => $brands,
                    'isVisible' => $brands->count() > 0
                ];
            } elseif ($filter->type === 'product' || $filter->type === 'both') {
                $filter->data = [
                    'options' => $filter->options,
                    'isVisible' => false // Will be set in map
                ];
            }
            return $filter;
        });

        $relevantProductFilters = $this->getProductFilters($category);
        $orderedFilters = $orderedFilters->map(function ($systemFilter) use ($relevantProductFilters, $childCategories, $brands, $category) {

            if ($systemFilter->key === 'category_system') {
                // Check visibility - strictly show only if children exist, matching original show blade logic logic logic
                $isVisible = $childCategories->count() > 0;

                $systemFilter->formattedData = [
                    'type' => 'category_system',
                    'items' => $childCategories,
                    'isVisible' => $isVisible
                ];
            } elseif ($systemFilter->key === 'brand_system') {
                $isVisible = $brands->count() > 0;

                $systemFilter->formattedData = [
                    'type' => 'brand_system',
                    'items' => $brands,
                    'isVisible' => $isVisible
                ];
            } else {
                // It's a dynamic filter. Check if it is in $relevantProductFilters
                $match = $relevantProductFilters->firstWhere('id', $systemFilter->id);
                if ($match) {
                    $systemFilter->formattedData = [
                        'type' => 'dynamic',
                        'items' => $match->options,
                        'isVisible' => true
                    ];
                } else {
                    $systemFilter->formattedData = [
                        'type' => 'dynamic',
                        'items' => [],
                        'isVisible' => false
                    ];
                }
            }
            return $systemFilter;
        });

        // Logic to determine which view to show:
        // 1. If category has children, show main.blade.php (same as main() method)
        // 2. If no children but has products, show show.blade.php
        // 3. If neither, redirect to parent or show empty state

        if ($childCategories->count() > 0) {
            // Has children - show as main category view with subcategories
            $latestNews = \App\Models\News::orderBy('created_at', 'desc')->take(3)->get();

            return view('frontend.category.main', compact(
                'category',
                'childCategories',
                'relatedBrands',
                'breadcrumb',
                'recentlyViewedItems',
                'latestNews',
                'productFilters',
                'orderedFilters'
            ));
        } elseif ($category->products->count() > 0) {
            // No children but has products - show products directly
            return view('frontend.category.show', compact(
                'category',
                'childCategories', // Will be empty but needed for template
                'brands',
                'breadcrumb',
                'recentlyViewedItems',
                'productFilters',
                'orderedFilters'
            ));
        } else {
            // Empty category - redirect to parent or show empty state
            if ($category->parent) {
                return redirect()->route('category.main', $category->parent->id)
                    ->with('warning', 'This category is currently empty.');
            } else {
                // Root category with no content
                return view('frontend.category.show', compact(
                    'category',
                    'childCategories',
                    'brands',
                    'breadcrumb',
                    'recentlyViewedItems',
                    'productFilters',
                    'orderedFilters'
                ))->with('info', 'This category is currently empty.');
            }
        }


    }

    // Add this new method to get brands from category and all descendants
    private function getRelatedBrands($category)
    {
        $productIds = collect();

        // Add products from current category
        if ($category->products) {
            $productIds = $productIds->merge($category->products->pluck('id'));
        }

        // Add products from all descendant categories recursively
        $this->collectProductsFromChildren($category, $productIds);

        if ($productIds->isEmpty()) {
            return collect();
        }

        // Get unique brands from all these products
        return Brand::whereHas('products', function ($query) use ($productIds) {
            $query->whereIn('id', $productIds);
        })->distinct()->get();
    }

    // Add this helper method to recursively collect product IDs
    private function collectProductsFromChildren($category, &$productIds)
    {
        if ($category->children) {
            foreach ($category->children as $child) {
                // Add products from this child
                if ($child->products) {
                    $productIds = $productIds->merge($child->products->pluck('id'));
                }

                // Recursively collect from grandchildren
                $this->collectProductsFromChildren($child, $productIds);
            }
        }
    }

    // Add this helper method to get product filters for a category
    // Add this new method to get filter options from category and all descendants
    private function getRelatedFilterOptionIds($category)
    {
        $productIds = collect();

        // Add products from current category
        if ($category->products) {
            $productIds = $productIds->merge($category->products->pluck('id'));
        }

        // Add products from all descendant categories recursively
        $this->collectProductsFromChildren($category, $productIds);

        if ($productIds->isEmpty()) {
            return [];
        }

        // Get unique filter option IDs from all these products
        return \App\Models\FilterOption::whereHas('products', function ($query) use ($productIds) {
            $query->whereIn('products.id', $productIds);
        })->distinct()->pluck('id')->toArray();
    }

    private function getProductFilters($category)
    {
        $productIds = collect();

        // Add products from current category
        if ($category->products) {
            $productIds = $productIds->merge($category->products->pluck('id'));
        }

        // Add products from all descendant categories recursively
        $this->collectProductsFromChildren($category, $productIds);

        if ($productIds->isEmpty()) {
            return collect();
        }

        // Get filters of type 'product' that have options associated with these products
        $filters = \App\Models\Filter::whereIn('type', ['product', 'both'])
            ->with([
                'options' => function ($query) use ($productIds) {
                    $query->whereHas('products', function ($q) use ($productIds) {
                        $q->whereIn('products.id', $productIds);
                    })->distinct();
                }
            ])
            ->get()
            ->filter(function ($filter) {
                // Only return filters that have at least one option
                return $filter->options->count() > 0;
            });

        return $filters;
    }


    // Add this method for AJAX filtering (optional but recommended)
    public function filterCategoryContent(Request $request, $id)
    {
        $category = Category::with([
            'children.children.products.brand',
            'children.products.brand'
        ])->findOrFail($id);

        $selectedCategories = $request->input('categories', []);
        $selectedBrands = $request->input('brands', []);

        $results = [
            'subcategories' => [],
            'products' => []
        ];

        foreach ($category->children as $subcategory) {
            // If no category filter or this subcategory is selected
            if (empty($selectedCategories) || in_array($subcategory->id, $selectedCategories)) {

                $subcategoryData = [
                    'id' => $subcategory->id,
                    'name' => $subcategory->name,
                    'description' => $subcategory->description,
                    'image' => $subcategory->image,
                    'hasChildren' => $subcategory->children->count() > 0,
                    'products' => []
                ];

                // Filter products by brand if needed
                if ($subcategory->products) {
                    foreach ($subcategory->products as $product) {
                        if (empty($selectedBrands) || in_array($product->brand_id, $selectedBrands)) {
                            $subcategoryData['products'][] = [
                                'id' => $product->id,
                                'name' => $product->name,
                                'serial_number' => $product->serial_number,
                                'images' => $product->images
                            ];
                        }
                    }
                }

                $results['subcategories'][] = $subcategoryData;
            }
        }

        return response()->json($results);
    }

    public function filterProducts(Request $request)
    {
        try {
            Log::info('FilterProducts request received', $request->all());
            $query = Product::with(['brand', 'category']);

            // Parent category filtering
            if ($parentId = $request->input('parent_id')) {
                $query->whereHas('category', function ($q) use ($parentId) {
                    $q->where('id', $parentId)
                        ->orWhere('parent_id', $parentId); // Also include products directly in subcategories of parent
                });
            }

            // Category filtering (if needed, though parent_id might cover it)
            if ($request->has('categories')) {
                $categories = json_decode($request->categories, true);
                if (is_array($categories) && !empty($categories)) {
                    $query->whereIn('category_id', $categories);
                }
            }

            // Brand filtering
            if ($request->has('brands')) {
                $brands = json_decode($request->brands, true);
                if (is_array($brands) && !empty($brands)) {
                    $query->whereIn('brand_id', $brands);
                }
            }

            // Product Filters
            if ($request->has('filters')) {
                $filters = json_decode($request->filters, true);
                if (is_array($filters) && !empty($filters)) {
                    foreach ($filters as $filterId => $optionIds) {
                        if (!empty($optionIds)) {
                            $query->whereHas('filters', function ($q) use ($optionIds) {
                                $q->whereIn('filter_options.id', $optionIds);
                            });
                        }
                    }
                }
            }

            $products = $query->latest()->paginate(12);

            $baseUrl = rtrim($request->getSchemeAndHttpHost(), '/'); // Ensure no trailing slash

            // Helper function to construct the full image URL
            $constructFullUrl = function ($imageName) use ($baseUrl) {
                if (empty($imageName)) {
                    return null;
                }
                // If $imageName is already a full HTTP/HTTPS URL, return it directly.
                if (preg_match('/^https?:\/\//', $imageName)) {
                    return $imageName;
                }
                // Remove any leading slashes from $imageName to standardize.
                $imageName = ltrim($imageName, '/');

                // If $imageName starts with 'public/', it's already structured for $baseUrl.
                // e.g., $imageName = 'public/Uploads/products/file.jpg'
                if (strpos($imageName, 'public/') === 0) {
                    return $baseUrl . '/' . $imageName;
                }

                // If $imageName starts with 'Uploads/products/', this is a common case.
                // Prepend '/public/' to make it: $baseUrl . '/public/Uploads/products/file.jpg'
                if (strpos($imageName, 'Uploads/products/') === 0) {
                    return $baseUrl . '/public/' . $imageName;
                }

                // If $imageName is just a filename (e.g., 'file.jpg'), assume it belongs in the standard product image path.
                return $baseUrl . '/public/Uploads/products/' . $imageName;
            };


            $transformedProducts = $products->through(function ($product) use ($baseUrl, $constructFullUrl) {
                $image_path_final = null;

                // Prioritize 'images' field (JSON string or array)
                if ($product->images) {
                    $imagesArr = [];
                    if (is_string($product->images)) {
                        try {
                            $imagesArr = json_decode($product->images, true);
                            if (json_last_error() !== JSON_ERROR_NONE)
                                $imagesArr = [];
                        } catch (\Exception $e) {
                            Log::warning("Failed to parse images JSON for product {$product->id}: {$e->getMessage()}");
                            $imagesArr = [];
                        }
                    } elseif (is_array($product->images)) {
                        $imagesArr = $product->images;
                    }

                    if (!empty($imagesArr) && is_array($imagesArr) && !empty($imagesArr[0])) {
                        $image_path_final = $constructFullUrl($imagesArr[0]);
                    }
                }

                // Fallback to 'image' field if 'images' didn't yield a path
                if (!$image_path_final && $product->image) {
                    $image_path_final = $constructFullUrl($product->image);
                }

                // Fallback to default no-image placeholder
                if (!$image_path_final) {
                    // Ensure this path is correct for your application's no-image.png
                    $image_path_final = $baseUrl . '/public/images/no-image.png';
                }

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'short_description' => $product->small_description, // Assuming this is the correct field
                    'image_path' => $image_path_final,
                    'serial_number' => $product->serial_number,
                    'selling_price' => $product->selling_price,
                    'category' => $product->category ? [
                        'id' => $product->category->id,
                        'name' => $product->category->name
                    ] : null,
                    'brand' => $product->brand ? [
                        'id' => $product->brand->id,
                        'name' => $product->brand->name
                    ] : null
                ];
            });

            return response()->json([
                'status' => 200,
                'message' => 'Products filtered successfully',
                'products' => $transformedProducts->items(),
                'pagination' => [
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'total' => $products->total()
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Product filtering error: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while filtering products.',
                'error' => $e->getMessage() // Provide error in dev, but maybe not in prod
            ], 500);
        }
    }


    public function filterSubcategories(Request $request)
    {
        $categories = $request->input('categories') ? explode(',', $request->input('categories')) : [];
        $brands = $request->input('brands') ? explode(',', $request->input('brands')) : [];
        $parentId = $request->input('parent_id');

        $productsQuery = Product::with(['brand', 'category']);

        if ($parentId) {
            $productsQuery->where('category_id', $parentId);
        }

        if (!empty($brands)) {
            $productsQuery->whereIn('brand_id', $brands);
        }

        if (!empty($categories)) {
            $productsQuery->whereIn('category_id', $categories);
        }

        $products = $productsQuery->get();

        $subcategories = Category::where('parent_id', $parentId)->get();

        return response()->json([
            'subcategories' => $subcategories,
            'products' => $products
        ]);
    }

    public function storeProduct(Request $request) // This seems like an admin function
    {
        $product = new Product();

        if ($request->hasFile('image')) {
            // Storing in 'public/Uploads/products'
            // The path stored in DB will be 'Uploads/products/filename.ext'
            $imagePath = $request->file('image')->store('Uploads/products', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return redirect()->route('products.index'); // Assuming an admin route
    }

    public function update(Request $request, $id) // This seems like an admin function
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            // 'price' => 'required|numeric', // Price was in original, uncomment if needed
            'documents.*.type' => 'required|string',
            'documents.*.file_path' => 'nullable|file|mimes:pdf,doc,docx,zip',
        ]);

        $productData = ['name' => $request->input('name')];
        // if ($request->has('price')) {
        //     $productData['price'] = $request->input('price');
        // }
        $product->update($productData);


        if ($request->has('documents')) {
            foreach ($request->input('documents') as $index => $documentData) {
                $filePath = $documentData['file_path'] ?? null; // Keep existing if no new file
                if ($request->hasFile("documents.$index.file_path")) {
                    $filePath = $request->file("documents.$index.file_path")->store('documents', 'public');
                }

                $product->documents()->updateOrCreate(
                    ['id' => $documentData['id'] ?? null], // Use id for existing docs
                    [
                        'type' => $documentData['type'],
                        'file_path' => $filePath,
                    ]
                );
            }
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully.'); // Assuming an admin route
    }

    public function getSubcategories(Request $request)
    {
        $subcategories = Category::whereIn('parent_id', $request->categories)->get();
        return response()->json($subcategories);
    }
    public function showCategoryWithBrand($brand_id, $category_id)
    {
        // Fetch brand and category
        $brand = Brand::findOrFail($brand_id);
        $category = Category::with(['children', 'products'])->findOrFail($category_id);
        $allBrands = Brand::all();

        // Log for debugging
        Log::info("showCategoryWithBrand called", [
            'brand_id' => $brand_id,
            'category_id' => $category_id,
            'category_name' => $category->name,
            'child_count' => $category->children->count()
        ]);

        // Build breadcrumb
        $breadcrumb = [];
        $currentCategory = $category;
        $crumbCategories = [];
        while ($currentCategory) {
            $crumbCategories[] = $currentCategory;
            $currentCategory = $currentCategory->parent;
        }
        $breadcrumb = array_merge([
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Brands', 'url' => route('brand')],
            ['name' => $brand->name, 'url' => route('brand.products', $brand->id)],
        ], array_reverse(array_map(function ($cat) {
            return ['name' => $cat->name, 'url' => null];
        }, $crumbCategories)));

        // Fetch recently viewed items
        $recentlyViewedIds = session('recently_viewed_items', []);
        $recentlyViewedItems = Product::whereIn('id', $recentlyViewedIds)
            ->with(['category', 'brand'])
            ->get()
            ->sortBy(function ($item) use ($recentlyViewedIds) {
                return array_search($item->id, $recentlyViewedIds);
            })
            ->values();

        // Check if category has child categories
        if ($category->children->count() > 0) {
            // Category has children, show subcategories using products.blade.php
            $products = Product::with(['category', 'brand'])
                ->where('brand_id', $brand_id)
                ->where(function ($query) use ($category_id) {
                    $query->where('category_id', $category_id)
                        ->orWhereHas('category', function ($subQuery) use ($category_id) {
                            $subQuery->where('parent_id', $category_id);
                        });
                })
                ->paginate(12);

            // Fetch main categories for filter
            $categories = Category::whereNull('parent_id')
                ->whereHas('children', function ($query) use ($brand_id) {
                    $query->whereHas('products', function ($subQuery) use ($brand_id) {
                        $subQuery->where('brand_id', $brand_id);
                    })->orWhereHas('children', function ($subQuery) use ($brand_id) {
                        $subQuery->whereHas('products', function ($subSubQuery) use ($brand_id) {
                            $subSubQuery->where('brand_id', $brand_id);
                        });
                    });
                })
                ->with([
                    'children' => function ($query) {
                        $query->with('children');
                    }
                ])
                ->get();

            return view('brand.products', compact('brand', 'products', 'breadcrumb', 'categories', 'allBrands', 'recentlyViewedItems'));
        } else {
            // No child categories, show products using show.blade.php
            $products = Product::with(['category', 'brand'])
                ->where('brand_id', $brand_id)
                ->where('category_id', $category_id)
                ->get();

            // Log products for debugging
            Log::info("Products for category $category_id and brand $brand_id", [
                'product_count' => $products->count(),
                'product_ids' => $products->pluck('id')->toArray()
            ]);

            // Pass brands for the filter
            $brands = Brand::all();

            return view('brand.show', compact('category', 'products', 'brands', 'breadcrumb', 'recentlyViewedItems'));
        }
    }
}
