@extends('layouts.app')

@section('content')

<style>
    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

    a:hover {
        border: none;
        text-decoration: none;
    }

    main {
        background-color: rgb(250, 250, 250) !important;
        min-height: auto;
        width: 100%;
    }

    .layout-category-container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0px 110px;
    }

    /* Main content alignment wrapper */
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



    #product-display-area .card:hover {
        box-shadow: 0px 0px 10px 3px rgb(0 0 0 / 31%);
        z-index: 2;

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
        border: 1px solid #212529 !important;
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

    /* Updated Tab Styles */
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
        font-weight: 500;
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
        object-fit: contain;
        overflow: hidden;
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

    .top-part {
        background: #ffffff !important;
        padding: 0px 0vw;
    }


    .custom-col {
        flex: 0 0 auto;
        /* column base */
        width: 33.333333%;
        /* col-md-4 → 4 of 12 grid */
        display: flex;
        /* d-flex */
        justify-content: flex-end;
        /* justify-content-end */
        align-items: center;
        /* align-items-center */
    }

    .layout-category-container {
        padding: 0px 10px;
    }

    @media (max-width: 768px) {
        .top-part {
            padding: 0px 20px;
        }

        .custom-col {
            flex: 0 0 auto;
            /* column base */
            width: 100%;
            /* col-md-4 → 4 of 12 grid */
            display: flex;
            /* d-flex */
            justify-content: center;
            /* justify-content-end */
            align-items: center;
            /* align-items-center */
        }

        .products-area {
            padding: 0px 20px;
        }
    }
</style>

