<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentBrand;
use App\Models\DocumentCategory;
// ...existing use statements...
use App\Models\DocumentsSection;
use App\Models\DocumentType;
use Illuminate\Support\Facades\Log;
use App\Models\Filter;
use Illuminate\Support\Facades\DB;
use App\Models\FilterOption;


class DownloadController extends Controller
{
    /**
     * Display the download page with initial data.
     */
    public function downloadPage()
    {
        try {
            $categories = DocumentCategory::whereNull('parent_id')->get();
            $documentCategories = DocumentCategory::all();
            $documentBrands = DocumentBrand::all();
            $documents = DocumentsSection::all();

            return view('frontend.pages.download', compact('categories', 'documentCategories', 'documentBrands', 'documents'));
        } catch (\Exception $e) {
            Log::error('Error in downloadPage: ' . $e->getMessage());
            return back()->with('error', 'Error loading the download page.');
        }
    }

    /**
     * Fetch all document languages.
     */
    public function fetchDocumentLanguages(Request $request)
    {
        try {
            // Get unique languages from DocumentsSection
            $languages = \App\Models\DocumentsSection::query()
                ->select('language')
                ->whereNotNull('language')
                ->distinct()
                ->orderBy('language')
                ->pluck('language')
                ->filter(fn($lang) => trim($lang) !== '')
                ->values();

            $result = $languages->map(fn($lang) => ['name' => $lang]);
            return response()->json(['documentLanguages' => $result]);
        } catch (\Exception $e) {
            Log::error('Error in fetchDocumentLanguages: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch document languages.'], 500);
        }


        // Filter by subcategory
        if ($request->has('subcategory') && !empty($request->subcategory)) {
            $subcategoryNames = DocumentCategory::whereIn('id', $request->subcategory)->pluck('name');
            $query->whereIn('document_category', $subcategoryNames);
        }

        // Filter by brand
        if ($request->has('brand') && !empty($request->brand)) {
            $brandNames = DocumentBrand::whereIn('id', $request->brand)->pluck('name');
            $query->whereIn('document_brand', $brandNames);
        }

        // Search by document name
        if ($request->has('search') && !empty($request->search)) {
            $query->where('document_name', 'LIKE', '%' . $request->search . '%');
        }

        $documents = $query->get();

        if ($request->ajax()) {
            return response()->json(['documents' => $documents]);
        }

