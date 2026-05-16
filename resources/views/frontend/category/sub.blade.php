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
                <h1 class="mb-3 theme-text" style="font-size: 42px; font-weight: normal; cursor:default;">{{ $category->name }}</h1>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="col-md-12 mx-auto">
            @if ($childCategories->count() > 0)
                <div class="row row-cols-1 row-cols-md-4 g-4">
                    @foreach ($childCategories as $subcategory)
                        <div class="col">
                            <div class="card h-100 d-flex flex-column" style="border:1px solid #a2a2a247!important;">
                                <a href="{{ route('child.category.show', $subcategory->id) }}" class="d-flex flex-column align-items-center text-decoration-none">
                                  @if ($subcategory->image && file_exists(public_path('uploads/category/' . $subcategory->image)))
    <img src="{{ asset('uploads/category/' . $subcategory->image) }}"
        alt="{{ $subcategory->name }}" class="card-img-top"
        style="object-fit: contain; height: 140px; width: 140px; display:block; margin:0 auto;">
@else
    <div class="d-flex justify-content-center align-items-center"
        style="height: 140px; width: 100%; display:block; margin:0 auto; background:#f8f9fa; border:1px dashed #ccc; color:#888; font-size:14px;">
        No Image
    </div>
@endif

                                </a>
                                <div class="card-body d-flex flex-column">
                                    
                                    <a href="{{ route('child.category.show', $subcategory->id) }}">
                                        <h5 class="card-title text-black fw-normal mb-2 mt-3 text-start" style="font-size: 20px;">{{ $subcategory->name }}</h5>
                                    </a>
                                    <p class="card-text  description-text mb-2 text-start" style="font-size: 15px;">{!! $subcategory->description !!}</p>
                                    <div class="mt-auto text-start">
                                        <a href="{{ route('child.category.show', $subcategory->id) }}"
                                            class="theme-text" style="text-decoration:underline;font-weight:500;">View Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
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

        </div>
    </div>
    @endif
</div>

<style>
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
.category-content-wrapper {
    max-width: 100%;
    margin: 0 auto;
    box-sizing: border-box;
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
    background: #f8f8f8;
    display: flex;
    align-items: center;
    justify-content: center;
}
.product-card-img-wrapper img,
.product-card-img-wrapper .no-image {
    width: 100%;
    height: 100%;
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
.recently-viewed .row {
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-start;
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
.recently-viewed img {
    background: #f8f8f8;
}
@media (max-width: 767.98px) {
    .recently-viewed .col {
        width: 100%;
        max-width: 285px;
    }
    .recently-viewed .row {
        justify-content: center;
    }
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
.static-containers .card-text {
    flex-grow: 1;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-box-orient: vertical;
}
.static-containers .col {
    flex: 1 1 300px;
    max-width: 280px;
}
@media (max-width: 768px) {
    .static-containers .col {
        margin-right: 0;
        max-width: 100%;
    }
}
.c-static-card {
    transition: all 0.3s ease-in-out;
}
.c-static-card:hover {
    box-shadow: 0px 0px 5px rgba(96, 96, 96, 0.711);
    padding: 0;
}
a:hover {
    text-decoration: underline;
    color: black;
    border: none;
}
a {
    text-decoration: none;
    border: none;
}
.product-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    border: 1px solid rgba(0,0,0,0.1);
}
.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
.product-card .card-title {
    font-size: 1.1rem;
    font-weight: 500;
    margin-bottom: 0.5rem;
}
.product-card .card-text {
    font-size: 0.9rem;
    color: #666;
}
.product-card .price {
    font-size: 1.2rem;
    font-weight: 600;
    color: #2561a8;
}
.product-card .btn-primary {
    background-color: #2561a8;
    border-color: #2561a8;
}
.product-card .btn-primary:hover {
    background-color: #1a4a8f;
    border-color: #1a4a8f;
}
.category-content-wrapper {
    max-width: 100%;
    margin: 0 auto;
    box-sizing: border-box;
}
@media (max-width: 991.98px) {
    .category-content-wrapper {
        padding: 16px 4vw;
    }
}
@media (max-width: 767.98px) {
    .category-content-wrapper {
        padding: 8px 2vw;
    }
}
</style>
<style>
    /* Desktop styles remain unchanged */

    /* Mobile Responsive Styles */
    @media (max-width: 768px) {
        .layout-category-container {
            padding: 0 10px !important;
            max-width: 100% !important;
        }
        .category-content-wrapper {
            padding: 8px 2vw !important;
        }
        .category-heading h1 {
            font-size: 24px !important;
        }
        .product-path {
            font-size: 12px !important;
            white-space: nowrap;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .row.row-cols-1.row-cols-md-4.g-4 {
            flex-direction: column !important;
        }
        .col {
            width: 100% !important;
            margin-bottom: 20px;
        }
        .card {
            margin: 0 !important;
        }
        .recently-viewed .col {
            width: 100% !important;
            max-width: 285px;
        }
        .recently-viewed .row {
            justify-content: center !important;
        }
        .need-help-section {
            padding: 10px !important;
        }
        .need-help-card {
            height: auto !important;
            min-height: 80px !important;
        }
        h5.theme-text {
            font-size: 18px !important;
        }
    }

    @media (max-width: 576px) {
        .category-heading h1 {
            font-size: 18px !important;
        }
        .category-description {
            font-size: 13px !important;
        }
        .need-help-section h2 {
            font-size: 18px !important;
        }
    }
</style>

@endsection
