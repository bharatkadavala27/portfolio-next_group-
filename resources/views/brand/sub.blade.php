@extends('layouts.app')

@section('content')

    <div class="layout-category-container px-6">
        @if ($category)
            <div class="category-content-wrapper" style="background: #fafafa; ">
                <div class="category-heading">
                    <p class="product-path text-dark" style="font-size: 14px;">
                        <a href="{{ url('/') }}" class="breadcrumb-link">Home</a> <i class="fas fa-chevron-right mx-2"></i>
                        Products & Services
                        @foreach ($breadcrumb as $crumb)
                            <i class="fas fa-chevron-right mx-2"></i>
                            @php
                                $hasChildren = $crumb->children && $crumb->children->count() > 0;
                            @endphp
                            @if (is_null($crumb->parent_id) && $hasChildren)
                                <a href="{{ route('category.main', $crumb->id) }}" class="breadcrumb-link">{{ $crumb->name }}</a>
                            @elseif (!is_null($crumb->parent_id) && $hasChildren)
                                <a href="{{ route('child.category.show', $crumb->id) }}" class="breadcrumb-link">{{ $crumb->name }}</a>
                            @else
                                <a href="{{ route('child.category.show', $crumb->id) }}" class="breadcrumb-link">{{ $crumb->name }}</a>
                            @endif
                        @endforeach
                    </p>
                    <div class="col-md-9 mt-5 w-100 mx-auto">
                        <h1 class="mb-3 theme-text" style="font-size: 42px; font-weight: normal;">{{ $category->name }}</h1>
                    </div>
                </div>

                <!-- Main Content Area -->
                <div class="col-md-12 mx-auto">
                    @if (isset($childCategories) && $childCategories->count() > 0)
                        <div class="row row-cols-1 row-cols-md-4 g-4">
                            @foreach ($childCategories as $subcategory)
                                <div class="col">
                                    <div class="card h-100 d-flex flex-column" style="border:1px solid #a2a2a247!important;">
                                        <a href="{{ route('child.category.show', $subcategory->id) }}"
                                            class="d-flex flex-column align-items-center text-decoration-none">
                                            @if ($subcategory->image)
                                                <img src="{{ asset('uploads/category/' . $subcategory->image) }}"
                                                    alt="{{ $subcategory->name }}" class="card-img-top"
                                                    style="object-fit: contain; height: 140px; width: 140px; display:block; margin:0 auto;">
                                            @endif
                                        </a>
                                        <div class="card-body d-flex flex-column">
                                            <a href="{{ route('child.category.show', $subcategory->id) }}">
                                                <h5 class="card-title text-black fw-normal mb-2 mt-3 text-start"
                                                    style="font-size: 20px;">{{ $subcategory->name }}</h5>
                                            </a>
                                            <p class="card-text text-muted description-text mb-2 text-start" style="font-size: 15px;">
                                                {!! $subcategory->description !!}</p>
                                            <div class="mt-auto text-start">
                                                <a href="{{ route('child.category.show', $subcategory->id) }}" class="theme-text"
                                                    style="text-decoration:underline;font-weight:500;">View Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @elseif (isset($products) && $products->count() > 0)
                        <div class="row row-cols-1 row-cols-md-4 g-4">
                            @foreach ($products as $product)
                                <div class="col">
                                    <div class="card h-100 d-flex flex-column product-card">
                                        <div class="product-card-img-wrapper">
                                            @php
                                                $images = is_string($product->images) ? json_decode($product->images, true) : $product->images;
                                                $imageUrl = !empty($images) && is_array($images) && count($images) > 0
                                                    ? asset($images[0])
                                                    : asset('images/no-image.png');
                                            @endphp
                                            <img src="{{ $imageUrl }}" alt="{{ $product->name }}">
                                        </div>
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title">{{ $product->name }}</h5>
                                            <p class="card-text">{!! $product->description !!}</p>
                                            <div class="mt-auto">
                                                <a href="{{ url('/product', $product->id) }}" class="btn btn-outline-dark w-100">View
                                                    Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center text-muted p-4">No subcategories or products found for this category.</p>
                    @endif

                    {{-- <!-- Recently Viewed Items Section -->
                    <div class="layout-category-container">
                        <div class="recently-viewed mt-5">
                            <h5 class="theme-text fw-bold mb-4" style="font-size: 26px">Recently Viewed Items</h5>
                            <div class="row row-cols-1 row-cols-md-3 g-4" style="justify-content: flex-start;">
                                @forelse ($recentlyViewedItems as $item)
                                <div class="col">
                                    <div class="card border-0" style="width: 300px; height: 105px;border:none!important;">
                                        <div class="d-flex align-items-center p-3">
                                            @php
                                            $images = is_string($item->images)
                                            ? json_decode($item->images, true)
                                            : $item->images;
                                            $imageUrl =
                                            !empty($images) && is_array($images) && count($images) > 0
                                            ? asset($images[0])
                                            : asset('images/no-image.png');
                                            @endphp
                                            <a href="{{ url('/product', $item->id) }}"
                                                style="width: 70px; height: 70px; margin-right: 15px;">
                                                <img src="{{ $imageUrl }}" alt="{{ $item->name }}"
                                                    style="width: 100%; height: 100%; object-fit: contain;">
                                            </a>
                                            <div class="flex-grow-1">
                                                <h6 class="card-title text-muted mb-1" style="font-size: 10px;">
                                                    {{ $item->serial_number }}</h6>
                                                <a href="{{ url('/product', $item->id) }}" class="text-decoration-none">
                                                    <p class="card-text text-dark mb-0 fw-semibold" style="font-size: 12px;">
                                                        {{ $item->name }}</p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <p class="text-center text-muted">No recently viewed items.</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Need Help Section -->
                        <div class="need-help-section mt-2 mb-5 p-3" style="border: 1px solid #c2baba54;">
                            <h2 class="mb-4" style="font-size: 26px; font-weight: bold;">Need help?</h2>
                            <div class="row row-cols-1 row-cols-md-4 g-4">
                                <div class="col">
                                    <div class="card need-help-card"
                                        style="width: 100%; height: 100px; border:1px solid #c2baba54;">
                                        <div class="contentfull"
                                            style="height:100%; display: flex; flex-direction: column; justify-content: space-between; padding: 10px; border: 1px solid #c2baba54;">
                                            <div class="topside"
                                                style="display: flex; justify-content: space-between; align-items: center;">
                                                <h5 class="card-title"
                                                    style="font-size: 16px; font-weight: bold; margin-bottom: 0;">
                                                    Product Selector</h5>
                                                <i class="fas fa-headset" style="font-size: 20px; color: #2561a8;"></i>
                                            </div>
                                            <p class="card-text text-muted"
                                                style="font-size: 13px; line-height: 1.3; margin: 0;">
                                                Quickly and easily find the right products and accessories for your application.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card need-help-card"
                                        style="width: 100%; height: 100px; border:1px solid #c2baba54;">
                                        <div class="contentfull"
                                            style="height:100%; display: flex; flex-direction: column; justify-content: space-between; padding: 10px; border: 1px solid #c2baba54;">
                                            <div class="topside"
                                                style="display: flex; justify-content: space-between; align-items: center;">
                                                <h5 class="card-title"
                                                    style="font-size: 16px; font-weight: bold; margin-bottom: 0;">
                                                    Get a Quote</h5>
                                                <i class="fas fa-lightbulb" style="font-size: 20px; color: #2561a8;"></i>
                                            </div>
                                            <p class="card-text text-muted"
                                                style="font-size: 13px; line-height: 1.3; margin: 0;">
                                                Start your sales enquiry online and an expert will connect with you.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card need-help-card"
                                        style="width: 100%; height: 100px; border:1px solid #c2baba54;">
                                        <div class="contentfull"
                                            style="height:100%; display: flex; flex-direction: column; justify-content: space-between; padding: 10px; border: 1px solid #c2baba54;">
                                            <div class="topside"
                                                style="display: flex; justify-content: space-between; align-items: center;">
                                                <h5 class="card-title"
                                                    style="font-size: 16px; font-weight: bold; margin-bottom: 0;">
                                                    Where to Buy?</h5>
                                                <i class="fas fa-map-marker-alt" style="font-size: 20px; color: #2561a8;"></i>
                                            </div>
                                            <p class="card-text text-muted"
                                                style="font-size: 13px; line-height: 1.3; margin: 0;">
                                                Easily find the nearest Schneider Electric distributor in your location.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card need-help-card"
                                        style="width: 100%; height: 100px; border:1px solid #c2baba54;">
                                        <div class="contentfull"
                                            style="height:100%; display: flex; flex-direction: column; justify-content: space-between; padding: 10px; border: 1px solid #c2baba54;">
                                            <div class="topside"
                                                style="display: flex; justify-content: space-between; align-items: center;">
                                                <h5 class="card-title"
                                                    style="font-size: 16px; font-weight: bold; margin-bottom: 0;">
                                                    Help Centre</h5>
                                                <i class="fas fa-question-circle" style="font-size: 20px; color: #2561a8;"></i>
                                            </div>
                                            <p class="card-text text-muted"
                                                style="font-size: 13px; line-height: 1.3; margin: 0;">
                                                Find support resources for all your needs, in one place.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    @include('frontend.partials.recently-viewed')

                </div>
            </div>
        @endif
    </div>

    <style>
        [...styles as provided...]
    </style>

@endsection