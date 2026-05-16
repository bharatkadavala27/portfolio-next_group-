@extends('layouts.app')

@section('title', $fileName ?? ($parentCategory->name ?? 'Documents'))

@section('content')
    <!-- Added Bootstrap Icons CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/material-design-icons/3.0.1/iconfont/material-icons.css"
        rel="stylesheet">

    <!-- Added CSRF token meta tag for AJAX -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            background: #f0f1f2 !important;
        }

        .filter-sidebar {
            background: #fff !important;
            border: 1px solid #e0e0e0 !important;
            border-radius: 8px;
            padding: 1.5rem 1rem;
            min-height: 400px;
            transition: all 0.3s ease;
        }

        .filter-title {
            color: #2561a8 !important;
            font-size: 16px;
            font-weight: bold !important;
            margin-bottom: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .document-card {
            background: #fff;
            border: 1px solid #e0e0e0 !important;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .document-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .document-header {
            margin-bottom: 1.2rem;
        }

        .document-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #2561a8;
            margin-bottom: 0.5rem;
        }

        .docOtherDetails {
            color: #666;
            font-size: 0.9rem;
        }

        .spacingLeftRight {
            margin: 0 0.5rem;
            color: #ccc;
        }

        .documentTypeLabel {
            color: #2561a8;
            font-weight: 500;
        }

        .doc-info {
            margin-top: 0.5rem;
            color: #444;
            font-size: 0.9rem;
        }

        .spacingLeft {
            margin-left: 0.3rem;
        }

        .document-details {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .doc-description {
            margin-top: 0.75rem;
            color: #666;
            font-size: 0.9rem;
        }

        .description {
            /* margin: 10px; */
        }

        .document-footer {
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid #eee;
        }

        .files-section {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .file-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.4rem 0.8rem;
            border: 1px solid #e0e0e0;
            border-radius: 1px;
            color: #2561a8;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .file-link:hover {
            background: #f8f9fa;
            border-color: #2561a8;
        }

        .download-section {
            margin-top: 1rem;
        }

        .download-doc-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: #2561a8;
            border-radius: 1px;
            color: white;
            border: none;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .download-doc-btn:hover {
            background: #1a4a8f;
        }

        .filter-checkbox {
            margin-right: 0.5rem;
        }

        .filter-checkbox:checked+span {
            color: #0d6efd;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .filter-label {
            font-weight: 500;
            font-size: 0.95rem;
            margin-bottom: 0.4rem;
            color: #495057;
        }

        .document-card span {
            font-weight: 500;
            font-size: 0.9rem;
            color: #6c757d;
        }

        .document-card .text-muted {
            font-size: 0.85rem;
        }

        .main-info {
            font-size: 1.1rem;
            color: #333;
        }

        .main-info .doc-type {
            font-weight: 500;
        }

        .sub-info {
            font-size: 0.9rem;
            color: #666;
        }

        .mx-2 {
            margin-left: 0.5rem;
            margin-right: 0.5rem;
        }

        .mb-2 {
            margin-bottom: 0.5rem;
        }

        .hello-text {
            color: #333;
            font-size: 1rem;
            margin-top: 1rem;
        }

        .download-btn {
            min-width: 120px;
        }

        .btn {
            font-weight: 500;
            letter-spacing: 0.3px;
        }

        .ui-dialog-titlebar-close {
            outline: none;
            background: none;
            border: 1px solid #c5c5c5;
            border-radius: 3px;
            width: 20px;
            height: 20px;
            position: absolute;
            right: .3em;
            top: 50%;
            margin: -10px 0 0 0;
            padding: 1px;
        }

        .ui-dialog-titlebar-close:before {
            content: "×";
            display: block;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            font-size: 16px;
            font-weight: bold;
            color: #666;
        }

        .ui-dialog-titlebar-close:hover {
            border-color: #999;
            background: #ededed;
        }

        .ui-dialog-titlebar-close:hover:before {
            color: #333;
        }

        .modal-spinner {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 120px;
        }

        .toast-message {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            background: #28a745;
            color: #fff;
            padding: 12px 24px;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            display: none;
            font-weight: 500;
            letter-spacing: 0.2px;
        }

        #searchDocument {
            border-radius: 1px;
        }

        #searchDocument::placeholder {
            font-weight: 400;
            font-style: italic;
            color: #adb5bd;
        }

        .fade-enter {
            opacity: 0;
            transform: translateY(10px);
        }

        .fade-enter-active {
            opacity: 1;
            transform: translateY(0);
            transition: none !important;
            /* transition: opacity 0.3s ease-in-out, transform 0.3s ease-out; */
        }

        @keyframes cardFadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            display: none;
            justify-content: center;
            align-items: center;
            border-radius: 8px;
            z-index: 100;
            backdrop-filter: blur(2px);
        }

        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .documents-container {
            position: relative;
            transition: opacity 0.2s ease-in-out;
            min-height: 200px;
        }

        .filter-sidebar.loading {
            opacity: 0.7;
            pointer-events: none;
        }

        .alert {
            font-weight: 500;
            letter-spacing: 0.2px;
        }

        .list-group-item {
            font-weight: 500;
            color: #343a40;
        }

        .ui-dialog-title {
            font-weight: 600 !important;
            letter-spacing: 0.3px;
        }

        .bread:hover {
            color: #2561a8 !important;
        }

        /* Updated/Added styles to match main.blade.php */
        .layout-category-container {
            max-width: 1280px;
            margin: 0 30px;
            padding: 0px 10px;
        }

        /* Updated breadcrumb styles */
        .product-path {
            margin-top: 0 !important;
            font-size: 14px;
            color: #6c757d;
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .breadcrumb-item {
            display: flex;
            align-items: center;
        }

        .breadcrumb-item a {
            color: #6c757d;
            text-decoration: none;
            transition: color 0.2s;
            font-size: 14px;
        }

        .breadcrumb-item.active {
            color: #6c757d;
            font-size: 14px;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            content: "\f054" !important;
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            font-size: 10px;
            color: #6c757d;
            padding: 0 8px;
            display: flex;
            align-items: center;
        }

        .breadcrumb-link {
            color: inherit;
            text-decoration: none;
        }

        .breadcrumb-link:hover {
            color: #1a1a1a !important;
        }

        /* Header Row Styles */
        .hover-opacity:hover {
            opacity: 0.8;
        }

        .gap-4 {
            gap: 1.5rem;
        }

        .fs-6 {
            font-size: 0.9rem !important;
        }

        .fw-medium {
            font-weight: 500 !important;
        }

        /* Filter badge styles */
        .filter-badge {
            font-size: 0.85rem;
            padding: 0.35rem 0.75rem;
            border-radius: 4px;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            color: #495057;
        }

        .filter-badge i {
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .filter-badge i:hover {
            opacity: 0.7;
        }

        .filter-badge .bi-x {
            padding: 2px;
            border-radius: 50%;
            background-color: rgba(0, 0, 0, 0.1);
            margin-left: 4px;
        }

        .filter-badge .bi-x:hover {
            background-color: rgba(0, 0, 0, 0.2);
        }

        /* Improve filter sections */
        .card-header {
            background-color: #f8f9fa;
            font-weight: 500;
            font-size: 0.95rem;
            color: #2561a8;
            border-bottom: 1px solid #e9ecef;
        }

        .filter-checkbox {
            width: 1.15rem;
            height: 1.15rem;
            margin-right: 0.75rem;
            cursor: pointer;
        }

        .filter-label {
            cursor: pointer;
            transition: color 0.2s;
        }

        .filter-label:hover {
            color: #2561a8;
        }

        /* Language filter specific styles */
        .document-language-checkbox:disabled+span {
            color: #6c757d;
            cursor: not-allowed;
        }

        #allLanguagesCheckbox+span {
            font-weight: 500;
            color: #2561a8;
        }

        .document-language-checkbox:checked+span {
            color: #2561a8;
            font-weight: 500;
        }

        .form-control {
            width: 50%;
        }

        .card-header {
            background: #ffffff;
            border-bottom: none;
        }

        .col-md-3 {
            padding: 0;
        }

        .search-bar-container {
            position: relative;
        }

        .search-suggestions-list {
            position: unset;
            width: 50%;
            top: 100%;
            left: 0;
            right: 0;
            background: #fff;
            border: 1px solid #e0e0e0;
            border-top: none;
            border-radius: 0 0 8px 8px;
            z-index: 1000;
            display: none;
            max-height: 300px;
            overflow-y: auto;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .suggestion-item {
            padding: 12px 18px;
            cursor: pointer;
            font-size: 0.95rem;
            color: #333;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: background-color 0.2s ease;
        }

        .suggestion-item:hover {
            background-color: #f8f9fa;
        }

        .suggestion-item .bi-file-earmark-text {
            color: #2561a8;
        }

        .category-class {
            font-size: 42px;
            font-weight: 400;
        }

        .reset-container {
            margin-left: 200px;
            display: flex;
            justify-content: center;
            align-self: center;
            font-size: 16px;
            position: relative;
            gap: 10px;
        }

        /* Mobile Filter Toggle Button */
        .mobile-filter-toggle {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            background: #2561a8;
            color: white;
            border: none;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            font-size: 24px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .mobile-filter-toggle:hover {
            background: #1a4a8f;
            transform: scale(1.05);
        }

        /* Mobile Filter Overlay */
        .mobile-filter-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 10000;

        }

        .mobile-filter-sidebar {
            position: fixed;
            top: 0;
            left: -100%;
            width: 320px;
            height: 100vh;
            background: white;
            z-index: 1050;
            overflow-y: auto;
            transition: left 0.6s ease;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .mobile-filter-sidebar.show {
            left: 0;
            z-index: 10001;
        }

        .mobile-filter-header {
            padding: 20px;
            border-bottom: 1px solid #e0e0e0;
            background: #f8f9fa;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .mobile-filter-close {
            background: none;
            border: none;
            font-size: 24px;
            color: #666;
            cursor: pointer;
        }

        a:hover {
            text-decoration: none;
            border: none;
        }

        /* MOBILE RESPONSIVE STYLES */
        @media (max-width: 767.98px) {

            /* Container adjustments */
            .layout-category-container {
                margin: 0 15px;
                padding: 0;
            }

            /* Category title responsive */
            .category-class {
                font-size: 28px !important;
                margin-top: 1rem !important;
            }

            /* Search bar mobile */
            .form-control {
                width: 100% !important;
                font-size: 16px;
                /* Prevents zoom on iOS */
            }

            .search-suggestions-list {
                width: 100% !important;
            }

            /* Hide desktop filters, show mobile toggle */
            .col-md-3 {
                display: none;
            }

            .mobile-filter-toggle {
                display: flex !important;
                align-items: center;
                justify-content: center;
            }

            /* Adjust main content to full width */
            .col-md-9 {
                width: 100% !important;
                max-width: 100% !important;
                flex: 0 0 100% !important;
                padding: 0 !important;
            }

            /* Header row mobile adjustments */
            .d-flex.justify-content-between {
                flex-direction: column !important;
                gap: 1rem;
                align-items: flex-start !important;
            }

            /* Reset container mobile */
            .reset-container {
                margin-left: 0 !important;
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            /* Filter badges mobile */
            .filter-badge {
                font-size: 0.8rem;
                padding: 0.25rem 0.5rem;
                margin-right: 0.25rem;
                margin-bottom: 0.25rem;
            }

            /* Sort dropdown mobile */
            .form-select {
                width: 100%;
                max-width: 200px;
            }

            /* Document cards mobile */
            .document-card {
                padding: 1rem !important;
                margin-bottom: 1rem !important;
            }

            .document-title {
                font-size: 1.1rem !important;
                line-height: 1.3;
            }

            .main-info {
                font-size: 0.95rem !important;
                flex-direction: column;
                gap: 0.25rem;
            }

            .main-info .mx-2 {
                display: none;
            }

            .sub-info {
                font-size: 0.85rem !important;
                margin-top: 0.5rem;
            }

            .sub-info .mx-2 {
                display: none;
            }

            /* Files section mobile */
            .files-section {
                flex-direction: column;
                gap: 0.5rem;
            }

            .file-link {
                justify-content: center;
                padding: 0.6rem 0.8rem;
                font-size: 0.85rem;
            }

            .download-doc-btn {
                width: 100%;
                justify-content: center;
                padding: 0.75rem 1rem;
            }

            /* Breadcrumb mobile */
            .breadcrumb {
                font-size: 12px !important;
                flex-wrap: wrap;
            }

            .breadcrumb-item {
                font-size: 12px !important;
            }

            /* Toast message mobile */
            .toast-message {
                top: 10px;
                right: 10px;
                left: 10px;
                text-align: center;
            }

            /* Modal adjustments for mobile */
            .ui-dialog {
                width: 95% !important;
                max-width: 95% !important;
                left: 2.5% !important;
            }

            .list-group-item {
                font-size: 0.9rem;
                padding: 0.75rem;
            }

            /* Mobile filter sidebar content */
            .mobile-filter-sidebar .card {
                border: none;
                border-radius: 0;
                border-bottom: 1px solid #e0e0e0;
            }

            .mobile-filter-sidebar .card-header {
                background: white;
                font-weight: 600;
                font-size: 1rem;
                color: #2561a8;
                padding: 1rem;
            }

            .mobile-filter-sidebar .card-body {
                padding: 1rem;
            }

            .mobile-filter-sidebar .filter-label {
                font-size: 0.9rem;
                margin-bottom: 0.75rem;
                display: flex;
                align-items: center;
            }

            .mobile-filter-sidebar .filter-checkbox {
                margin-right: 0.75rem;
                width: 1.2rem;
                height: 1.2rem;
            }
        }

        @media (max-width: 575.98px) {

            /* Extra small devices */
            .layout-category-container {
                margin: 0 10px;
            }

            .category-class {
                font-size: 24px !important;
            }

            .document-card {
                padding: 0.75rem !important;
            }

            .document-title {
                font-size: 1rem !important;
            }

            .main-info,
            .sub-info {
                font-size: 0.85rem !important;
            }

            .filter-badge {
                font-size: 0.75rem;
                padding: 0.2rem 0.4rem;
            }

            .mobile-filter-sidebar {
                width: 100%;
            }
        }

        /* Landscape mobile adjustments */
        @media (max-height: 500px) and (orientation: landscape) {
            .mobile-filter-toggle {
                bottom: 10px;
                right: 10px;
                width: 50px;
                height: 50px;
                font-size: 20px;
            }
        }
    </style>


    <div class="layout-category-container">
        <nav aria-label="breadcrumb" class="">
            <ol class="breadcrumb product-path">
                <li class="breadcrumb-item">
                    <a href="/" class="breadcrumb-link">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/download" class="breadcrumb-link">Download</a>
                </li>
                @if(isset($parentCategory) && $parentCategory)
                    <li class="breadcrumb-item active">{{ $parentCategory->name }}</li>
                @endif
            </ol>
        </nav>

        <div class="category-class mt-5">
            @if(isset($parentCategory) && $parentCategory)
                <p>{{ $parentCategory->name }}</p>
                @if(!empty($parentCategory->description))
                    <div class="mt-2 description text-muted fs-6">{!! $parentCategory->description !!}</div>
                @endif
                <div class="mt-2 description text-muted fs-6">Search by keyword, product name, or number</div>
            @endif
        </div>

        <div class="search  mt-2 mb-2">
            <div class="mb-3 search-bar-container">
                <input type="text" id="searchDocument" class="form-control" placeholder="Search documents...">
                <div id="searchSuggestions" class="search-suggestions-list"></div>
            </div>
        </div>

        <div class="container my-5">
            <div class="row">
                <!-- Header Row -->
                <div class="col-12">
                    <div
                        class="filter-header-row d-flex justify-content-between align-items-center px-3 py-2 rounded flex-wrap flex-md-nowrap">
                        <div class="d-flex align-items-center gap-3 gap-md-4 flex-wrap flex-md-nowrap w-100">
                            <span class="text-dark fs-6 fw-medium mb-2 mb-md-0">Filter By</span>
                            <div class="reset-container d-flex flex-wrap align-items-center gap-2 gap-md-3 mb-2 mb-md-0">
                                <button class="btn btn-link text-decoration-none p-0 text-primary hover-opacity"
                                    id="resetAllFilters">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i>Reset All Filters
                                </button>
                                <span class="text-dark fw-medium">
                                    <span class="text-dark fw-medium" id="totalResults">0</span> Results
                                </span>
                            </div>
                        </div>
                    </div>
                    <style>
                        @media (max-width: 767.98px) {
                            .filter-header-row {
                                flex-direction: column !important;
                                align-items: flex-start !important;
                                gap: 0.5rem !important;
                                padding: 0.75rem 0.5rem !important;
                            }

                            .filter-header-row .d-flex {
                                flex-direction: column !important;
                                align-items: flex-start !important;
                                gap: 0.5rem !important;
                                width: 100% !important;
                            }

                            .reset-container {
                                margin-left: 0 !important;
                                flex-direction: row !important;
                                gap: 0.5rem !important;
                            }

                            .filter-header-row .btn {
                                font-size: 1rem !important;
                            }
                        }
                    </style>
                </div>
                <!-- LEFT FILTERS -->
                <div class="col-md-3 mb-4">
                    {{-- Build a route URL with current category id so form submits to correct route --}}
                    @php
                        $routeParams = [];
                        if (isset($category) && $category->id)
                            $routeParams['id'] = $category->id;
                        $actionUrl = route('category.documents', $routeParams);
                        $preserve = request()->except(['filter_options', 'documenttype', 'documentbrand']);
                    @endphp

                    <form id="filters-form" method="GET" action="{{ $actionUrl }}">
                        {{-- preserve other query params (search, parent_category_id, etc.) --}}
                        @foreach($preserve as $k => $v)
                            @if(is_array($v))
                                @foreach($v as $vv)
                                    <input type="hidden" name="{{ $k }}[]" value="{{ $vv }}">
                                @endforeach
                            @else
                                <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                            @endif
                        @endforeach

                        @foreach($filters as $filter)
                            @continue(!isset($filter->isVisible) || !$filter->isVisible)

                            @if(isset($filter->key) && $filter->key === 'subcategory_system')
                                <!-- Subcategories System Filter -->
                                <div class="card mb-3 shadow-sm">
                                    <div class="card-header">{{ $filter->name }}</div>
                                    <div class="card-body" id="subcategory-list">
                                        @foreach($filter->viewData as $subcategory)
                                                <div class="form-check">
                                                    {{-- Subcategories often behave like links or filters. 
                                                         If filter, we need to decide how to pass it. 
                                                         Usually standard link to subcategory page OR filter current list.
                                                         Current implementation treats them as "filters" for document_category?
                                                         But DownloadController uses them to load docs. 
                                                         If we use checkboxes, it implies filtering *within* the scope.
                                                         Let's assume standard behavior: checkbox to filter documents by this subcat. --}}
                                                    <input type="checkbox" class="form-check-input subcategory-checkbox"
                                                        value="{{ $subcategory->name }}" 
                                                        data-category-id="{{ $subcategory->id }}"
                                                        id="subcategory-{{ $subcategory->id }}"
                                                        name="subcategories[]" {{-- Note: logic in controller might need to handle this name if not using filter_options --}}
                                                        >
                                                    <label class="form-check-label" for="subcategory-{{ $subcategory->id }}">
                                                        {{ $subcategory->name }}
                                                    </label>
                                                </div>
                                        @endforeach
                                    </div>
                                </div>

                            @elseif(isset($filter->key) && $filter->key === 'document_type_system')
                                <!-- Document Type System Filter -->
                                <div class="card mb-3 shadow-sm">
                                    <div class="card-header">{{ $filter->name }}</div>
                                    <div class="card-body" id="document-type-list">
                                         @foreach($filter->viewData as $type)
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input document-type-checkbox" 
                                                    id="type-{{ Str::slug($type) }}"
                                                    name="documenttype[]" 
                                                    value="{{ $type }}"
                                                    {{ in_array($type, $selectedTypes ?? []) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="type-{{ Str::slug($type) }}">
                                                    {{ $type }}
                                                </label>
                                            </div>
                                         @endforeach
                                    </div>
                                </div>

                            @elseif(isset($filter->key) && $filter->key === 'brand_system')
                                <!-- Brand System Filter -->
                                <div class="card mb-3 shadow-sm">
                                    <div class="card-header">{{ $filter->name }}</div>
                                    <div class="card-body" id="document-brand-list">
                                        @foreach($filter->viewData as $brand)
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input document-brand-checkbox" 
                                                    id="brand-{{ Str::slug($brand) }}"
                                                    name="documentbrand[]" 
                                                    value="{{ $brand }}"
                                                    {{ in_array($brand, $selectedBrands ?? []) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="brand-{{ Str::slug($brand) }}">
                                                    {{ $brand }}
                                                </label>
                                            </div>
                                         @endforeach
                                    </div>
                                </div>
                            
                            @else
                                <!-- Dynamic Filter -->
                                <div class="card mb-3 shadow-sm">
                                    <div class="card-header">{{ $filter->name }}</div>
                                    <div class="card-body">
                                        @foreach($filter->viewData as $option)
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input filter-checkbox"
                                                    id="option-{{ $option->id }}" name="filter_options[]"
                                                    value="{{ $option->id }}" 
                                                    {{ (isset($selectedOptions) && in_array($option->id, $selectedOptions)) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="option-{{ $option->id }}">
                                                    {{ $option->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                        @endforeach
                    </form>
                    {{-- Scripts remain largely same, just need to ensure selectors match --}}

        </div>

        <!-- RIGHT CONTENT -->
        <div class="col-md-9 position-relative">

            <!-- Selected filters + Sort by -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <!-- Selected filters -->
                <div id="selected-filters">
                    <span class="text-muted">Selected Filters:</span>
                    <!-- Example badges (populate dynamically via JS) -->
                    {{-- <span class="badge bg-primary me-1">Brand: Schneider</span> --}}
                </div>

                <!-- Sort by dropdown -->
                <div>
                    <select class="form-select form-select-sm" id="sortBy">
                        <option value="newest">Sort by: Newest</option>
                        <option value="oldest">Sort by: Oldest</option>
                    </select>
                </div>
            </div>

            <!-- Loading overlay -->
            <div class="loading-overlay" style="display: none;">
                <div class="loading-spinner"></div>
            </div>

            <!-- Documents List -->
            <div class="row" id="documentsList">
                @forelse($documents as $doc)
                        <div class="col-12 mb-3">
                            <div class="card document-card shadow-sm">
                                <div class="card-header">
                                    <h5 class="document-title">{{ $doc->document_name }}</h5>
                                    @if(!empty($doc->description))
                                        <div class="doc-description text-muted mt-1">{!! $doc->description !!}</div>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <div class="main-info mb-2">
                                        <span class="doc-type">{{ $doc->document_type ?? 'Document' }} ({{ $doc->size ??
                    'N/A' }})</span>
                                        <span class="mx-2">|</span>
                                        <span class="version-date">{{ $doc->version_date ?
                    \Carbon\Carbon::parse($doc->version_date)->format('d M Y') : 'N/A' }}</span>
                                        <span class="mx-2">|</span>
                                        <span class="brand-name">{{ $doc->document_brand ?? 'Unknown' }}</span>
                                    </div>
                                    <div class="sub-info text-muted">
                                        Language: {{ $doc->language ?? 'English' }}
                                        <span class="mx-2">|</span>
                                        Latest Version: {{ $doc->version ?? '1.0' }}
                                    </div>
                                    @if(!empty($doc->description))
                                        <div class="doc-description text-muted">{!! $doc->description !!}</div>
                                    @endif
                                </div>
                                <div class="card-footer">
                                    <a href="{{ asset($doc->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-download"></i> Download
                                    </a>
                                </div>
                            </div>
                        </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">No documents found.</div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    </div>

    <!-- Mobile Filter Toggle Button -->
    <button class="mobile-filter-toggle" id="mobileFilterToggle">
        <i class="bi bi-funnel"></i>
    </button>

    <!-- Mobile Filter Overlay -->
    <div class="mobile-filter-overlay" id="mobileFilterOverlay"></div>

    <!-- Mobile Filter Sidebar -->
    <div class="mobile-filter-sidebar" id="mobileFilterSidebar">
        <div class="mobile-filter-header">
            <h5 class="mb-0 fw-bold text-primary">Filters</h5>
            <button class="mobile-filter-close" id="mobileFilterClose">
                <i class="bi bi-x"></i>
            </button>
        </div>
        <div class="mobile-filter-content">
             @foreach($filters as $filter)
                @continue(!isset($filter->isVisible) || !$filter->isVisible)

                @if(isset($filter->key) && $filter->key === 'subcategory_system')
                    <!-- Subcategories -->
                    <div class="card mb-0">
                        <div class="card-header">{{ $filter->name }}</div>
                        <div class="card-body" id="mobile-subcategory-list">
                            @foreach($filter->viewData as $subcategory)
                                <div class="form-check mb-3">
                                    <input type="checkbox" class="form-check-input subcategory-checkbox filter-checkbox"
                                        value="{{ $subcategory->name }}" data-category-id="{{ $subcategory->id }}"
                                        id="mobile-subcategory-{{ $subcategory->id }}">
                                    <label class="form-check-label filter-label" for="mobile-subcategory-{{ $subcategory->id }}">
                                        {{ $subcategory->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                @elseif(isset($filter->key) && $filter->key === 'document_type_system')
                    <!-- Document Type -->
                     <div class="card mb-0">
                        <div class="card-header">{{ $filter->name }}</div>
                        <div class="card-body" id="mobile-document-type-list">
                            @foreach($filter->viewData as $type)
                                <div class="form-check mb-3">
                                    <input type="checkbox" class="form-check-input document-type-checkbox filter-checkbox" 
                                        value="{{ $type }}"
                                        id="mobile-type-{{ Str::slug($type) }}"
                                        {{ in_array($type, $selectedTypes ?? []) ? 'checked' : '' }}>
                                    <label class="form-check-label filter-label" for="mobile-type-{{ Str::slug($type) }}">
                                        {{ $type }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                @elseif(isset($filter->key) && $filter->key === 'brand_system')
                   <!-- Brand -->
                     <div class="card mb-0">
                        <div class="card-header">{{ $filter->name }}</div>
                        <div class="card-body" id="mobile-document-brand-list">
                            @foreach($filter->viewData as $brand)
                                <div class="form-check mb-3">
                                    <input type="checkbox" class="form-check-input document-brand-checkbox filter-checkbox" 
                                        value="{{ $brand }}"
                                        id="mobile-brand-{{ Str::slug($brand) }}"
                                        {{ in_array($brand, $selectedBrands ?? []) ? 'checked' : '' }}>
                                    <label class="form-check-label filter-label" for="mobile-brand-{{ Str::slug($brand) }}">
                                        {{ $brand }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                @else
                    <!-- Dynamic Filters -->
                    <div class="card mb-0">
                        <div class="card-header">{{ $filter->name }}</div>
                        <div class="card-body">
                            @foreach($filter->viewData as $option)
                                <div class="form-check mb-3">
                                    <input type="checkbox" class="form-check-input filter-checkbox"
                                        id="mobile-option-{{ $option->id }}" name="filter_options[]"
                                        value="{{ $option->id }}" {{ (isset($selectedOptions) &&
                                        in_array($option->id, $selectedOptions)) ? 'checked' : '' }}>
                                    <label class="form-check-label filter-label" for="mobile-option-{{ $option->id }}">
                                        {{ $option->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach

            <div class="p-3">
                <button class="btn btn-outline-secondary w-100 mb-2" id="mobileResetFilters">Reset Filters</button>
                <button class="btn btn-primary w-100" id="mobileApplyFilters">Apply Filters</button>
            </div>
        </div>
    </div>

    <!-- Toast Message -->
    <div class="toast-message" id="toastMsg"></div>

    <!-- Download links will open directly in a new tab. Modal removed. -->

    <!-- Hidden iframe for downloads -->
    <iframe id="downloadFrame" style="display:none;"></iframe>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script>
        // Function to format dates like "28 May 2025"
        function formatDate(dateStr) {
            if (!dateStr) return 'N/A';
            const date = new Date(dateStr);
            if (isNaN(date.getTime())) return 'N/A';
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`;
        }

        $(document).ready(function () {
            // Set up CSRF token for AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Initialize sort change handler
            $('#sortBy').on('change', function () {
                console.log('Sort order changed to:', $(this).val());
                fetchDocuments();
            });

            // Safely get parentCategoryId
            const parentCategoryId = @if(isset($parentCategory) && $parentCategory) '{{ $parentCategory->id }}' @else null @endif;

            // **SOLUTION 1: Load documents via AJAX instead of using server-side data**
            // This ensures consistent data format between initial load and filtered results

            // Initialize documents by fetching from server (instead of using passed data)
            // fetchDocuments(); // This will load all documents with proper format 
            // NOTE: We are rendering documents server side initially now given the view logic changes? 
            // Wait, standard view rendering renders $documents. fetchDocuments() overrides it?
            // The logic below (lines 1490+) `renderDocuments` uses `$('#documentsList').html(html)`.
            // If we assume server side rendering works initially, we might not need this initial call,
            // BUT pagination or Sort might need it. 
            // Let's keep existing behavior:
            fetchDocuments(); 

            // Fetch filter options -> REMOVED to avoid overwriting server-rendered ordered filters
            // fetchDocumentTypes();
            // fetchDocumentBrands();

            // Mobile Filter Functions
            function initializeMobileFilters() {

                // Mobile filter toggle
                $('#mobileFilterToggle').on('click', function () {
                    $('#mobileFilterOverlay').show();
                    $('#mobileFilterSidebar').addClass('show');
                    $('body').css('overflow', 'hidden');
                });

                // Close mobile filters
                function closeMobileFilters() {
                    $('#mobileFilterSidebar').removeClass('show');
                    setTimeout(() => {
                        $('#mobileFilterOverlay').hide();
                        $('body').css('overflow', 'auto');
                    }, 300);
                }

                $('#mobileFilterClose, #mobileFilterOverlay').on('click', closeMobileFilters);

                // Apply filters and close
                $('#mobileApplyFilters').on('click', function () {
                    syncMobileFiltersToDesktop();
                    fetchDocuments();
                    closeMobileFilters();
                });

                // Mobile reset filters
                $('#mobileResetFilters').on('click', function () {
                    resetMobileFilters();
                    fetchDocuments();
                });
            }

            function syncDesktopFiltersToMobile() {
                // Sync document types
                $('#document-type-list .document-type-checkbox').each(function () {
                    const value = $(this).val();
                    const isChecked = $(this).is(':checked');
                    $(`#mobile-document-type-list .document-type-checkbox[value="${value}"]`).prop('checked', isChecked);
                });

                // Sync brands
                $('#document-brand-list .document-brand-checkbox').each(function () {
                    const value = $(this).val();
                    const isChecked = $(this).is(':checked');
                    $(`#mobile-document-brand-list .document-brand-checkbox[value="${value}"]`).prop('checked', isChecked);
                });


            }

            function syncMobileFiltersToDesktop() {
                // Sync document types
                $('#mobile-document-type-list .document-type-checkbox').each(function () {
                    const value = $(this).val();
                    const isChecked = $(this).is(':checked');
                    $(`#document-type-list .document-type-checkbox[value="${value}"]`).prop('checked', isChecked);
                });

                // Sync brands
                $('#mobile-document-brand-list .document-brand-checkbox').each(function () {
                    const value = $(this).val();
                    const isChecked = $(this).is(':checked');
                    $(`#document-brand-list .document-brand-checkbox[value="${value}"]`).prop('checked', isChecked);
                });


            }

            function resetMobileFilters() {
                $('#mobile-document-type-list .document-type-checkbox, #mobile-document-brand-list .document-brand-checkbox, #mobile-subcategory-list .subcategory-checkbox').prop('checked', false);
            }

            // Initialize mobile filters
            initializeMobileFilters();

            // Select All Subcategories logic
            $('#selectAllSubcategories').on('change', function () {
                $('.subcategory-checkbox').prop('checked', this.checked);
                fetchDocuments();
            });

            $('.subcategory-checkbox').on('change', function () {
                const allChecked = $('.subcategory-checkbox:checked').length === $('.subcategory-checkbox').length;
                $('#selectAllSubcategories').prop('checked', allChecked);
                fetchDocuments();
            });

            // Add event listeners for filter changes
            $(document).on('change', '.document-type-checkbox, .document-brand-checkbox', function () {
                fetchDocuments();
            });



            // Add event listener for search input
            let searchTimeout;
            $('#searchDocument').on('input', function () {
                clearTimeout(searchTimeout);
                const query = $(this).val();
                if (query.length > 2) {
                    searchTimeout = setTimeout(() => {
                        fetchSearchSuggestions(query);
                    }, 300);
                } else {
                    $('#searchSuggestions').hide();
                }
                fetchDocuments(); // This can be debounced as well
            });

            // Hide suggestions when clicking outside
            $(document).on('click', function (e) {
                if (!$(e.target).closest('.search-bar-container').length) {
                    $('#searchSuggestions').hide();
                }
            });

            // Function to escape HTML to prevent XSS
            function escapeHtml(unsafe) {
                return unsafe
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");
            }

            function fetchDocumentTypes() {
                $.ajax({
                    url: '/fetch-document-types',
                    method: 'GET',
                    success: function (data) {
                        let html = '';
                        let mobileHtml = '';
                        if (data.documentTypes && data.documentTypes.length) {
                            data.documentTypes.forEach(function (type) {
                                const checkbox = `<div><label class='filter-label'><input type='checkbox' class='filter-checkbox document-type-checkbox' value='${escapeHtml(type.name)}'> ${escapeHtml(type.name)}</label></div>`;
                                html += checkbox;
                                mobileHtml += checkbox.replace('filter-checkbox', 'filter-checkbox');
                            });
                        } else {
                            html = '<div class="text-muted">No types found.</div>';
                            mobileHtml = html;
                        }
                        $('#document-type-list').html(html);
                        $('#mobile-document-type-list').html(mobileHtml);
                        console.log('[DEBUG] Document types loaded:', data.documentTypes);
                    },
                    error: function (xhr) {
                        console.error('[ERROR] Failed to load document types:', xhr.responseText);
                        $('#document-type-list').html('<div class="text-danger">Error loading types</div>');
                        $('#mobile-document-type-list').html('<div class="text-danger">Error loading types</div>');
                    }
                });
            }

            function fetchDocumentBrands() {
                $.ajax({
                    url: '/fetch-document-brands',
                    method: 'GET',
                    success: function (data) {
                        let html = '';
                        let mobileHtml = '';
                        if (data.documentBrands && data.documentBrands.length) {
                            data.documentBrands.forEach(function (brand) {
                                const checkbox = `<div><label class='filter-label'><input type='checkbox' class='filter-checkbox document-brand-checkbox' value='${escapeHtml(brand.name)}'> ${escapeHtml(brand.name)}</label></div>`;
                                html += checkbox;
                                mobileHtml += checkbox.replace('filter-checkbox', 'filter-checkbox');
                            });
                        } else {
                            html = '<div class="text-muted">No brands found.</div>';
                            mobileHtml = html;
                        }
                        $('#document-brand-list').html(html);
                        $('#mobile-document-brand-list').html(mobileHtml);
                        console.log('[DEBUG] Document brands loaded:', data.documentBrands);
                    },
                    error: function (xhr) {
                        console.error('[ERROR] Failed to load document brands:', xhr.responseText);
                        $('#document-brand-list').html('<div class="text-danger">Error loading brands</div>');
                        $('#mobile-document-brand-list').html('<div class="text-danger">Error loading brands</div>');
                    }
                });
            }



            // Fetch language options (add this with other fetch functions)


            function renderDocuments(docs) {
                if (!Array.isArray(docs)) {
                    console.error('Invalid documents data:', docs);
                    return;
                }

                if (docs.length > 0) {
                    console.log('Documents before sorting:', docs.map(d => ({ name: d.document_name, date: d.version_date })));

                    // Sort documents based on version_date
                    const sortOrder = $('#sortBy').val();
                    console.log('Current sort order:', sortOrder);

                    docs.sort((a, b) => {
                        const dateA = a.version_date ? new Date(a.version_date).getTime() : 0;
                        const dateB = b.version_date ? new Date(b.version_date).getTime() : 0;

                        console.log(`Comparing: ${a.document_name} (${dateA}) with ${b.document_name} (${dateB})`);

                        if (sortOrder === 'newest') {
                            return dateB - dateA;
                        } else {
                            return dateA - dateB;
                        }
                    });

                    console.log('Documents after sorting:', docs.map(d => ({ name: d.document_name, date: d.version_date })));
                }
                let html = '';
                if (docs && docs.length) {
                    docs.forEach(function (doc) {
                        const docType = doc.document_type || 'Document';
                        const size = doc.size || 'N/A';
                        const versionDate = formatDate(doc.version_date);
                        const brand = doc.document_brand || 'Unknown';
                        const version = doc.version || '1.0';
                        // description may contain HTML (stored from Summernote).
                        // We intentionally do *not* escape it here so markup renders correctly.
                        // Be sure the server sanitizes/trusts this field appropriately.
                        const description = doc.description ? String(doc.description) : '';

                        // Build document type icon/image HTML
                        let docTypeImageHtml = '';
                        if (doc.document_type_image) {
                            docTypeImageHtml = `<img src="/public/document-types/${escapeHtml(doc.document_type_image)}" alt="${escapeHtml(docType)}" class="me-2" style="width:24px; height:24px; object-fit:contain;">`;
                        } else {
                            docTypeImageHtml = `<i class="fa fa-file me-2" style="font-size:18px;"></i>`;
                        }

                        html += `<div class='col-12'><div class='document-card'>
                                        <div class='document-header'>
                                            <h5 class="document-title">${escapeHtml(doc.document_name)}</h5>
                                        </div>
                                        <div class="document-details mb-3">
                                            <div class="main-info mb-2">
                                                <span class="doc-type">${docTypeImageHtml}${escapeHtml(docType)} (${escapeHtml(size)})</span> 
                                                <span class="mx-2">|</span> 
                                                <span class="version-date">${versionDate}</span>
                                                <span class="mx-2">|</span>
                                                <span class="brand-name">${escapeHtml(brand)}</span>
                                            </div>
                                            <div class="sub-info text-muted">
                                                Latest Version: ${escapeHtml(version)}
                                            </div>
                                            ${description ? `<div class="doc-description text-muted">${description}</div>` : ''}
                                        </div>
                                        <div class="document-footer">
                                            ${(doc.file_path || doc.file_link) ? `
                                                <div class="files-section">
                                                    ${doc.file_path ? `
                                                        <a href='${escapeHtml(doc.file_path)}' class='file-link' target='_blank'>
                                                            <span class="file-name">Download File</span>
                                                            <i class="bi bi-download"></i>
                                                        </a>` : ''}

                                                    ${doc.file_link ? `
                                                        <a href='${escapeHtml(doc.file_link)}' class='file-link' target='_blank'>
                                                            <span class="file-name">External Link</span>
                                                            <i class="bi bi-box-arrow-up-right"></i>
                                                        </a>` : ''}
                                                </div>
                                            ` : ''}
                                            <div class="download-section">
                                                <button class='download-doc-btn' 
                                                        data-docid='${doc.id}' 
                                                        data-docname='${escapeHtml(doc.document_name)}'>
                                                           
                                                    Download
                                                </button>
                                            </div>
                                        </div>
                                    </div></div>`;
                    });
                }
                $('#documentsList').html(html);
            }

            // Function to update total results count
            function updateTotalResults(count) {
                $('#totalResults').text(count || 0);
            }

            // Function to update selected filters display (includes dynamic filter_options[])
            function updateSelectedFilters() {
                let html = '<div class="d-flex flex-wrap align-items-center gap-2 mt-1">';
                let filters = [];
                let hasFilters = false;

                // Get selected document types
                $('.document-type-checkbox:checked').each(function () {
                    hasFilters = true;
                    filters.push(`<span class="filter-badge">
                                    <span><i class="bi bi-tag-fill me-1"></i>Type: ${escapeHtml($(this).val())}</span>
                                    <i class="bi bi-x" data-filter="type" data-value="${escapeHtml($(this).val())}"></i>
                                </span>`);
                });

                // Get selected brands
                $('.document-brand-checkbox:checked').each(function () {
                    hasFilters = true;
                    filters.push(`<span class="filter-badge">
                                    <span><i class="bi bi-building me-1"></i>Brand: ${escapeHtml($(this).val())}</span>
                                    <i class="bi bi-x" data-filter="brand" data-value="${escapeHtml($(this).val())}"></i>
                                </span>`);
                });



                // Get selected dynamic filter options (server rendered)
                $('input[name="filter_options[]"]:checked').each(function () {
                    hasFilters = true;
                    const val = $(this).val();
                    // Try to get a human readable label from the closest label
                    let label = '';
                    const $lbl = $(this).closest('.form-check').find('label');
                    if ($lbl && $lbl.length) label = $lbl.text().trim();
                    if (!label) label = $(this).data('name') || val;
                    filters.push(`<span class="filter-badge">
                                    <span><i class="bi bi-funnel me-1"></i>${escapeHtml(label)}</span>
                                    <i class="bi bi-x" data-filter="option" data-value="${escapeHtml(val)}"></i>
                                </span>`);
                });

                // Get selected subcategories
                $('.subcategory-checkbox:checked').each(function () {
                    hasFilters = true;
                    filters.push(`<span class="filter-badge">
                                    <span><i class="bi bi-folder me-1"></i>Category: ${escapeHtml($(this).val())}</span>
                                    <i class="bi bi-x" data-filter="subcategory" data-value="${escapeHtml($(this).val())}"></i>
                                </span>`);
                });

                // Add search term if exists
                let searchTerm = $('#searchDocument').val();
                if (searchTerm) {
                    hasFilters = true;
                    filters.push(`<span class="filter-badge">
                                    <span><i class="bi bi-search me-1"></i>Search: ${escapeHtml(searchTerm)}</span>
                                    <i class="bi bi-x" data-filter="search"></i>
                                </span>`);
                }

                if (!hasFilters) {
                    html += '<span class="text-muted fst-italic">No filters applied</span>';
                }

                html += filters.join('') + '</div>';
                $('#selected-filters').html(html);
            }

            // Function to reset all filters
            function resetAllFilters() {
                // Reset checkboxes including dynamic filter options
                $('.document-type-checkbox, .document-brand-checkbox, .subcategory-checkbox').prop('checked', false);

                // Reset search
                $('#searchDocument').val('');

                // Reset sort
                $('#sortBy').val('newest');

                // Clear selected filters display
                $('#selected-filters').html('<span class="text-muted">Selected Filters:</span>');

                // Fetch all documents
                fetchDocuments();
            }

            // Reset All Filters button click handler
            $('#resetAllFilters').click(function (e) {
                e.preventDefault();
                resetAllFilters();
            });

            // Handle sort change
            $('#sortBy').off('change').on('change', function () {
                console.log('Sort changed to:', $(this).val());
                fetchDocuments();
            });

            function fetchDocuments() {
                // Show loading state
                $('.filter-sidebar').addClass('loading');
                // Show overlay on the whole documents section
                $('.col-md-9 .loading-overlay').css('display', 'flex');

                let types = [];
                let brands = [];

                let subcategories = [];
                let selectedFilterOptions = [];
                let search = $('#searchDocument').val();
                let sortBy = $('#sortBy').val();

                console.log('Fetching documents with sort order:', sortBy);
                $('.document-type-checkbox:checked').each(function () {
                    types.push($(this).val());
                });

                $('.document-brand-checkbox:checked').each(function () {
                    brands.push($(this).val());
                });

                // Collect dynamic filter options (server-rendered checkboxes named filter_options[])
                $('input[name="filter_options[]"]:checked').each(function () {
                    selectedFilterOptions.push($(this).val());
                });



                $('.subcategory-checkbox:checked').each(function () {
                    subcategories.push($(this).val());
                });

                // If no subcategories are selected and we're on a parent category page,
                // include all available subcategories by default
                if (subcategories.length === 0 && parentCategoryId) {
                    $('.subcategory-checkbox').each(function () {
                        subcategories.push($(this).val());
                    });
                }

                $.ajax({
                    url: '/filter-documents',
                    method: 'GET',
                    data: {
                        documenttype: types.length > 0 ? types : undefined,
                        documentbrand: brands.length > 0 ? brands : undefined,

                        documentcategory: subcategories.length > 0 ? subcategories : undefined,
                        filter_options: selectedFilterOptions.length > 0 ? selectedFilterOptions : undefined,
                        parent_category_id: parentCategoryId,
                        search: search || undefined,
                        sort_order: sortBy
                    },
                    success: function (response) {
                        // Remove loading states FIRST
                        $('.filter-sidebar').removeClass('loading');
                        $('.col-md-9 .loading-overlay').css('display', 'none');

                        if (response.error) {
                            showToast(response.error, '#dc3545');
                            return;
                        }

                        // FIXED: Remove all transition classes and directly update content
                        console.log('Fetched documents payload:', response.documents);

                        // Clear and render documents without animation conflicts
                        renderDocuments(response.documents);

                        // Update total results count
                        updateTotalResults(response.documents ? response.documents.length : 0);

                        // Update selected filters display
                        updateSelectedFilters();

                        // Handle remove filter clicks
                        $(document).off('click', '.bi-x').on('click', '.bi-x', function () {
                            const filterType = $(this).data('filter');
                            const filterValue = $(this).data('value');

                            switch (filterType) {
                                case 'type':
                                    $(`.document-type-checkbox[value="${filterValue}"]`).prop('checked', false);
                                    break;
                                case 'brand':
                                    $(`.document-brand-checkbox[value="${filterValue}"]`).prop('checked', false);
                                    break;
                                case 'language':
                                    $(`.document-language-checkbox[value="${filterValue}"]`).prop('checked', false);
                                    break;
                                case 'subcategory':
                                    $(`.subcategory-checkbox[value="${filterValue}"]`).prop('checked', false);
                                    break;
                                case 'option':
                                    // Uncheck dynamic filter option checkbox(s) matching this value
                                    // First try exact value match
                                    $(`input[name="filter_options[]"][value="${filterValue}"]`).prop('checked', false);
                                    // Also try matching by id if value wasn't the id
                                    $(`#option-${filterValue}`).prop('checked', false);
                                    break;
                                case 'search':
                                    $('#searchDocument').val('');
                                    break;
                            }

                            fetchDocuments();
                        });
                    },
                    error: function (xhr) {
                        $('.filter-sidebar').removeClass('loading');
                        $('.col-md-9 .loading-overlay').css('display', 'none');
                        showToast('Error loading documents: ' + (xhr.responseJSON?.message || 'Unknown error'), '#dc3545');
                        console.error('Filter error:', xhr.responseText);
                    }
                });
            }
            function showToast(msg, color = '#28a745') {
                $('#toastMsg').css('background', color).text(msg).fadeIn(200);
                setTimeout(() => { $('#toastMsg').fadeOut(400); }, 2000);
            }

            // Simplified download behavior: open primary file in a new tab directly.
            // When the document card already contains a direct file link (.file-link), open it.
            // Otherwise, fetch document info via AJAX and open the first available file URL.
            $(document).on('click', '.download-doc-btn', function (e) {
                e.preventDefault();
                const $btn = $(this);
                const docId = $btn.data('docid');

                // Try to find an existing direct link rendered in the card
                const $card = $btn.closest('.document-card');
                const $directLink = $card.find('.file-link').first();
                if ($directLink && $directLink.length) {
                    const href = $directLink.attr('href');
                    if (href) {
                        window.open(href, '_blank');
                        return;
                    }
                }

                // Fallback: fetch document details and open the first available file
                const originalHtml = $btn.html();
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Opening...');

                $.ajax({
                    url: '/filter-documents',
                    method: 'GET',
                    data: { id: docId },
                    success: function (response) {
                        let doc = null;
                        if (response.documents && response.documents.length) {
                            doc = response.documents.find(d => d.id == docId) || response.documents[0];
                        }
                        let url = null;
                        if (doc) {
                            if (doc.file_path) url = doc.file_path;
                            else if (doc.file_link) url = doc.file_link;
                            else if (doc.files && doc.files.length) url = doc.files[0].url;
                        }
                        if (url) {
                            window.open(url, '_blank');
                        } else {
                            showToast('No downloadable file found for this document.', '#dc3545');
                        }
                    },
                    error: function () {
                        showToast('Error fetching document file. Please try again.', '#dc3545');
                    },
                    complete: function () {
                        $btn.prop('disabled', false).html(originalHtml);
                    }
                });
            });

            // Event listeners
            $(document).on('change', '.filter-checkbox', fetchDocuments);
            $('#searchDocument').on('input', debounce(fetchDocuments, 300));

            // Handle filter removal
            $(document).on('click', '.filter-badge .bi-x', function (e) {
                e.preventDefault();
                e.stopPropagation();
                const filterType = $(this).data('filter');
                const filterValue = $(this).data('value');

                console.log('Removing filter:', filterType, filterValue);

                switch (filterType) {
                    case 'type':
                        $(`.document-type-checkbox[value="${filterValue}"]`).prop('checked', false);
                        break;
                    case 'brand':
                        $(`.document-brand-checkbox[value="${filterValue}"]`).prop('checked', false);
                        break;

                    case 'subcategory':
                        $(`.subcategory-checkbox[value="${filterValue}"]`).prop('checked', false);
                        break;
                    case 'search':
                        $('#searchDocument').val('');
                        break;
                }

                $(this).closest('.filter-badge').fadeOut(200, function () {
                    $(this).remove();
                    fetchDocuments();
                });
            });

            $('#resetFilters').on('click', function () {
                $('.filter-checkbox').prop('checked', false);

                $('#searchDocument').val('');
                $('#selectAllSubcategories').prop('checked', false);
                fetchDocuments();
            });

            // Debounce function
            function debounce(func, wait) {
                let timeout;
                return function () {
                    const context = this;
                    const args = arguments;
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(context, args), wait);
                };
            }

            function fetchSearchSuggestions(query) {
                console.log('Fetching suggestions for:', query); // Debugging
                $.ajax({
                    url: '/filter-documents', // Use the same endpoint
                    method: 'GET',
                    data: {
                        search: query,
                        limit: 5 // Limit suggestions
                    },
                    success: function (response) {
                        console.log('Suggestions received:', response); // Debugging
                        if (response.documents && response.documents.length) {
                            let suggestionsHtml = '';
                            response.documents.forEach(doc => {
                                suggestionsHtml += `<div class="suggestion-item" data-name="${escapeHtml(doc.document_name)}">
                                                <i class="bi bi-file-earmark-text"></i>
                                                <span>${escapeHtml(doc.document_name)}</span>
                                            </div>`;
                            });
                            $('#searchSuggestions').html(suggestionsHtml).show();

                            // Handle suggestion click
                            $('.suggestion-item').on('click', function () {
                                const selectedName = $(this).data('name');
                                $('#searchDocument').val(selectedName);
                                $('#searchSuggestions').hide();
                                fetchDocuments();
                            });
                        } else {
                            console.log('No suggestions found.'); // Debugging
                            $('#searchSuggestions').hide();
                        }
                    },
                    error: function (xhr) {
                        console.error('Error fetching suggestions:', xhr.responseText); // Debugging
                    }
                });
            }
        });
    </script>
@endsection
