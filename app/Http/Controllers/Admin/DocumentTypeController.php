<?php

namespace App\Http\Controllers\Admin;

use App\Models\DocumentType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class DocumentTypeController extends Controller
{
    public function index()
    {
        $documentTypes = DocumentType::orderBy('serial_number')->get();
        return view('admin.document-type.index', compact('documentTypes'));
    }

    public function create()
    {
        $nextSerialNumber = DocumentType::max('serial_number') + 1;
        $documentType = new DocumentType();
        return view('admin.document-type.create', compact('nextSerialNumber', 'documentType'));
    }

    public function form($id = null)
    {
        $existingSerialNumbers = DocumentType::orderBy('serial_number', 'asc')->pluck('serial_number')->toArray();
        $nextSerialNumber = $this->getNextAvailableSerialNumber($existingSerialNumbers);
        if ($nextSerialNumber === null) {
            $lastSerialNumber = DocumentType::max('serial_number') ?? 0;
            $nextSerialNumber = $lastSerialNumber + 1;
        }
        $documentType = $id ? DocumentType::findOrFail($id) : new DocumentType();

        return view('admin.document-type.create', compact('documentType', 'nextSerialNumber'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:document_types,name',
            'description' => 'required',
            'serial_number' => 'required|integer|unique:document_types,serial_number',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('document-types', 'public');
            $data['image'] = $imagePath;
        }

        $documentType = new DocumentType($data);
        $documentType->save();

        return redirect()->route('admin.document-type.index')->with('success', 'Document Type created successfully.');
    }

    public function update(Request $request, $id)
    {
        Log::info('Update method called', ['id' => $id, 'request' => $request->all()]);

        $request->validate([
            'name' => 'required|unique:document_types,name,' . $id,
            'description' => 'required',
            'serial_number' => 'required|integer|unique:document_types,serial_number,' . $id,
            'image' => 'nullable|image|max:2048',
        ]);

        $documentType = DocumentType::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($documentType->image) {
                $oldImagePath = public_path('storage/' . $documentType->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $imagePath = $request->file('image')->store('document-types', 'public');
            $data['image'] = $imagePath;
        }

        Log::info('Updating document type', ['data' => $data]);
        $documentType->update($data);

        return redirect()->route('admin.document-type.index')->with('success', 'Document Type updated successfully.');
    }

    public function destroy($id)
    {
        $documentType = DocumentType::find($id);

        if (!$documentType) {
            return redirect()->route('admin.document-type.index')->with('error', 'Document Type not found.');
        }

        if ($documentType->image) {
            $imagePath = public_path('storage/' . $documentType->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $documentType->delete();

        return redirect()->route('admin.document-type.index')->with('message', 'Document Type deleted successfully.');
    }

    public function removeImage($id)
    {
        $documentType = DocumentType::findOrFail($id);
        if ($documentType->image) {
            $imagePath = public_path('storage/' . $documentType->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $documentType->update(['image' => null]);
        }
        return redirect()->back()->with('success', 'Image removed successfully.');
    }

    protected function getNextAvailableSerialNumber(array $existingSerialNumbers)
    {
        $nextSerialNumber = null;
        $expected = 1;
        foreach ($existingSerialNumbers as $serialNumber) {
            if ($serialNumber != $expected) {
                $nextSerialNumber = $expected;
                break;
            }
            $expected++;
        }

        return $nextSerialNumber;
    }
}