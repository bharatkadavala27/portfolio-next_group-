@extends('layouts.app')

@section('title', 'Download')

@section('content')
    <div class="container py-4">
        <h2 class="mb-3 text-primary fw-bold text-center">Download Documents</h2>

        <div class="row">
            <!-- Filters (Left Side) -->
            <div class="col-md-3">
                <div class="p-4 bg-white shadow rounded border">
                    <h5 class="fw-bold text-dark">Filter by</h5>

                    <!-- Search Filter -->
                    <div class="mb-3">
                        <label class="fw-bold">Search Product</label>
                        <input type="text" id="searchProduct" class="form-control" placeholder="Enter product name">
                    </div>

                    <!-- Category Filter -->
                    <div class="mb-3">
                        <label class="fw-bold">Category</label>
                        <ul class="list-unstyled">
                            @foreach ($categories as $category)
                                <li>
                                    <label class="d-flex align-items-center">
                                        <input type="checkbox" name="category[]" value="{{ $category->id }}" class="filter-checkbox category-checkbox me-2">
                                        <span class="text-truncate">{{ $category->name }}</span>
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Subcategory Filter -->
                    <div class="mb-3">
                        <label class="fw-bold">Subcategory</label>
                        <ul id="subcategory-list" class="list-unstyled text-truncate">
                            <p class="text-muted">Select a category to see subcategories.</p>
                        </ul>
                    </div>

                    <!-- Brand Filter -->
                    <div class="mb-3">
                        <label class="fw-bold">Brand</label>
                        <ul class="list-unstyled">
                            @foreach ($brands as $brand)
                                <li>
                                    <label class="d-flex align-items-center">
                                        <input type="checkbox" name="brand[]" value="{{ $brand->id }}" class="filter-checkbox brand-checkbox me-2">
                                        <span>{{ $brand->name }}</span>
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- <button class="btn btn-primary w-100 mb-2" id="applyFilters">Apply Filters</button> --}}
                    <button class="btn btn-outline-secondary w-100" id="resetFilters">Reset All</button>
                </div>
            </div>

            <!-- Documents (Right Side) -->
            <div class="col-md-9">
                <div class="row" id="documentsList">
                    @foreach ($documents as $document)
                        <div class="col-md-12 mb-4">
                            <div class="document-card shadow-sm rounded overflow-hidden">
                                <div class="document-header text-center text-dark fw-bold">{{ $document->product->name ?? 'N/A' }}</div>
                                <div class="document-body p-3">
                                    <p class="text-muted small"><strong>Type:</strong> {{ $document->type ?? 'N/A' }}</p>
                                    <p class="text-muted small"><strong>Price:</strong> Rs {{ $document->product->price ?? 'N/A' }}</p>
                                    <p class="text-muted small"><strong>Category:</strong> {{ $document->product->category->name ?? 'N/A' }}</p>
                                    <p class="text-muted small"><strong>Brand:</strong> {{ $document->product->brand->name ?? 'N/A' }}</p>
                                </div>
                                <div class="document-footer text-center p-2">
                                    <a href="{{ $document->file_path }}" class="btn btn-primary btn-sm w-75">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('admin/js/jquery-1.12.4.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            function fetchSubcategories(categoryIds) {
                $.ajax({
                    url: "{{ route('fetch.subcategories') }}",
                    method: "GET",
                    data: {
                        category_ids: categoryIds
                    },
                    success: function(response) {
                        let subcategoryList = $('#subcategory-list');
                        subcategoryList.empty();

                        if (!response.subcategories || response.subcategories.length === 0) {
                            subcategoryList.html('<p class="text-muted">No subcategories found.</p>');
                            return;
                        }

                        response.subcategories.forEach(subcategory => {
                            subcategoryList.append(`
                                <li>
                                    <label class="d-flex align-items-center">
                                        <input type="checkbox" name="subcategory[]" value="${subcategory.id}" class="filter-checkbox subcategory-checkbox me-2">
                                        <span>${subcategory.name}</span>
                                    </label>
                                </li>
                            `);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", error);
                        alert("Something went wrong while fetching subcategories. Please try again.");
                    }
                });
            }

            function applyFilters() {
                let selectedCategories = [];
                let selectedSubcategories = [];
                let selectedBrands = [];
                let searchQuery = $('#searchProduct').val();

                $('input[name="category[]"]:checked').each(function() {
                    selectedCategories.push($(this).val());
                });

                $('input[name="subcategory[]"]:checked').each(function() {
                    selectedSubcategories.push($(this).val());
                });

                $('input[name="brand[]"]:checked').each(function() {
                    selectedBrands.push($(this).val());
                });

                try {
                    $.ajax({
                        url: "{{ route('filter.documents') }}",
                        method: "GET",
                        data: {
                            category: selectedCategories,
                            subcategory: selectedSubcategories,
                            brand: selectedBrands,
                            search: searchQuery
                        },
                        success: function(response) {
                            let documentsList = $('#documentsList');
                            documentsList.empty();

                            if (!response.documents || response.documents.length === 0) {
                                documentsList.html('<p class="text-center">No documents found.</p>');
                                return;
                            }

                            response.documents.forEach(document => {
                                let categoryName = document.product?.category?.name || 'N/A';
                                let brandName = document.product?.brand?.name || 'N/A';

                                documentsList.append(`
                                    <div class="col-md-12 mb-4">
                                        <div class="document-card shadow-sm rounded overflow-hidden">
                                            <div class="document-header text-center text-dark fw-bold">${document.product?.name || 'N/A'}</div>
                                            <div class="document-body p-3">
                                                <p class="text-muted small"><strong>Type:</strong> ${document.type || 'N/A'}</p>
                                                <p class="text-muted small"><strong>Price:</strong> Rs ${document.product?.price || 'N/A'}</p>
                                                <p class="text-muted small"><strong>Category:</strong> ${categoryName}</p>
                                                <p class="text-muted small"><strong>Brand:</strong> ${brandName}</p>
                                            </div>
                                            <div class="document-footer text-center p-2">
                                                <a href="${document.file_path}" class="btn btn-primary btn-sm w-75">
                                                    <i class="fas fa-download"></i> Download
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                `);
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error:", error);
                            alert("Something went wrong while fetching documents. Please try again.");
                        }
                    });
                } catch (error) {
                    console.error("Try-Catch Error:", error);
                    alert("An unexpected error occurred. Please reload the page and try again.");
                }
            }

            // Reset filters
            function resetFilters() {
                $('.filter-checkbox').prop('checked', false);
                $('#searchProduct').val('');
                $('#subcategory-list').empty();
                $('#subcategory-list').html('<p class="text-muted">Select a category to see subcategories.</p>');
                applyFilters(); // Call applyFilters to reload all documents
            }

            // Fetch subcategories when a category is selected
            $('input[name="category[]"]').change(function() {
                let selectedCategories = [];
                $('input[name="category[]"]:checked').each(function() {
                    selectedCategories.push($(this).val());
                });
                fetchSubcategories(selectedCategories);
                applyFilters();
            });

            // Apply filters when subcategory or brand is selected
            $('input[name="subcategory[]"], input[name="brand[]"]').change(function() {
                applyFilters();
            });

            // Event Listeners
            $('#applyFilters').click(applyFilters);
            $('#resetFilters').click(resetFilters);
        });
    </script>
@endsection
