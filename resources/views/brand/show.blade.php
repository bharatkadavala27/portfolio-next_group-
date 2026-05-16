@extends('layouts.app')

@section('content')
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        main {
            background-color: rgb(250, 250, 250) !important;
            min-height: auto;
            width: 100%;
        }

        .layout-category-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0px 10px;
        }

        .content-width-limiter {
            max-width: 1400px;
            margin-left: auto;
            margin-right: auto;
            padding-left: 20px;
            padding-right: 20px;
            width: 100%;
        }

        .card {
            transition: all 0.3s ease;
            border: 1px solid #dee2e6 !important;
            border-radius: .25rem !important;
        }

        .card:hover {
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .product-image-container {
            background: #fff;
            min-height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-img {
            transition: transform 0.3s ease;
            max-height: 170px;
            width: auto;
            object-fit: contain;
        }

        .model-number {
            font-size: 0.9rem;
            color: #666;
            text-align: left;
        }

        .product-title {
            font-size: 1rem;
            font-weight: normal;
            color: #333;
            text-align: left;
        }

        .w-90 {
            width: 90% !important;
            margin: 0 auto;
            display: block;
        }

        .btn-outline-dark {
            border-width: 1px;
            font-weight: normal;
        }

        .btn-outline-dark:hover {
            background-color: transparent !important;
            color: inherit !important;
            border-color: #212529 !important;
        }

        .form-check-input:checked {
            background-color: #2561a8;
            border-color: #2561a8;
        }

        .documents-link {
            color: #2561a8;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .documents-link:hover {
            /* text-decoration: underline; */
        }

        .nav-tabs {
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 0;
            gap: 0;
            background: #f8f9fa;
            width: 100%;
        }

        .nav-tabs .nav-item {
            margin-bottom: 0;
        }

        .nav-tabs .nav-link {
            background: #fff;
            border: none;
            border-radius: 0;
            color: #666;
            padding: 1rem 1.5rem;
            font-weight: 400;
            font-size: 1rem;
            transition: all 0.2s ease-in-out;
            position: relative;
        }

        .nav-tabs .nav-link:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: transparent;
            transition: all 0.2s ease-in-out;
        }

        .nav-tabs .nav-link:hover:not(.active) {
            color: #000000;
            background: rgba(37, 97, 168, 0.05);
            border: none;
        }

        .nav-tabs .nav-item.show .nav-link,
        .nav-tabs .nav-link.active {
            color: #2561a8;
            background: #fafafa;
            border: none;
            font-weight: 500;
        }

        .nav-tabs .nav-link.active:after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: #2561a8;
        }

        .tab-content {
            background: #fafafa;
            min-height: 300px;
            border: none;
            border-radius: 0;
            padding-top: 20px;
        }

        .tab-pane {
            padding: 0px;
            display: none;
            border: none;
        }

        .tab-pane.active {
            display: block;
        }

        .tab-pane.show {
            opacity: 1;
            animation: fadeInTabContent 0.2s ease-in-out;
        }

        @keyframes fadeInTabContent {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .card-body {
            padding: 1rem !important;
        }

        .p-4 {
            padding: 1rem !important;
        }

        .p-3 {
            padding: 0.75rem !important;
        }

        .category-heading {
            margin-bottom: 30px;
        }

        .product-path {
            margin-top: 0 !important;
            font-size: 14px;
        }

        .breadcrumb-link {
            color: inherit;
            text-decoration: none;
            transition: color 0.2s;
        }

        .breadcrumb-link:hover {
            color: #1a1a1a !important;
        }

        .fa-chevron-right {
            font-size: 10px;
            color: #6c757d;
            vertical-align: middle;
            margin-top: -2px;
        }

        .category-description {
            font-size: 16px;
            line-height: 1.5;
        }

        .card .card-header {
            border: none !important;
            border-radius: 0 !important;
            background: transparent !important;
            padding: 0.75rem 1rem;
        }

        .card .card-header h5 {
            margin-bottom: 0;
            font-weight: 500;
            color: black !important;
        }

        .categories-filter-header hr {
            margin-top: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .nav-tabs {
            background-color: #fff;
        }

        .card.fade-out {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.3s ease-out, transform 0.3s ease-out;
        }

        .card.fade-in {
            opacity: 1;
            transform: translateY(0);
            animation: fadeInCardAnimation 0.5s ease-in-out;
        }

        @keyframes fadeInCardAnimation {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .filter-checkbox {
            transition: transform 0.2s ease;
        }

        .filter-checkbox:checked {
            transform: scale(1.2);
        }

        .product-card-fixed {
            height: 100%;
            min-height: 390px;
            display: flex;
            flex-direction: column;
        }

        .product-card-img-wrapper {
            height: 200px;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .product-card-img-wrapper img,
        .product-card-img-wrapper .no-image {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .product-card-img-wrapper .no-image {
            display: flex;
            align-items: center;
            justify-content: center;
            color: #aaa;
            font-size: 16px;
            background: #f0f0f0;
        }

        .theme-color {
            background-color: #2561a8 !important;
            color: white !important;
        }

        .theme-color:hover {
            background-color: #1e4f8c !important;
            color: white !important;
        }

        .theme-text {
            color: #2561a8;
        }

        .description-text {
            display: -webkit-box;
            -webkit-line-clamp: 5;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            word-wrap: break-word;
            max-height: 120px;
        }

        .filterby p {
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .c-static-card {
            transition: all 0.3s ease-in-out;
        }

        .c-static-card:hover {
            transition: all 0.3s ease-in-out;
            box-shadow: 0px 0px 5px rgba(96, 96, 96, 0.711);
            padding: 0;
        }

        .documents-panel {
            transition: all 0.3s ease;
            opacity: 0;
            pointer-events: none;
            position: absolute;
            transform-origin: bottom center;
            transform: scaleY(0);
            padding: 12px;
            min-width: 200px;
            width: calc(100% + 10px);
            z-index: 100;
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 4px 4px 0 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            bottom: 34px;
            left: -5px;
            right: -5px;
        }

        @media (max-width: 768px) {
            .documents-panel {
                left: 50% !important;
                transform: translateX(-50%) scaleY(0);
                width: calc(100% + 10px);
            }
        }

        .documents-panel.show {
            opacity: 1;
            pointer-events: auto;
            transform: scaleY(1);
        }

        @media (max-width: 768px) {
            .documents-panel.show {
                transform: translateX(-50%) scaleY(1);
            }
        }

        @media (min-width: 769px) {
            .documents-panel.show {
                transform: scaleY(1);
            }
        }

        .fa-arrow-up {
            transition: transform 0.3s ease;
            display: inline-block;
        }

        .fa-arrow-up.rotated {
            transform: rotate(180deg);
        }

        .close-documents {
            position: absolute;
            top: 8px;
            right: 8px;
            background: none;
            border: none;
            color: #666;
            padding: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .close-documents:hover {
            color: #333;
        }

        .toggle-documents {
            position: relative;
            display: block;
            border: 1px solid #e0e0e0;
            border-radius: 0 0 4px 4px;
            padding: 6px;
            margin: 0 -5px;
            background: white;
            z-index: 1;
        }
    </style>

    <meta name="category-id" content="{{ $category->id }}">

    <div class="top-part" style="background: #ffffff!important; padding:0px 10vw">
        <div class="content-width-limiter">
            @if ($category)
                <div class="category-heading">
                    <p class="product-path text-dark">
                        @foreach ($breadcrumb as $index => $crumb)
                            @if ($index > 0)
                                <i class="fas fa-chevron-right mx-2"></i>
                            @endif
                            @if ($crumb['url'])
                                <a href="{{ $crumb['url'] }}" class="breadcrumb-link">{{ $crumb['name'] }}</a>
                            @else
                                <span>{{ $crumb['name'] }}</span>
                            @endif
                        @endforeach
                    </p>
                    <div class="row align-items-center mt-2">
                        <div class="col-md-8">
                            <h1 class="mb-3 theme-text" style="font-size: 42px; font-weight:500;">{{ $category->name }}</h1>
                            <p class="category-description text-muted pb-2">{!! $category->description !!}</p>
                            <div class="d-flex gap-3 mt-4">
                                <a href="{{ url('/contact-us') }}" class="btn theme-color px-4 py-2 fw-semibold">Contact
                                    Sales</a>
                                <a href="{{ url('/contact-us') }}" class="btn btn-outline-dark rounded-1 px-4 py-2">Contact
                                    Support</a>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex justify-content-end align-items-center">
                            @if ($category->image)
                                <div class="category-image-wrapper">
                                    <img src="{{ asset('uploads/category/' . $category->image) }}" alt=" {{ $category->name }} "
                                        class="img-fluid rounded" style="width:260px; height: 260px; object-fit: contain;">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <ul class="nav nav-tabs mt-4" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="products-tab-btn" data-bs-toggle="tab"
                        data-bs-target="#products-pane" type="button" role="tab" aria-controls="products-pane"
                        aria-selected="true">Products</button>
                </li>
            </ul>
        </div>
    </div>

    <div class="bottom-part py-4" style="background:#fafafa!important;">
        <div class="layout-category-container">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="products-pane" role="tabpanel"
                    aria-labelledby="products-tab-btn">
                    <p style="font-weight: 500; margin-bottom: 0.5rem;">Filter by:</p>
                    <div class="row">
                        <!-- Left Side Filter -->
                        <div class="col-md-3 mt-3">
                            <!-- Category Checkbox Filter -->
                            <div class="card mb-4">
                                <div style="padding-top:10px; padding-left: 10px;">
                                    <h5 class="card-header m-0 p-0 fs-6" style="font-weight: 500; color: black !important;">
                                        Categories</h5>
                                    <div class="hr">
                                        <hr>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form id="filter-form" class="filter-form">
                                        <div class="categories ms-3">
                                            @php
                                                $mainCategory = $categories->first(function ($cat) {
                                                    return (string) $cat->id === '100';
                                                });
                                                $childCategories = $categories->filter(function ($cat) {
                                                    return (string) $cat->parent_id === '100';
                                                });
                                            @endphp

                                            @if($mainCategory)
                                                                                    <div class="mb-3">
                                                                                        <input type="checkbox"
                                                                                            class="form-check-input me-2 filter-checkbox category-filter"
                                                                                            name="categories[]" id="cat-{{ $mainCategory->id }}"
                                                                                            value="{{ $mainCategory->id }}" {{ in_array(
                                                    $mainCategory->id,
                                                    request()->input('categories', [])
                                                ) ? 'checked' : '' }}>
                                                                                        <label class="d-inline fw-bold" for="cat-{{ $mainCategory->id }}">
                                                                                            {{ $mainCategory->name }}
                                                                                        </label>
                                                                                    </div>
                                            @endif

                                            @foreach($childCategories as $cat)
                                                                                <div class="ms-4 mb-2">
                                                                                    <input type="checkbox"
                                                                                        class="form-check-input me-2 filter-checkbox category-filter"
                                                                                        name="categories[]" id="cat-{{ $cat->id }}" value="{{ $cat->id }}" {{
                                                in_array($cat->id, request()->input('categories', [])) ? 'checked' : ''
                                                                                    }}>
                                                                                    <label class="d-inline" for="cat-{{ $cat->id }}">
                                                                                        {{ $cat->name }}
                                                                                    </label>
                                                                                </div>
                                            @endforeach
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Brands List -->
                            <div class="card mb-4">
                                <h5 class="card-header text-white fw-bold theme-color">Brands</h5>
                                <div class="card-body">
                                    @foreach ($allBrands as $brandItem)
                                        <div class="mb-2">
                                            <a href="{{ route('brand.products', $brandItem->id) }}"
                                                class="text-decoration-none d-block px-2 py-1 rounded-1 {{ $brandItem->id == $brand->id ? 'fw-bold text-primary bg-light' : 'text-dark' }}">
                                                {{ $brandItem->name }}
                                                @if($brandItem->id == $brand->id)
                                                    <i class="fas fa-check ms-1"></i>
                                                @endif
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Main Content Area -->
                        <div class="col-md-9 products-area">
                            @if (isset($childCategories) && $childCategories->count() > 0)
                                <div id="subcategory-display-area" class="mb-4">
                                    <h4 class="mb-3 theme-text" style="font-size: 26px; font-weight: normal;">Subcategories</h4>
                                    <div class="row row-cols-1 row-cols-md-3 g-4" id="subcategory-list">
                                        @foreach ($childCategories as $subcategory)
                                            <div class="col">
                                                <div class="card c-static-card h-100 d-flex flex-column"
                                                    style="border:1px solid #E7E6E6FF !important;">
                                                    <a
                                                        href="{{ route('brand.category.show', ['brand_id' => $brand->id ?? request()->brand_id, 'category_id' => $subcategory->id]) }}">
                                                        <img src="{{ asset('uploads/category/' . ($subcategory->image ?? 'default.jpg')) }}"
                                                            alt="{{ $subcategory->name }}" class="card-img-top"
                                                            style="object-fit: contain; height: 100px; object-position: left; margin:20px 20px 0px 20px;">
                                                    </a>
                                                    <div class="card-body d-flex flex-column">
                                                        <a href="{{ route('brand.category.show', ['brand_id' => $brand->id ?? request()->brand_id, 'category_id' => $subcategory->id]) }}"
                                                            style="text-decoration:none">
                                                            <h5 class="card-title text-dark text-truncate fw-normal">
                                                                {{ $subcategory->name }}
                                                            </h5>
                                                        </a>
                                                        <p class="card-text text-muted description-text flex-grow-1">
                                                            {!! $subcategory->description !!}
                                                        </p>
                                                        <div class="mt-auto">
                                                            <a href="{{ route('brand.category.show', ['brand_id' => $brand->id ?? request()->brand_id, 'category_id' => $subcategory->id]) }}"
                                                                class="theme-text" style="text-decoration:none">View Details</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if (isset($products) && $products->count() > 0)
                                <div id="product-display-area">
                                    @if (isset($childCategories) && $childCategories->count() > 0)
                                        <h4 class="mb-3 theme-text" style="font-size: 26px; font-weight: normal;">Products</h4>
                                    @endif
                                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                                        @foreach ($products as $product)
                                            <div class="col p-0">
                                                <div class="card h-100 position-relative product-card-fixed">
                                                    <div class="form-check position-absolute"
                                                        style="top: 10px; left: 10px; z-index: 1;">
                                                        <input type="checkbox" class="form-check-input"
                                                            id="product-select-{{ $product->id }}">
                                                    </div>
                                                    <div class="product-card-img-wrapper">
                                                        @php
                                                            $images = is_string($product->images)
                                                                ? json_decode(str_replace('\\', '/', $product->images), true)
                                                                : ($product->images ?? []);

                                                            $firstImage = is_array($images) && !empty($images[0]) ? $images[0] : null;

                                                            if ($firstImage) {
                                                                $firstImage = ltrim($firstImage, '/');
                                                                if (stripos($firstImage, 'uploads/products/') !== 0) {
                                                                    $firstImage = 'uploads/products/' . $firstImage;
                                                                }
                                                                $imageUrl = asset($firstImage);
                                                            } else {
                                                                $imageUrl = asset('images/no-image.png');
                                                            }
                                                        @endphp

                                                        <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="product-img">

                                                    </div>
                                                    <div class="card-body d-flex flex-column p-3">
                                                        <div class="position-relative">
                                                            <p class="model-number text-muted mb-1">
                                                                {{ $product->serial_number }}
                                                            </p>
                                                            <h5 class="product-title mb-2 text-truncate fw-semibold"
                                                                title="{{ $product->name }}">{{ $product->name }}</h5>
                                                        </div>
                                                        <div class="mt-auto text-center pt-2">
                                                            <a href="{{ url('/product', $product->id) }}"
                                                                class="btn btn-outline-dark rounded-1 w-90 mb-2 fw-semibold">View
                                                                Details</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if (
                                    (!isset($childCategories) || $childCategories->count() == 0) &&
                                    (!isset($products) || $products->count() == 0)
                                )
                                <p class="text-center text-muted p-5">No items to display in this category.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{--
            <!-- Recently Viewed Items Section -->
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
                                    <p class="card-text text-muted" style="font-size: 13px; line-height: 1.3; margin: 0;">
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
                                    <p class="card-text text-muted" style="font-size: 13px; line-height: 1.3; margin: 0;">
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
                                    <p class="card-text text-muted" style="font-size: 13px; line-height: 1.3; margin: 0;">
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
                                    <p class="card-text text-muted" style="font-size: 13px; line-height: 1.3; margin: 0;">
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

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const style = document.createElement('style');
                style.textContent = `
                    .documents-panel {
                        transition: transform 0.3s ease, opacity 0.3s ease;
                        opacity: 0;
                        pointer-events: none;
                        transform: translateY(-10px);
                    }
                    .documents-panel.show {
                        opacity: 1;
                        pointer-events: auto;
                        transform: translateY(0);
                    }
                    .fa-arrow-up {
                        transition: transform 0.3s ease;
                        display: inline-block;
                    }
                    .fa-arrow-up.rotated {
                        transform: rotate(180deg);
                    }
                `;
                document.head.appendChild(style);

                document.querySelectorAll('.toggle-documents').forEach(function (link) {
                    let isAnimating = false;
                    link.addEventListener('click', function (e) {
                        e.preventDefault();
                        if (isAnimating) return;
                        const productId = this.getAttribute('data-product-id');
                        const panel = document.getElementById('documents-panel-' + productId);
                        const arrow = this.querySelector('.fa-arrow-up');
                        const allPanels = document.querySelectorAll('.documents-panel');
                        const allArrows = document.querySelectorAll('.fa-arrow-up');
                        isAnimating = true;
                        allPanels.forEach(p => {
                            if (p !== panel && p.classList.contains('show')) {
                                p.classList.remove('show');
                                setTimeout(() => p.style.display = 'none', 300);
                            }
                        });
                        allArrows.forEach(a => {
                            if (a !== arrow) a.classList.remove('rotated');
                        });
                        if (panel.style.display === 'none' || panel.style.display === '') {
                            panel.style.display = 'block';
                            requestAnimationFrame(() => {
                                panel.classList.add('show');
                                arrow.classList.add('rotated');
                            });
                        } else {
                            panel.classList.remove('show');
                            arrow.classList.remove('rotated');
                            setTimeout(() => panel.style.display = 'none', 300);
                        }
                        setTimeout(() => isAnimating = false, 300);
                    });
                });

                document.addEventListener('click', function (e) {
                    if (!e.target.closest('.documents-panel') && !e.target.closest('.toggle-documents')) {
                        document.querySelectorAll('.documents-panel.show').forEach(panel => {
                            panel.classList.remove('show');
                            const productId = panel.id.replace('documents-panel-', '');
                            const arrow = document.querySelector(`[data-product-id="${productId}"] .fa-arrow-up`);
                            if (arrow) arrow.classList.remove('rotated');
                            setTimeout(() => panel.style.display = 'none', 300);
                        });
                    }
                });

                document.querySelectorAll('.close-documents').forEach(button => {
                    button.addEventListener('click', function () {
                        const panel = this.closest('.documents-panel');
                        const productId = panel.id.replace('documents-panel-', '');
                        const arrow = document.querySelector(`[data-product-id="${productId}"] .fa-arrow-up`);
                        panel.classList.remove('show');
                        if (arrow) arrow.classList.remove('rotated');
                        setTimeout(() => panel.style.display = 'none', 300);
                    });
                });
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const brandCheckboxes = document.querySelectorAll('input[name="brands[]"]');
                const baseUrl = window.location.origin;

                function filterProducts() {
                    const selectedBrands = Array.from(document.querySelectorAll('input[name="brands[]"]:checked')).map(cb => cb.value);
                    const productsArea = document.querySelector('.products-area');
                    if (productsArea) {
                        productsArea.innerHTML = '<div class="text-center p-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
                    }
                    const categoryId = document.querySelector('meta[name="category-id"]')?.getAttribute('content');
                    const searchParams = new URLSearchParams({
                        brands: JSON.stringify(selectedBrands),
                        category_id: categoryId,
                        brand_id: '{{ $brand->id ?? request()->brand_id }}'
                    });

                    fetch(`/api/products?${searchParams.toString()}`, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                        .then(async response => {
                            if (!response.ok) {
                                let errorMessage = `HTTP error! status: ${response.status}`;
                                try {
                                    const errorData = await response.json();
                                    errorMessage = errorData.message || errorMessage;
                                } catch (e) {
                                    try {
                                        const errorText = await response.text();
                                        errorMessage = errorText || errorMessage;
                                    } catch (e2) { }
                                }
                                throw new Error(errorMessage);
                            }
                            return response.json()
                        })
                        .then(data => {
                            const productsContainer = document.querySelector('.products-area');
                            if (data.status === 200 && productsContainer) {
                                let productsHTML = '';
                                const products = data.products || [];
                                if (products.length > 0) {
                                    productsHTML = '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">';
                                    products.forEach(product => {
                                        let imageUrl = '';
                                        if (product.images) {
                                            let imagesArr = [];
                                            if (typeof product.images === 'string') {
                                                try {
                                                    imagesArr = JSON.parse(product.images);
                                                } catch (e) {
                                                    imagesArr = [];
                                                }
                                            } else if (Array.isArray(product.images)) {
                                                imagesArr = product.images;
                                            }
                                            if (imagesArr && imagesArr.length > 0 && imagesArr[0]) {
                                                let img = imagesArr[0].replace(/^\/+/, ''); // strip leading /
                                                if (!img.toLowerCase().startsWith('uploads/products/')) {
                                                    img = 'uploads/products/' + img;
                                                }
                                                imageUrl = baseUrl + '/public/' + img;
                                            }



                                        }
                                        if (!imageUrl && product.image_path) {
                                            imageUrl = product.image_path.match(/^https?:\/\/\//) ? product.image_path : (product.image_path.startsWith('/') ? baseUrl + product.image_path : baseUrl + '/uploads/' + product.image_path);
                                        }
                                        if (!imageUrl) {
                                            imageUrl = baseUrl + '/images/no-image.png';
                                        }

                                        productsHTML += `
                                        <div class="col p-0">
                                            <div class="card h-100 position-relative product-card-fixed">
                                                <div class="form-check position-absolute" style="top: 10px; left: 10px; z-index: 1;">
                                                    <input type="checkbox" class="form-check-input" id="product-select-${product.id}">
                                                </div>
                                                <div class="product-card-img-wrapper">
                                                    <img src="${imageUrl}" alt="${product.name}" class="product-img">
                                                </div>
                                                <div class="card-body d-flex flex-column p-3">
                                                    <div class="position-relative">
                                                        <p class="model-number text-muted mb-1">${product.serial_number || ''}</p>
                                                        <h5 class="product-title mb-2 text-truncate fw-semibold" title="${product.name}">${product.name}</h5>
                                                    </div>
                                                    <div class="mt-auto text-center pt-2">
                                                        <a href="/product/${product.id}" class="btn btn-outline-dark rounded-1 w-90 mb-2 fw-semibold">View Details</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    `;
                                    });
                                    productsHTML += '</div>';
                                } else {
                                    productsHTML = '<p class="text-center text-muted p-5">No products found for the selected filters.</p>';
                                }
                                productsContainer.innerHTML = productsHTML;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            const productsContainer = document.querySelector('.products-area');
                            if (productsContainer) {
                                productsContainer.innerHTML = `<p class="text-center text-danger p-5">An error occurred while filtering products: ${error.message}</p>`;
                            }
                        });
                }

                brandCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', filterProducts);
                });

                if (document.querySelectorAll('input[name="brands[]"]:checked').length > 0) {
                    filterProducts();
                }
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Use event delegation for category filter checkboxes
                document.addEventListener('change', function (e) {
                    if (e.target && e.target.classList.contains('category-filter')) {
                        const form = document.getElementById('filter-form');
                        const formData = new FormData(form);
                        const params = new URLSearchParams();
                        for (const pair of formData.entries()) {
                            params.append(pair[0], pair[1]);
                        }

                        fetch(window.location.pathname + '?' + params.toString(), {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                            .then(response => response.text())
                            .then(html => {
                                const parser = new DOMParser();
                                const doc = parser.parseFromString(html, 'text/html');
                                const newContent = doc.querySelector('.col-md-9');
                                const oldContent = document.querySelector('.col-md-9');
                                if (newContent && oldContent) {
                                    oldContent.innerHTML = newContent.innerHTML;
                                }
                                window.scrollTo({ top: 0, behavior: 'smooth' });
                            });
                    }
                });
            });
        </script>
@endsection