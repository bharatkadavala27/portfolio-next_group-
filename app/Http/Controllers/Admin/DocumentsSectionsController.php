<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\DocumentBrand;
use App\Models\DocumentCategory;
use App\Models\DocumentsSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DocumentsSectionsController extends Controller
{

    private function getCategoryHierarchyPrefix($categoryName)
    {
        $category = DocumentCategory::where('name', $categoryName)->first();
        if (!$category) {
            return '';
        }

        $level = 0;
        $parent = $category;
        while ($parent && $parent->parent_id) {
            $level++;
            $parent = DocumentCategory::find($parent->parent_id);
        }

        return str_repeat('-', $level);
    }

    private function formatCategoriesWithHierarchy()
    {
        $roots = DocumentCategory::whereNull('parent_id')->with('children')->get();
        $formattedCategories = collect();

        foreach ($roots as $root) {
            $root->formatted_name = $root->name;
            $formattedCategories->push($root);

            foreach ($root->children as $child) {
                $child->formatted_name = '&nbsp;&nbsp;&nbsp;-- ' . $child->name;
                $formattedCategories->push($child);
            }
        }

        return $formattedCategories;
    }

    public function create()
    {
        $categories = DocumentCategory::all();
        $documentTypes = DocumentType::all();
        $documentCategories = $this->formatCategoriesWithHierarchy();
        $documentBrands = DocumentBrand::all();
        $filters = \App\Models\Filter::with('options')
            ->whereIn('type', ['document', 'both'])
            ->get();

        return view('admin.documents-sections.create', compact('categories', 'documentTypes', 'documentCategories', 'documentBrands', 'filters'));
    }

    public function index()
    {
        $documents = DocumentsSection::with(['filters'])->get();

        $documents->each(function ($document) {
            $prefix = $this->getCategoryHierarchyPrefix($document->document_category);
            $document->category_display = $prefix ? $prefix . ' ' . $document->document_category : $document->document_category;
        });

        return view('admin.documents-sections.index', compact('documents'));
    }

    public function edit($id)
    {
        $document = DocumentsSection::with('filters')->findOrFail($id);
        $categories = DocumentCategory::all();
        $documentTypes = DocumentType::all();
        $documentCategories = $this->formatCategoriesWithHierarchy();
        $documentBrands = DocumentBrand::all();
        $filters = \App\Models\Filter::with('options')
            ->whereIn('type', ['document', 'both'])
            ->get();

        return view('admin.documents-sections.edit', compact('document', 'categories', 'documentTypes', 'documentCategories', 'documentBrands', 'filters'));
    }


    public function store(Request $request)
    {
        try {
            $request->validate([
                'document_name' => 'required|string|max:255',
                'document_type' => 'required|exists:document_types,id',
                'document_category' => 'required|exists:document_categories,id',
                'document_brand' => 'required|exists:document_brands,id',
                'description' => 'nullable|string',
                'documents' => 'required_without:file_link|array',
                'documents.*' => 'required_without:file_link|file',
                'file_link' => 'required_without:documents|nullable|url',
                'filter_id' => 'nullable|array',
                'filter_id.*' => 'nullable|exists:filters,id',
                'filter_option_id' => 'nullable|array',
                'filter_option_id.*' => 'nullable|exists:filter_options,id',

                'version_date' => 'nullable|date',
                'version' => 'nullable|string',
                'size' => 'nullable|string',
            ]);

            // Resolve names
            $documentType = DocumentType::findOrFail($request->document_type)->name;
            $documentCategory = DocumentCategory::findOrFail($request->document_category)->name;
            $documentBrand = DocumentBrand::findOrFail($request->document_brand)->name;

            // Handle file uploads
            $uploadedFiles = [];
            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $file) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('documents-sections'), $filename);
                    $uploadedFiles[] = 'documents-sections/' . $filename;
                }
            }

            $document = DocumentsSection::create([
                'document_name' => $request->document_name,
                'document_type' => $documentType,
                'document_category' => $documentCategory,
                'document_brand' => $documentBrand,
                'description' => $request->description,
                'file_path' => !empty($uploadedFiles) ? implode(',', $uploadedFiles) : null,
                'documents' => !empty($uploadedFiles) ? implode(',', array_map(function ($file) {
                    return basename($file);
                }, $uploadedFiles)) : null,
                'file_link' => $request->file_link,
                'language' => 'English',
                'version_date' => $request->version_date,
                'version' => $request->version,
                'size' => $request->size,
            ]);

            // Sync filter options pivot
            if ($request->filled('filter_option_id') && $document) {
                $selectedOptions = array_filter($request->input('filter_option_id', []));
                $selectedOptions = array_values(array_unique(array_map('intval', $selectedOptions)));
                $document->filters()->sync($selectedOptions);
            }

            return redirect()->route('admin.documents-sections.index')
                ->with('success', 'Document section created successfully.');

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Document upload error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error creating document: ' . $e->getMessage())->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'document_name' => 'required|string|max:255',
                'document_type' => 'required',
                'document_category' => 'required',
                'document_brand' => 'required',
                'description' => 'nullable|string',
                'documents.*' => 'nullable|file',
            ]);

            $document = DocumentsSection::findOrFail($id);

            // Validate and fetch related models
            $documentType = DocumentType::findOrFail($request->document_type);
            $documentCategory = DocumentCategory::findOrFail($request->document_category);
            $documentBrand = DocumentBrand::findOrFail($request->document_brand);

            // Handle file uploads
            $uploadedFiles = $document->file_path ? explode(',', $document->file_path) : [];
            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $file) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('documents-sections'), $filename);
                    $uploadedFiles[] = 'documents-sections/' . $filename;
                }
            }

            $document->update([
                'document_name' => $request->document_name,
                'document_type' => $documentType->name,
                'document_category' => $documentCategory->name,
                'document_brand' => $documentBrand->name,
                'description' => $request->description,
                'file_path' => implode(',', $uploadedFiles),
                'documents' => implode(',', array_map(function ($file) {
                    return basename($file);
                }, $uploadedFiles)),
                // if file_link is present but empty, set to null so cleared; otherwise save provided value
                'file_link' => $request->has('file_link') ? ($request->filled('file_link') ? $request->file_link : null) : $document->file_link,
                'version_date' => $request->filled('version_date') ? $request->version_date : null,
                'version' => $request->filled('version') ? $request->version : null,
                'size' => $request->filled('size') ? $request->size : null,
            ]);

            // Sync selected filter options if provided
            if ($request->has('filter_option_id')) {
                $selectedOptions = array_filter($request->input('filter_option_id', []));
                $selectedOptions = array_values(array_map('intval', $selectedOptions));
                $document->filters()->sync($selectedOptions);
            }

            return redirect()->route('admin.documents-sections.index')
                ->with('success', 'Document section updated successfully.');

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Update error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error updating document: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $document = DocumentsSection::findOrFail($id);
        $filePaths = explode(',', $document->file_path);

        // Delete files from public directory
        foreach ($filePaths as $path) {
            $fullPath = public_path($path);
            if (File::exists($fullPath)) {
                File::delete($fullPath);
            }
        }

        $document->delete();
        return redirect()->route('admin.documents-sections.index')
            ->with('success', 'Document deleted successfully.');
    }

    public function deleteFile(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|string',
                'document_id' => 'required|integer|exists:documents_sections,id',
            ]);

            $document = DocumentsSection::findOrFail($request->document_id);
            $fileToRemove = $request->file;

            if (!File::exists(public_path($fileToRemove))) {
                return response()->json([
                    'success' => false,
                    'message' => 'File not found on server.'
                ]);
            }

            // Delete file from disk
            File::delete(public_path($fileToRemove));

            // Remove file from document's file_path and documents columns
            $files = array_filter(explode(',', $document->file_path ?? ''), function ($f) use ($fileToRemove) {
                return trim($f) !== '' && $f !== $fileToRemove;
            });

            $fileNames = array_filter(explode(',', $document->documents ?? ''), function ($f) use ($fileToRemove) {
                return trim($f) !== '' && $f !== basename($fileToRemove);
            });

            $document->update([
                'file_path' => count($files) ? implode(',', array_values($files)) : null,
                'documents' => count($fileNames) ? implode(',', array_values($fileNames)) : null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'File removed successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Error removing file: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove file: ' . $e->getMessage()
            ]);
        }
    }

    public function cleanUpDocuments()
    {
        $documents = Document::all();

        foreach ($documents as $document) {
            if (is_null($document->file_path) || !File::exists(public_path($document->file_path))) {
                $document->delete();
            }
        }

        return response()->json(['success' => true, 'message' => 'Documents cleaned up successfully.']);
    }
}
