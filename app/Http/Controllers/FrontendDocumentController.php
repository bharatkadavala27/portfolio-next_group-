<?php

namespace App\Http\Controllers;

use App\Models\Filter;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use App\Models\DocumentBrand;
use App\Models\DocumentCategory;
use App\Models\DocumentsSection;
use App\Models\FilterOption;
use Illuminate\Support\Facades\Log;

class FrontendDocumentController extends Controller
{
    public function showCategoryDocuments()
    {
        $documents = DocumentsSection::with([
            'documentType',
            'documentCategory',
            'documentBrand',
            'filterOptions' // make sure this relation exists
        ])->get()->map(function ($doc) {
            $fileNames = array_filter(explode(',', $doc->documents));
            $files = array_map(function ($fileName) {
                return [
                    'name' => $fileName,
                    'url' => url('public/documents-sections/' . $fileName)
                ];
            }, $fileNames);
            
            // Get document type image if available
            $docTypeImage = null;
            if ($doc->documentType && $doc->documentType->image) {
                $docTypeImage = $doc->documentType->image;
            }

            return [
                'id' => $doc->id,
                'document_name' => (string) $doc->document_name,
                'document_type' => (string) $doc->document_type,
                'document_category' => (string) $doc->document_category,
                'document_brand' => (string) $doc->document_brand,
                'description' => (string) $doc->description,
                'files' => $files,
                'size' => $doc->size !== null ? (string) $doc->size : '',
                'version' => $doc->version !== null ? (string) $doc->version : '',
                'version_date' => $doc->version_date ? (is_object($doc->version_date) ? $doc->version_date->toDateString() : (string) $doc->version_date) : '',
                'language' => $doc->language !== null ? (string) $doc->language : '',
                'file_link' => $doc->file_link !== null ? (string) $doc->file_link : '',
                'document_type_image' => $docTypeImage,
            ];
        });

        // Fetch filters with their options
        $filters = Filter::with('options')->get();

        Log::info('Frontend documents data:', $documents->toArray());

        // Pass both $documents and $filters to the view
        return view('frontend.pages.category-documents', compact('documents', 'filters'));
    }


    public function fetchDocumentCategories()
    {
        $documentCategories = DocumentsSection::select('document_category')
            ->distinct()
            ->whereNotNull('document_category')
            ->get()
            ->map(function ($doc) {
                return ['id' => $doc->document_category, 'name' => $doc->document_category];
            });

        return response()->json(['documentCategories' => $documentCategories]);
    }

    public function fetchDocumentTypes()
    {
        $types = DocumentsSection::select('document_type')
            ->distinct()
            ->whereNotNull('document_type')
            ->get()
            ->map(function ($doc) {
                return ['id' => $doc->document_type, 'name' => $doc->document_type];
            });

        return response()->json(['documentTypes' => $types]);
    }

    public function fetchDocumentBrands()
    {
        $brands = DocumentsSection::select('document_brand')
            ->distinct()
            ->whereNotNull('document_brand')
            ->get()
            ->map(function ($doc) {
                return ['id' => $doc->document_brand, 'name' => $doc->document_brand];
            });

        return response()->json(['documentBrands' => $brands]);
    }

