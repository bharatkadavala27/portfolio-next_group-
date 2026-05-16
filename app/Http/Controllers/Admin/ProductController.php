<?php
namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\Document;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use App\Models\ShortAttribute;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['attributes', 'documents'])->get();
        return view('admin.product.index', compact('products'));
    }

    public function create($id = null)
    {
        $brands = Brand::all();
        $categories = Category::whereNull('parent_id')->with('children')->get();
        $documentTypes = DocumentType::all();
        $existingSerialNumbers = Product::orderBy('serial_number', 'asc')->pluck('serial_number')->toArray();
        $nextSerialNumber = $this->getNextAvailableSerialNumber($existingSerialNumbers) ?? (Product::max('serial_number') + 1);
        $filters = \App\Models\Filter::with('options')
            ->whereIn('type', ['product', 'both'])
            ->get();
        $product = $id ? Product::findOrFail($id) : null;
        return view('admin.product.create', compact('brands', 'categories', 'nextSerialNumber', 'product', 'documentTypes', 'filters'));
    }

    public function getSubcategories($categoryId)
    {
        $category = Category::with('children')->findOrFail($categoryId);
        return response()->json(['subcategories' => $category->children]);
    }

    public function store(Request $request)
    {
        try {
            // Store files temporarily
            $tempFiles = $this->storeTemporaryFiles($request);

            // Store temp files in session in case validation fails
            session()->put('temp_files', $tempFiles);

            $validated = $request->validate([
                'name' => 'required|string',
                'price' => 'nullable|numeric',
                'brand_id' => 'required|exists:brands,id',
                'category_id' => 'required|exists:categories,id',
                'serial_number' => 'required|unique:products,serial_number',
                'description' => 'nullable|string',
                'short_description' => 'nullable|array',
                'short_description.*' => 'nullable|string',
                'images' => 'nullable|array',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp',
                'temp_images' => 'nullable|array',
                'temp_images.*' => 'string',
                'temp_documents' => 'nullable|array',
                'temp_documents.*' => 'string',
                'attributes' => 'nullable|array',
                'attributes.*.title' => 'nullable|string',
                'attributes.*.short_attributes' => 'nullable|array',
                'attributes.*.short_attributes.*.key' => 'nullable|string',
                'attributes.*.short_attributes.*.values' => 'nullable|array',
                'attributes.*.short_attributes.*.values.*' => 'nullable|string',
                'documents' => 'nullable|array',
                'documents.*.document_name' => 'nullable|string',
                'documents.*.type' => 'nullable|exists:document_types,id',
                'documents.*.file_path' => 'nullable|file',
                'documents.*.file_path' => 'nullable|file',
                'documents.*.path' => 'nullable|string',
                'file_path' => 'nullable|string',
                'filter_id' => 'nullable|array',
                'filter_option_id' => 'nullable|array',
            ]);

            $product = Product::create([
                'name' => $validated['name'],
                'price' => $validated['price'],
                'brand_id' => $validated['brand_id'],
                'category_id' => $validated['category_id'],
                'serial_number' => $validated['serial_number'],
                'description' => $validated['description'] ?? null,
                'short_description' => $request->short_description ?? [], // ✅ new
            ]);


            // Handle images
            $images = [];

            Log::info('=== CREATE PRODUCT IMAGE HANDLING ===', [
                'has_images' => $request->hasFile('images'),
                'has_new_image_order' => $request->has('new_image_order'),
                'new_image_order' => $request->input('new_image_order'),
                'images_count' => $request->hasFile('images') ? count($request->file('images')) : 0,
            ]);

            // Handle new uploaded images
            if ($request->hasFile('images')) {
                Log::info('--- Processing New Images ---');

                // Map original name to uploaded filenames
                $uploadedMap = [];
                $tempImagesList = [];

                foreach ($request->file('images') as $i => $image) {
                    $originalName = $image->getClientOriginalName();
                    Log::info("Image Index: $i, Name: $originalName");

                    $filename = now()->format('Ymd_His') . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('uploads/products'), $filename);

                    // Store in map handling duplicates
                    $uploadedMap[$originalName][] = $filename;
                    $tempImagesList[] = $filename; // Keep original order as fallback
                }

                // Reorder based on explicit frontend order if present
                if ($request->has('new_image_order') && is_array($request->input('new_image_order'))) {
                    $frontendOrder = $request->input('new_image_order');
                    Log::info('--- Reordering Images based on Frontend Input ---', [
                        'frontend_order' => $frontendOrder,
                        'uploaded_map_keys' => array_keys($uploadedMap)
                    ]);

                    foreach ($frontendOrder as $origName) {
                        if (isset($uploadedMap[$origName]) && count($uploadedMap[$origName]) > 0) {
                            $filename = array_shift($uploadedMap[$origName]);
                            $images[] = $filename;
                            Log::info("Mapped: $origName => $filename");
                        } else {
                            Log::warning("Could not find uploaded file for: $origName");
                        }
                    }

                    // Add any remaining files (duplicates or missed ones)
                    foreach ($uploadedMap as $origName => $files) {
                        foreach ($files as $file) {
                            $images[] = $file;
                        }
                    }
                } else {
                    // Fallback to original loop order
                    $images = array_merge($images, $tempImagesList);
                }
            }

            // Handle temporary images from previous upload with sequence support
            if ($request->has('temp_images_order') && !empty($request->input('temp_images_order'))) {
                // Use the submitted order if available (drag-and-drop sequence from create page)
                $imageOrder = $request->input('temp_images_order');
                foreach ($imageOrder as $tempPath) {
                    if (Storage::disk('public')->exists($tempPath)) {
                        $filename = now()->format('Ymd_His') . '_' . uniqid() . '.' . pathinfo($tempPath, PATHINFO_EXTENSION);
                        $newPath = 'uploads/products/' . $filename;
                        Storage::disk('public')->copy($tempPath, $newPath);
                        $images[] = $filename;
                    }
                }
            } elseif ($request->has('temp_images')) {
                // Fallback to original order if no sequence submitted
                foreach ($request->input('temp_images') as $tempPath) {
                    if (Storage::disk('public')->exists($tempPath)) {
                        $filename = now()->format('Ymd_His') . '_' . uniqid() . '.' . pathinfo($tempPath, PATHINFO_EXTENSION);
                        $newPath = 'uploads/products/' . $filename;
                        Storage::disk('public')->copy($tempPath, $newPath);
                        $images[] = $filename;
                    }
                }
            }

            if (!empty($images)) {
                $product->images = json_encode($images);
                $product->save();

                Log::info('=== PRODUCT CREATED WITH IMAGE SEQUENCE ===', [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'image_sequence' => $images,
                ]);
            }

            // Handle attributes
            if (!empty($validated['attributes'])) {
                foreach ($validated['attributes'] as $attribute) {
                    if (!empty($attribute['title'])) {
                        $createdAttribute = $product->attributes()->create([
                            'title' => $attribute['title'],
                        ]);
                        if (!empty($attribute['short_attributes'])) {
                            foreach ($attribute['short_attributes'] as $shortAttribute) {
                                if (!empty($shortAttribute['key']) && !empty($shortAttribute['values'])) {
                                    // Join multiple values with comma
                                    $value = implode(',', array_filter($shortAttribute['values']));
                                    if (!empty($value)) {
                                        $createdAttribute->shortAttributes()->create([
                                            'key' => $shortAttribute['key'],
                                            'value' => $value,
                                        ]);
                                    }
                                }
                            }
                        }
                    }
                }
            }

            // Handle documents
            if (!empty($validated['documents'])) {
                foreach ($validated['documents'] as $index => $document) {
                    $documentPath = null;

                    // Handle new uploaded file
                    if (isset($document['file_path']) && $document['file_path'] instanceof UploadedFile) {
                        $file = $document['file_path'];
                        $filename = now()->format('Ymd_His') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('documents'), $filename);
                        $documentPath = '/documents/' . $filename;
                    }
                    // Handle temporary file from previous upload
                    elseif (isset($validated['temp_documents'][$index])) {
                        $tempPath = $validated['temp_documents'][$index];
                        if (Storage::disk('public')->exists($tempPath)) {
                            $filename = now()->format('Ymd_His') . '_' . uniqid() . '.' . pathinfo($tempPath, PATHINFO_EXTENSION);
                            $newPath = 'documents/' . $filename;
                            Storage::disk('public')->copy($tempPath, $newPath);
                            $documentPath = '/documents/' . $filename;
                        }
                    }

                    if (!empty($document['type']) || !empty($documentPath) || !empty($document['path'])) {
                        Document::create([
                            'product_id' => $product->id,
                            'document_name' => $document['document_name'] ?? null,
                            'file_path' => $documentPath,
                            'type' => $document['type'] ?? null,
                            'path' => $document['path'] ?? null,
                            'file_path_text' => $validated['file_path'] ?? null,
                        ]);
                    }
                }
            }

            // Handle Filters
            if ($request->filled('filter_option_id')) {
                $selectedOptions = array_filter($request->input('filter_option_id', []));
                $selectedOptions = array_values(array_unique(array_map('intval', $selectedOptions)));
                $product->filters()->sync($selectedOptions);
            }

            // Clean up temp files after successful creation
            $this->cleanupTemporaryFiles(session()->get('temp_files', []));
            session()->forget('temp_files');

            return redirect()->route('products.index')->with('success', 'Product created successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            // Clean up temp files on error
            $this->cleanupTemporaryFiles(session()->get('temp_files', []));
            session()->forget('temp_files');

            Log::error('Error creating product: ' . $e->getMessage());
            return redirect()->back()
                ->withErrors(['error' => 'An error occurred while creating the product.'])
                ->withInput();
        }
    }

    public function edit($id)
    {
        $product = Product::with(['attributes.shortAttributes', 'documents'])->findOrFail($id);
        $brands = Brand::all();
        $categories = Category::whereNull('parent_id')->with('children')->get();
        $documentTypes = DocumentType::all();
        $existingSerialNumbers = Product::orderBy('serial_number', 'asc')->pluck('serial_number')->toArray();
        $nextSerialNumber = $this->getNextAvailableSerialNumber($existingSerialNumbers) ?? (Product::max('serial_number') + 1);
        $filters = \App\Models\Filter::with('options')
            ->whereIn('type', ['product', 'both'])
            ->get();

        return view('admin.product.edit', compact('product', 'brands', 'categories', 'nextSerialNumber', 'documentTypes', 'filters'));
    }

    public function update(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);

            // Store files temporarily
            $tempFiles = $this->storeTemporaryFiles($request);

            // Store temp files in session in case validation fails
            session()->put('temp_files', $tempFiles);
            $validated = $request->validate([
                'name' => 'required|string',
                'price' => 'nullable|numeric',
                'brand_id' => 'required|exists:brands,id',
                'category_id' => 'required|exists:categories,id',
                'serial_number' => 'required|unique:products,serial_number,' . $id,
                'description' => 'nullable|string',
                'short_description' => 'nullable|array',
                'short_description.*' => 'nullable|string', // ✅ add this
                'images' => 'nullable|array',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp',
                'temp_images' => 'nullable|array',
                'temp_images.*' => 'string',
                'temp_documents' => 'nullable|array',
                'temp_documents.*' => 'string',
                'attributes' => 'nullable|array',
                'attributes.*.id' => 'nullable|integer|exists:attributes,id',
                'attributes.*.title' => 'nullable|string',
                'attributes.*.short_attributes' => 'nullable|array',
                'attributes.*.short_attributes.*.id' => 'nullable|integer|exists:short_attributes,id',
                'attributes.*.short_attributes.*.key' => 'nullable|string',
                'attributes.*.short_attributes.*.values' => 'nullable|array',
                'attributes.*.short_attributes.*.values.*' => 'nullable|string',
                'documents' => 'nullable|array',
                'documents.*.id' => 'nullable|integer|exists:documents,id',
                'documents.*.document_name' => 'nullable|string',
                'documents.*.type' => 'nullable|exists:document_types,id',
                'documents.*.file_path' => 'nullable|file',
                'documents.*.file_path' => 'nullable|file',
                'documents.*.path' => 'nullable|string',
                'file_path' => 'nullable|string',
                'filter_id' => 'nullable|array',
                'filter_option_id' => 'nullable|array',
            ]);

            $product->update([
                'name' => $validated['name'],
                'price' => $validated['price'],
                'brand_id' => $validated['brand_id'],
                'category_id' => $validated['category_id'],
                'serial_number' => $validated['serial_number'],
                'description' => $validated['description'] ?? $product->description,
                'short_description' => $request->short_description ?? $product->short_description,
            ]);

            // Unified Image Handling (Reorder, New, Replace)
            $newImages = [];
            $uploadedMap = []; // Map: OriginalFilename -> NewStoredFilename[]

            // 1. Process New Uploads
            if ($request->hasFile('images')) {
                Log::info('--- Update: Processing New Images ---');
                foreach ($request->file('images') as $image) {
                    $originalName = $image->getClientOriginalName();
                    $filename = now()->format('Ymd_His') . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('uploads/products'), $filename);

                    if (!isset($uploadedMap[$originalName])) {
                        $uploadedMap[$originalName] = [];
                    }
                    $uploadedMap[$originalName][] = $filename;
                    Log::info("Uploaded: $originalName -> $filename");
                }
            }

            // 2. Process Temp Images (if any)
            if ($request->has('temp_images')) {
                foreach ($request->input('temp_images') as $tempPath) {
                    if (Storage::disk('public')->exists($tempPath)) {
                        $filename = now()->format('Ymd_His') . '_' . uniqid() . '.' . pathinfo($tempPath, PATHINFO_EXTENSION);
                        $newPath = 'uploads/products/' . $filename;
                        Storage::disk('public')->move($tempPath, $newPath);

                        // Treat temp images as "new" uploads with their temp path basename or similar logic if feasible.
                        // However, temp images usually lack original name context in this flow unless tracked.
                        // For simpler replacement logic, we'll append them. If needed for exact order, 
                        // one would need to send their original names. We'll treat them as un-ordered new files for now 
                        // unless we implement temp-file name tracking.
                        // Actually, let's just append them to the pool of available new images.
                        $newImages[] = $filename;
                    }
                }
            }

            // 3. Reconstruct Final Image List
            $finalImages = [];

            $rawImages = $product->images;
            $existingImages = is_string($rawImages) ?
                (json_decode($rawImages, true) ?: []) :
                (is_array($rawImages) ? $rawImages : []);

            // Helper to lookup existing image by basename
            // We'll keep a copy to track which ones are used
            $existingImagesMap = [];
            foreach ($existingImages as $path) {
                $existingImagesMap[basename($path)] = $path;
            }

            if ($request->has('image_order') && !empty($request->input('image_order'))) {
                $imageOrder = $request->input('image_order');
                Log::info('--- Update: Reconstructing Image Order ---', ['order' => $imageOrder]);

                foreach ($imageOrder as $item) {
                    // Log details for each item check
                    Log::info("Checking Item: $item", [
                        'in_uploaded_map' => isset($uploadedMap[$item]),
                        'in_existing_map' => isset($existingImagesMap[$item])
                    ]);

                    // Case A: Item matches a New Upload (Original Name)
                    if (isset($uploadedMap[$item]) && count($uploadedMap[$item]) > 0) {
                        $file = array_shift($uploadedMap[$item]);
                        $finalImages[] = $file;
                        Log::info("Order Item '$item': Using new upload '$file'");
                    }
                    // Case B: Item matches an Existing Image (Basename)
                    elseif (isset($existingImagesMap[$item])) {
                        $finalImages[] = $existingImagesMap[$item];
                        unset($existingImagesMap[$item]);
                        Log::info("Order Item '$item': Kept existing");
                    }
                }
            }

            // 4. Append remaining new uploads (that weren't explicit in order)
            foreach ($uploadedMap as $name => $files) {
                foreach ($files as $file) {
                    $finalImages[] = $file;
                }
            }
            foreach ($newImages as $file) {
                $finalImages[] = $file;
            }

            // 5. Append remaining existing images (that weren't in order list - safety fallback, UNLESS we assume explicit list means "delete missing")
            // Logic: "Replace" effectively means the old image is REMOVED from the list.
            // If we append all remaining existing images, the "Replaced" image (which is still in DB but not in our new order list) would reappear at the end!
            // BUT, standard "Reorder" logic often appends missing items to prevent accidental deletion.
            // HOW TO DISTINGUISH "Replaced/Deleted" vs "Forgot to list"?
            // Usually, the frontend sends the *Complete* list of images to keep. 
            // If an image is NOT in `image_order`, it implies it should be DELETED (or at least not saved).
            // However, the original code had:
            // "Add any existing images that weren't in the submitted order (safety fallback)"
            // If we keep that, replacement won't work (old image re-appears).
            // If we remove that, we risk deleting images if frontend logic is buggy.
            // DECISION: To support "Replace", we MUST trust the `image_order` list if it exists. 
            // But we should only trust it if it covers most images. 
            // Let's compromise: If `image_order` was provided, we assume it's the authoritative list of *Existing* images to keep. 
            // So we DO NOT append remaining `$existingImagesMap`.
            // The only exception is if `image_order` is empty, then we keep everything (but we checked !empty above).

            // Wait, existing logic allowed partial updates? 
            // "Add any existing images that weren't in the submitted order (safety fallback)" <-- This exists in original code.
            // We must Change this behaviour to allow deletion/replacement.
            // So, we will NOT append remaining `$existingImagesMap`.
            // Ensure we handle the case where no change happens (empty image_order -> keep existing).

            if (!$request->has('image_order')) {
                // No order update submitted, keep existing + append new
                $finalImages = array_merge($existingImages, $uploadedMap ? array_merge(...array_values($uploadedMap)) : [], $newImages);
            } else {
                // Explicit order submitted. We only keep what was in the list + remaining new uploads.
                // We implicitly DELETE existing images not in the list.
            }

            $product->images = json_encode($finalImages);
            $product->save();

            // Handle Filters
            if ($request->filled('filter_option_id')) {
                $selectedOptions = array_filter($request->input('filter_option_id', []));
                $selectedOptions = array_values(array_unique(array_map('intval', $selectedOptions)));
                $product->filters()->sync($selectedOptions);
            } else {
                // Try to see if empty input was sent (clearing filters)
                // But typically if field is missing, we might not want to clear?
                // However, for checkbox/selects usually we handle "sync" carefully.
                // If the form field exists but is empty, we sync empty.
                if ($request->has('filter_option_id')) {
                    $product->filters()->sync([]);
                }
            }

            // Handle documents
            if (!empty($validated['documents'])) {
                foreach ($validated['documents'] as $index => $document) {
                    $documentPath = null;

                    // Handle new file upload
                    if (isset($document['file_path']) && $document['file_path'] instanceof UploadedFile) {
                        $file = $document['file_path'];
                        $filename = now()->format('Ymd_His') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('documents'), $filename);
                        $documentPath = '/documents/' . $filename;
                    }
                    // Handle temporary file from previous validation failure
                    elseif (isset($validated['temp_documents'][$index])) {
                        $tempPath = $validated['temp_documents'][$index];
                        if (Storage::disk('public')->exists($tempPath)) {
                            $filename = now()->format('Ymd_His') . '_' . uniqid() . '.' . pathinfo($tempPath, PATHINFO_EXTENSION);
                            $newPath = 'documents/' . $filename;
                            Storage::disk('public')->move($tempPath, $newPath);
                            $documentPath = '/documents/' . $filename;
                        }
                    }

                    if (!empty($document['type']) || !empty($documentPath) || !empty($document['path'])) {
                        // Update existing document or create new one
                        if (!empty($document['id'])) {
                            Document::where('id', $document['id'])->update([
                                'document_name' => $document['document_name'] ?? null,
                                'file_path' => $documentPath ?: Document::find($document['id'])->file_path,
                                'type' => $document['type'] ?? null,
                                'path' => $document['path'] ?? null,
                            ]);
                        } else {
                            Document::create([
                                'product_id' => $product->id,
                                'document_name' => $document['document_name'] ?? null,
                                'file_path' => $documentPath,
                                'type' => $document['type'] ?? null,
                                'path' => $document['path'] ?? null,
                            ]);
                        }
                    }
                }
            }

            // Clean up temp files after successful update
            $this->cleanupTemporaryFiles(session()->get('temp_files', []));
            session()->forget('temp_files');

            return redirect()->route('products.index')->with('success', 'Product updated successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            // Clean up temp files on error
            $this->cleanupTemporaryFiles(session()->get('temp_files', []));
            session()->forget('temp_files');

            Log::error('Error updating product: ' . $e->getMessage());
            return redirect()->back()
                ->withErrors(['error' => 'An error occurred while updating the product.'])
                ->withInput();
        }
    }

    public function destroy(Product $product)
    {
        if ($product->images) {
            foreach (json_decode($product->images, true) as $image) {
                $imagePath = 'uploads/products/' . $image;
                if (File::exists(public_path($imagePath))) {
                    File::delete(public_path($imagePath));
                }
            }
        }
        foreach ($product->documents as $doc) {
            $docPath = ltrim($doc->file_path, '/'); // Remove leading slash for public_path
            if (File::exists(public_path($docPath))) {
                File::delete(public_path($docPath));
            }
        }
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }

    protected function getNextAvailableSerialNumber(array $existingSerialNumbers)
    {
        $expected = 1;
        foreach ($existingSerialNumbers as $serialNumber) {
            if ($serialNumber != $expected) {
                return $expected;
            }
            $expected++;
        }
        return null;
    }

    public function show($id)
    {
        $product = Product::with(['attributes', 'documents'])->findOrFail($id);
        return view('admin.product.show', compact('product'));
    }

    public function removeFile(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|string',
                'productId' => 'required|integer|exists:products,id',
                'documentId' => 'required|integer|exists:documents,id'
            ]);

            $document = Document::findOrFail($request->documentId);
            $filePath = ltrim($document->file_path, '/'); // Remove leading slash for public_path
            $fullPath = public_path($filePath);

            if (File::exists($fullPath)) {
                File::delete($fullPath);
                $document->delete();
                return response()->json(['success' => true, 'message' => 'File removed successfully.']);
            }

            Log::warning('File not found on the server', ['file_path' => $fullPath]);
            return response()->json(['success' => false, 'message' => 'File not found on the server.'], 404);
        } catch (\Exception $e) {
            Log::error('Error removing file', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'An error occurred while removing the file.'], 500);
        }
    }

    public function removeImage(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|string',
                'productId' => 'required|integer|exists:products,id',
            ]);

            $product = Product::findOrFail($request->productId);
            $imagePath = $request->image;
            $images = json_decode($product->images, true) ?? [];

            // Function to normalize path - removes any potential 'uploads/products/' prefix
            $normalizePath = function ($path) {
                return preg_replace('#^(uploads/products/|Uploads/products/)#i', '', $path);
            };

            // Get the base filename from the request
            $normalizedRequestPath = $normalizePath($imagePath);

            // First try exact match (for legacy data)
            $imageIndex = array_search($imagePath, $images);

            // If exact match not found, try with normalized path
            if ($imageIndex === false) {
                foreach ($images as $index => $storedImage) {
                    if ($normalizePath($storedImage) === $normalizedRequestPath) {
                        $imageIndex = $index;
                        break;
                    }
                }
            }

            if ($imageIndex === false) {
                Log::warning('Image not found in database', [
                    'requested_path' => $imagePath,
                    'normalized_path' => $normalizedRequestPath,
                    'stored_images' => $images
                ]);
                return response()->json(['success' => false, 'message' => 'Image not found in database'], 404);
            }

            // Remove from array
            unset($images[$imageIndex]);

            // Always look for the file in uploads/products/
            $fileSystemPath = 'uploads/products/' . $normalizedRequestPath;
            if (File::exists(public_path($fileSystemPath))) {
                File::delete(public_path($fileSystemPath));
            }

            $images = array_values(array_filter($images, fn($img) => $img !== $imagePath));
            $product->images = json_encode($images);
            $product->save();

            return response()->json(['success' => true, 'message' => 'Image removed successfully']);
        } catch (\Exception $e) {
            Log::error('Error removing image', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Error removing image: ' . $e->getMessage()], 500);
        }
    }

    public function cleanUpImages()
    {
        $products = Product::all();
        foreach ($products as $product) {
            $images = json_decode($product->images, true) ?? [];
            $validImages = array_filter($images, function ($image) {
                $fileSystemPath = ltrim($image, '/'); // Remove leading slash for public_path
                return File::exists(public_path($fileSystemPath));
            });
            if (count($validImages) !== count($images)) {
                $product->images = json_encode(array_values($validImages));
                $product->save();
            }
        }
        return response()->json(['success' => true, 'message' => 'Images cleaned up successfully.']);
    }

    protected function storeTemporaryFiles(Request $request)
    {
        $tempFiles = [];

        // Store product images temporarily
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('temp/products', 'public');
                $tempFiles['images'][$index] = $path;
            }
        }

        // Store document files temporarily
        if ($request->has('documents')) {
            foreach ($request->input('documents') as $index => $document) {
                if (isset($document['file_path']) && $document['file_path'] instanceof UploadedFile) {
                    $path = $document['file_path']->store('temp/documents', 'public');
                    $tempFiles['documents'][$index]['file_path'] = $path;
                    $tempFiles['documents'][$index]['type'] = $document['type'] ?? null;
                    $tempFiles['documents'][$index]['path'] = $document['path'] ?? null;
                }
            }
        }

        return $tempFiles;
    }

    protected function cleanupTemporaryFiles($tempFiles)
    {
        foreach ($tempFiles['images'] ?? [] as $path) {
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }
        foreach ($tempFiles['documents'] ?? [] as $document) {
            if (isset($document['file_path']) && Storage::disk('public')->exists($document['file_path'])) {
                Storage::disk('public')->delete($document['file_path']);
            }
        }
    }

    public function removeTempImage(Request $request)
    {
        $image = $request->input('image');

        // Remove file from storage
        if (Storage::disk('public')->exists($image)) {
            Storage::disk('public')->delete($image);
        }

        // Remove from session
        $tempFiles = session('temp_files', []);
        if (isset($tempFiles['images'])) {
            $tempFiles['images'] = array_filter($tempFiles['images'], fn($img) => $img !== $image);
            session(['temp_files' => $tempFiles]);
        }

        return response()->json(['success' => true]);
    }

    public function checkSerial(Request $request)
    {
        // 1. Check for exact match (for validation error)
        $existsQuery = Product::where('serial_number', $request->serial_number);
        if ($request->product_id) {
            $existsQuery->where('id', '!=', $request->product_id);
        }
        $exists = $existsQuery->exists();

        // 2. Fetch matches for autocomplete list
        $matchesQuery = Product::where('serial_number', 'LIKE', "{$request->serial_number}%");
        if ($request->product_id) {
            $matchesQuery->where('id', '!=', $request->product_id);
        }
        $taken_serials = $matchesQuery->orderBy('serial_number')->limit(20)->pluck('serial_number')->toArray();

        return response()->json([
            'exists' => $exists,
            'taken_serials' => $taken_serials
        ]);
    }


}