        return view('frontend.pages.download', compact('categories', 'brands', 'documents', 'documentCategories'));
    }

    /**
     * Fetch subcategories for given parent categories.
     */
    public function fetchSubcategories(Request $request)
    {
        $subcategories = DocumentCategory::whereIn('parent_id', $request->category_ids)
            ->orderBy('serial_number')
            ->get();
        return response()->json(['subcategories' => $subcategories]);
    }

    /**
     * Filter documents dynamically.
     */
    public function filterDocuments(Request $request)
    {
        try {
            $query = DocumentsSection::query();

            // Filter by language
            if ($request->has('documentlanguage') && !empty($request->documentlanguage)) {
                $languages = is_array($request->documentlanguage) ? $request->documentlanguage : [$request->documentlanguage];
                $query->whereIn('language', $languages);
            }

            // Filter by document type
            if ($request->has('documenttype') && !empty($request->documenttype)) {
                $types = is_array($request->documenttype) ? $request->documenttype : [$request->documenttype];
                $query->whereIn('document_type', $types);
            }

            // Filter by brand
            if ($request->has('documentbrand') && !empty($request->documentbrand)) {
                $brandNames = DocumentBrand::whereIn('id', (array) $request->documentbrand)->pluck('name')->toArray();
                if (!empty($brandNames)) {
                    $query->whereIn('document_brand', $brandNames);
                }
            }

            // Filter by categories
            if ($request->has('documentcategory') && !empty($request->documentcategory)) {
                $categoryNames = DocumentCategory::whereIn('id', (array) $request->documentcategory)
                    ->pluck('name')
                    ->toArray();

                if (!empty($categoryNames)) {
                    $query->where(function ($q) use ($categoryNames) {
                        foreach ($categoryNames as $name) {
                            $q->orWhere('document_category', $name);
                        }
                    });
                }
            }

            // Include parent + subcategories if parent_category_id is given
            if ($request->has('parent_category_id')) {
                $parentCategory = DocumentCategory::find($request->parent_category_id);
                if ($parentCategory) {
                    $categoryNames = [$parentCategory->name];
                    $subcategories = DocumentCategory::where('parent_id', $parentCategory->id)->pluck('name');
                    $categoryNames = array_merge($categoryNames, $subcategories->toArray());

                    $query->where(function ($q) use ($categoryNames) {
                        foreach ($categoryNames as $name) {
                            $q->orWhere('document_category', $name);
                        }
                    });
                }
            }

            // Search filter
            if ($request->has('search') && !empty($request->search)) {
                $query->where('document_name', 'LIKE', '%' . $request->search . '%');
            }

            // Filter by dynamic filter options (filter_options[])
            // Expecting an array of filter_option ids. Desired semantics:
            // - OR within the same filter (multiple options of same filter -> match any)
            // - AND across different filters (if options from multiple filters selected -> document must match all filters)
            if ($request->has('filter_options') && !empty($request->filter_options)) {
                $selectedOptionIds = is_array($request->filter_options) ? $request->filter_options : [$request->filter_options];

                // Map option id -> filter_id
                $optionToFilter = FilterOption::whereIn('id', $selectedOptionIds)
                    ->pluck('filter_id', 'id')
                    ->toArray();

                // Group option ids by their parent filter_id
                $grouped = [];
                foreach ($selectedOptionIds as $optId) {
                    $filterId = $optionToFilter[$optId] ?? null;
                    if ($filterId) {
                        $grouped[$filterId][] = $optId;
                    }
                }

                // For each filter group, add a whereHas that accepts any of the options (OR within a filter)
                foreach ($grouped as $filterId => $optionIdsForFilter) {
                    $query->whereHas('filters', function ($q) use ($optionIdsForFilter) {
                        $q->whereIn('id', $optionIdsForFilter);
                    });
                }
            }

            // Debugging SQL
            Log::info('Generated SQL:', [
                'query' => $query->toSql(),
                'bindings' => $query->getBindings()
            ]);

            // Format documents
            $documents = $query->get()->map(function ($doc) {
                return [
                    'id' => $doc->id,
                    'document_name' => $doc->document_name,
                    'document_type' => $doc->document_type,
                    'document_category' => $doc->document_category,
                    'document_brand' => $doc->document_brand,
                    'description' => $doc->description,
                    'language' => $doc->language,
                    'files' => collect(explode(',', $doc->file_path))->map(function ($path) {
                        return [
                            'name' => basename($path),
                            'url' => asset('/' . $path)
                        ];
                    })->toArray()
                ];
            });

            return response()->json(['documents' => $documents]);
        } catch (\Exception $e) {
            Log::error('Filter error:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show documents under a specific category.
     */

    public function categoryDocuments($id)
    {
        try {
            $category = DocumentCategory::findOrFail($id);
            $subcategories = DocumentCategory::where('parent_id', $category->id)
                ->orderBy('serial_number')
                ->get();

            // collect selected filter option ids from query (GET)
            $selectedOptions = request()->input('filter_options', []);

            // Collect other selected filters
            $selectedTypes = request()->input('documenttype', []); // Array of names
            $selectedBrands = request()->input('documentbrand', []); // Array of names
            if (!is_array($selectedTypes))
                $selectedTypes = [$selectedTypes];
            if (!is_array($selectedBrands))
                $selectedBrands = [$selectedBrands];


            // If subcategories exist, load documents per subcategory and apply filters per-subcategory
            $visibleDocumentIds = collect();
            if ($subcategories->count() > 0) {
                foreach ($subcategories as $subcategory) {
                    $q = DocumentsSection::where('document_category', $subcategory->name);

                    // apply selected filter options (AND across selected option ids)
                    if (!empty($selectedOptions)) {
                        // Simplify: Group selected options by filter to apply correct AND/OR logic if needed
                        // For now, assuming standard behavior: all selected options must match (or OR within filter?)
                        // Usually dynamic filters are AND across filters, OR within.
                        // But for simplicity of this refactor, let's keep existing logic or improve slightly.
                        foreach ((array) $selectedOptions as $optId) {
                            $q->whereHas('filters', function ($qq) use ($optId) {
                                $qq->where('filter_options.id', $optId);
                            });
                        }
                    }

                    if (!empty($selectedTypes)) {
                        $q->whereIn('document_type', $selectedTypes);
                    }
                    if (!empty($selectedBrands)) {
                        $q->whereIn('document_brand', $selectedBrands);
                    }


                    $subcategory->documents = $q->get();
                    $visibleDocumentIds = $visibleDocumentIds->merge($subcategory->documents->pluck('id'));
                }
                $documents = collect([]);
            } else {
                $q = DocumentsSection::where('document_category', $category->name);

                if (!empty($selectedOptions)) {
                    foreach ((array) $selectedOptions as $optId) {
                        $q->whereHas('filters', function ($qq) use ($optId) {
                            $qq->where('filter_options.id', $optId);
                        });
                    }
                }

                if (!empty($selectedTypes)) {
                    $q->whereIn('document_type', $selectedTypes);
                }
                if (!empty($selectedBrands)) {
                    $q->whereIn('document_brand', $selectedBrands);
                }

                $documents = $q->get();
                $visibleDocumentIds = $documents->pluck('id');
            }

            // Build filters limited to options present in currently visible documents
            $visibleDocumentIds = $visibleDocumentIds->unique()->values()->toArray();

            // 1. Fetch Ordered Filters (System + Dynamic)
            $allOrderedFilters = Filter::where('download_sequence', '>', 0)->orderBy('download_sequence', 'asc')->get();

            // 2. Prepare Dynamic Filter Data (Options present in visible docs)
            $availableDynamicOptions = [];
            if (!empty($visibleDocumentIds)) {
                $availableDynamicOptions = DB::table('document_section_filter')
                    ->whereIn('document_id', $visibleDocumentIds)
                    ->pluck('filter_option_id')
                    ->unique()
                    ->toArray();
            }

            // 3. Prepare System Filter Data
            // We need unique Types and Brands from the VISIBLE documents
            $visibleDocuments = DocumentsSection::whereIn('id', $visibleDocumentIds)->get();
            $availableTypes = $visibleDocuments->pluck('document_type')->unique()->filter()->values();
            $availableBrands = $visibleDocuments->pluck('document_brand')->unique()->filter()->values();


            // 4. Map Filters to View Data
            $mappedFilters = $allOrderedFilters->map(function ($filter) use ($subcategories, $availableDynamicOptions, $availableTypes, $availableBrands, $category) {

                // Clone/Modify filter to attach data without saving to DB
                $filter->viewData = [];
                $filter->isVisible = false;

                if ($filter->key === 'subcategory_system') {
                    // Subcategories are strictly those of the current category (already fetched)
                    $filter->viewData = $subcategories;
                    $filter->isVisible = $subcategories->count() > 0;
                    $filter->systemType = 'subcategory';

                } elseif ($filter->key === 'document_type_system') {
                    // Show types available in current visible docs
                    // Or should we show ALL types found in the Category even if not in current filtered result?
                    // Standard facet behavior: show available in current context.
                    $filter->viewData = $availableTypes;
                    $filter->isVisible = $availableTypes->count() > 0;
                    $filter->systemType = 'document_type';

                } elseif ($filter->key === 'brand_system') {
                    $filter->viewData = $availableBrands;
                    $filter->isVisible = $availableBrands->count() > 0;
                    $filter->systemType = 'brand';

                } elseif ($filter->key === 'category_system') {
                    // Category system filter usually implies "Navigate to other categories" or "Parent/Child"
                    // In DownloadController context, usually we are IN a category. 
                    // Let's hide it unless there's specific logic needed.
                    $filter->isVisible = false;

                } else {
                    // Dynamic Filter
                    // Load options that are available
                    $options = $filter->options->whereIn('id', $availableDynamicOptions);
                    $filter->viewData = $options;
                    $filter->isVisible = $options->count() > 0;
                    $filter->systemType = 'dynamic';
                }

                return $filter;
            });

            // Filter out invisible ones if desired, or keep them to show enabled/disabled state. 
            // For now, let's keep them but view handle visibility? 
            // Better to filter out completely empty ones to clear up UI
            $mappedFilters = $mappedFilters->filter(function ($f) {
                return $f->isVisible;
            });

            return view('frontend.pages.category-documents', [
                'category' => $category,
                'documents' => $documents,
                'subcategories' => $subcategories, // Keep sending for backward compatibility if needed by view parts
                'parentCategory' => $category->parent_id === null ? $category : DocumentCategory::find($category->parent_id),
                'filters' => $mappedFilters, // This is the new master list
                'selectedOptions' => (array) $selectedOptions,
                'selectedTypes' => (array) $selectedTypes,
                'selectedBrands' => (array) $selectedBrands,
            ]);

        } catch (\Exception $e) {
            Log::error('Error in categoryDocuments:', [
                'message' => $e->getMessage(),
                'category_id' => $id
            ]);
            return back()->with('error', 'Error loading documents.');
        }
    }

    /**
     * Fetch all document types.
     */
    public function fetchDocumentTypes(Request $request)
    {
        try {
            $types = DocumentType::select('name')->orderBy('serial_number')->orderBy('name')->get();
            return response()->json([
                'documentTypes' => $types->map(fn($type) => ['name' => $type->name])
            ]);
        } catch (\Exception $e) {
            Log::error('Error in fetchDocumentTypes: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch document types.'], 500);
        }
    }

    /**
     * Fetch all document brands.
     */
    public function fetchDocumentBrands(Request $request)
    {
        try {
            $brands = DocumentBrand::orderBy('serial_number')->orderBy('name')->get();
            return response()->json(['documentBrands' => $brands]);
        } catch (\Exception $e) {
            Log::error('Error in fetchDocumentBrands: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch document brands.'], 500);
        }
    }
}
