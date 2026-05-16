<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('query');

        if(strlen($query) < 2) {
            if($request->ajax()) {
                return '';
            }
            return view('search', ['products' => collect()]);
        }

        $products = Product::where(function($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%")
              ->orWhere('description', 'LIKE', "%{$query}%")
              ->orWhere('serial_number', 'LIKE', "%{$query}%");
        })
        ->with(['category', 'brand'])
        ->take(8)
        ->get();

        if($request->ajax()) {
            $output = '';

            if(count($products) > 0) {
                foreach($products as $product) {
                    // Handle image display logic
                    $imageUrl = '';
                    if (!empty($product->images) && is_array($product->images) && count($product->images) > 0) {
                        $imageUrl = asset('storage/' . $product->images[0]);
                    } else {
                        $imageUrl = asset('images/no-image.png');
                    }

                    $categoryName = $product->category ? $product->category->name : '';
                    $brandName = $product->brand ? $product->brand->name : '';

                    $output .= '
                    <a href="'.route('product.show', $product->id).'" class="list-group-item list-group-item-action">
                        <div class="d-flex align-items-center">
                            <img src="'.$imageUrl.'" alt="'.$product->name.'" class="search-result-img">
                            <div class="ms-3">
                                <div class="fw-bold">'.$product->name.'</div>
                                <div class="text-muted small">
                                    '.($categoryName ? '<span class="badge bg-secondary me-2">'.$categoryName.'</span>' : '').'
                                    '.($brandName ? '<span class="badge bg-info">'.$brandName.'</span>' : '').'
                                </div>
                                <small class="text-muted">'.substr($product->description ?? '', 0, 100).(strlen($product->description ?? '') > 100 ? '...' : '').'</small>
                            </div>
                        </div>
                    </a>';
                }
            } else {
                $output .= '<div class="list-group-item">No results found</div>';
            }

            return $output;
        }

        return view('search', ['products' => $products]);
    }
}
