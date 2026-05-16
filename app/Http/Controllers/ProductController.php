// ...existing code...

public function store(Request $request)
{
    // ...existing code...

    $images = [];
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $file) {
            $path = $file->store('uploads/products', 'public');
            $images[] = $path; // Store the path relative to the 'storage/app/public' directory
        }
    }

    $product = new Product();
    // ...existing code...








// ...existing code...}    // ...existing code...    $product->save();    $product->images = json_encode($images); // Store as JSON-encoded array
