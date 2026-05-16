<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\DocumentBrand;
use App\Http\Controllers\Controller;

class DocumentBrandController extends Controller
{
    // ...existing code...

    public function save(Request $request, $id = null)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'serial_number' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($id) {
            $documentBrand = DocumentBrand::findOrFail($id);
            $documentBrand->update($data);
        } else {
            $documentBrand = DocumentBrand::create($data);
        }

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('document-brands', 'public');
            $documentBrand->update(['image' => $imagePath]);
        }

        return redirect()->route('admin.document-brands.index')->with('success', 'Document Brand saved successfully.');
    }

    // public function fetchDocumentBrands()
    // {
    //     $documentBrands = DocumentBrand::all();
    //     return response()->json(['documentBrands' => $documentBrands]);
    // }

    // ...existing code...
}