<meta name="category-id" content="{{ $category->id }}">
<div class="top-part">

    <div class="content-width-limiter">



        @if ($category)
        <div class="category-heading">
            <p class="product-path text-dark">
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
            <div class="row align-items-center mt-2">
                <div class="col-md-8">
                    <h1 class="mb-3 theme-text" style="font-size: 42px; font-weight:500; cursor:default;">{{ $category->name }}</h1>
                    <p class="category-description  pb-2">{!! $category->description !!}</p>
                    <div class="d-flex gap-3 mt-4">
                        <a href="{{ url('/contact-us') }}" class="btn theme-color  -1 px-4 py-2 fw-semibold">Contact
                            Sales</a> <a href="{{ url('/contact-us') }}"
                            class="btn btn-outline-dark rounded-1 px-4 py-2">Contact
                            Support</a>
                    </div>
                </div>


                <div class="custom-col">
                    @if ($category->image)
                    <div class="category-image-wrapper">
                        <img src="{{ asset('uploads/category/' . $category->image) }}" alt="{{ $category->name }}"
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
                    aria-selected="true">
                    Products
                </button>
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
                    <!-- Left Side Filter -->
                    <div class="col-md-3 mt-3">
                        {{-- Loop through ordered filters --}}
                        @if(isset($orderedFilters))
                            @foreach($orderedFilters as $filter)
                                @php
                                     $type = $filter->formattedData['type'] ?? 'unknown';
                                     $isVisible = $filter->formattedData['isVisible'] ?? false;
                                     $items = $filter->formattedData['items'] ?? [];
                                @endphp

                                @if($type === 'category_system' && $isVisible)
                                   {{-- Show categories if applicable --}}
                                    <div class="card mb-4" style="border:1px solid #E7E6E6FF !important;">
                                        <div style="padding-top:10px; padding-left: 10px;">
                                            <h5 class="card-header m-0 p-0 fs-6" style="font-weight: 500; color: black !important;">
                                                Categories
                                            </h5>
                                            <div class="hr"><hr></div>
                                        </div>
                                        <div class="card-body">
                                             <div class="subcategories ">
                                                @foreach ($items as $subcategory)
                                                    <div class="form-check mb-2">
                                                        <input type="checkbox"
                                                               class="form-check-input me-2 filter-checkbox"
                                                               name="categories[]"
                                                               id="cat-{{ $subcategory->id }}"
                                                               value="{{ $subcategory->id }}"
                                                               {{ in_array($subcategory->id, (array) request()->input('categories', [])) ? 'checked' : '' }}>
                                                        <label for="cat-{{ $subcategory->id }}" class="form-check-label d-inline">
                                                            {{ $subcategory->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @elseif($type === 'brand_system' && $isVisible)
                                    <div class="card mb-4" style="border:1px solid #E7E6E6FF !important;">
                                        <div class="card-header categories-filter-header">
                                            <h5 class="card-header fs-6" style="font-weight: 500; color: black !important; ">
                                                Brands</h5>
                                            <hr style="margin-top: 0.5rem; margin-bottom: 0.5rem;">
                                        </div>
                                        <div class="card-body">
                                            <div class="brands ms-1">
                                                @foreach ($items as $brand)
                                                    <div class="form-check mb-2">
                                                        <input type="checkbox" class="form-check-input me-2 filter-checkbox"
                                                            name="brands[]" id="brand-{{ $brand->id }}" value="{{ $brand->id }}" {{
                                                            request()->has('brands') && in_array($brand->id, (array)request()->brands) ?
                                                        'checked' : '' }}>
                                                        <label class="form-check-label" for="brand-{{ $brand->id }}">
                                                            {{ $brand->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @elseif($type === 'dynamic' && $isVisible)
                                    <div class="card mb-4" style="border:1px solid #E7E6E6FF !important;">
                                        <div class="card-header categories-filter-header">
                                            <h5 class="card-header fs-6" style="font-weight: 500; color: black !important;">
                                                {{ $filter->name }}</h5>
                                            <hr style="margin-top: 0.5rem; margin-bottom: 0.5rem;">
                                        </div>
                                        <div class="card-body">
                                            <div class="filter-options ms-1">
                                                @foreach ($items as $option)
                                                    <div class="form-check mb-2">
                                                        <input type="checkbox"
                                                               class="form-check-input me-2 filter-checkbox"
                                                               name="filters[{{ $filter->id }}][]"
                                                               id="filter-{{ $filter->id }}-option-{{ $option->id }}"
                                                               value="{{ $option->id }}"
                                                               {{ in_array($option->id, (array) request()->input('filters.' . $filter->id, [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="filter-{{ $filter->id }}-option-{{ $option->id }}">
                                                            {{ $option->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>

                    <!-- Main Content Area -->
                    <div class="col-md-9 products-area">
                        @if (isset($childCategories) &&
                        $childCategories->count() > 0 &&
                        !($category->products->count() > 0 && empty(request('category'))))
                        <div id="subcategory-display-area" class="mb-4">
                            <h4 class="mb-3 theme-text" style="font-size: 26px; font-weight: normal;">Subcategories
                            </h4>
                            <div class="row row-cols-1 row-cols-md-3 g-4" id="subcategory-list">
                                @foreach ($childCategories as $subcategory)
                                <div class="col">
                                    <div class="card c-static-card h-100 d-flex flex-column"
                                        style="border:1px solid #E7E6E6FF !important;">

                                        <a href="{{ url('/category', $subcategory->id) }}">
                                            <img src="{{ asset('Uploads/category/' . $subcategory->image) }}"
                                                alt="{{ $subcategory->name }}" class="card-img-top"
                                                style="object-fit: contain; height: 100px; object-position: left; margin:20px 20px 00px 20px;">
                                        </a>
                                        <div class="card-body d-flex flex-column">
                                            <a href="{{ url('/category', $subcategory->id) }}"
                                                style="text-decoration:none">
                                                <h5 class="card-title text-dark text-truncate fw-normal">
                                                    {{ $subcategory->name }}</h5>
                                            </a>
                                            <p class="card-text text-muted description-text flex-grow-1">
                                                {!! $subcategory->description !!}</p>
                                            <div class="mt-auto">
                                                <a href="{{ url('/category', $subcategory->id) }}" class="theme-text"
                                                    style="text-decoration:none">View
                                                    Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if (isset($category->products) && $category->products->count() > 0)
                        <div id="product-display-area">
                            @if (isset($childCategories) && $childCategories->count() > 0)
                            <h4 class="mb-3 theme-text" style="font-size: 26px; font-weight: normal;">Products
                            </h4>
                            @endif
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                                @foreach ($category->products as $product)
                                <div class="col p-0">

                                    <a href="/product/{{ $product->id }}" style="text-decoration:none;color:inherit;">
                                        <div class="card h-100 position-relative product-card-fixed">
                                            <div class="form-check position-absolute"
                                                style="top: 10px; left: 10px; z-index: 1;">
                                                <input type="checkbox" class="form-check-input"
                                                    id="product-select-{{ $product->id }}">
                                            </div>
                                            {{-- Replace the image section in your Blade template with this --}}
                                            <div class="product-card-img-wrapper">
                                                @php
                                                    $images = [];
                                                    if ($product->images) {
                                                        try {
                                                            $images = json_decode($product->images, true, 512, JSON_THROW_ON_ERROR);
                                                            if (!is_array($images)) {
                                                                $images = [];
                                                            }
                                                        } catch (\JsonException $e) {
                                                            $images = [];
                                                        }
                                                    }

                                                    $imagePath = '';
                                                    if (!empty($images) && !empty($images[0]) && $images[0] !== 'null' && trim($images[0]) !== '') {
                                                        // Normalize path: if DB already has "uploads/products/" or "Uploads/products/"
                                                        if (stripos($images[0], 'uploads/products/') === 0 || stripos($images[0], 'Uploads/products/') === 0) {
                                                            $imagePath = $images[0];
                                                        } else {
                                                            $imagePath = 'uploads/products/' . ltrim($images[0], '/');
                                                        }
                                                    }
                                                @endphp

                                                @if (!empty($imagePath))
                                                    <img src="{{ asset($imagePath) }}" alt="{{ $product->name }}"
                                                        class="product-img bg-white"
                                                        onerror="this.parentElement.innerHTML='<div class=\'no-image text-muted small\'>Image failed to load</div>'">
                                                @else
                                                <div class="no-image text-muted small">No image available</div>
                                                @endif
                                            </div>


                                            <div class="card-body d-flex flex-column p-3">
                                                <div class="position-relative">
                                                    <p class="model-number text-muted mb-1">
                                                        {{ $product->serial_number }}</p>
                                                    <h5 class="product-title mb-2 text-truncate fw-semibold"
                                                        title="{{ $product->name }}">
                                                        {{ $product->name }}
                                                    </h5>
                                                    <div class="documents-panel" id="documents-panel-{{ $product->id }}"
                                                        style="margin-bottom: -110px;">
                                                        <div class="p-2">
                                                            <div
                                                                class="d-flex justify-content-between align-items-center mb-2">
                                                                <small class="fw-bold">Documents</small>
                                                                <button type="button"
                                                                    class="btn-close btn-sm close-documents"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <div class="documents-list">
                                                                @php $docs = $product->documents ?? []; @endphp
                                                                @if (!empty($docs))
                                                                    @foreach ($docs->take(3) as $document)
                                                                        <div class="document-item mb-1">
                                                                            <a href="{{ asset($document->file_path) }}" target="_blank"
                                                                                class="documents-link text-decoration-none d-flex align-items-center">

                                                                                @if(!empty($document->documentType) && !empty($document->documentType->image))
                                                                                    {{-- Show document type image --}}
                                                                                    <img src="{{ asset('document-types/' . $document->documentType->image) }}"
                                                                                        alt="{{ $document->document_name ?? 'Document' }}"
                                                                                        class="me-2"
                                                                                        style="width:24px; height:24px; object-fit:contain;">
                                                                                @else
                                                                                    {{-- Fallback file icon --}}
                                                                                    <i class="fa fa-file me-2" style="font-size:18px;"></i>
                                                                                @endif

                                                                                {{ Str::limit($document->document_name ?? basename($document->file_path), 25, '...') }}
                                                                            </a>
                                                                        </div>
                                                                    @endforeach
                                                                @if (count($docs) > 3)
                                                                <div class="text-center mt-2">
                                                                    <a href="{{ url('/product', $product->id) }}#documents"
                                                                        class="documents-link text-decoration-none">
                                                                        View All ({{ count($docs) - 3 }}
                                                                        more)
                                                                    </a>
                                                                </div>
                                                                @endif
                                                                @else
                                                                <div class="text-center text-muted small">No
                                                                    documents available</div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-auto text-center pt-2">
                                                    <a href="{{ url('/product', $product->id) }}"
                                                        class="btn btn-outline-dark rounded-1 w-90 mb-2 fw-semibold">View
                                                        Details</a>
                                                    <div class="position-relative">
                                                        <span class="documents-link d-block toggle-documents"
                                                            data-product-id="{{ $product->id }}"
                                                            style="border: 1px solid #e0e0e0; border-radius: 0 0 4px 4px; padding: 6px; margin: 0 -5px; background: white; cursor:pointer;">
                                                            <!-- <i class="fas fa-file-alt me-1"></i>  -->
                                                            Documents <i
                                                                class="fas fa-arrow-up"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif



                        @if (
                        (!isset($childCategories) || $childCategories->count() == 0) &&
                        (!isset($category->products) || $category->products->count() == 0))
                        <p class="text-center text-muted p-5">No items to display in this category.</p>
                        @endif
                    </div>

                </div>
            </div>

            <div class="tab-pane fade" id="presentation-pane" role="tabpanel" aria-labelledby="presentation-tab-btn">
                <p class="p-4 text-center">Presentation content will be displayed here.</p>
            </div>
            <div class="tab-pane fade" id="documents-pane" role="tabpanel" aria-labelledby="documents-tab-btn">
                <p class="p-4 text-center">Documents will be listed here.</p>
            </div>
            <div class="tab-pane fade" id="software-pane" role="tabpanel" aria-labelledby="software-tab-btn">
                <p class="p-4 text-center">Software and Firmware links will appear here.</p>
            </div>
            <div class="tab-pane fade" id="registration-pane" role="tabpanel" aria-labelledby="registration-tab-btn">
                <p class="p-4 text-center">Software Registration information will be here.</p>
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
                    <div class="card need-help-card" style="width: 100%; height: 100px; border:1px solid #c2baba54;">
                        <div class="contentfull"
                            style="height:100%; display: flex; flex-direction: column; justify-content: space-between; padding: 10px; border: 1px solid #c2baba54;">
                            <div class="topside"
                                style="display: flex; justify-content: space-between; align-items: center;">
                                <h5 class="card-title" style="font-size: 16px; font-weight: bold; margin-bottom: 0;">
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
                    <div class="card need-help-card" style="width: 100%; height: 100px; border:1px solid #c2baba54;">
                        <div class="contentfull"
                            style="height:100%; display: flex; flex-direction: column; justify-content: space-between; padding: 10px; border: 1px solid #c2baba54;">
                            <div class="topside"
                                style="display: flex; justify-content: space-between; align-items: center;">
                                <h5 class="card-title" style="font-size: 16px; font-weight: bold; margin-bottom: 0;">
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
                    <div class="card need-help-card" style="width: 100%; height: 100px; border:1px solid #c2baba54;">
                        <div class="contentfull"
                            style="height:100%; display: flex; flex-direction: column; justify-content: space-between; padding: 10px; border: 1px solid #c2baba54;">
                            <div class="topside"
                                style="display: flex; justify-content: space-between; align-items: center;">
                                <h5 class="card-title" style="font-size: 16px; font-weight: bold; margin-bottom: 0;">
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
                    <div class="card need-help-card" style="width: 100%; height: 100px; border:1px solid #c2baba54;">
                        <div class="contentfull"
                            style="height:100%; display: flex; flex-direction: column; justify-content: space-between; padding: 10px; border: 1px solid #c2baba54;">
                            <div class="topside"
                                style="display: flex; justify-content: space-between; align-items: center;">
                                <h5 class="card-title" style="font-size: 16px; font-weight: bold; margin-bottom: 0;">
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
                // Add CSS for animations
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

                // Handle documents panel toggle
                document.querySelectorAll('.toggle-documents').forEach(function(link) {
                    let isAnimating = false;

                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        if (isAnimating) return;

                        const productId = this.getAttribute('data-product-id');
                        const panel = document.getElementById('documents-panel-' + productId);
                        const arrow = this.querySelector('.fa-arrow-up');
                        const allPanels = document.querySelectorAll('.documents-panel');
                        const allArrows = document.querySelectorAll('.fa-arrow-up');

                        isAnimating = true;

                        // Close all other panels first
                        allPanels.forEach(p => {
                            if (p !== panel && p.classList.contains('show')) {
                                p.classList.remove('show');
                                setTimeout(() => {
                                    p.style.display = 'none';
                                }, 300);
                            }
                        });

                        // Reset all other arrows
                        allArrows.forEach(a => {
                            if (a !== arrow) {
                                a.classList.remove('rotated');
                            }
                        });

                        if (panel.style.display === 'none' || panel.style.display === '') {
                            // Show panel
                            panel.style.display = 'block';
                            requestAnimationFrame(() => {
                                panel.classList.add('show');
                                arrow.classList.add('rotated');
                            });
                        } else {
                            // Hide panel
                            panel.classList.remove('show');
                            arrow.classList.remove('rotated');
                            setTimeout(() => {
                                panel.style.display = 'none';
                            }, 300);
                        }

                        setTimeout(() => {
                            isAnimating = false;
                        }, 300);
                    });
                });

                // Close panel when clicking outside
                document.addEventListener('click', function(e) {
                    if (!e.target.closest('.documents-panel') && !e.target.closest('.toggle-documents')) {
                        document.querySelectorAll('.documents-panel.show').forEach(panel => {
                            const productId = panel.id.replace('documents-panel-', '');
                            const arrow = document.querySelector(
                                `[data-product-id="${productId}"] .fa-arrow-up`);

                            panel.classList.remove('show');
                            if (arrow) arrow.classList.remove('rotated');

                            setTimeout(() => {
                                panel.style.display = 'none';
                            }, 300);
                        });
                    }
                });

                // Close button handler
                document.querySelectorAll('.close-documents').forEach(button => {
                    button.addEventListener('click', function() {
                        const panel = this.closest('.documents-panel');
                        const productId = panel.id.replace('documents-panel-', '');
                        const arrow = document.querySelector(
                            `[data-product-id="${productId}"] .fa-arrow-up`);

                        panel.classList.remove('show');
                        if (arrow) arrow.classList.remove('rotated');

                        setTimeout(() => {
                            panel.style.display = 'none';
                        }, 300);
                    });
                });
            });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const allFilterCheckboxes = document.querySelectorAll('.filter-checkbox');
    const baseUrl = window.location.origin;

    // Store initial product order and original HTML
    let initialProductOrder = [];
    let originalProductsHTML = '';
    const initialProducts = document.querySelectorAll('.products-area .product-card-fixed');
    
    // Store the original products area HTML for restoration
    const productsContainer = document.querySelector('.products-area');
    if (productsContainer) {
        originalProductsHTML = productsContainer.innerHTML;
    }
    
    initialProducts.forEach(product => {
        const checkbox = product.querySelector('.form-check-input');
        if (checkbox) {
            const productId = checkbox.id.replace('product-select-', '');
            initialProductOrder.push(productId);
        }
    });

    function getImageHTML(product) {
        let imageHTML = '';

        // Check if product has image_path (from API)
        if (product.image_path && product.image_path !== '' && product.image_path !== 'null') {
            let imageUrl = product.image_path;

            // If it's already a full URL, use it as-is (normalization happens in onerror fallback)
            if (imageUrl.startsWith('http')) {
                console.log(`Product ${product.id} - Full URL: ${imageUrl}`);
                imageHTML = `<img src="${imageUrl}" alt="${product.name || ''}" class="product-img bg-white" 
                    data-tried="0" onerror="handleImageError(this)"
                    onload="console.log('Image loaded successfully: ${imageUrl}')">`;
            } else {
                // Normalize relative path: preserve public/ if present, normalize case for uploads
                imageUrl = imageUrl.replace(/^public\/Uploads\//i, 'public/uploads/')
                                  .replace(/^public\/uploads\//i, 'public/uploads/')
                                  .replace(/^Uploads\//i, 'uploads/')
                                  .replace(/^uploads\//i, 'uploads/')
                                  .replace(/^\/+/, '');

                // Ensure correct path format
                if (!imageUrl.includes('uploads/products/')) {
                    if (imageUrl.startsWith('public/')) {
                        imageUrl = 'public/uploads/products/' + imageUrl.replace(/^public\//, '');
                    } else {
                        imageUrl = 'uploads/products/' + imageUrl;
                    }
                }

                console.log(`Product ${product.id} - Relative Path: /${imageUrl}`);
                imageHTML = `<img src="/${imageUrl}" alt="${product.name || ''}" class="product-img bg-white" 
                    data-tried="0" onerror="handleImageError(this)"
                    onload="console.log('Image loaded successfully: /${imageUrl}')">`;
            }
        } else if (product.images) {
            // Handle original template structure with images JSON
            let imagesArr = [];

            // Parse images if it's a string
            if (typeof product.images === 'string') {
                try {
                    imagesArr = JSON.parse(product.images);
                    if (!Array.isArray(imagesArr)) {
                        imagesArr = [];
                    }
                } catch (e) {
                    imagesArr = [];
                    console.warn(`Failed to parse images for product ${product.id}:`, e);
                }
            } else if (Array.isArray(product.images)) {
                imagesArr = product.images;
            }

            // Check if we have valid images
            if (Array.isArray(imagesArr) && imagesArr.length > 0 && imagesArr[0] && imagesArr[0].trim() !== '' && imagesArr[0] !== 'null') {
                let imageUrl = imagesArr[0];

                // If it's already a full URL, use it (with onerror fallback)
                if (imageUrl.startsWith('http')) {
                    imageHTML = `<img src="${imageUrl}" alt="${product.name || ''}" class="product-img bg-white" 
                        data-tried="0" onerror="handleImageError(this)">`;
                } else {
                    // Normalize relative path as above
                    imageUrl = imageUrl.replace(/^public\/Uploads\//i, 'public/uploads/')
                                      .replace(/^public\/uploads\//i, 'public/uploads/')
                                      .replace(/^Uploads\//i, 'uploads/')
                                      .replace(/^uploads\//i, 'uploads/')
                                      .replace(/^\/+/, '');

                    if (!imageUrl.includes('uploads/products/')) {
                        if (imageUrl.startsWith('public/')) {
                            imageUrl = 'public/uploads/products/' + imageUrl.replace(/^public\//, '');
                        } else {
                            imageUrl = 'uploads/products/' + imageUrl;
                        }
                    }

                    imageHTML = `<img src="/${imageUrl}" alt="${product.name || ''}" class="product-img bg-white" 
                        data-tried="0" onerror="handleImageError(this)">`;
                }
            } else {
                imageHTML = `<div class="no-image text-muted small">No image available</div>`;
            }
        } else {
            imageHTML = `<div class="no-image text-muted small">No image available</div>`;
        }

        return imageHTML;
    }

    function filterProducts() {
        const selectedBrands = Array.from(document.querySelectorAll('input[name="brands[]"]:checked')).map(cb => cb.value);
        
        // Collect selected product filters
        const selectedFilters = {};
        document.querySelectorAll('input[name^="filters["]:checked').forEach(cb => {
             const match = cb.name.match(/filters\[(\d+)\]/);
             if (match) {
                 const filterId = match[1];
                 if (!selectedFilters[filterId]) selectedFilters[filterId] = [];
                 selectedFilters[filterId].push(cb.value);
             }
        });

        const productsArea = document.querySelector('.products-area');
        
        // If no filters selected, restore original HTML
        if (selectedBrands.length === 0 && Object.keys(selectedFilters).length === 0) {
            if (productsArea) {
                productsArea.innerHTML = originalProductsHTML;
                // Reinitialize document panels for original content
                initializeDocumentPanels();
            }
            return;
        }
        
        if (productsArea) {
            productsArea.innerHTML = '<div class="text-center p-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
        }
        
        const categoryId = document.querySelector('meta[name="category-id"]')?.getAttribute('content');
        const searchParams = new URLSearchParams({
            brands: JSON.stringify(selectedBrands),
            filters: JSON.stringify(selectedFilters),
            parent_id: categoryId
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
                    } catch (e2) {}
                }
                throw new Error(errorMessage);
            }
            return response.json();
        })
        .then(data => {
            console.log('API Response:', data);
            const productsContainer = document.querySelector('.products-area');
            if (data.status === 200 && productsContainer) {
                let productsHTML = '';
                let products = data.products || [];
                console.log('Products count:', products.length);

                if (products.length > 0) {
                    console.log('Sample product data:', products[0]);
                    productsHTML = '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">';
                    products.forEach(product => {
                        // Use the unified image handling function
                        const imageHTML = getImageHTML(product);

                        // Build documents panel HTML
                        let documentsHTML = '';
                        let documentsCount = 0;
                        
                        if (product.documents && Array.isArray(product.documents) && product.documents.length > 0) {
                            documentsCount = product.documents.length;
                            const displayDocs = product.documents.slice(0, 3);
                            
                            documentsHTML = displayDocs.map(doc => {
                                let docUrl = doc.file_path;
                                if (docUrl && !docUrl.match(/^https?:\/\//)) {
                                    docUrl = baseUrl + '/' + docUrl.replace(/^\/+/, '');
                                }
                                const fileName = doc.file_path ? doc.file_path.split('/').pop() : 'Document';
                                return `<div class="document-item mb-1">
                                    <a href="${docUrl}" target="_blank" class="documents-link text-decoration-none">
                                        <i class="fas fa-file-pdf me-1"></i>${fileName}
                                    </a>
                                </div>`;
                            }).join('');
                            
                            if (documentsCount > 3) {
                                documentsHTML += `<div class="text-center mt-2">
                                    <a href="${baseUrl}/product/${product.id}#documents" class="documents-link text-decoration-none">
                                        View All (${documentsCount - 3} more)
                                    </a>
                                </div>`;
                            }
                        } else {
                            documentsHTML = '<div class="text-center text-muted small">No documents available</div>';
                        }

                        productsHTML += `
                            <div class="col p-0">
                                <a href="/product/${product.id}" style="text-decoration:none;color:inherit;">
                                    <div class="card h-100 position-relative product-card-fixed">
                                        <div class="form-check position-absolute" style="top: 10px; left: 10px; z-index: 1;">
                                            <input type="checkbox" class="form-check-input" id="product-select-${product.id}">
                                        </div>
                                        
                                        <div class="product-card-img-wrapper">
                                            ${imageHTML}
                                        </div>
                                        <div class="card-body d-flex flex-column p-3">
                                            <div class="position-relative">
                                                <p class="model-number text-muted mb-1">${product.serial_number || ''}</p>
                                                <h5 class="product-title mb-2 text-truncate fw-semibold" title="${product.name || ''}">${product.name || ''}</h5>
                                                <div class="documents-panel" id="documents-panel-${product.id}" style="margin-bottom: -110px;">
                                                    <div class="p-2">
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <small class="fw-bold">Documents</small>
                                                            <button type="button" class="btn-close btn-sm close-documents" aria-label="Close"></button>
                                                        </div>
                                                        <div class="documents-list">
                                                            ${documentsHTML}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-auto text-center pt-2">
                                                <a href="${baseUrl}/product/${product.id}" class="btn btn-outline-dark rounded-1 w-90 mb-2 fw-semibold">View Details</a>
                                                <div class="position-relative">
                                                    <span class="documents-link d-block toggle-documents" data-product-id="${product.id}" style="border: 1px solid #e0e0e0; border-radius: 0 0 4px 4px; padding: 6px; margin: 0 -5px; background: white; cursor:pointer;">
                                                        <i class="fas fa-file-alt me-1"></i> Documents <i class="fas fa-arrow-up"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>`;
                    });
                    productsHTML += '</div>';
                } else {
                    productsHTML = '<p class="text-center text-muted p-5">No products found for the selected filters.</p>';
                }
                
                // Update the container and reinitialize document toggle functionality
                productsContainer.innerHTML = productsHTML;
                
                // Reinitialize document panel functionality for new elements
                initializeDocumentPanels();
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

    // Image error handler to try alternate casing
    window.handleImageError = function(img) {
        const tried = parseInt(img.dataset.tried || '0');
        if (tried < 1) {
            let newSrc = img.src;
            if (newSrc.match(/\/Uploads\//i)) {
                newSrc = newSrc.replace(/\/Uploads\//i, '/uploads/');
            } else if (newSrc.match(/\/uploads\//i)) {
                newSrc = newSrc.replace(/\/uploads\//i, '/Uploads/');
            }
            img.dataset.tried = '1';
            img.src = newSrc;  // Triggers reload; if fails again, onerror will fire a second time
        } else {
            img.parentElement.innerHTML = '<div class="no-image text-muted small">Image failed to load</div>';
        }
    };

    // Add this function to reinitialize document panels after filtering
    function initializeDocumentPanels() {
        // Remove existing event listeners to avoid duplicates
        document.querySelectorAll('.toggle-documents').forEach(function(link) {
            // Clone node to remove all event listeners
            const newLink = link.cloneNode(true);
            link.parentNode.replaceChild(newLink, link);
        });

        // Add new event listeners
        document.querySelectorAll('.toggle-documents').forEach(function(link) {
            let isAnimating = false;

            link.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation(); // Prevent parent link navigation
                
                if (isAnimating) return;

                const productId = this.getAttribute('data-product-id');
                const panel = document.getElementById('documents-panel-' + productId);
                const arrow = this.querySelector('.fa-arrow-up');
                
                if (!panel || !arrow) {
                    console.warn(`Panel or arrow not found for product ${productId}`);
                    return;
                }
                
                const allPanels = document.querySelectorAll('.documents-panel');
                const allArrows = document.querySelectorAll('.fa-arrow-up');

                isAnimating = true;

                // Close all other panels first
                allPanels.forEach(p => {
                    if (p !== panel && p.classList.contains('show')) {
                        p.classList.remove('show');
                        setTimeout(() => {
                            p.style.display = 'none';
                        }, 300);
                    }
                });

                // Reset all other arrows
                allArrows.forEach(a => {
                    if (a !== arrow) {
                        a.classList.remove('rotated');
                    }
                });

                if (panel.style.display === 'none' || panel.style.display === '') {
                    // Show panel
                    panel.style.display = 'block';
                    requestAnimationFrame(() => {
                        panel.classList.add('show');
                        arrow.classList.add('rotated');
                    });
                } else {
                    // Hide panel
                    panel.classList.remove('show');
                    arrow.classList.remove('rotated');
                    setTimeout(() => {
                        panel.style.display = 'none';
                    }, 300);
                }

                setTimeout(() => {
                    isAnimating = false;
                }, 300);
            });
        });

        // Close button handler
        document.querySelectorAll('.close-documents').forEach(button => {
            button.addEventListener('click', function(e) {
                e.stopPropagation(); // Prevent parent link navigation
                
                const panel = this.closest('.documents-panel');
                if (!panel) return;
                
                const productId = panel.id.replace('documents-panel-', '');
                const arrow = document.querySelector(`[data-product-id="${productId}"] .fa-arrow-up`);

                panel.classList.remove('show');
                if (arrow) arrow.classList.remove('rotated');

                setTimeout(() => {
                    panel.style.display = 'none';
                }, 300);
            });
        });
    }
    

    // Event listeners for all filter checkboxes
    if (allFilterCheckboxes && allFilterCheckboxes.length > 0) {
        allFilterCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', filterProducts);
        });

        // Initial load of filtered products if any are checked
        if (document.querySelectorAll('.filter-checkbox:checked').length > 0) {
            filterProducts();
        }
    }

    // Initialize document panels on page load
    initializeDocumentPanels();
});
    </script>

    @endsection