<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use App\Models\DocumentsSection;

class DocumentsSectionsController extends Controller
{
    // public function index()
    // {
    //     $documents = Document::with('category', 'brand')->get();
    //     return view('admin.documents-sections.index', compact('documents'));
    // }

    public function index()
    {
        $documents = DocumentsSection::with('documentType', 'documentCategory', 'documentBrand')->get();
        return view('frontend.pages.category-documents', compact('documents'));
    }

    public function create()
    {
        return view('admin.documents-sections.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'document_name' => 'required|string|max:255',
            'document_type' => 'required|string|max:255',
            'category_name' => 'required|string|max:255',
            'brand_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file_path' => 'required|string|max:255',
        ]);

        Document::create([
            'document_name' => $request->document_name,
            'document_type' => $request->document_type,
            'category_name' => $request->category_name,
            'brand_name' => $request->brand_name,
            'description' => $request->description,
            'file_path' => $request->file_path,
        ]);

        return redirect()->route('documents-sections.index')->with('success', 'Document section created successfully.');
    }

    public function edit($id)
    {
        $document = Document::findOrFail($id);
        return view('admin.documents-sections.edit', compact('document'));
    }

    // ...other methods like create, store, edit, update, destroy...
}
