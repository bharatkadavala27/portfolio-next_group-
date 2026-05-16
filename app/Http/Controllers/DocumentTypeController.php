<?php

namespace App\Http\Controllers;

use App\Models\DocumentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DocumentTypeController extends Controller
{
    public function index()
    {
        $documentTypes = DocumentType::all();
        return view('admin.document-type.index', compact('documentTypes'));
    }

    public function create()
    {
        return view('admin.document-type.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'serial_number' => 'required|integer|unique:document_types',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $documentType = new DocumentType();
        $documentType->name = $request->name;
        $documentType->serial_number = $request->serial_number;
        $documentType->description = $request->description;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('document-types'), $imagePath);
            $documentType->image = $imagePath;
        }

        $documentType->save();

        return redirect()->route('admin.document-types.index')->with('message', 'Document Type created successfully!');
    }

    public function edit($id)
    {
        $documentType = DocumentType::findOrFail($id);
        return view('admin.document-type.edit', compact('documentType'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'serial_number' => 'required|integer|unique:document_types,serial_number,' . $id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $documentType = DocumentType::findOrFail($id);
        $documentType->name = $request->name;
        $documentType->serial_number = $request->serial_number;
        $documentType->description = $request->description;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('document-types'), $imagePath);

            if ($documentType->image && File::exists(public_path('document-types/' . $documentType->image))) {
                File::delete(public_path('document-types/' . $documentType->image));
            }

            $documentType->image = $imagePath;
        }

        $documentType->save();

        return redirect()->route('admin.document-types.index')->with('message', 'Document Type updated successfully!');
    }

    public function destroy($id)
    {
        $documentType = DocumentType::findOrFail($id);

        if ($documentType->image && File::exists(public_path('document-types/' . $documentType->image))) {
            File::delete(public_path('document-types/' . $documentType->image));
        }

        $documentType->delete();

        return redirect()->route('admin.document-types.index')->with('message', 'Document Type deleted successfully!');
    }

    public function removeImage($id)
    {
        $documentType = DocumentType::findOrFail($id);

        if ($documentType->image && File::exists(public_path('document-types/' . $documentType->image))) {
            File::delete(public_path('document-types/' . $documentType->image));
            $documentType->image = null;
            $documentType->save();
        }

        return redirect()->route('admin.document-types.edit', $id)->with('message', 'Image removed successfully!');
    }
    public function checkSerial(Request $request)
    {
        // 1. Check for exact match
        $existsQuery = DocumentType::where('serial_number', $request->serial_number);
        if ($request->id) {
            $existsQuery->where('id', '!=', $request->id);
        }
        $exists = $existsQuery->exists();

        // 2. Fetch matches for autocomplete list
        $matchesQuery = DocumentType::where('serial_number', 'LIKE', "{$request->serial_number}%");
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
