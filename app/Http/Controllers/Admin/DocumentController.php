<?php

namespace App\Http\Controllers\admin;

use App\Models\Product;
use App\Models\Document;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DocumentController extends Controller
{
    public function index(Product $product)
    {
        return response()->json($product->documents);
    }

    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'type' => 'required|in:Software,PDF,Driver',
            'file_path' => 'required|string',
        ]);

        $document = $product->documents()->create($validated);
        return response()->json($document, 201);
    }

    public function show(Product $product, Document $document)
    {
        return response()->json($document);
    }

    public function update(Request $request, Product $product, Document $document)
    {
        $validated = $request->validate([
            'type' => 'sometimes|in:Software,PDF,Driver',
            'file_path' => 'sometimes|string',
        ]);

        $document->update($validated);
        return response()->json($document);
    }

    public function destroy(Product $product, Document $document)
    {
        $document->delete();
        return response()->json(null, 204);
    }

    public function create()
    {
        $nextSerialNumber = DocumentType::max('serial_number') + 1;
        $documentType = new DocumentType(); // Define the variable
        return view('admin.documents.create', compact('nextSerialNumber', 'documentType'));
    }

    public function showCategoryDocuments($category)
    {
        $documents = Document::whereHas('product.category', function ($query) use ($category) {
            $query->where('name', $category);
        })->get();

        // return view('frontend.pages.category-documents', compact('category', 'documents'));
    }
}