    public function filterDocuments(Request $request)
    {
        $query = DocumentsSection::query();

        try {
            // Document Type
            if ($request->has('documenttype') && !empty($request->documenttype)) {
                $query->whereIn('document_type', (array) $request->documenttype);
            }

            // Brand
            if ($request->has('documentbrand') && !empty($request->documentbrand)) {
                $query->whereIn('document_brand', (array) $request->documentbrand);
            }

            // Language
            if ($request->has('documentlanguage') && !empty($request->documentlanguage)) {
                $query->whereIn('language', (array) $request->documentlanguage);
            }

            // Subcategory/Category
            if ($request->has('documentcategory') && !empty($request->documentcategory)) {
                $query->whereIn('document_category', (array) $request->documentcategory);
            } elseif ($request->has('parent_category_id') && !empty($request->parent_category_id)) {
                // Only apply this if no subcategories are selected
                $parentCategory = DocumentCategory::find($request->parent_category_id);
                if ($parentCategory) {
                    // Get names of subcategories
                    $categoryNames = DocumentCategory::where('parent_id', $parentCategory->id)
                        ->pluck('name')
                        ->toArray();
                    // Add the parent category's name to the list
                    $categoryNames[] = $parentCategory->name;

                    $query->whereIn('document_category', $categoryNames);
                }
            }

            // Search
            if ($request->filled('search')) {
                $search = trim($request->search);
                $query->where(function ($q) use ($search) {
                    $q->where('document_name', 'LIKE', "%{$search}%")
                        ->orWhere('description', 'LIKE', "%{$search}%");
                });
            }

            // By ID
            if ($request->has('id')) {
                $query->where('id', $request->id);
            }

            // Limit for suggestions
            if ($request->has('limit')) {
                $query->limit($request->limit);
            }

            // Debug log
            // Handle dynamic filter options (filter_options[])
            // Treat selected options as OR across all selected option ids so selecting
            // options from different filters returns documents that match any selected option.
            if ($request->has('filter_options') && !empty($request->filter_options)) {
                $selectedOptionIds = is_array($request->filter_options) ? $request->filter_options : [$request->filter_options];

                // Add a single whereHas to match any of the selected option ids (OR semantics)
                $query->whereHas('filters', function ($q) use ($selectedOptionIds) {
                    // qualify column name to avoid ambiguity in the generated SQL
                    $q->whereIn('filter_options.id', $selectedOptionIds);
                });
            }

            Log::info('Document filter request', $request->all());

            // Debugging info: log selected filter option ids (if present), SQL, and matching count
            if ($request->has('filter_options') && !empty($request->filter_options)) {
                $selectedOptionIds = is_array($request->filter_options) ? $request->filter_options : [$request->filter_options];
                Log::info('Selected filter option ids', ['selected' => $selectedOptionIds]);
            }

            try {
                Log::info('Filter query SQL', ['sql' => $query->toSql(), 'bindings' => $query->getBindings()]);
                $matchCount = $query->count();
                Log::info('Matching documents count (pre-get)', ['count' => $matchCount]);
            } catch (\Exception $e) {
                Log::error('Error while logging query debug info', ['message' => $e->getMessage()]);
            }

            $documents = $query->with('documentType')->get()->map(function ($doc) {
                $fileNames = array_filter(explode(',', $doc->documents));
                $files = array_map(function ($fileName) {
                    return [
                        'name' => $fileName,
                        'url' => url('public/documents-sections/' . $fileName)
                    ];
                }, $fileNames);
                
                // Get document type image if available
                $docTypeImage = null;
                if ($doc->documentType && $doc->documentType->image) {
                    $docTypeImage = $doc->documentType->image;
                }
                
                return [
                    'id' => $doc->id,
                    'document_name' => $doc->document_name,
                    'document_type' => $doc->document_type,
                    'document_category' => $doc->document_category,
                    'document_brand' => $doc->document_brand,
                    'description' => $doc->description,
                    'files' => $files,
                    'size' => $doc->size,
                    'version' => $doc->version,
                    'version_date' => $doc->version_date,
                    'language' => $doc->language,
                    'file_link' => $doc->file_link,
                    'document_type_image' => $docTypeImage,
                ];
            });

            return response()->json(['documents' => $documents]);
        } catch (\Exception $e) {
            Log::error('Error in filterDocuments:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Error filtering documents'], 500);
        }
    }

    private function getDocumentFiles($document)
    {
        $filePaths = array_filter(explode(',', $document->file_path));
        $docNames = array_filter(explode(',', $document->documents));

        return collect($filePaths)->map(function ($path, $index) use ($docNames) {
            return [
                'name' => $docNames[$index] ?? basename($path),
                'url' => asset('storage/' . $path)
            ];
        })->values()->all();
    }
}
