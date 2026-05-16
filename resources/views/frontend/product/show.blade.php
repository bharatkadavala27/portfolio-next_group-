@extends('layouts.app')

@section('title', $product->name ?? 'Product Details')
@section('page_css')
<link href="{{ asset('assets/css/product.css') }}" rel="stylesheet">
@endsection
@section('preload')
    @if ($product->images)
        @php
            $firstImage = null;
            try {
                $imagesArray = json_decode($product->images, true, 512, JSON_THROW_ON_ERROR);
                if (is_array($imagesArray) && count($imagesArray) > 0) {
                    $firstImage = $imagesArray[0];
                }
            } catch (\JsonException $e) {
                // Handle JSON decode error gracefully
            }
        @endphp
        @if ($firstImage && !empty($firstImage))
            <link rel="preload" as="image" href="{{ asset($firstImage) }}" fetchpriority="high">
        @endif
    @endif
@endsection

@section('content')
    <main class="product-page" style="padding:0">
        <div class="container">
            <p class="product-path text-dark" style="font-size: 14px;">
                <a href="{{ url('/') }}" class="breadcrumb-link">Home</a>
                @if(request()->has('from_brand'))
                    <i class="fas fa-chevron-right mx-2"></i>
                    <a href="{{ route('brands') }}" class="breadcrumb-link">Brands</a>
                    @if(isset($product->brand))
                        <i class="fas fa-chevron-right mx-2"></i>
                        <a href="{{ route('brand.products', $product->brand->id) }}" class="breadcrumb-link">{{
                        $product->brand->name }}</a>
                    @endif
                    <i class="fas fa-chevron-right mx-2"></i>
                    <span>{{ $product->name }}</span>
                @else
                    <i class="fas fa-chevron-right mx-2"></i>
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
                @endif
            </p>

            <div class="product-container mt-4">
                <div class="row g-3" style="--bs-gutter-x: 15px;">
                    <div class="col-auto">
                        <div class="sticky-wrapper">
                            <div class="product-images bg-white p-3 rounded" style="width: 360px;" id="sticky-image">
                                @php
                                    $imagesArray = [];
                                    if ($product->images) {
                                        try {
                                            $decodedImages = json_decode($product->images, true, 512, JSON_THROW_ON_ERROR);
                                            if (is_array($decodedImages)) {
                                                // Filter out empty images
                                                $imagesArray = array_filter($decodedImages, function ($image) {
                                                    return !empty($image) && is_string($image);
                                                });
                                            }
                                        } catch (\JsonException $e) {
                                            // Handle JSON decode error gracefully
                                            $imagesArray = [];
                                        }
                                    }
                                @endphp

                                @if (!empty($imagesArray))
                                    <div class="exzoom" id="exzoom">
                                        <div class="exzoom_img_box">
                                            <ul class='exzoom_img_ul'>
                                                @foreach ($imagesArray as $image)
                                                    @php
                                                        // Normalize path
                                                        $normalizedImage = $image;
                                                        if (
                                                            stripos($image, 'uploads/products/') !== 0 && stripos(
                                                                $image,
                                                                'Uploads/products/'
                                                            ) !== 0
                                                        ) {
                                                            $normalizedImage = 'uploads/products/' . ltrim($image, '/');
                                                        }
                                                    @endphp

                                                    <li>
                                                        <img src="{{ asset($normalizedImage) }}"
                                                            alt="{{ $product->name }} image {{ $loop->iteration }}"
                                                            style="width: 340px; height: 340px; object-fit: contain;"
                                                            onerror="this.style.display='none';" />
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        @if (count($imagesArray) > 1)
                                            <div class="exzoom_nav"></div>
                                            {{-- <p class="exzoom_btn">
                                                <a href="javascript:void(0);" class="exzoom_prev_btn">
                                                    <i class="fa fa-chevron-left"></i>
                                                </a>
                                                <a href="javascript:void(0);" class="exzoom_next_btn">
                                                    <i class="fa fa-chevron-right"></i>
                                                </a>
                                            </p> --}}
                                        @endif
                                    </div>
                                @else
                                    <div class="text-center p-5 text-muted border rounded d-flex flex-column align-items-center justify-content-center"
                                        style="min-height: 340px;">
                                        <i class="fa fa-picture-o fa-3x mb-2 text-light" aria-hidden="true"></i>
                                        <p>No Image Available</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- resources/views/products/show.blade.php --}}

                    <div class="col" id="product-details">
                        <div class="bg-white p-4 rounded mb-3">
                            <h1 class="fw-bold mb-2 fs-4">{{ $product->name }}</h1>
                            @if ($product->serial_number)
                                <p class="text-muted mb-2 small fw-bold"> {{ $product->serial_number }}</p>
                            @endif

                            @if (!empty($product->short_description) && count($product->short_description) > 0)

                                <div class="description-content small mb-2">
                                    <ul class="list-unstyled">
                                        @foreach($product->short_description as $line)
                                            <li class="d-flex align-items-start mb-1">
                                                <i class="fas fa-check text-success me-2 mt-1"></i>
                                                <span>{{ $line }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                            @elseif (!empty(strip_tags($product->description ?? '')))
                                <div class="description-content small mb-2" id="descriptionContentProduct">
                                    {!! $product->description !!}
                                </div>
                                <button class="btn btn-link ps-0 small read-more-btn" type="button"
                                    data-target="descriptionContentProduct">
                                    Read More
                                </button>
                            @endif

                            <div class="d-flex flex-column flex-sm-row gap-2 mt-3">
                                <a href="https://wa.me/?text=I'm%20interested%20in%20{{ urlencode($product->name) }}"
                                    target="_blank" class="btn btn-success btn-sm flex-grow-1">
                                    <i class="fa-brands fa-whatsapp me-1"></i> WhatsApp
                                </a>
                                <a href="tel:+1234567890" class="btn btn-outline-primary btn-sm flex-grow-1">
                                    <i class="fa fa-phone me-1"></i> Call Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>



                @if ($product->documents->count() > 0)
                    <section id="documents-section-preview" class="mt-4">
                        <div>
                            <h3 class="section-title colored-text">Main Documents</h3>
                        </div>
                        <div class="w-100 main-doc" style="border: 1px solid #9d95954f; padding: 20px;">
                            <p style="font-weight: 700;">Documents</p>
                            <div class="row row-cols-1 row-cols-md-4 g-2">
                                @foreach ($product->documents->take(8) as $document)
                                    <div class="col bg-red">
                                        <div class="card h-100 document-card">
                                            <div class="card-body">
                                                {{-- @if($document->documentType)
                                                @endif --}}
                                                <div class="d-flex  flex-column gap-2 d-flex-custom btn">
                                                    @if($document->hasFile())
                                                                                <a href="{{ asset($document->file_path) }}" class="d-flex align-items-center"
                                                                                    target="_blank" download>
                                                                                    @if(
                                                                                            !empty($document->documentType) &&
                                                                                            !empty($document->documentType->image)
                                                                                        )
                                                                                        {{-- Show document type image --}}
                                                                                        <img src="{{ asset('document-types/' . $document->documentType->image) }}"
                                                                                            alt="{{ $document->document_name ?? 'Document' }}" class="me-2"
                                                                                            style="width:24px; height:24px; object-fit:contain;">
                                                                                    @else
                                                                                        {{-- Fallback file icon --}}
                                                                                        <i class="fa fa-file me-2" style="font-size:18px;"></i>
                                                                                    @endif

                                                                                    <span class="document-name">
                                                                                        {{ Str::limit($document->document_name ??
                                                        basename($document->file_path), 25) }}
                                                                                    </span>
                                                                                </a>
                                                    @endif


                                                    @if($document->hasLink())
                                                                                <a href="{{ $document->path }}" class="d-flex align-items-center"
                                                                                    target="_blank">
                                                                                    @if(!empty($document->image))
                                                                                        {{-- Show document type image --}}
                                                                                        <img src="{{ asset($document->image) }}"
                                                                                            alt="{{ $document->document_name ?? 'Document' }}" class="me-2"
                                                                                            style="width:24px; height:24px; object-fit:contain;">
                                                                                    @else
                                                                                        {{-- Fallback link icon --}}
                                                                                        <i class="fa fa-link me-2" style="font-size:18px;"></i>
                                                                                    @endif

                                                                                    <span class="document-name">
                                                                                        {{ Str::limit($document->document_name ??
                                                        basename(parse_url($document->path, PHP_URL_PATH)), 25) }}
                                                                                    </span>
                                                                                </a>
                                                    @endif

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 text-start">
                                    <a href="#documents-section" class="btn text-primary" style="padding: 0">See all
                                        documents</a>
                                </div>
                            </div>
                            @if ($product->documents->count() > 8)
                                <div class="row mt-2">
                                    <div class="col-12 text-center">
                                        <a href="#documents-section" class="btn btn-link">View All Documents</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </section>
                @endif
                <div class="container section-narrow">
                    @if (!empty(strip_tags($product->description ?? '')))
                        <hr class="section-divider mt-5 mb-4">
                        <section id="description-section">
                            <div class="row">
                                <div class="col-md-3">
                                    <h3 class="section-title colored-text">Description</h3>
                                </div>
                                <div class="col-md-9">
                                    <div class="description-content" id="descriptionSectionContentFull">
                                        {!! $product->description !!}
                                    </div>
                                    <button class="btn btn-link ps-0 small read-more-btn mt-2" type="button"
                                        data-target="descriptionSectionContentFull">
                                        Read More
                                    </button>
                                </div>
                            </div>
                        </section>
                    @endif

                    @if ($product->attributes && $product->attributes->count() > 0)
                        <hr class="section-divider mt-4 mb-4">
                        <section id="specifications-section">
                            <div class="row">
                                <div class="col-md-3">
                                    <h3 class="section-title colored-text">Specifications</h3>
                                </div>
                                <div class="col-md-9">
                                    @foreach ($product->attributes as $attribute)
                                        <div class="card mb-3 {{ !$loop->first ? 'attribute-hidden' : '' }}"
                                            style="{{ !$loop->first ? 'display: none;' : '' }}">
                                            <div style="background:#f3f2f2" class="card-header fw-normal">
                                                {{ $attribute->title ?? 'Specification' }}
                                            </div>
                                            <div class="card-body" style="padding: 0px;">
                                                @if ($attribute->shortAttributes && $attribute->shortAttributes->count() > 0)

                                                    <!-- Desktop Table View -->
                                                    <table class="table spec-table table-bordered mb-0">
                                                        <tbody class="spec-table-body">
                                                            @foreach ($attribute->shortAttributes->take(10) as $shortAttribute)
                                                                @if (!empty($shortAttribute->key))
                                                                    <tr class="spec-row">
                                                                        <td class="fw-bold w-25">{{ $shortAttribute->key }}</td>
                                                                        <td class="value" style="font-weight: normal!important;">
                                                                            @if(is_array($shortAttribute->value))
                                                                                @foreach($shortAttribute->value as $val)
                                                                                    {{ $val }} <br>
                                                                                @endforeach
                                                                            @else
                                                                                {{ $shortAttribute->value }}
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        </tbody>
                                                        <tbody class="spec-table-body-hidden" style="display: none !important;">
                                                            @foreach ($attribute->shortAttributes->skip(10) as $shortAttribute)
                                                                @if (!empty($shortAttribute->key))
                                                                    <tr class="spec-row spec-row-hidden">
                                                                        <td class="fw-bold w-25">{{ $shortAttribute->key }}</td>
                                                                        <td class="value" style="font-weight: normal!important;">
                                                                            @if(is_array($shortAttribute->value))
                                                                                @foreach($shortAttribute->value as $val)
                                                                                    {{ $val }} <br>
                                                                                @endforeach
                                                                            @else
                                                                                {{ $shortAttribute->value }}
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        </tbody>
                                                    </table>

                                                    <!-- Mobile List View -->
                                                    <div class="mobile-spec-list" style="display: none;">
                                                        @foreach ($attribute->shortAttributes->take(10) as $shortAttribute)
                                                            @if (!empty($shortAttribute->key))
                                                                <div class="mobile-spec-item">
                                                                    <div class="mobile-spec-key">{{ $shortAttribute->key }}</div>
                                                                    <div class="mobile-spec-value">
                                                                        @if(is_array($shortAttribute->value))
                                                                            @foreach($shortAttribute->value as $val)
                                                                                {{ $val }}<br>
                                                                            @endforeach
                                                                        @else
                                                                            {{ $shortAttribute->value }}
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach

                                                        @foreach ($attribute->shortAttributes->skip(10) as $shortAttribute)
                                                            @if (!empty($shortAttribute->key))
                                                                <div class="mobile-spec-item mobile-spec-hidden" style="display: none;">
                                                                    <div class="mobile-spec-key">{{ $shortAttribute->key }}</div>
                                                                    <div class="mobile-spec-value">
                                                                        @if(is_array($shortAttribute->value))
                                                                            @foreach($shortAttribute->value as $val)
                                                                                {{ $val }}<br>
                                                                            @endforeach
                                                                        @else
                                                                            {{ $shortAttribute->value }}
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>

                                                @else
                                                    <p class="text-muted mb-0"><i>No specifications available for this category.</i></p>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach

                                    @php
                                        $showGlobalSpecButton = false;
                                        if ($product->attributes && $product->attributes->count() > 1) {
                                            $showGlobalSpecButton = true;
                                        } else if ($product->attributes && $product->attributes->count() == 1) {
                                            $firstAttribute = $product->attributes->first();
                                            if ($firstAttribute->shortAttributes && $firstAttribute->shortAttributes->count() > 10) {
                                                $showGlobalSpecButton = true;
                                            }
                                        }
                                    @endphp

                                    @if ($showGlobalSpecButton)
                                        <button id="toggle-all-specs-btn" class="btn btn-link ps-0 small mt-2" type="button">
                                            Show More Specifications
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </section>
                    @endif

                    @if ($product->documents->count() > 0)
                        <hr class="section-divider mt-4 mb-4">
                        <section id="documents-section">
                            <div class="row">
                                <div class="col-md-3">
                                    <h3 class="section-title colored-text">Downloads</h3>
                                </div>
                                <div class="col-md-9">
                                    @foreach ($product->documents as $document)
                                        <div class="card mb-2 shadow-sm border border-light-subtle">
                                            <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-2 p-4"
                                                style="border: 0.6px solid #00000057;">
                                                <div class="flex-grow-1">
                                                    <h5 class="mb-1 fs-6 fw-bold">
                                                        @if($document->file_path)
                                                                                        <a href="{{ asset($document->file_path) }}" target="_blank"
                                                                                            class="text-decoration-none text-primary download border-0">
                                                                                            {{ Str::limit($document->document_name ??
                                                            basename($document->file_path), 25) }}
                                                                                        </a>
                                                        @elseif($document->path)
                                                                                        <a href="{{ $document->path }}" target="_blank"
                                                                                            class="text-decoration-none text-primary download border-0">
                                                                                            {{ Str::limit($document->document_name ??
                                                            basename(parse_url($document->path, PHP_URL_PATH)), 25) }}
                                                                                        </a>
                                                        @else
                                                            <span class="text-muted">{{ $document->document_name ?? 'No document
                                                                                                    available' }}</span>
                                                        @endif
                                                    </h5>
                                                    <p class="text-muted mb-0 small">
                                                        @php
                                                            $fileType = '';
                                                            $fileSize = null;
                                                            if ($document->file_path) {
                                                                $fileType = strtoupper(pathinfo($document->file_path, PATHINFO_EXTENSION));
                                                                if (file_exists(public_path($document->file_path))) {
                                                                    $bytes = filesize(public_path($document->file_path));
                                                                    $fileSize = $bytes >= 1048576
                                                                        ? number_format($bytes / 1048576, 1) . ' MB'
                                                                        : number_format($bytes / 1024, 1) . ' KB';
                                                                }
                                                            } elseif ($document->path) {
                                                                $fileType = $document->type ??
                                                                    strtoupper(pathinfo(
                                                                        parse_url($document->path, PHP_URL_PATH),
                                                                        PATHINFO_EXTENSION
                                                                    )) ?? 'LINK';
                                                            }
                                                        @endphp

                                                        @if(
                                                                !empty($document->documentType) &&
                                                                !empty($document->documentType->image)
                                                            )
                                                            {{-- Show document type image --}}
                                                            <img src="{{ asset('document-types/' . $document->documentType->image) }}"
                                                                alt="{{ $document->document_name ?? 'Document' }}" class="me-2"
                                                                style="width:24px; height:24px; object-fit:contain;">
                                                        @else
                                                            {{-- Fallback file icon --}}
                                                            <i class="fa fa-file me-2" style="font-size:18px;"></i>
                                                        @endif
                                                        {{-- <i
                                                            class="fa {{ $fileType == 'PDF' ? 'fa-file-pdf-o' : ($document->path ? 'fa-external-link' : 'fa-file-o') }} me-1"></i>
                                                        --}}
                                                        {{ $fileType }}@if($fileSize) ({{ $fileSize }})@endif |
                                                        Added: {{ optional($document->created_at)->format('d M Y') }}
                                                    </p>
                                                </div>

                                                @if($document->file_path)
                                                    <a href="{{ asset($document->file_path) }}" target="_blank"
                                                        class="btn btn-sm btn-outline-primary download">
                                                        <i class="fa fa-download me-1"></i> Download
                                                    </a>
                                                @elseif($document->path)
                                                    <a href="{{ $document->path }}" target="_blank"
                                                        class="btn btn-sm btn-outline-secondary download">
                                                        <i class="fa fa-external-link me-1"></i> Open Link
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </section>
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
{{-- Corrected JavaScript Block --}}
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize ExZoom Image Gallery
            const exzoomElement = document.getElementById('exzoom');
            if (exzoomElement && typeof $ !== 'undefined' && $.fn.exzoom) {
                try {
                    $("#exzoom").exzoom({
                        navWidth: 60,
                        navHeight: 60,
                        navItemNum: 5,
                        navItemMargin: 7,
                        navBorder: 1,
                        autoPlay: false,
                        previewWidth: $('#sticky-image').width() - (2 * parseFloat($('#sticky-image').css('padding-left'))),
                        previewHeight: 340
                    });
                } catch (e) {
                    console.error("Error initializing exzoom:", e);
                }
            }

            // Handle Description Read More/Read Less
            document.querySelectorAll('.description-content').forEach(content => {
                const readMoreBtn = content.nextElementSibling;
                if (!readMoreBtn || !readMoreBtn.classList.contains('read-more-btn') || readMoreBtn.dataset.target !== content.id) {
                    return;
                }
                const computedStyle = getComputedStyle(content);
                const lineHeight = parseFloat(computedStyle.lineHeight) || 20;

                // Set the maximum number of lines to show when collapsed
                const maxLines = 8;
                const collapsedMaxHeight = maxLines * lineHeight;

                // Temporarily remove truncation to measure full height
                const originalStyles = {
                    maxHeight: content.style.maxHeight,
                    webkitLineClamp: content.style.webkitLineClamp,
                    display: content.style.display,
                    overflow: content.style.overflow,
                    webkitBoxOrient: content.style.webkitBoxOrient
                };
                content.style.maxHeight = 'none';
                content.style.webkitLineClamp = 'unset';
                content.style.display = 'block';
                content.style.overflow = 'visible';
                content.style.webkitBoxOrient = 'auto';
                const actualScrollHeight = content.scrollHeight;
                Object.assign(content.style, originalStyles);

                // If content is taller than collapsed height, enable "Read More"
                if (actualScrollHeight > collapsedMaxHeight + (lineHeight * 0.5)) {
                    content.style.maxHeight = collapsedMaxHeight + 'px';
                    content.style.overflow = 'hidden';
                    content.style.display = '-webkit-box';
                    content.style.webkitBoxOrient = 'vertical';
                    content.style.webkitLineClamp = String(maxLines);
                    readMoreBtn.textContent = 'Read More';
                    readMoreBtn.style.display = 'block';

                    readMoreBtn.addEventListener('click', function (e) {
                        e.preventDefault();
                        if (content.classList.contains('expanded')) {
                            // Collapse
                            content.classList.remove('expanded');
                            content.style.maxHeight = collapsedMaxHeight + 'px';
                            content.style.overflow = 'hidden';
                            content.style.display = '-webkit-box';
                            content.style.webkitLineClamp = String(maxLines);
                            this.textContent = 'Read More';
                        } else {
                            // Expand
                            content.classList.add('expanded');
                            content.style.maxHeight = actualScrollHeight + 'px';
                            content.style.overflow = 'visible';
                            content.style.display = 'block';
                            content.style.webkitLineClamp = 'unset';
                            content.style.webkitBoxOrient = 'auto';
                            this.textContent = 'Read Less';
                        }
                    });
                } else {
                    // Content is short enough; no need for a button
                    readMoreBtn.style.display = 'none';
                    content.style.maxHeight = 'none';
                    content.style.webkitLineClamp = 'unset';
                    content.style.display = originalStyles.display || 'block';
                    content.style.overflow = originalStyles.overflow || 'visible';
                    content.style.webkitBoxOrient = 'auto';
                }
            });

            // Handle Specifications Read More/Read Less
            const toggleAllSpecsBtn = document.getElementById('toggle-all-specs-btn');
            if (toggleAllSpecsBtn) {
                let allSpecsAreExpanded = false;
                toggleAllSpecsBtn.addEventListener('click', function () {
                    allSpecsAreExpanded = !allSpecsAreExpanded;
                    document.querySelectorAll('.attribute-hidden').forEach(attr => {
                        attr.style.display = allSpecsAreExpanded ? 'block' : 'none';
                    });
                    document.querySelectorAll('.spec-table-body-hidden').forEach(hiddenBody => {
                        hiddenBody.style.display = allSpecsAreExpanded ? 'table-row-group' : 'none';
                        hiddenBody.querySelectorAll('.spec-row').forEach(row => {
                            row.classList.toggle('spec-row-hidden', !allSpecsAreExpanded);
                        });
                    });
                    document.querySelectorAll('.mobile-spec-hidden').forEach(hiddenItem => {
                        hiddenItem.style.display = allSpecsAreExpanded ? 'block' : 'none';
                    });
                    this.textContent = allSpecsAreExpanded ? 'Show Less Specifications' : 'Show More Specifications';
                });
            }
        });
    </script>

    <style>
        /* Target the preview pane inside the exzoom element */
        .exzoom .exzoom_preview {
            width: 792px !important;
            height: 328px !important;
            left: 333px !important;
            position: absolute;
        }

        .exzoom .exzoom_preview_img {
            max-width: 100% !important;
            max-height: 100% !important;
        }


        .container {
            max-width: 1200px;
            padding-left: 30px;
            padding-right: 30px;
        }

        .exzoom_preview_img {
            width: 1540px !important;
            height: 1030px !important;
        }

        /* ExZoom Gallery Styles */
        .exzoom .exzoom_img_box {
            background: #ffffff;
            position: relative;
        }

        .fa-chevron-right {
            font-size: 10px;
            color: #6c757d;
            vertical-align: middle;
            margin-top: -2px;
        }

        /* Specification Table Styles */
        .spec-table {
            border-left: none !important;
            border-right: none !important;
            border-collapse: collapse;
        }

        .spec-table th,
        .spec-table td {
            border-left: none !important;
            border-right: none !important;
        }

        .spec-table .value {
            font-weight: normal !important;
        }

        .spec-table-body-hidden {
            display: none !important;
        }

        .spec-row-hidden {
            display: none !important;
        }

        .spec-table-body-hidden[style*="table-row-group"] {
            display: table-row-group !important;
        }

        /* Card Styles */
        .card {
            border: none !important;
        }

        .card-header {
            border: none !important;
        }

        /* General Styles */
        .colored-text {
            color: #2561a8;
        }

        /* Breadcrumb Styles */
        .breadcrumb-link {
            color: inherit;
            text-decoration: none !important;
            border-bottom: none !important;
            transition: color 0.2s;
            font-size: 14px;
        }

        .breadcrumb-link:hover {
            color: inherit !important;
            text-decoration: none !important;
            border-bottom: none !important;
        }

        /* Description Styles */
        .description-content {
            transition: max-height 0.35s ease-in-out;
            color: #171717;
            font-weight: 500;
            text-align: justify;
        }

        .read-more-btn {
            display: none;
            text-decoration: none !important;
        }

        .read-more-btn:hover {
            text-decoration: underline !important;
        }

        /* ExZoom Specific Styles */
        .exzoom_img_ul_outer {
            border: none !important;
        }

        .exzoom_img_box {
            width: 340px !important;
            height: 340px !important;
        }

        .exzoom_img_box ul.exzoom_img_ul li img {
            max-width: 100%;
            object-fit: contain;
        }

        /* Thumbnail Navigation Styles */
        .exzoom .exzoom_nav .exzoom_nav_inner span.current {
            border: 1px solid #2561a8 !important;
        }

        /* Navigation Button Styles */
        .exzoom p.exzoom_btn a.exzoom_prev_btn,
        .exzoom p.exzoom_btn a.exzoom_next_btn {
            border: 1px solid #2561a8;
            background: #ffffff;
            color: #2561a8;
            opacity: 1;
            box-sizing: border-box;
        }

        /* Thumbnail Image Styles */
        .exzoom .exzoom_nav .exzoom_nav_inner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Document Card Styles */
        .document-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .document-card:hover {
            transform: translateY(0px);
            box-shadow: none;
        }

        .document-card .card-body {
            padding: 0px;
        }

        .document-card .card-subtitle {
            color: #2561a8;
            font-size: 0.9rem;
            margin-bottom: 0.75rem;
        }

        /* Download Link Styles */
        .download:hover {
            text-decoration: none !important;
        }

        a.download.btn:hover {
            text-decoration: none !important;
        }

        .document-card .btn-sm {
            padding: 0px;
            font-size: 0.875rem;
        }

        .main-doc>p {
            margin-top: 0;
            margin-bottom: 10px !important;
        }

        /* Section Container */
        .section-narrow {
            width: 90%;
            margin-left: 0;
        }

        .d-flex-custom {
            justify-content: start;
            align-items: flex-start;
        }

        .btn>a {
            text-decoration: none !important;
            border: none !important;
            background: none !important;
            padding: 0 !important;
            color: inherit !important;
        }

        .btn a:hover {
            text-decoration: none !important;
        }

        /* 
                    .btn {
                        margin: 0 !important;
                        padding: 0 !important;
                    } */


        .card-body>.btn:hover {
            background-color: rgb(255, 255, 255);
            color: rgb(0, 0, 0) !important;
            transform: translateY(0px);
            box-shadow: none;
        }

        .text-start>.btn:hover {
            background-color: rgb(255, 255, 255);
            color: rgb(0, 0, 0) !important;
            transform: translateY(0px);
            box-shadow: none;

            a:hover {
                border-bottom: none;
            }

            /* Global rule: remove underline/border from all links on hover */


            /* Keep underline (border-bottom) ONLY for text links with .download class */
            a.download:hover {
                border-bottom: 1px solid #0d6efd;
                !important;
            }


            /* Mobile Responsive Styles for Specifications */
            @media (max-width: 768px) {
                .container {
                    padding-left: 10px;
                    padding-right: 10px;
                }

                /* Hide table on mobile */
                .spec-table {
                    display: none !important;
                }

                /* Show mobile version */
                .mobile-spec-list {
                    display: block !important;
                }

                .mobile-spec-item {
                    padding: 12px 16px;
                    border-bottom: 1px solid #e9ecef;
                }

                .mobile-spec-item:last-child {
                    border-bottom: none;
                }

                .mobile-spec-key {
                    font-weight: 600;
                    color: #495057;
                    font-size: 0.9rem;
                    margin-bottom: 4px;
                }

                .mobile-spec-value {
                    color: #6c757d;
                    font-size: 0.85rem;
                    line-height: 1.4;
                }

                .card-header {
                    padding: 12px 16px;
                    font-size: 1rem;
                    font-weight: 600;
                }

                /* Mobile product image adjustments */
                .product-images {
                    width: 100% !important;
                    max-width: 100% !important;
                }

                .exzoom_img_box {
                    width: 100% !important;
                    height: 280px !important;
                }

                .exzoom_img_box ul.exzoom_img_ul li img {
                    width: 100% !important;
                    height: 280px !important;
                }

                /* Mobile layout adjustments */
                .product-container .row {
                    flex-direction: column;
                }

                .col-auto {
                    width: 100%;
                }

                .sticky-wrapper {
                    position: relative !important;
                }

                /* Mobile section adjustments */
                .section-narrow {
                    width: 100%;
                }

                .row>.col-md-3,
                .row>.col-md-9 {
                    width: 100%;
                }

                .col-md-3 {
                    margin-bottom: 1rem;
                }

                /* Mobile document cards */
                .document-card .card-body {
                    flex-direction: column;
                    align-items: flex-start !important;
                }

                .document-card .btn {
                    margin-top: 10px;
                    align-self: flex-start;
                }
            }

            /* Desktop - hide mobile version */
            @media (min-width: 769px) {
                .mobile-spec-list {
                    display: none !important;
                }
            }

            .document-name {
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                flex-grow: 1;
                min-width: 0;
            }
    </style>
@endpush