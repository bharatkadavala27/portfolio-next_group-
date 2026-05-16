@extends('layouts.app')

@section('content')

   


<div class="layout-category-container px-6">
    @if ($brand)
    <div class="category-heading">
        <p class="product-path text-dark mt-3" style="font-size: 14px;">
            @foreach ($breadcrumb as $index => $crumb)
                @if ($index > 0)
                    <i class="fas fa-chevron-right mx-2"></i>
                @endif
                @if ($crumb['url'])
                    <a href="{{ $crumb['url'] }}" class="breadcrumb-link text-dark">{{ $crumb['name'] }}</a>
                @else
                    <span>{{ $crumb['name'] }}</span>
                @endif
            @endforeach
        </p>
        <div class="col-md-9 mt-5 w-100">
            <h1 class="mb-3 theme-text" style="font-size: 42px; font-weight: normal; margin-top: 80px;">
                {{ isset($mainCategory) && !empty($mainCategory->name) ? $mainCategory->name : ($brand->name ?? 'Products') }}
            </h1>
            <p class="category-description text-muted" style="padding-bottom:10px;">
                {!! isset($mainCategory) && !empty($mainCategory->description) ? $mainCategory->description : ('Browse products from ' . ($brand->name ?? '')) !!}
            </p>
        </div>
    </div>

    <div class="row">
        <!-- Left Side Filter -->
        <div class="col-md-3 mt-3">
            <div class="card mb-4">
                <div style="padding-top:10px; padding-left: 10px;">
                    <h5 class="card-header m-0 p-0 fs-6" style="font-weight: 500; color: black !important;">Categories</h5>
                    <div class="hr">
                        <hr>
                    </div>
                </div>
                <div class="card-body">
                    @php
                        $uniqueTopLevelParents = collect();
                        $processedParentIds = [];

                        // Get all unique top-level parent categories
                        if (isset($categories) && $categories instanceof \Illuminate\Support\Collection && $categories->count() > 0) {
                            foreach ($categories as $currentCategoryInLoop) {
                                $topParent = $currentCategoryInLoop;
                                // Traverse up to the top-level parent
                                while ($topParent->parent) {
                                    $topParent = $topParent->parent;
                                }

                                // Add the top-level parent to our list if it hasn't been added yet
                                if (!in_array($topParent->id, $processedParentIds)) {
                                    $uniqueTopLevelParents->push($topParent);
                                    $processedParentIds[] = $topParent->id;
                                }
                            }
                        }
                    @endphp

                    <form id="filter-form" class="filter-form">
                        @if ($uniqueTopLevelParents->count() > 0)
                        <div class="subcategories ms-3">
                            @foreach ($uniqueTopLevelParents as $parentCategory)
                            <div class="mb-2">
                                <input type="checkbox" class="form-check-input me-2 category-filter filter-checkbox" name="categories[]"
                                       id="cat-{{ $parentCategory->id }}" value="{{ $parentCategory->id }}"
                                       {{ in_array($parentCategory->id, request()->input('categories', [])) ? 'checked' : '' }}>
                                <label class="d-inline form-check-label" for="cat-{{ $parentCategory->id }}">
                                    {{ $parentCategory->name }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                        @else
                            {{-- <p class="ms-3 text-muted">No category filters available.</p> --}}
                        @endif
                    </form>
                </div>
            </div>

            <!-- Brands List (unchanged) -->
        <!-- Brands List (checkboxes but same behavior as before) -->
<div class="card mb-4">
    <div style="padding-top:10px; padding-left: 10px;">
        <h5 class="card-header m-0 p-0 fs-6" style="font-weight: 500; color: black !important;">Brands</h5>
        <div class="hr">
            <hr>
        </div>
    </div>
    <div class="card-body">
        <div class="brands ms-3">
            @foreach ($allBrands as $brandItem)
                <div class="mb-2">
                    <input type="checkbox"
                           class="form-check-input me-2 brand-checkbox"
                           id="brand-{{ $brandItem->id }}"
                           value="{{ route('brand.products', $brandItem->id) }}"
                           {{ $brandItem->id == $brand->id ? 'checked' : '' }}>
                    <label class="d-inline form-check-label" for="brand-{{ $brandItem->id }}">
                        {{ $brandItem->name }}
                    </label>
                </div>
            @endforeach
        </div>
    </div>



            </div>
        </div>

        <div class="col-md-9">
            <div class="tab-content bg-white" style="border:1px solid rgb(227, 225, 225);padding:0px 30px">
                <div>
                    @php
                        $selectedParentCategoryIDs = request()->input('categories', []);

                        // FIXED LOGIC: Filter categories to show based on selected parent IDs
                        if (empty($selectedParentCategoryIDs)) {
                            // If no filter selected, show all categories
                            $filteredCategoriesToDisplay = $categories;
                        } else {
                            // Filter categories: show only those whose top-level parent is in the selected IDs
                            $filteredCategoriesToDisplay = $categories->filter(function($categoryInList) use ($selectedParentCategoryIDs) {
                                // Find the top-level parent of this category
                                $topParent = $categoryInList;
                                while ($topParent->parent) {
                                    $topParent = $topParent->parent;
                                }

                                // Include this category if its top-level parent is selected
                                return in_array($topParent->id, $selectedParentCategoryIDs);
                            });
                        }
                    @endphp

                    @if ($filteredCategoriesToDisplay && $filteredCategoriesToDisplay->count() > 0)
                        @foreach($filteredCategoriesToDisplay as $category)
                            <h5 class="card-title theme-text fs-2 fw-normal bg-white text-truncate mt-4 mb-4">{{ $category->name }}</h5>
                            @php
                                // Get subcategories for this category
                                $subcategories = $category->children ?? collect();

                                // If selected filters exist, also filter subcategories
                                if (!empty($selectedParentCategoryIDs)) {
                                    $subcategories = $subcategories->filter(function($subcat) use ($selectedParentCategoryIDs) {
                                        // Find the top-level parent of this subcategory
                                        $topParent = $subcat;
                                        while ($topParent->parent) {
                                            $topParent = $topParent->parent;
                                        }
                                        return in_array($topParent->id, $selectedParentCategoryIDs);
                                    });
                                }
                            @endphp

                            @if($subcategories->count() > 0)
                                <main class="category-list mt-4 bg-white" data-category-id="{{ $category->id }}">
                                    <div class="subcategory-wrapper">
                                        <div class="row row-cols-1 row-cols-md-3 g-4" id="subcategory-list-{{ $category->id }}">
                                            @foreach($subcategories as $subcat)
                                                <div class="col">
                                                    <div class="card h-100 d-flex flex-column">
                                                        <a href="{{ route('brand.category.show', ['brand_id' => $brand->id, 'category_id' => $subcat->id]) }}">
                                                            <img src="{{ asset('uploads/category/' . ($subcat->image ?? 'default.jpg')) }}"
                                                                 alt="{{ $subcat->name }}" class="card-img-top"
                                                                 style="object-fit: contain; height: 100px; object-position: left; margin:20px 20px 0px 20px;">
                                                        </a>
                                                        <div class="card-body d-flex flex-column">
                                                            <a href="{{ route('brand.category.show', ['brand_id' => $brand->id, 'category_id' => $subcat->id]) }}">
                                                                <h5 class="card-title text-dark text-truncate fw-normal">{{ $subcat->name }}</h5>
                                                            </a>
                                                            <p class="card-text text-muted description-text">{!! $subcat->description !!}</p>
                                                            <div class="mt-auto">
                                                                <a href="{{ route('brand.category.show', ['brand_id' => $brand->id, 'category_id' => $subcat->id]) }}"
                                                                   class="theme-text" style="text-decoration:none">View Details</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </main>
                            @else
                                @php
                                    // Get products for this category (assuming $category->products relationship exists)
                                    $products = $category->products ?? collect();
                                @endphp

                                @if($products->count() > 0)
                                    <main class="product-list mt-4 bg-white" data-category-id="{{ $category->id }}">
                                        <div class="row row-cols-1 row-cols-md-3 g-4" id="product-list-{{ $category->id }}">
                                            @foreach($products as $product)
                                                <div class="col">
                                                    <div class="card h-100 d-flex flex-column">
                                                        <a href="{{ route('product.show', $product->id) }}">
                                                            @php
                                                                // Use the same logic as show.blade.php for product images
                                                                $images = json_decode(str_replace('\\', '/', $product->images ?? ''), true);
                                                            @endphp
                                                            @if (!empty($images) && is_array($images) && !empty($images[0]))
                                                                <img src="{{ asset($images[0]) }}"
                                                                     alt="{{ $product->name }}" class="card-img-top"
                                                                     style="object-fit: contain; height: 100px; object-position: left; margin:20px 20px 0px 20px;">
                                                            @else
                                                                <img src="{{ asset('images/no-image.png') }}"
                                                                     alt="No image" class="card-img-top"
                                                                     style="object-fit: contain; height: 100px; object-position: left; margin:20px 20px 0px 20px;">
                                                            @endif
                                                        </a>
                                                        <div class="card-body d-flex flex-column">
                                                            <a href="{{ route('product.show', $product->id) }}">
                                                                <h5 class="card-title text-dark text-truncate fw-normal">{{ $product->name }}</h5>
                                                            </a>
                                                            <p class="card-text text-muted description-text">{!! $product->description !!}</p>
                                                            <div class="mt-auto">
                                                                <a href="{{ route('product.show', $product->id) }}"
                                                                   class="theme-text" style="text-decoration:none">View Details</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </main>
                                @else
                                    <p class="text-muted">No subcategories or products available for {{ $category->name }}.</p>
                                @endif
                            @endif
                        @endforeach
                    @else
                        <p class="text-center text-muted p-4">
                            @if(!empty($selectedParentCategoryIDs))
                                No categories match your selected filters.
                            @else
                                No categories found for {{ $brand->name }}.
                            @endif
                        </p>
                    @endif
                </div>
            </div>
        </div>

        {{-- <!-- Recently Viewed Items Section -->
        <div class="layout-category-container">
            <div class="recently-viewed mt-5">
                <h5 class="theme-text fw-bold mb-4" style="font-size: 26px">Recently Viewed Items</h5>
                <div class="row row-cols-1 row-cols-md-3 g-4" style="justify-content: flex-start;">
                    @forelse ($recentlyViewedItems ?? [] as $item)
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
        <!-- Static Containers Section -->
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
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle category filter changes
    document.querySelector('.filter-form').addEventListener('change', function(e) {
        if (e.target.classList.contains('category-filter')) {
            // Show loading state
            const mainContent = document.querySelector('.col-md-9');
            mainContent.style.opacity = '0.5';

            // Collect all checked categories
            const checkedCategories = Array.from(document.querySelectorAll('.category-filter:checked'))
                .map(checkbox => checkbox.value);

            // Build URL with selected categories
            const url = new URL(window.location.href);
            url.searchParams.delete('categories[]'); // Clear existing categories params

            // Add each selected category
            checkedCategories.forEach(catId => {
                url.searchParams.append('categories[]', catId);
            });

            // Fetch filtered results
            fetch(url.toString(), {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                // Update only the product/category listing part
                const newContentArea = doc.querySelector('.col-md-9 .tab-content');
                const currentContentArea = document.querySelector('.col-md-9 .tab-content');

                if (newContentArea && currentContentArea) {
                    currentContentArea.innerHTML = newContentArea.innerHTML;
                } else {
                    // Fallback: reload the whole main content area
                    const newMainContent = doc.querySelector('.col-md-9');
                    if (newMainContent) {
                        mainContent.innerHTML = newMainContent.innerHTML;
                    } else {
                        // If all else fails, reload the page
                        window.location.href = url.toString();
                        return;
                    }
                }

                // Update URL without page reload
                window.history.pushState({}, '', url.toString());

                // Restore opacity
                mainContent.style.opacity = '1';
            })
            .catch(error => {
                console.error('Error fetching filtered content:', error);
                mainContent.style.opacity = '1';
                // You could show an error message here
                alert('An error occurred while filtering. Please try again.');
            });
        }
    });
});
document.addEventListener('DOMContentLoaded', function() {
    // Handle brand checkbox click
    document.querySelectorAll('.brand-checkbox').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                // Redirect to brand.products route (same as old link)
                window.location.href = this.value;
            }
        });
    });
});
</script>

