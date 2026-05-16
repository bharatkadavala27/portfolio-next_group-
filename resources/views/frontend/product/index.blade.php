@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h1 class="text-center mb-4">All Products</h1>
        <div class="row">
            @forelse($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">
                                <strong>Price:</strong> ${{ number_format($product->price, 2) }}<br>

                                <strong>Category:</strong> {{ $product->category->name }}
                            </p>
                        </div>
                        @php
                            $images = json_decode(str_replace('\\', '/', $product->images), true);
                        @endphp

                        @if (!empty($images) && is_array($images))
                            @foreach ($images as $image)
                                @if (!empty($image))
                                    <img src="{{ url($image) }}" alt="Product Image" class="img-thumbnail" width="50" height="50">
                                @else
                                    <p>No image available for this entry.</p>
                                @endif
                            @endforeach
                        @else
                            <p>No images available</p>
                        @endif

                        <div class="card-footer text-center">
                            <a href="{{ url('/product', $product->id) }}" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center">No products available.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
