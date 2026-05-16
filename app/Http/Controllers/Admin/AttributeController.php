<?php

namespace App\Http\Controllers\admin;

use App\Models\Product;
use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttributeController extends Controller
{
    public function index(Product $product)
    {
        return response()->json($product->attributes);
    }

    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $attribute = $product->attributes()->create($validated);
        return response()->json($attribute, 201);
    }

    public function show(Product $product, Attribute $attribute)
    {
        return response()->json($attribute);
    }

    public function update(Request $request, Product $product, Attribute $attribute)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
        ]);

        $attribute->update($validated);
        return response()->json($attribute);
    }

    public function destroy(Product $product, Attribute $attribute)
    {
        $attribute->delete();
        return response()->json(null, 204);
    }
}
