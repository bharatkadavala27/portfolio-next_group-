@extends('layouts.app')

@section('content')

    {{-- <h1>bharat</h1> --}}
    <style>
        .help-me-choose-box {
            background-color: #f5faff;
            border: 1px solid #d1e7ff;
            border-radius: 2px;
            padding: 35px 35px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        /* Base styles (existing desktop styles remain unchanged) */
        main {
            background-color: rgb(250, 250, 250) !important;
            min-height: auto;
            width: 100%;
        }

        a {
            color: var(--bs-link-color);
            text-decoration: none;
        }

        /* 
                    a:hover {
                        border-bottom: none;
                    } */
        /* Global: remove border-bottom for all links */
        a:hover {
            border-bottom: none;
        }

        /* Exception: keep border-bottom in product-card-bottom section */
        .product-card-bottom a:hover {
            border-bottom: 1px solid currentColor;
            /* or the color you were using */
        }


        .btn:hover {
            background-color: white !important;
            color: rgb(28, 26, 26) !important;
        }


        .download-btn>.btn:hover {
            background-color: rgb(0, 0, 0) !important;
            color: rgb(255, 255, 255) !important;
        }

        .btn a:hover {
            border-bottom: 1px solid black !important;
        }

        #product-display-area .card:hover {
            box-shadow: 0px 0px 10px 3px rgb(0 0 0 / 31%);
            z-index: 2;
        }

        .layout-category-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0px 10px;
        }

        .category-heading {
            margin-bottom: 30px;
        }

        .product-path {
            margin-top: 0 !important;
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
            width: 100% !important;
            max-width: 100% !important;
            display: block;
            font-weight: 500;
        }


        }

        .help-me-choose-box {
            background-color: #f5faff;
            border: 1px solid #d1e7ff;
            border-radius: 2px;
            padding: 35px 35px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .help-me-choose-btn {
            background-color: #2561a8;
            color: white;
            padding: 8px 20px;
            border-radius: 1px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }

        .help-me-choose-btn:hover {
            background-color: #1a4a8f;
            color: white;
        }

        .card {
            transition: all 0.3s ease-in-out;
            opacity: 1;
            transform: translateY(0);
            border: none !important;
            border-radius: 0 !important;
        }



        .card-header {
            border: none !important;
            border-radius: 0 !important;
            background: transparent !important;
        }

        .clickable-card {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            cursor: pointer;
        }

        .clickable-card:hover {
            box-shadow: 0px 0px 10px 3px rgb(0 0 0 / 31%);
            z-index: 2;
            border-radius: .25rem !important;
        }

        .clickable-card .form-check-input,
        .clickable-card .btn,
        .clickable-card .documents-link {
            position: relative;
            z-index: 2;
        }

        .clickable-card {
            user-select: none;
        }

        .w-90 {
            width: 90% !important;
            margin: 0 auto;
            display: block;
        }

        .product-card-fixed {
            height: 100%;
            min-height: 390px;
            display: flex;
            flex-direction: column;
            border: 1px solid #e0e0e0 !important;
        }

        .product-card-img-wrapper {
            height: 200px;
            padding: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #fff;
        }

        .product-card-img-wrapper img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .product-card-img-wrapper .no-image {
            display: flex;
            align-items: center;
            justify-content: center;
            color: #aaa;
            font-size: 14px;
            background: #f8f8f8;
            width: 100%;
            height: 100%;
        }

        .product-title {
            font-size: 16px;
            line-height: 1.4;
            margin-bottom: 8px;
            color: #333;
        }

        .model-number {
            font-size: 14px;
            color: #666;
        }

        .documents-link {
            color: #2561a8;
            text-decoration: none;
            font-size: 0.9rem;
            position: relative;
            display: block;
            border: 1px solid #e0e0e0;
            border-radius: 0 0 4px 4px;
            padding: 6px;
            margin: 0 -5px;
            background: white;
            z-index: 1;
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

        .documents-panel.show {
            opacity: 1;
            pointer-events: auto;
            transform: scaleY(1);
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

        .theme-color {
            background-color: #2561a8;
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

        .static-containers .static-card {
            display: flex;
            flex-direction: column;
            height: 100%;
            overflow: hidden;
            border: 1px solid #E7E6E6FF !important;
        }

        .static-containers .card-body {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 16px;
        }

        .c-static-card {
            transition: all 0.3s ease-in-out;
        }

        .c-static-card:hover {
            box-shadow: 0px 0px 5px rgba(96, 96, 96, 0.711);
            padding: 0;
        }

        /* .product-card-bottom a :hover{
                        border-bottom: 1px solid black;
                    } */

        /* MOBILE RESPONSIVE STYLES */

        /* Mobile: Extra Small devices (phones, 576px and down) */
        @media (max-width: 575.98px) {
            .layout-category-container {
                padding: 0 15px;
            }

            /* Category heading adjustments */
            .category-heading h1 {
                font-size: 28px !important;
                margin-top: 40px !important;
                line-height: 1.2;
            }

            .category-description {
                font-size: 14px;
            }

            /* Breadcrumb improvements */
            .product-path {
                font-size: 12px !important;
                line-height: 1.4;
            }

            .fa-chevron-right {
                margin: 0 8px;
            }

            /* Help me choose box */
            .help-me-choose-box {
                padding: 20px 15px;
                margin-bottom: 20px;
            }

            .help-me-choose-box .d-flex {
                flex-direction: column;
                text-align: center;
            }

            .help-me-choose-box .help-icon {
                margin-bottom: 15px;
                margin-right: 0 !important;
            }

            .help-me-choose-box h5 {
                font-size: 14px !important;
                margin-bottom: 8px;
            }

            .help-me-choose-box p {
                font-size: 12px !important;
                margin-bottom: 15px;
            }

            .help-me-choose-btn {
                padding: 10px 20px;
                font-size: 13px;
                align-self: center;
                width: auto;
            }

            /* Filter sidebar becomes collapsible */
            .col-md-3 {
                margin-bottom: 20px;
            }

            .filter-card {
                margin-bottom: 15px;
            }

            .card-header {
                padding: 10px 15px;
            }

            .card-body {
                padding: 15px;
            }

            /* Product cards mobile layout */
            .product-card-fixed {
                min-height: 320px;
            }

            .product-card-img-wrapper {
                height: 150px;
                padding: 0.75rem;
            }

            .product-title {
                font-size: 14px;
                line-height: 1.3;
            }

            .model-number {
                font-size: 12px;
            }

            .w-90 {
                width: 100% !important;
                font-size: 13px;
                padding: 8px 12px;
            }

            .documents-link {
                font-size: 12px;
                padding: 4px;
            }

            /* Documents panel mobile adjustments */
            .documents-panel {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%) scaleY(0);
                width: 90vw;
                max-width: 300px;
                max-height: 70vh;
                overflow-y: auto;
                border-radius: 8px;
                z-index: 1000;
            }

            .documents-panel.show {
                transform: translate(-50%, -50%) scaleY(1);
            }

            .documents-panel::before {
                content: '';
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: -1;
            }

            /* Static containers mobile */
            .static-containers .col {
                margin-bottom: 20px;
            }

            .static-containers .card-title {
                font-size: 16px;
            }

            .static-containers .card-text {
                font-size: 13px;
                -webkit-line-clamp: 4;
            }

            /* Need help section mobile */
            .need-help-section {
                padding: 20px 15px;
                margin-top: 15px;
            }

            .need-help-section h2 {
                font-size: 22px !important;
                margin-bottom: 20px;
            }

            .need-help-card {
                height: 120px !important;
                margin-bottom: 15px;
            }

            .need-help-card .card-title {
                font-size: 14px !important;
            }

            .need-help-card .card-text {
                font-size: 12px !important;
            }

            .contentfull {
                padding: 12px !important;
            }

            /* Tab content mobile */
            .tab-content {
                padding: 15px !important;
            }

            /* Row gaps mobile */
            .g-4 {
                --bs-gutter-x: 1rem;
                --bs-gutter-y: 1rem;
            }
        }


        /* Mobile: Small devices (landscape phones, 576px and up) */
        @media (min-width: 576px) and (max-width: 767.98px) {
            .layout-category-container {
                padding: 0 20px;
            }

            .category-heading h1 {
                font-size: 32px !important;
                margin-top: 50px !important;
            }

            .help-me-choose-box {
                padding: 25px 20px;
            }

            .help-me-choose-box .d-flex {
                flex-direction: row;
                align-items: center;
            }

            .help-me-choose-btn {
                margin-left: auto;
                flex-shrink: 0;
            }

            .product-card-fixed {
                min-height: 350px;
            }

            .product-card-img-wrapper {
                height: 180px;
            }

            /* Two columns for products on small screens */
            .row-cols-sm-2>* {
                flex: 0 0 50%;
                max-width: 50%;
            }
        }

        /* Tablet: Medium devices (tablets, 768px and up) */
        @media (min-width: 768px) and (max-width: 991.98px) {
            .layout-category-container {
                padding: 0 25px;
            }

            .category-heading h1 {
                font-size: 36px !important;
                margin-top: 60px !important;
            }

            .help-me-choose-box {
                padding: 30px 25px;
            }

            .product-card-fixed {
                min-height: 370px;
            }

            .static-containers .col {
                max-width: 350px;
            }
        }

        /* Utilities for mobile */
        @media (max-width: 767.98px) {
            .mobile-hide {
                display: none !important;
            }

            .mobile-full-width {
                width: 100% !important;
                max-width: 100% !important;
            }

            .mobile-text-center {
                text-align: center !important;
            }

            .mobile-mb-3 {
                margin-bottom: 1rem !important;
            }

            .mobile-p-2 {
                padding: 0.5rem !important;
            }
        }

        /* Touch improvements for mobile */
        @media (hover: none) and (pointer: coarse) {
            .clickable-card:hover {
                box-shadow: 0px 0px 10px 3px rgb(0 0 0 / 31%);
            }



            .c-static-card:hover {
                box-shadow: 0px 0px 5px rgba(96, 96, 96, 0.711);
            }

            /* Increase touch targets */
            .form-check-input {
                width: 1.25em;
                height: 1.25em;
            }

            .btn {
                padding: 0.75rem 1rem;
                font-size: 1rem;
            }

            .documents-link {
                padding: 8px 6px;
                font-size: 0.95rem;
            }
        }

        /* Landscape mobile adjustments */
        @media (max-width: 767.98px) and (orientation: landscape) {
            .category-heading h1 {
                font-size: 24px !important;
                margin-top: 20px !important;
            }

            .help-me-choose-box {
                padding: 15px;
            }

            .product-card-fixed {
                min-height: 280px;
            }

            .product-card-img-wrapper {
                height: 120px;
            }
        }

        /* High DPI mobile screens */
        @media (max-width: 767.98px) and (-webkit-min-device-pixel-ratio: 2) {
            .product-card-img-wrapper img {
                image-rendering: -webkit-optimize-contrast;
            }
        }
    </style>



    <div class="layout-category-container px-6">
        @if ($category)
                <div class="category-heading">
                    <p class="product-path text-dark mt-3" style="font-size: 14px;">
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
                    <div class="col-md-9 mt-5 w-100">
                        <h1 class="mb-3 theme-text" style="font-size: 42px; font-weight: normal; margin-top: 80px; cursor:default;">
                            {{
                    $category->name }}</h1>
                        <p class="category-description " style="padding-bottom:10px;">{!! $category->description !!}</p>
                    </div>
                </div>

                @php
                    // booleans used later to decide whether to render sections
                    $hasChildCategories = isset($childCategories) && $childCategories->count() > 0;
                    $hasRelatedBrands = isset($relatedBrands) && $relatedBrands->count() > 0;
                    $hasAuthorisedBrands = isset($brand) && $brand->count() > 0;
                    $hasCategoryProducts = isset($category->products) && $category->products->count() > 0;

                    // show categories section only when there are subcategories OR direct category products
                    $showCategoriesSection = $hasChildCategories || $hasCategoryProducts;

                    // show brands filter only when related brands exist and there are products to filter
                    $showBrandsFilter = $hasRelatedBrands && ($hasCategoryProducts || $hasChildCategories);
                @endphp



                <p>Filter by:</p>


                @php
                    // Local flags for this section
                    $hasChildCategories = isset($childCategories) && $childCategories->count() > 0;
                    $hasCategoryProducts = isset($category->products) && $category->products->count() > 0;

                    // Determine if to show brands filter
                    $hasRelatedBrands = isset($relatedBrands) && $relatedBrands->count() > 0;

                    // Show brands filter if related brands exist (this implies products exist somewhere in the hierarchy)
                    $showBrandsFilter = $hasRelatedBrands;

                    // Decide whether left column should be rendered at all
                    $leftColExists = $hasChildCategories || $showBrandsFilter;
                @endphp

                <div class="row">
                    {{-- Left Side Filter (render only if there are subcategories or brands to show) --}}
                    @if($leftColExists)
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
                                        {{-- Categories Card --}}
                                        <div class="card mb-4" style="border:1px solid #E7E6E6FF !important;">
                                            <div style="padding-top:10px; padding-left: 10px;">
                                                <h5 class="card-header m-0 p-0 fs-6" style="font-weight: 500; color: black !important;">
                                                    Categories
                                                </h5>
                                                <div class="hr">
                                                    <hr>
                                                </div>
                                            </div>

                                            <div class="card-body">
                                                <form id="filter-form" class="filter-form">
                                                    <div class="subcategories ">
                                                        @foreach ($items as $subcategory)
                                                            <div class="mb-2">
                                                                <input type="checkbox" class="form-check-input me-2 filter-checkbox" name="categories[]"
                                                                    id="cat-{{ $subcategory->id }}" value="{{ $subcategory->id }}" {{ in_array($subcategory->id, (array) request()->input('categories', [])) ? 'checked' : '' }}>
                                                                <label for="cat-{{ $subcategory->id }}" class="form-check-label d-inline">
                                                                    {{ $subcategory->name }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                    @elseif($type === 'brand_system' && $isVisible)
                                        {{-- Brands Filter --}}
                                        <div class="card mb-4" style="border:1px solid #E7E6E6FF !important;">
                                            <div class="card-header categories-filter-header">
                                                <h5 class="card-header fs-6" style="font-weight: 500; color: black !important; ">
                                                    Brands</h5>
                                                <hr style="margin-top: 0.5rem; margin-bottom: 0.5rem;">
                                            </div>
                                            <div class="card-body">
                                                <div class="brands ms-1">
                                                    @foreach ($items as $rbrand)
                                                        @if ($rbrand)
                                                            <div class="mb-2">
                                                                <input type="checkbox" class="form-check-input me-2 filter-checkbox" name="brands[]"
                                                                    id="brand-{{ $rbrand->id }}" value="{{ $rbrand->id }}" {{ in_array($rbrand->id, (array) request()->input('brands', [])) ? 'checked' : '' }}>
                                                                <label for="brand-{{ $rbrand->id }}" class="form-check-label">
                                                                    {{ $rbrand->name }}
                                                                </label>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                    @elseif($type === 'dynamic' && $isVisible)
                                        {{-- Dynamic Product Filter --}}
                                        <div class="card mb-4" style="border:1px solid #E7E6E6FF !important;">
                                            <div class="card-header categories-filter-header">
                                                <h5 class="card-header fs-6" style="font-weight: 500; color: black !important;">
                                                    {{ $filter->name }}
                                                </h5>
                                                <hr style="margin-top: 0.5rem; margin-bottom: 0.5rem;">
                                            </div>
                                            <div class="card-body">
                                                <div class="filter-options ms-1">
                                                    @foreach ($items as $option)
                                                        <div class="mb-2">
                                                            <input type="checkbox" class="form-check-input me-2 filter-checkbox"
                                                                name="filters[{{ $filter->id }}][]"
                                                                id="filter-{{ $filter->id }}-option-{{ $option->id }}" value="{{ $option->id }}" {{ in_array($option->id, (array) request()->input('filters.' . $filter->id, [])) ? 'checked' : '' }}>
                                                            <label for="filter-{{ $filter->id }}-option-{{ $option->id }}" class="form-check-label">
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
                    @endif
                    {{-- end left column --}}

                    {{-- Main column: use full width if left column not rendered --}}
                    <div class="{{ $leftColExists ? 'col-md-9' : 'col-md-12' }}">
                        <!-- Help Me Choose Box -->
                        <div class="help-me-choose-box mt-4 mb-2">
                            <div class="d-flex align-items-center">
                                <div class="help-icon me-3">
                                    <i class="fas fa-lightbulb" style="font-size: 24px; color: #2561a8;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-1" style="font-size: 16px; font-weight: 500; color:rgb(97, 99, 105)">
                                        Need help choosing {{ $category->name }}?
                                    </h5>
                                    <p class="mb-0 text-muted" style="font-size: 14px;">
                                        Use this simple selector to find the best fit for your needs.
                                    </p>
                                </div>
                                <a href="{{ url('/contact-us') }}" class="btn help-me-choose-btn ms-3">Help Me Choose</a>
                            </div>
                        </div>

                        {{-- Tabs (show only if we have products to display) --}}
                        @php
                            $hasDirectProducts = isset($category->products) && $category->products->count() > 0;
                            $hasSubcategoriesWithProducts = false;

                            if ($hasChildCategories) {
                                foreach ($childCategories as $subcategory) {
                                    if (isset($subcategory->products) && $subcategory->products->count() > 0) {
                                        $hasSubcategoriesWithProducts = true;
                                        break;
                                    }
                                }
                            }

                            $showTabs = $hasDirectProducts || $hasSubcategoriesWithProducts;
                        @endphp

                        @if($showTabs)
                            <ul class="nav nav-tabs mt-4" id="categoryTabs">
                                <li class="nav-item">
                                    <button class="nav-link active" id="products-tab" data-bs-toggle="tab"
                                        data-bs-target="#products-pane" type="button">Products</button>
                                </li>
                            </ul>
                        @endif

                        <div class="tab-content bg-white pb-4 pt-4" style="border:1px solid rgb(227, 225, 225);padding:0px 30px">
                            <div>
                                {{-- If there are child categories render them --}}
                                @if ($hasChildCategories)
                                    @foreach ($childCategories as $mainsubcategory)
                                        @php
                                            $childOfSubcategories = $mainsubcategory->children ?? collect();
                                            $hasGrandchildren = $childOfSubcategories->count() > 0;
                                            $hasProducts = isset($mainsubcategory->products) && $mainsubcategory->products->count() > 0;
                                            $filterApplied = (count(request()->input('categories', [])) > 0) || (count(request()->input('brands', [])) > 0);
                                            $showSubcategory = !$filterApplied || in_array($mainsubcategory->id, (array) request()->input('categories', []));
                                        @endphp

                                        @if($showSubcategory && ($hasGrandchildren || $hasProducts))
                                            <div class="subcategory-section mb-5" data-category-id="{{ $mainsubcategory->id }}"
                                                data-brand-ids="{{ json_encode($mainsubcategory->related_brand_ids ?? []) }}"
                                                data-filter-option-ids="{{ json_encode($mainsubcategory->related_filter_option_ids ?? []) }}">

                                                <h5 class="card-title theme-text fs-2 fw-normal bg-white text-truncate mt-4 mb-4">
                                                    {{ $mainsubcategory->name }}
                                                </h5>

                                                {{-- Grandchildren subcategories --}}
                                                @if($hasGrandchildren)
                                                    <main class="category-list mt-4 bg-white">
                                                        <div class="subcategory-wrapper">
                                                            <div class="row row-cols-1 row-cols-md-3 g-4"
                                                                id="subcategory-list-{{ $mainsubcategory->id }}">
                                                                @foreach ($childOfSubcategories as $grandchild)
                                                                    <div class="col grandchild-category"
                                                                        data-brand-ids="{{ json_encode($grandchild->related_brand_ids ?? []) }}"
                                                                        data-filter-option-ids="{{ json_encode($grandchild->related_filter_option_ids ?? []) }}">
                                                                        <a href="{{ route('child.category.show', $grandchild->id) }}">
                                                                            <div class="card h-100 d-flex flex-column">
                                                                                @if ($grandchild->image && file_exists(public_path('uploads/category/' . $grandchild->image)))
                                                                                    <img src="{{ asset('uploads/category/' . $grandchild->image) }}"
                                                                                        alt="{{ $grandchild->name }}" class="card-img-top"
                                                                                        style="object-fit: contain; height: 100px; object-position: left; margin:20px 20px 0px 20px;">
                                                                                @else
                                                                                    <div class="d-flex justify-content-center align-items-center"
                                                                                        style="height:100px; margin:20px; background:#f8f9fa; color:#888; border:1px dashed #ccc;">
                                                                                        No Image
                                                                                    </div>
                                                                                @endif

                                                                                <div class="card-body d-flex flex-column">
                                                                                    <h5 class="card-title text-dark text-truncate fw-normal">
                                                                                        {{ $grandchild->name }}
                                                                                    </h5>
                                                                                    <p class="card-text text-muted description-text">
                                                                                        {!! $grandchild->description !!}
                                                                                    </p>
                                                                                    <div class="mt-auto">
                                                                                        <a href="{{ route('child.category.show', $grandchild->id) }}"
                                                                                            class="theme-text" style="text-decoration:none">View
                                                                                            Details</a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </main>
                                                @endif

                                                {{-- If has products but no grandchildren, show products --}}
                                                @if($hasProducts && !$hasGrandchildren)
                                                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4"
                                                        id="product-list-{{ $mainsubcategory->id }}">
                                                        @foreach ($mainsubcategory->products as $product)
                                                            <div class="col p-0">
                                                                <div class="card h-100 position-relative product-card-fixed clickable-card"
                                                                    data-brand-id="{{ $product->brand_id ?? ($product->brand->id ?? '') }}"
                                                                    data-filter-option-ids="{{ json_encode($product->filters->pluck('id')->toArray() ?? []) }}"
                                                                    onclick="window.location.href='{{ url('/product', $product->id) }}'"
                                                                    style="cursor: pointer;">
                                                                    <div class="form-check position-absolute"
                                                                        style="top: 10px; left: 10px; z-index: 1;">
                                                                        <input type="checkbox" class="form-check-input"
                                                                            id="product-select-{{ $product->id }}" onclick="event.stopPropagation();">
                                                                    </div>

                                                                    <div class="product-card-img-wrapper">
                                                                        @php
                                                                            $images = [];
                                                                            if ($product->images) {
                                                                                try {
                                                                                    $images = json_decode($product->images, true, 512, JSON_THROW_ON_ERROR);
                                                                                    if (!is_array($images))
                                                                                        $images = [];
                                                                                } catch (\Throwable $e) {
                                                                                    $images = [];
                                                                                }
                                                                            }

                                                                            $imagePath = '';
                                                                            if (!empty($images) && !empty($images[0]) && trim($images[0]) !== '' && $images[0] !== 'null') {
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
                                                                                onerror="this.parentElement.innerHTML='<div class=\'no-image text-muted small\'>No image</div>'">
                                                                        @else
                                                                            <div class="no-image text-muted small">No image</div>
                                                                        @endif
                                                                    </div>

                                                                    <div class="card-body d-flex flex-column p-3">
                                                                        <p class="model-number text-muted mb-1">{{ $product->serial_number }}</p>
                                                                        <h5 class="product-title mb-2 text-truncate fw-semibold"
                                                                            title="{{ $product->name }}">
                                                                            {{ $product->name }}
                                                                        </h5>

                                                                        <div class="mt-auto text-center pt-2 product-card-bottom">
                                                                            <a href="{{ url('/product', $product->id) }}"
                                                                                class="btn btn-outline-dark rounded-1 w-90 mb-2 fw-semibold"
                                                                                onclick="event.stopPropagation();">
                                                                                View Details
                                                                            </a>

                                                                            <div class="position-relative" onclick="event.stopPropagation();">
                                                                                <a href="#" class="documents-link toggle-documents">
                                                                                    <!-- <i class="fas fa-file-alt me-1"></i> -->
                                                                                     Documents
                                                                                    <i class="fas fa-arrow-up fa-xs ms-1"></i>
                                                                                </a>
                                                                                <div class="documents-panel">
                                                                                    <button class="close-documents"><i
                                                                                            class="fas fa-times"></i></button>
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
                                                                                                    class="documents-link text-decoration-none">View All
                                                                                                    ({{ count($docs) - 3 }} more)</a>
                                                                                            </div>
                                                                                        @endif
                                                                                    @else
                                                                                        <p class="mb-2">No documents available.</p>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif

                                            </div>
                                        @else
                                            {{-- If filter hides it initially server-side, we might not render it. But since we use JS
                                            filtering, we should probably render all and hide via JS if possible.
                                            However, user wants dynamic JS filtering. The existing $showSubcategory logic (line 854) was partly
                                            server-side.
                                            If we rely on JS, we should ideally render all blocks and let JS hide them.
                                            But keeping $showSubcategory for initial load is fine if it matches category filter.
                                            For brand filter, we rely on JS.
                                            --}}
                                        @endif
                                    @endforeach

                                    {{-- Show "No results" message if filters applied but nothing visible --}}
                                    @php
                                        $filterApplied = (count(request()->input('categories', [])) > 0) || (count(request()->input('brands', [])) > 0);
                                    @endphp

                                    {{-- We'll let JS handle the no-results visibility more dynamically --}}
                                    <div class="no-results-message text-center text-muted p-4" style="display: none">
                                        <p>No results found for your current filter selection.</p>
                                        <button id="clear-filters" class="btn btn-outline-secondary btn-sm">Clear Filters</button>
                                    </div>
                                @else
                                    <div class="no-results-message text-center text-muted p-4" style="display: none">
                                        <p>No results found for your current filter selection.</p>
                                        <button id="clear-filters-js" class="btn btn-outline-secondary btn-sm">Clear Filters</button>
                                    </div>
                                    {{-- No subcategories, show direct products if available --}}
                                    @if ($hasCategoryProducts)
                                        <div id="product-display-area">
                                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                                                @foreach ($category->products as $product)
                                                    <div class="col p-0">
                                                        <div class="card h-100 position-relative product-card-fixed clickable-card"
                                                            data-brand-id="{{ $product->brand_id ?? ($product->brand->id ?? '') }}"
                                                            data-filter-option-ids="{{ json_encode($product->filters->pluck('id')->toArray() ?? []) }}"
                                                            onclick="window.location.href='{{ url('/product', $product->id) }}'"
                                                            style="cursor: pointer;">
                                                            <div class="form-check position-absolute"
                                                                style="top: 10px; left: 10px; z-index: 1;">
                                                                <input type="checkbox" class="form-check-input"
                                                                    id="product-select-{{ $product->id }}" onclick="event.stopPropagation();">
                                                            </div>

                                                            <div class="product-card-img-wrapper">
                                                                @php
                                                                    $images = [];
                                                                    if ($product->images) {
                                                                        try {
                                                                            $images = json_decode($product->images, true, 512, JSON_THROW_ON_ERROR);
                                                                            if (!is_array($images))
                                                                                $images = [];
                                                                        } catch (\Throwable $e) {
                                                                            $images = [];
                                                                        }
                                                                    }
                                                                @endphp

                                                                @if (!empty($images) && !empty($images[0]))
                                                                    <img src="{{ asset($images[0]) }}" alt="{{ $product->name }}"
                                                                        class="product-img bg-white"
                                                                        onerror="this.parentElement.innerHTML='<div class=\'no-image text-muted small\'>No image</div>'">
                                                                @else
                                                                    <div class="no-image text-muted small">No image</div>
                                                                @endif
                                                            </div>

                                                            <div class="card-body d-flex flex-column p-3">
                                                                <p class="model-number text-muted mb-1">{{ $product->serial_number }}</p>
                                                                <h5 class="product-title mb-2 text-truncate fw-semibold"
                                                                    title="{{ $product->name }}">
                                                                    {{ $product->name }}
                                                                </h5>

                                                                <div class="mt-auto text-center pt-2 product-card-bottom">
                                                                    <a href="{{ url('/product', $product->id) }}"
                                                                        class="btn btn-outline-dark rounded-1 w-90 mb-2 fw-semibold"
                                                                        onclick="event.stopPropagation();">View Details</a>
                                                                    <a href="#" class="documents-link d-block"
                                                                        onclick="event.stopPropagation();"><i class="fas fa-file-alt me-1"></i>
                                                                        Documents</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <div class="text-center text-muted p-4">
                                            <p>No products or subcategories found in this category.</p>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>

                    @include('frontend.partials.recently-viewed')

                    {{-- Static Containers and Need Help sections --}}
                    <div class="static-containers mt-5">
                        <div class="row row-cols-1 row-cols-md-3 mb-5" style="justify-content: flex-start;">
                            @foreach($latestNews as $news)
                                <div class="col">
                                    <div class="card border-0 static-card c-static-card">
                                        <a href="{{ route('newsview', $news->id) }}" style="text-decoration: none; color: inherit;">
                                            <img src="{{ asset($news->image) }}" alt="{{ $news->header }}" class="card-img-top"
                                                style="height: 150px; object-fit: cover; border-radius: 0;">
                                            <div class="card-body p-3">
                                                <h5 class="card-title text-dark mb-2" style="font-size: 18px; font-weight: bold;">
                                                    {{Str::limit($news->header, 50)}}
                                                </h5>
                                                <p class="card-text text-muted mb-3" style="font-size: 14px; line-height: 1.4;">
                                                    {{ Str::limit(strip_tags($news->description), 150) }}
                                                </p>
                                                <span class="theme-text" style="font-size: 14px;">Discover now ></span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Need Help Section --}}
                    <div class="need-help-section mt-2 mb-5 p-3" style="border: 1px solid #c2baba54;">
                        <h2 class="mb-4" style="font-size: 26px; font-weight: bold;">Need help?</h2>
                        <div class="row row-cols-1 row-cols-md-4 g-4">
                            <div class="col">
                                <a href="{{ url('/contact-us') }}" style="text-decoration: none; color: inherit;">
                                    <div class="card need-help-card"
                                        style="width: 100%; height: 100px; border:1px solid #c2baba54;">
                                        <div class="contentfull"
                                            style="height:100%; display: flex; flex-direction: column; justify-content: space-between; padding: 10px; border: 1px solid #c2baba54;">
                                            <div class="topside"
                                                style="display: flex; justify-content: space-between; align-items: center;">
                                                <h5 class="card-title"
                                                    style="font-size: 16px; font-weight: bold; margin-bottom: 0;">Product Selector
                                                </h5>
                                                <i class="fas fa-headset" style="font-size: 20px; color: #2561a8;"></i>
                                            </div>
                                            <p class="card-text text-muted" style="font-size: 13px; line-height: 1.3; margin: 0;">
                                                Quickly and easily find the right products and accessories for your application.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col">
                                <a href="{{ url('/contact-us') }}" style="text-decoration: none; color: inherit;">
                                    <div class="card need-help-card"
                                        style="width: 100%; height: 100px; border:1px solid #c2baba54;">
                                        <div class="contentfull"
                                            style="height:100%; display: flex; flex-direction: column; justify-content: space-between; padding: 10px; border: 1px solid #c2baba54;">
                                            <div class="topside"
                                                style="display: flex; justify-content: space-between; align-items: center;">
                                                <h5 class="card-title"
                                                    style="font-size: 16px; font-weight: bold; margin-bottom: 0;">Get a Quote</h5>
                                                <i class="fas fa-lightbulb" style="font-size: 20px; color: #2561a8;"></i>
                                            </div>
                                            <p class="card-text text-muted" style="font-size: 13px; line-height: 1.3; margin: 0;">
                                                Start your sales enquiry online and an expert will connect with you.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col">
                                <a href="{{ url('/contact-us') }}" style="text-decoration: none; color: inherit;">
                                    <div class="card need-help-card"
                                        style="width: 100%; height: 100px; border:1px solid #c2baba54;">
                                        <div class="contentfull"
                                            style="height:100%; display: flex; flex-direction: column; justify-content: space-between; padding: 10px; border: 1px solid #c2baba54;">
                                            <div class="topside"
                                                style="display: flex; justify-content: space-between; align-items: center;">
                                                <h5 class="card-title"
                                                    style="font-size: 16px; font-weight: bold; margin-bottom: 0;">Where to Buy?</h5>
                                                <i class="fas fa-map-marker-alt" style="font-size: 20px; color: #2561a8;"></i>
                                            </div>
                                            <p class="card-text text-muted" style="font-size: 13px; line-height: 1.3; margin: 0;">
                                                Easily find the nearest Schneider Electric distributor in your location.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col">
                                <a href="{{ url('/contact-us') }}" style="text-decoration: none; color: inherit;">
                                    <div class="card need-help-card"
                                        style="width: 100%; height: 100px; border:1px solid #c2baba54;">
                                        <div class="contentfull"
                                            style="height:100%; display: flex; flex-direction: column; justify-content: space-between; padding: 10px; border: 1px solid #c2baba54;">
                                            <div class="topside"
                                                style="display: flex; justify-content: space-between; align-items: center;">
                                                <h5 class="card-title"
                                                    style="font-size: 16px; font-weight: bold; margin-bottom: 0;">Help Centre</h5>
                                                <i class="fas fa-question-circle" style="font-size: 20px; color: #2561a8;"></i>
                                            </div>
                                            <p class="card-text text-muted" style="font-size: 13px; line-height: 1.3; margin: 0;">
                                                Find support resources for all your needs, in one place.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkboxes = document.querySelectorAll('.filter-checkbox');
            const clearFiltersButton = document.getElementById('clear-filters');
            const clearFiltersJsButton = document.getElementById('clear-filters-js');

            function updateDisplay(e) {
                if (e) e.preventDefault();

                const selectedCategories = Array.from(document.querySelectorAll('input[name="categories[]"]:checked'))
                    .map(cb => cb.value);
                const selectedBrands = Array.from(document.querySelectorAll('input[name="brands[]"]:checked'))
                    .map(cb => cb.value);

                // Collect selected product filter options grouped by filter ID
                // Structure: { "7": ["64", "65"], "8": ["70"] }
                // Within a group = OR logic, between groups = AND logic
                const selectedFilterGroups = {};
                document.querySelectorAll('input[name^="filters["]:checked').forEach(cb => {
                    const match = cb.name.match(/filters\[(\d+)\]/);
                    if (match) {
                        const groupId = match[1];
                        if (!selectedFilterGroups[groupId]) selectedFilterGroups[groupId] = [];
                        selectedFilterGroups[groupId].push(cb.value);
                    }
                });
                // Flat list still needed for passing to filterProducts/filterGrandchildren
                const selectedFilterOptions = Object.values(selectedFilterGroups).flat();

                // If the user has checked every available product-filter option, treat that as "no filter"
                // (i.e., checking every box should show all results rather than narrow to items that contain ALL options)
                const totalFilterCheckboxes = document.querySelectorAll('input[name^="filters["]').length;
                if (selectedFilterOptions.length > 0 && selectedFilterOptions.length === totalFilterCheckboxes) {
                    // clear selectedFilterOptions so the filter logic treats it as no product filters selected
                    selectedFilterOptions.length = 0;
                    // clear grouped filters too, otherwise group-based matching still applies
                    Object.keys(selectedFilterGroups).forEach(groupId => {
                        delete selectedFilterGroups[groupId];
                    });
                }

                // Track what's currently visible
                let hasVisibleContent = false;

                // Handle each subcategory section
                const subcategorySections = document.querySelectorAll('.subcategory-section');

                subcategorySections.forEach(section => {
                    const categoryId = section.getAttribute('data-category-id');
                    const sectionBrandIds = JSON.parse(section.getAttribute('data-brand-ids') || '[]');

                    // Check category filter
                    const categoryMatch = selectedCategories.length === 0 || selectedCategories.includes(categoryId);

                    // Check brand filter (deep check)
                    let brandMatch = true;
                    if (selectedBrands.length > 0) {
                        brandMatch = selectedBrands.some(id => sectionBrandIds.includes(parseInt(id)) || sectionBrandIds.includes(String(id)));
                    }

                    // Check product filter options: OR within group, AND between groups
                    const sectionFilterIds = JSON.parse(section.getAttribute('data-filter-option-ids') || '[]');
                    let filterMatch = true;
                    if (Object.keys(selectedFilterGroups).length > 0) {
                        // Every selected group must have at least one matching option in this section (AND between groups)
                        // Within each group, any match is enough (OR within group)
                        filterMatch = Object.values(selectedFilterGroups).every(groupOptionIds =>
                            groupOptionIds.some(optionId =>
                                sectionFilterIds.includes(parseInt(optionId)) ||
                                sectionFilterIds.includes(String(optionId))
                            )
                        );
                    }

                    if (categoryMatch && brandMatch && filterMatch) {
                        section.style.display = 'block';
                        hasVisibleContent = true;

                        // Filter direct products within this section if they exist
                        const productList = section.querySelector('[id^="product-list-"]');
                        if (productList) {
                            filterProducts(productList, selectedBrands, selectedFilterOptions, selectedFilterGroups);
                        }

                        // Filter grandchildren if they exist
                        const grandchildList = section.querySelector('[id^="subcategory-list-"]');
                        if (grandchildList) {
                            filterGrandchildren(grandchildList, selectedBrands, selectedFilterOptions, selectedFilterGroups);
                        }
                    } else {
                        section.style.display = 'none';
                    }
                });

                // Handle direct category products (no subcategories)
                const directProductArea = document.getElementById('product-display-area');
                if (directProductArea) {
                    if (selectedCategories.length === 0) {
                        // For direct products, we still check brand compatibility?
                        // The container doesn't have data-brand-ids, but the products do.
                        // So we show the container and filter products. 
                        // If all products hidden, should we hide container?
                        // Let's rely on filterProductsByBrand to handle product visibility.
                        directProductArea.style.display = 'block';
                        const hasVisibleProducts = filterProducts(directProductArea, selectedBrands, selectedFilterOptions, selectedFilterGroups);
                        if (hasVisibleProducts) {
                            hasVisibleContent = true;
                        } else {
                            // If filtering by brand hides all products, we effectively have no content
                            directProductArea.style.display = 'none';
                        }
                    } else {
                        directProductArea.style.display = 'none';
                    }
                }

                // Show/hide "No results" message
                toggleNoResultsMessage(hasVisibleContent);
            }

            function findPreviousHeading(element) {
                let sibling = element.previousElementSibling;
                while (sibling) {
                    if (sibling.classList.contains('card-title') ||
                        sibling.tagName === 'H5' ||
                        sibling.tagName === 'H4') {
                        return sibling;
                    }
                    sibling = sibling.previousElementSibling;
                }
                return null;
            }

            function filterProducts(container, selectedBrands, selectedFilterOptions, selectedFilterGroups = {}) {
                const productCards = container.querySelectorAll('.col');
                let visibleCount = 0;

                if (selectedBrands.length === 0 && selectedFilterOptions.length === 0) {
                    productCards.forEach(card => card.style.display = 'block');
                    return productCards.length > 0;
                }

                productCards.forEach(card => {
                    const cardElement = card.querySelector('.card');
                    const brandId = cardElement.getAttribute('data-brand-id');
                    const productFilterIds = JSON.parse(cardElement.getAttribute('data-filter-option-ids') || '[]');

                    // Check brand match
                    const brandMatch = selectedBrands.length === 0 ||
                        selectedBrands.includes(brandId) ||
                        selectedBrands.includes(String(brandId));

                    // Check filter options match: OR within group, AND between groups
                    const filterMatch = selectedFilterOptions.length === 0 ||
                        Object.values(selectedFilterGroups).every(groupOptionIds =>
                            groupOptionIds.some(optionId =>
                                productFilterIds.includes(parseInt(optionId)) ||
                                productFilterIds.includes(String(optionId))
                            )
                        );

                    if (brandMatch && filterMatch) {
                        card.style.display = 'block';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                return visibleCount > 0;
            }

            // Keep old function name for backward compatibility
            function filterProductsByBrand(container, selectedBrands) {
                return filterProducts(container, selectedBrands, []);
            }

            function filterGrandchildren(container, selectedBrands, selectedFilterOptions, selectedFilterGroups = {}) {
                const grandchildCols = container.querySelectorAll('.grandchild-category');

                if (selectedBrands.length === 0 && selectedFilterOptions.length === 0) {
                    grandchildCols.forEach(col => col.style.display = 'block');
                    return;
                }

                grandchildCols.forEach(col => {
                    const brandIds = JSON.parse(col.getAttribute('data-brand-ids') || '[]');
                    const filterIds = JSON.parse(col.getAttribute('data-filter-option-ids') || '[]');

                    // Check brand match (OR logic)
                    const brandMatch = selectedBrands.length === 0 ||
                        selectedBrands.some(id => brandIds.includes(parseInt(id)) || brandIds.includes(String(id)));

                    // Check filter match: OR within group, AND between groups
                    const filterMatch = selectedFilterOptions.length === 0 ||
                        Object.values(selectedFilterGroups).every(groupOptionIds =>
                            groupOptionIds.some(optionId =>
                                filterIds.includes(parseInt(optionId)) ||
                                filterIds.includes(String(optionId))
                            )
                        );

                    if (brandMatch && filterMatch) {
                        col.style.display = 'block';
                    } else {
                        col.style.display = 'none';
                    }
                });
            }

            function toggleNoResultsMessage(hasVisibleContent) {
                const noResultsMsgs = document.querySelectorAll('.no-results-message');
                noResultsMsgs.forEach(msg => {
                    msg.style.display = hasVisibleContent ? 'none' : 'block';
                });
            }

            function clearAllFilters(e) {
                if (e) e.preventDefault();
                checkboxes.forEach(checkbox => checkbox.checked = false);
                updateDisplay();
            }

            // Event listeners
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateDisplay);
            });

            if (clearFiltersButton) {
                clearFiltersButton.addEventListener('click', clearAllFilters);
            }
            if (clearFiltersJsButton) {
                clearFiltersJsButton.addEventListener('click', clearAllFilters);
            }

            // Initialize display
            updateDisplay();

            // Documents panel functionality (unchanged)
            document.querySelectorAll('.toggle-documents').forEach(function (link) {
                let isAnimating = false;

                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();

                    if (isAnimating) return;
                    isAnimating = true;

                    const panel = this.nextElementSibling;
                    const arrow = this.querySelector('.fa-arrow-up');

                    if (panel.classList.contains('show')) {
                        panel.classList.remove('show');
                        arrow.classList.remove('rotated');
                    } else {
                        // Close all other open panels first
                        document.querySelectorAll('.documents-panel.show').forEach(p => {
                            if (p !== panel) {
                                p.classList.remove('show');
                                p.previousElementSibling.querySelector('.fa-arrow-up').classList.remove('rotated');
                            }
                        });

                        panel.classList.add('show');
                        arrow.classList.add('rotated');
                    }

                    setTimeout(() => {
                        isAnimating = false;
                    }, 300);
                });
            });

            // Close panel when clicking outside
            document.addEventListener('click', function (e) {
                if (!e.target.closest('.documents-panel') && !e.target.closest('.toggle-documents')) {
                    document.querySelectorAll('.documents-panel.show').forEach(panel => {
                        panel.classList.remove('show');
                        panel.previousElementSibling.querySelector('.fa-arrow-up').classList.remove('rotated');
                    });
                }
            });

            // Close button handler
            document.querySelectorAll('.close-documents').forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    const panel = this.closest('.documents-panel');
                    const arrow = panel.previousElementSibling.querySelector('.fa-arrow-up');
                    panel.classList.remove('show');
                    arrow.classList.remove('rotated');
                });
            });
        });
    </script>

@endsection