<style>
main {
    background-color: rgb(250, 250, 250) !important;
    min-height: auto;
    width: 100%;
}
.layout-category-container {
    max-width: 1280px;
    margin: 0 auto !important;
    padding: 0px 10px;
}
.category-heading {
    margin-bottom: 30px;
}
.product-path {
    margin-top: 0 !important;
}
.breadcrumb-link,
a,
a:visited {
    text-decoration: none !important;
    border: none;
}
.breadcrumb-link:hover,
a:hover {
    text-decoration: none !important;
    border: none;
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
}
.help-card {
    background-color: #f5faff;
    border: 1px solid #d1e7ff;
    border-radius: 2px;
    padding: 35px 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}
.help-me-choose-btn {
    background-color: #2561a8;
    color: white;
    padding: 8px 20px;
    border-radius: 2px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
}
.help-me-choose-btn:hover {
    background-color: #333;
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
    border-radius: none !important;
    background: none !important;
}
.card.fade-out {
    opacity: 0;
    transform: translateY(20px);
}
.card.fade-in {
    animation: fadeIn 0.5s ease-in-out;
}
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.filter-transition {
    transition: all 0.3s ease-in-out;
}
.tab-pane {
    transition: opacity 0.3s ease-in-out;
}
.tab-pane.fade {
    opacity: 0;
}
.tab-pane.show {
    opacity: 1;
}
.nav-tabs {
    border: none !important;
}
.filter-checkbox {
    transition: transform 0.2s ease;
}
.filter-checkbox:checked {
    transform: scale(1.1);
}
.product-card-fixed {
    height: 100%;
    min-height: 390px;
    display: flex;
    flex-direction: column;
    border: 1px solid #e0e0e0 !important;
}
.product-card-img-wrapper {
    height: auto !important;
    padding: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: white;
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
    background: none;
    width: 100%;
    height: auto;
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
    font-size: 14px;
    margin-top: 8px;
}
.documents-link:hover {
    color: #1e4a8f;
    text-decoration: none;
}
.theme-color {
    background-color: #2561a8;
}
.theme-text {
    color: #2561a8;
}
.description-text {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    word-wrap: break-word;
    max-height: auto;
}
.recently-viewed {
    .products-row {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
    }
}
.recently-viewed .col {
    flex: 0 0 auto;
    width: 285px;
}
.recently-viewed .card {
    transition: transform 0.2s ease;
}
.recently-viewed .card:hover {
    transform: translateY(-2px);
}
.viewed-recently img {
    background: #f8f8f8;
}
@media (max-width: 767.98px) {
    .recently-viewed .col {
        width: 100%;
        max-width: 285px;
    }
    .products-row .row {
        justify-content: center;
    }
}
</style>
@endsection
