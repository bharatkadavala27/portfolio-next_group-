@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h2>Search Results</h2>
                <div class="list-group mt-4">
                    @if($products->count() > 0)
                        @foreach($products as $product)
                            <a href="{{ route('product.show', $product->id) }}" class="list-group-item list-group-item-action">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <h5 class="mb-1">{{ $product->name }}</h5>
                                        @if($product->category)
                                            <span class="badge bg-secondary">{{ $product->category->name }}</span>
                                        @endif
                                        <p class="card-text"><strong>Price:</strong>
                                            @if ($product->price == 0)
                                                No Price available
                                            @else
                                                ${{ number_format($product->price, 2) }}
                                            @endif
                                        </p>
                                        <p class="mt-2 mb-0 text-muted">
                                            {!! Str::limit(strip_tags($product->description ?? ''), 150) !!}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    @else
                        <div class="list-group-item">No results found</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .list-group-item {
            transition: background-color 0.2s;
        }

        .list-group-item:hover {
            background-color: #f8f9fa;
        }
    </style>
@endsection