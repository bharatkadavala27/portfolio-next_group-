@extends('layouts.admin')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Edit Product</h2>
        <form id="product-form" action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="card-title">Product Details</h4>
                </div>
                <div class="card-body">
                    <!-- Product Name -->
                    <div class="form-group mb-4">
                        <label for="name">Product Name</label>
                        <input type="text" name="name" id="name" class="form-control"
                            value="{{ old('name', $product->name) }}" >
                        <small class="text-danger d-none" id="nameError">Product name required</small>
                    </div>

                    <!-- Product Price -->
                    <div class="form-group mb-4">
                        <label for="price">Price</label>
                        <input type="number" name="price" id="price" class="form-control"
                            value="{{ old('price', $product->price) }}">
                    </div>

                    <!-- Category -->
                    <div class="form-group mb-4">
                        <label for="category_id">Category</label>
                        <select name="category_id" id="category_id" class="form-control" >
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    @if((int)$product->category_id === (int)$category->id) selected @endif>
                                    {{ $category->name }}
                                </option>
                                @if ($category->children)
                                    @foreach ($category->children as $childCategory)
                                        @include('admin.product.partials.category-options', [
                                            'category' => $childCategory,
                                            'level' => 1,
                                        ])
                                    @endforeach
                                @endif
                            @endforeach
                        </select>
                        <small class="text-danger d-none" id="categoryError">Category required</small>
                    </div>

                    <!-- Brand -->
                    <div class="form-group mb-4">
                        <label for="brand_id">Brand</label>
                        <select name="brand_id" id="brand_id" class="form-control">
                            <option value="">Select Brand</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}"
                                    @if((int)$product->brand_id === (int)$brand->id) selected @endif>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-danger d-none" id="brandError">Brand required</small>
                    </div>

                    <!-- Filters -->
                    <div class="form-group mb-4">
                        <label class="form-label">Filters</label>
                        <div id="filters-container">
                        @php
                            $existingFilterOptions = $product->filters->pluck('id')->toArray();
                            $oldFilters = old('filter_id', []);
                            $oldOptions = old('filter_option_id', $existingFilterOptions);
                            
                            if (is_array($oldOptions) && count($oldOptions) > 0) {
                                // Build filter_id array from options
                                if (empty($oldFilters)) {
                                    $oldFilters = [];
                                    foreach ($oldOptions as $optId) {
                                        $option = \App\Models\FilterOption::find($optId);
                                        if ($option) {
                                            $oldFilters[] = $option->filter_id;
                                        }
                                    }
                                }
                            } else {
                                $oldFilters = [''];
                                $oldOptions = [''];
                            }
                        @endphp

                        @foreach ($oldFilters as $i => $oldFilterValue)
                            <div class="filter-pair mb-2 d-flex align-items-start" data-index="{{ $i }}">
                                <select name="filter_id[]" class="form-control me-2 filter-select">
                                    <option value="">Select Filter</option>
                                    @foreach ($filters as $filter)
                                        <option value="{{ $filter->id }}" {{ $oldFilterValue == $filter->id ? 'selected' : '' }}>
                                            {{ $filter->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <select name="filter_option_id[]" class="form-control me-2 filter-option-select">
                                    <option value="">Select Option</option>
                                    @if(!empty($oldOptions[$i]))
                                        @php
                                            $selectedFilter = $filters->firstWhere('id', $oldFilterValue);
                                        @endphp
                                        @if($selectedFilter && $selectedFilter->options)
                                            @foreach($selectedFilter->options as $opt)
                                                <option value="{{ $opt->id }}" {{ $oldOptions[$i] == $opt->id ? 'selected' : '' }}>{{ $opt->name }}</option>
                                            @endforeach
                                        @endif
                                    @endif
                                </select>

                                <button type="button" class="btn btn-success btn-add me-1" title="Add">+</button>
                                <button type="button" class="btn btn-danger btn-remove" title="Remove">−</button>
                            </div>
                        @endforeach
                        </div>
                    </div>
<!-- Short Description -->
<!-- Short Description -->
<div class="mb-3">
    <label class="form-label">Short Descriptions</label>

    <div id="short-description-wrapper">
        @php
            $shortDescriptions = old('short_description', $product->short_description ?? []);
            if (!is_array($shortDescriptions)) {
                $shortDescriptions = json_decode($shortDescriptions, true) ?? [];
            }
        @endphp

        @forelse($shortDescriptions as $desc)
            <div class="input-group mb-2 short-description-item">
                <input type="text" name="short_description[]" class="form-control"
                       value="{{ $desc }}" placeholder="Enter short description">
                <button type="button" class="btn btn-danger remove-short-desc">−</button>
            </div>
        @empty
            <div class="input-group mb-2 short-description-item">
                <input type="text" name="short_description[]" class="form-control"
                       placeholder="Enter short description">
                <button type="button" class="btn btn-danger remove-short-desc">−</button>
            </div>
        @endforelse
    </div>

    <!-- Add button aligned right -->
    <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-primary" id="add-short-desc">+ Add</button>
    </div>

    @error('short_description')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    let wrapper = document.getElementById("short-description-wrapper");
    let addBtn = document.getElementById("add-short-desc");

    // Add new field
    addBtn.addEventListener("click", function () {
        let div = document.createElement("div");
        div.classList.add("input-group", "mb-2", "short-description-item");

        div.innerHTML = `
            <input type="text" name="short_description[]" class="form-control" placeholder="Enter short description">
            <button type="button" class="btn btn-danger remove-short-desc">−</button>
        `;

        wrapper.appendChild(div);
    });

    // Remove field
    wrapper.addEventListener("click", function (e) {
        if (e.target.classList.contains("remove-short-desc")) {
            e.target.closest(".short-description-item").remove();
        }
    });
});
</script>
@endpush





                    <!-- Description -->
                    <div class="form-group mb-4">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <!-- Serial Number -->
                    <div class="form-group mb-4">
                        <label for="serial_number">Model Number</label>
                        <div class="position-relative">
                            <input type="text" name="serial_number" id="serial_number" class="form-control"
                                value="{{ old('serial_number', $product->serial_number) }}" autocomplete="off">
                            <small class="text-danger d-none" id="serialError"></small>
                            <div id="takenSerialsDropdown" class="taken-serials-dropdown shadow-sm" style="display: none;">
                                <h6 class="dropdown-header text-muted border-bottom mb-2 pb-2" style="font-size: 0.85rem;">Taken Serial Numbers</h6>
                                <div id="takenSerialsContent" class="list-group list-group-flush"></div>
                            </div>
                        </div>
                        <style>
                            .taken-serials-dropdown {
                                position: absolute;
                                top: 100%;
                                left: 0;
                                right: 0;
                                z-index: 1050;
                                background: #fff;
                                border: 1px solid #ddd;
                                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                                border-radius: 4px;
                                padding: 10px;
                                max-height: 250px;
                                overflow-y: auto;
                                margin-top: 5px;
                            }
                        </style>
                    </div>

                    <!-- Product Images -->
                    <div class="form-group mb-4">
                        <label for="images">Product Images</label>
                        <input type="file" id="product-images" name="images[]" class="form-control" accept="image/*" multiple>

                        {{-- Show temporary files from previous upload attempt --}}
                        @if(session()->has('temp_files.images'))
                            <div class="mt-3">
                                <h5>Previously Selected Images</h5>
                                <div class="d-flex flex-wrap">
                                    @foreach(session('temp_files.images') as $index => $image)
                                        @php
                                            $imageData = null;
                                            $mimeType = 'image/png';
                                            try {
                                                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($image)) {
                                                    $contents = \Illuminate\Support\Facades\Storage::disk('public')->get($image);
                                                    $imageData = base64_encode($contents);
                                                    $mimeType = \Illuminate\Support\Facades\Storage::disk('public')->mimeType($image) ?: $mimeType;
                                                }
                                            } catch (\Exception $ex) {
                                                $imageData = null;
                                            }
                                        @endphp

                                        <div class="position-relative me-2 mb-2">
                                            @if ($imageData)
                                                <img src="data:{{ $mimeType }};base64,{{ $imageData }}" alt="Temporary Image"
                                                     class="img-thumbnail" width="100" height="100">
                                            @else
                                                <div class="img-thumbnail d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                                                    <span class="text-muted">Image</span>
                                                </div>
                                            @endif
                                            <input type="hidden" name="temp_images[]" value="{{ $image }}">
                                        </div>
                                    @endforeach

                                </div>
                        @endif

                        

                        {{-- Show existing images --}}
      {{-- Existing images --}}
@php
    // Get images as array
    $storedImages = $product->images ?? [];
    if (!is_array($storedImages)) {
        $storedImages = json_decode($storedImages, true) ?: [];
    }
@endphp

@if (count($storedImages) > 0)
    <div class="mt-3">
        <h5>Existing Images <small class="text-muted">(Drag to reorder)</small></h5>
        <div id="sortable-images" class="d-flex flex-wrap border rounded p-3" style="min-height: 150px; background: #f9f9f9;">
            @foreach ($storedImages as $index => $stored)
                @php
                    $imgUrl = $product->resolveImageUrl($stored);
                    $basename = basename(parse_url($imgUrl, PHP_URL_PATH));
                @endphp
                <div class="sortable-image me-3 mb-3 position-relative" draggable="true" data-filename="{{ $basename }}" data-index="{{ $index }}" style="cursor: grab; user-select: none;">
                    <img src="{{ $imgUrl }}"
                         alt="Product Image"
                         class="img-thumbnail"
                         width="100" height="100"
                         style="pointer-events: none;">
                    <div class="position-absolute top-0 start-0 p-1">
                        <button type="button" class="btn btn-info btn-sm text-white" style="width: 20px; height: 20px; line-height: 1; padding: 0;" onclick="replaceExistingImage(this, {{ $index }})" title="Replace Image">↻</button>
                    </div>
                    <div class="position-absolute top-0 end-0 d-flex gap-1">
                        <button type="button" class="btn btn-danger btn-sm" onclick="removeImage('{{ $basename }}', {{ $product->id }})">×</button>
                    </div>
                    <div class="position-absolute bottom-0 start-50 translate-middle-x bg-dark text-white px-2 py-1 rounded" style="font-size: 0.75rem; opacity: 0.8;">{{ $index + 1 }}</div>
                </div>
            @endforeach
        </div>
        <!-- Hidden inputs to store order -->
        <div id="image-order-container" style="display:none;">
            @foreach ($storedImages as $stored)
                @php
                    $imgUrl = $product->resolveImageUrl($stored);
                    $basename = basename(parse_url($imgUrl, PHP_URL_PATH));
                @endphp
                <input type="hidden" name="image_order[]" value="{{ $basename }}">
            @endforeach
        </div>
    </div>
@endif


            <!-- Drag & Drop Image Sequence Script -->
            <script>
            (function() {
                function initSortable() {
                    const container = document.getElementById('sortable-images');
                    if (!container) return;

                    let draggedElement = null;

                    function handleDragStart(e) {
                        draggedElement = this;
                        this.style.opacity = '0.5';
                        e.dataTransfer.effectAllowed = 'move';
                        e.dataTransfer.setData('text/html', this.innerHTML);
                    }

                    function handleDragEnd(e) {
                        if (draggedElement) draggedElement.style.opacity = '1';
                        document.querySelectorAll('.sortable-image').forEach(el => {
                            el.style.borderTop = '';
                            el.style.borderLeft = '';
                        });
                    }

                    function handleDragOver(e) {
                        if (e.preventDefault) e.preventDefault();
                        e.dataTransfer.dropEffect = 'move';
                        return false;
                    }

                    function handleDragEnter(e) {
                        if (this !== draggedElement) {
                            this.style.borderTop = '3px solid #0d6efd';
                        }
                    }

                    function handleDragLeave(e) {
                        this.style.borderTop = '';
                    }

                    function handleDrop(e) {
                        if (e.stopPropagation) e.stopPropagation();
                        if (this !== draggedElement) {
                            // Swap elements
                            const allImages = Array.from(container.querySelectorAll('.sortable-image'));
                            const draggedIndex = allImages.indexOf(draggedElement);
                            const targetIndex = allImages.indexOf(this);
                            
                            if (draggedIndex < targetIndex) {
                                this.parentNode.insertBefore(draggedElement, this.nextSibling);
                            } else {
                                this.parentNode.insertBefore(draggedElement, this);
                            }
                            
                            updateImageOrder();
                        }
                        return false;
                    }

                    window.updateImageOrder = function() {

                        const orderContainer = document.getElementById('image-order-container');
                        orderContainer.innerHTML = '';
                        
                        let index = 1;
                        container.querySelectorAll('.sortable-image').forEach(item => {
                            const filename = item.dataset.filename;
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'image_order[]';
                            input.value = filename;
                            orderContainer.appendChild(input);
                            
                            // Update index badge
                            const badge = item.querySelector('div[style*="bottom"]');
                            if (badge) badge.textContent = index;
                            index++;
                        });
                    }

                    // Attach drag listeners
                    container.querySelectorAll('.sortable-image').forEach(item => {
                        item.addEventListener('dragstart', handleDragStart);
                        item.addEventListener('dragend', handleDragEnd);
                        item.addEventListener('dragover', handleDragOver);
                        item.addEventListener('dragenter', handleDragEnter);
                        item.addEventListener('dragleave', handleDragLeave);
                        item.addEventListener('drop', handleDrop);
                    });

                    // Ensure order is saved before form submission
                    const form = document.querySelector('form');
                    if (form) {
                        form.addEventListener('submit', function(e) {
                            updateImageOrder();
                            console.log('✓ Image order updated before submit');
                        });
                    }
                    
                    console.log('✓ Sortable images initialized');
                }
                // Initialize Sortable
                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', initSortable);
                } else {
                    initSortable();
                }
            })();

            // Global logic for image replacement
            let layoutUploadedFiles = []; 
            const editForm = document.getElementById('product-form');
            const editImageInput = document.getElementById('product-images');
            
            if (editForm && editImageInput) {
                 editForm.addEventListener('submit', function(e) {
                    if (layoutUploadedFiles.length > 0) {
                        const dt = new DataTransfer();
                        const existingFiles = (editImageInput.files) ? Array.from(editImageInput.files) : [];
                        existingFiles.forEach(f => dt.items.add(f));
                        layoutUploadedFiles.forEach(f => dt.items.add(f));
                        editImageInput.files = dt.files;
                    }
                 });
            }

            window.replaceExistingImage = function(btn, index) {
                const container = btn.closest('.sortable-image'); 
                const imgTag = container.querySelector('img');
                
                const input = document.createElement('input');
                input.type = 'file';
                input.accept = 'image/*';
                
                input.onchange = function(e) {
                    if (this.files && this.files[0]) {
                        const file = this.files[0];
                        
                        // Update Preview
                        const reader = new FileReader();
                        reader.onload = function(evt) {
                            imgTag.src = evt.target.result;
                        };
                        reader.readAsDataURL(file);
                        
                        // Update Data Attribute so Sortable logic picks up the new name
                        container.dataset.filename = file.name;
                        
                        // Add to upload queue
                        layoutUploadedFiles.push(file);
                        
                        // Update the hidden inputs for order immediately
                        if (typeof window.updateImageOrder === 'function') {
                            window.updateImageOrder();
                        }
                    }
                };
                input.click();
            };

            </script>
            <script>
            // Serial Validation Logic (moved from global script block to prevent scope issues)
            </script>
            </script>

            {{-- Product Documents --}}
            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="card-title">Documents</h4>
                </div>
                <div class="card-body">
                    <div id="documents-container" class="mb-4">
                        {{-- Show temporary documents from previous upload attempt --}}
                        @if(session()->has('temp_files.documents'))
                            @foreach(session('temp_files.documents') as $index => $tempDoc)
                                <div class="document mb-3" id="document-temp-{{ $index }}">
                                    <label for="documents[{{ $index }}][type]" class="form-label">Type</label>
                                    <select name="documents[{{ $index }}][type]" class="form-control">
                                        <option value="">Select Document Type</option>
                                        @foreach ($documentTypes as $documentType)
                                            <option value="{{ $documentType->id }}"
                                                {{ old('documents.'.$index.'.type', $tempDoc['type']) == $documentType->id ? 'selected' : '' }}>
                                                {{ $documentType->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <label for="documents[{{ $index }}][file_path]" class="form-label">File</label>
                                    <input type="file" name="documents[{{ $index }}][file_path]" class="form-control">
                                    <input type="hidden" name="temp_documents[{{ $index }}]" value="{{ $tempDoc['file_path'] }}">

                                    <div class="form-group mt-2">
                                        <label for="documents[{{ $index }}][path]">File Link (Optional)</label>
                                        <input type="text" name="documents[{{ $index }}][path]" class="form-control"
                                            value="{{ old('documents.'.$index.'.path', $tempDoc['path']) }}" placeholder="Enter file URL if not uploading directly">
                                    </div>

                                    <div class="mt-2">
                                        <h6>Previously Selected File:</h6>
                                        <a href="{{ asset('storage/'.$tempDoc['file_path']) }}" target="_blank" class="btn btn-sm btn-info">View Document</a>
                                    </div>

                                    <button type="button" class="btn btn-danger remove-document mt-3">Remove</button>
                                </div>
                            @endforeach
                        @endif

                        {{-- Existing documents --}}
                        @if ($product->documents->count() > 0)
                            @foreach ($product->documents as $index => $document)
                                <div class="document mb-3" id="document-{{ $index }}">
                                    <input type="hidden" name="documents[{{ $index }}][id]" value="{{ $document->id }}">
                                    <div class="form-group mb-3">
                                        <label for="documents[{{ $index }}][document_name]" class="form-label">Document Name</label>
                                        <input type="text" name="documents[{{ $index }}][document_name]" class="form-control" value="{{ old('documents.' . $index . '.document_name', $document->document_name ?? '') }}" placeholder="Enter document name">
                                    </div>
                                    <label for="documents[{{ $index }}][type]" class="form-label">Type</label>
                                    <select name="documents[{{ $index }}][type]" class="form-control" >
                                        <option value="">Select Document Type</option>
                                        @foreach ($documentTypes as $documentType)
                                            <option value="{{ $documentType->id }}"
                                                {{ old('documents.' . $index . '.type', $document->type) == $documentType->id ? 'selected' : '' }}>
                                                {{ $documentType->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="documents[{{ $index }}][file_path]" class="form-label">File</label>
                                    <input type="file" name="documents[{{ $index }}][file_path]" class="form-control">
                                    <div class="form-group mt-2">
                                        <label for="documents[{{ $index }}][path]">File Link (Optional)</label>
                                        <input type="text" name="documents[{{ $index }}][path]" class="form-control"
                                            id="documents_{{ $index }}_path"
                                            value="{{ old('documents.' . $index . '.path', $document->path ?? '') }}" placeholder="Enter file URL if not uploading directly">
                                    </div>
                                    @if ($document->file_path)
                                        <div class="mt-2">
                                            <h5>Existing Document:</h5>
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="text-muted">{{ basename($document->file_path) }}</span>
                                                <a href="{{ asset('/' . $document->file_path) }}" target="_blank" class="btn btn-info btn-sm">View</a>
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="removeFile('{{ $document->file_path }}', {{ $product->id }}, {{ $document->id }})">Remove</button>
                                            </div>
                                        </div>
                                    @endif
                                    <button type="button" class="btn btn-danger remove-document mt-3">Remove</button>
                                </div>
                            @endforeach
                        @else
                            <div class="document mb-3" id="document-0">
                                <div class="form-group mb-3">
                                    <label for="documents[0][document_name]" class="form-label">Document Name</label>
                                    <input type="text" name="documents[0][document_name]" class="form-control" placeholder="Enter document name" value="{{ old('documents.0.document_name') }}">
                                </div>
                                <label for="documents[0][type]" class="form-label">Type</label>
                                <select name="documents[0][type]" class="form-control" >
                                    <option value="">Select Document Type</option>
                                    @foreach ($documentTypes as $documentType)
                                        <option value="{{ $documentType->id }}"
                                            {{ old('documents.0.type') == $documentType->id ? 'selected' : '' }}>
                                            {{ $documentType->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="documents[0][file_path]" class="form-label">File</label>
                                <input type="file" name="documents[0][file_path]" class="form-control">
                                <div class="form-group mt-2">
                                    <label for="documents[0][path]">File Link (Optional)</label>
                                    <input type="text" name="documents[0][path]" class="form-control"
                                        id="documents_0_path" value="{{ old('documents.0.path') }}" placeholder="Enter file URL if not uploading directly">
                                </div>
                                <button type="button" class="btn btn-danger remove-document mt-3">Remove</button>
                            </div>
                        @endif
                    </div>
                    <button type="button" class="btn btn-success btn-sm text-white float-end" id="add-document">+ Add Document</button>
                </div>
            </div>

            {{-- Attributes --}}
            <div class="container mt-5">
                <h3 class="mb-4">Attributes</h3>
                <div id="attributes" class="mb-4">
                    @php
                        $oldAttributes = old('attributes', $product->attributes->map(function($attr) {
                            return [
                                'id' => $attr->id,
                                'title' => $attr->title,
                                'short_attributes' => $attr->shortAttributes->map(function($short) {
                                    return [
                                        'id' => $short->id,
                                        'key' => $short->key,
                                        'values' => explode(',', $short->getRawOriginal('value'))
                                    ];
                                })->toArray()
                            ];
                        })->toArray());
                    @endphp

                    @if (count($oldAttributes) > 0)
                        @foreach($oldAttributes as $index => $attribute)
                            <div class="card attribute-row mb-3">
                                <div class="card-body">
                                    @if(isset($attribute['id']))
                                        <input type="hidden" name="attributes[{{ $index }}][id]" value="{{ $attribute['id'] }}">
                                    @endif
                                    <h5 class="card-title">Attribute {{ $index + 1 }}</h5>
                                    <input type="text" name="attributes[{{ $index }}][title]"
                                        class="form-control mb-2" placeholder="Attribute Title"
                                        value="{{ $attribute['title'] ?? '' }}">

                                    <div class="card p-3 mb-3">
                                        <h6>Short Attributes</h6>
                                        <div class="short-attributes-container">
                                            @if(isset($attribute['short_attributes']) && is_array($attribute['short_attributes']))
                                                @foreach($attribute['short_attributes'] as $shortIndex => $shortAttribute)
                                                    <div class="row short-attribute-row mb-2">
                                                        @if(isset($shortAttribute['id']))
                                                            <input type="hidden"
                                                                name="attributes[{{ $index }}][short_attributes][{{ $shortIndex }}][id]"
                                                                value="{{ $shortAttribute['id'] }}">
                                                        @endif
                                                        <div class="col-md-4">
                                                            <input type="text"
                                                                name="attributes[{{ $index }}][short_attributes][{{ $shortIndex }}][key]"
                                                                class="form-control" placeholder="Key"
                                                                value="{{ $shortAttribute['key'] ?? '' }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="values-container">
                                                                @if(isset($shortAttribute['values']) && is_array($shortAttribute['values']))
                                                                    @foreach($shortAttribute['values'] as $valueIndex => $value)
                                                                        <div class="d-flex mb-2">
                                                                            <input type="text"
                                                                                name="attributes[{{ $index }}][short_attributes][{{ $shortIndex }}][values][]"
                                                                                class="form-control me-2" placeholder="Value"
                                                                                value="{{ $value }}">
                                                                            @if($valueIndex === 0)
                                                                                <button type="button" class="btn btn-sm btn-primary add-value">+</button>
                                                                            @else
                                                                                <button type="button" class="btn btn-sm btn-danger remove-value">-</button>
                                                                            @endif
                                                                        </div>
                                                                    @endforeach
                                                                @else
                                                                    <div class="d-flex mb-2">
                                                                        <input type="text"
                                                                            name="attributes[{{ $index }}][short_attributes][{{ $shortIndex }}][values][]"
                                                                            class="form-control me-2" placeholder="Value">
                                                                        <button type="button" class="btn btn-sm btn-primary add-value">+</button>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 text-end">
                                                            <button type="button" class="btn btn-danger btn-sm remove-short-attribute">Remove</button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-primary btn-sm add-short-attribute mt-2">+ Add Short Attribute</button>
                                    </div>
                                    <button type="button" class="btn btn-danger remove-attribute">Remove Attribute</button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="card attribute-row mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Attribute 1</h5>
                                <input type="text" name="attributes[0][title]" class="form-control mb-2"
                                    placeholder="Attribute Title">
                                <div class="card bg-white p-3 mb-3 border border-dark">
                                    <h6>Short Attributes</h6>
                                    <div class="short-attributes-container">
                                        <div class="row short-attribute-row mb-2">
                                            <div class="col-md-4">
                                                <input type="text" name="attributes[0][short_attributes][0][key]"
                                                    class="form-control" placeholder="Key">
                                            </div>
                                            <div class="col-md-6">
                                                <div class="values-container">
                                                    <div class="d-flex mb-2">
                                                        <input type="text" name="attributes[0][short_attributes][0][values][]"
                                                            class="form-control me-2" placeholder="Value">
                                                        <button type="button" class="btn btn-sm btn-primary add-value">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2 text-end">
                                                <button type="button" class="btn btn-danger btn-sm remove-short-attribute">Remove</button>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary btn-sm add-short-attribute">+ Add Short Attribute</button>
                                </div>
                                <button type="button" class="btn btn-danger remove-attribute">Remove Attribute</button>
                            </div>
                        </div>
                    @endif
                </div>
                <button type="button" class="btn btn-success text-white float-end" id="add-attribute">+ Add Attribute</button>
            </div>

            <button type="submit" class="btn btn-primary mb-3">Update Product</button>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#description').summernote({
                placeholder: 'Enter product description...',
                tabsize: 2,
                height: 300,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['help']]
                ]
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function getNextIndex(selector) {
                return document.querySelectorAll(selector).length;
            }

            // Add/Remove Value field handler
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('add-value')) {
                    const valuesContainer = e.target.closest('.values-container');
                    const inputContainer = e.target.closest('.d-flex').cloneNode(true);
                    const input = inputContainer.querySelector('input');
                    input.value = ''; // Clear the value of the new input

                    // Change the + button to a - button for the new row
                    const addButton = inputContainer.querySelector('.add-value');
                    addButton.classList.remove('btn-primary', 'add-value');
                    addButton.classList.add('btn-danger', 'remove-value');
                    addButton.textContent = '-';

                    valuesContainer.appendChild(inputContainer);
                }

                if (e.target.classList.contains('remove-value')) {
                    e.target.closest('.d-flex').remove();
                }
            });

            // Add Document
            document.getElementById('add-document').addEventListener('click', function () {
                console.log('Add Document clicked');
                const index = getNextIndex('.document');
                const documentRow = document.createElement('div');
                documentRow.classList.add('document', 'mb-3');
                documentRow.id = `document-${index}`;
                documentRow.innerHTML = `
                    <div class="form-group mb-3">
                        <label for="documents[${index}][document_name]" class="form-label">Document Name</label>
                        <input type="text" name="documents[${index}][document_name]" class="form-control" placeholder="Enter document name">
                    </div>
                    <label for="documents[${index}][type]" class="form-label">Type</label>
                    <select name="documents[${index}][type]" class="form-control" >
                        <option value="">Select Document Type</option>
                        @foreach ($documentTypes as $documentType)
                            <option value="{{ $documentType->id }}">{{ $documentType->name }}</option>
                        @endforeach
                    </select>
                    <label for="documents[${index}][file_path]" class="form-label">File</label>
                    <input type="file" name="documents[${index}][file_path]" class="form-control">
                    <div class="form-group mt-2">
                        <label for="documents[${index}][path]">File Link (Optional)</label>
                        <input type="text" name="documents[${index}][path]" class="form-control" id="documents_${index}_path" placeholder="Enter file URL if not uploading directly">
                    </div>
                    <button type="button" class="btn btn-danger remove-document mt-3">Remove</button>
                `;
                document.getElementById('documents-container').appendChild(documentRow);
            });

            // Remove Document
            document.getElementById('documents-container').addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-document')) {
                    console.log('Remove Document clicked');
                    e.target.closest('.document').remove();
                }
            });

            // Add Attribute
            document.getElementById('add-attribute').addEventListener('click', function () {
                console.log('Add Attribute clicked');
                const index = getNextIndex('.attribute-row');
                const attributeRow = document.createElement('div');
                attributeRow.classList.add('card', 'attribute-row', 'mb-3');
                attributeRow.innerHTML = `
                    <div class="card-body">
                        <h5 class="card-title">Attribute ${index + 1}</h5>
                        <input type="text" name="attributes[${index}][title]" class="form-control mb-2" placeholder="Attribute Title">
                        <div class="card bg-white p-3 mb-3 border border-dark">
                            <h6>Short Attributes</h6>
                            <div class="short-attributes-container">
                                <div class="row short-attribute-row mb-2">
                                    <div class="col-md-4">
                                        <input type="text" name="attributes[${index}][short_attributes][0][key]" class="form-control" placeholder="Key">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="values-container">
                                            <div class="d-flex mb-2">
                                                <input type="text" name="attributes[${index}][short_attributes][0][values][]" class="form-control me-2" placeholder="Value">
                                                <button type="button" class="btn btn-sm btn-primary add-value">+</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <button type="button" class="btn btn-danger btn-sm remove-short-attribute">Remove</button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary btn-sm add-short-attribute mt-2">+ Add Short Attribute</button>
                        </div>
                        <button type="button" class="btn btn-danger remove-attribute">Remove Attribute</button>
                    </div>
                `;
                document.getElementById('attributes').appendChild(attributeRow);
            });

            // Handle Attribute and Short Attribute Actions
            document.getElementById('attributes').addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-attribute')) {
                    console.log('Remove Attribute clicked');
                    e.target.closest('.attribute-row').remove();
                }
                if (e.target.classList.contains('add-short-attribute')) {
                    console.log('Add Short Attribute clicked');
                    const shortAttributesContainer = e.target.previousElementSibling;
                    const attributeIndex = [...document.querySelectorAll('.attribute-row')].indexOf(
                        e.target.closest('.attribute-row')
                    );
                    const shortIndex = shortAttributesContainer.querySelectorAll('.short-attribute-row').length;
                    const shortAttributeRow = document.createElement('div');
                    shortAttributeRow.classList.add('row', 'short-attribute-row', 'mb-2');
                    shortAttributeRow.innerHTML = `
                        <div class="col-md-4">
                            <input type="text" name="attributes[${attributeIndex}][short_attributes][${shortIndex}][key]" class="form-control" placeholder="Key">
                        </div>
                        <div class="col-md-6">
                            <div class="values-container">
                                <div class="d-flex mb-2">
                                    <input type="text" name="attributes[${attributeIndex}][short_attributes][${shortIndex}][values][]" class="form-control me-2" placeholder="Value">
                                    <button type="button" class="btn btn-sm btn-primary add-value">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 text-end">
                            <button type="button" class="btn btn-danger btn-sm remove-short-attribute">Remove</button>
                        </div>
                    `;
                    shortAttributesContainer.appendChild(shortAttributeRow);
                }
                if (e.target.classList.contains('remove-short-attribute')) {
                    console.log('Remove Short Attribute clicked');
                    e.target.closest('.short-attribute-row').remove();
                }
            });

            // Filters Logic
            let filters = @json($filters ?? []) || [];
            // Ensure filters is an array
            if (!Array.isArray(filters)) {
                try {
                    filters = Object.values(filters);
                } catch (e) {
                    filters = [];
                }
            }

            const container = document.getElementById('filters-container');
            if (container) {
                function populateOptionsForSelect(filterSelect, optionSelect) {
                    const selectedId = filterSelect.value;
                    optionSelect.innerHTML = '<option value="">Select Option</option>';
                    if (!selectedId) return;
                    const selectedFilter = filters.find(f => String(f.id) === String(selectedId));
                    if (!selectedFilter || !selectedFilter.options) return;
                    selectedFilter.options.forEach(opt => {
                        const o = document.createElement('option');
                        o.value = opt.id;
                        o.textContent = opt.name;
                        optionSelect.appendChild(o);
                    });
                }

                function attachDirectListeners() {
                    Array.from(container.querySelectorAll('.filter-pair')).forEach(pair => {
                        const filterSel = pair.querySelector('.filter-select');
                        const optionSel = pair.querySelector('.filter-option-select');
                        const addBtn = pair.querySelector('.btn-add');
                        const remBtn = pair.querySelector('.btn-remove');

                        if (filterSel) {
                            filterSel.addEventListener('change', function (ev) {
                                populateOptionsForSelect(this, optionSel);
                            });
                        }

                        if (addBtn) {
                            addBtn.addEventListener('click', function () {
                                addFilterPair();
                            });
                        }

                        if (remBtn) {
                            remBtn.addEventListener('click', function () {
                                if (container.querySelectorAll('.filter-pair').length > 1) {
                                    pair.remove();
                                } else {
                                    if (filterSel) filterSel.value = '';
                                    if (optionSel) optionSel.innerHTML = '<option value="">Select Option</option>';
                                }
                            });
                        }
                    });
                }

                function addFilterPair(selectedFilter = '', selectedOption = '') {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'filter-pair mb-2 d-flex align-items-start';

                    const filterSel = document.createElement('select');
                    filterSel.name = 'filter_id[]';
                    filterSel.className = 'form-control me-2 filter-select';
                    filterSel.innerHTML = '<option value="">Select Filter</option>' +
                        filters.map(f => `<option value="${f.id}" ${f.id == selectedFilter ? 'selected' : ''}>${f.name}</option>`).join('');

                    const optionSel = document.createElement('select');
                    optionSel.name = 'filter_option_id[]';
                    optionSel.className = 'form-control me-2 filter-option-select';
                    optionSel.innerHTML = '<option value="">Select Option</option>';

                    const addBtn = document.createElement('button');
                    addBtn.type = 'button';
                    addBtn.className = 'btn btn-success btn-add me-1';
                    addBtn.textContent = '+';

                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className = 'btn btn-danger btn-remove';
                    removeBtn.textContent = '−';

                    wrapper.appendChild(filterSel);
                    wrapper.appendChild(optionSel);
                    wrapper.appendChild(addBtn);
                    wrapper.appendChild(removeBtn);

                    container.appendChild(wrapper);

                    filterSel.addEventListener('change', function () {
                        populateOptionsForSelect(this, optionSel);
                    });

                    addBtn.addEventListener('click', function () { addFilterPair(); });
                    removeBtn.addEventListener('click', function () {
                        if (container.querySelectorAll('.filter-pair').length > 1) wrapper.remove();
                        else { filterSel.value = ''; optionSel.innerHTML = '<option value="">Select Option</option>'; }
                    });

                    if (selectedFilter) {
                        populateOptionsForSelect(filterSel, optionSel);
                        if (selectedOption) {
                            optionSel.value = selectedOption;
                        }
                    }
                }

                attachDirectListeners();
            }
            // Subcategory Fetching
            const categorySelect = document.getElementById('category_id');
            const subcategoriesContainer = document.getElementById('subcategories-container');
            if (categorySelect && subcategoriesContainer) {
                categorySelect.addEventListener('change', function () {
                    console.log('Category changed:', this.value);
                    subcategoriesContainer.innerHTML = '';
                    if (this.value) {
                        fetchSubcategories(this.value, null, subcategoriesContainer);
                    }
                });
            }

            function fetchSubcategories(categoryId, parentId, container) {
                console.log('Fetching subcategories for category:', categoryId, 'parent:', parentId);
                fetch(`/admin/products/subcategories/${categoryId}?parent_id=${parentId || ''}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.subcategories.length > 0) {
                            const subcategoryDiv = document.createElement('div');
                            subcategoryDiv.classList.add('form-group', 'mb-4');
                            subcategoryDiv.innerHTML = `
                                <label>Subcategory</label>
                                <select name="subcategory_ids[]" class="form-control">
                                    <option value="">Select Subcategory</option>
                                    ${data.subcategories
                                        .map(sub => `<option value="${sub.id}">${sub.name}</option>`)
                                        .join('')}
                                </select>
                            `;
                            container.appendChild(subcategoryDiv);
                            const subcategorySelect = subcategoryDiv.querySelector('select');
                            subcategorySelect.addEventListener('change', function () {
                                const siblings = Array.from(container.children);
                                const index = siblings.indexOf(subcategoryDiv);
                                siblings.slice(index + 1).forEach(sibling => sibling.remove());
                                if (this.value) {
                                    fetchSubcategories(categoryId, this.value, container);
                                }
                            });
                        }
                    })
                    .catch(error => console.error('Error fetching subcategories:', error));
            }

            // Image and File Removal
            window.removeImage = function(image, productId) {
                if (confirm('Are you sure you want to remove this image?')) {
                    fetch('/admin/products/remove-image', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ image, productId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Find and remove the image element from DOM
                            const imageElement = document.querySelector(`img[src*="${image}"]`);
                            if (imageElement) {
                                imageElement.closest('.position-relative').remove();
                            }
                        } else {
                            alert('Failed to remove image: ' + (data.message || 'Unknown error'));
                        }
                    })
                    .catch(error => {
                        console.error('Error removing image:', error);
                        alert('Error removing image. Please try again.');
                    });
                }
            };

            window.removeFile = function(file, productId, documentId) {
                if (confirm('Are you sure you want to remove this document?')) {
                    fetch('/admin/products/remove-file', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ file, productId, documentId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Find and remove the document element from DOM
                            const documentElement = document.querySelector(`a[href*="${file}"]`);
                            if (documentElement) {
                                documentElement.closest('.document').remove();
                            }
                        } else {
                            alert('Failed to remove document: ' + (data.message || 'Unknown error'));
                        }
                    })
                    .catch(error => {
                        console.error('Error removing file:', error);
                        alert('Error removing document. Please try again.');
                    });
                }
            };
        });
    </script>

    
<!-- JS to handle add/remove -->
<script>
    
    document.addEventListener("DOMContentLoaded", function () {
        let wrapper = document.getElementById('short-description-wrapper');
        let addBtn = document.getElementById('add-short-desc');

        addBtn.addEventListener('click', function () {
            let div = document.createElement('div');
            div.classList.add('input-group', 'mb-2', 'short-description-item');
            div.innerHTML = `
                <input type="text" name="short_description[]" class="form-control" placeholder="Enter short description">
                <button type="button" class="btn btn-danger remove-short-desc">−</button>
            `;
            wrapper.appendChild(div);
        });

        wrapper.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-short-desc')) {
                e.target.closest('.short-description-item').remove();
            }
        });
    });
      function addShortDescription() {
        let wrapper = document.getElementById('short-description-wrapper');
        let input = document.createElement('input');
        input.type = 'text';
        input.name = 'short_description[]';
        input.className = 'form-control mb-2';
        input.placeholder = 'Enter short description';
        wrapper.appendChild(input);
    }

// Validation Script
document.addEventListener('blur', function (e) {
    if (e.target.id === 'name') {
        required('name', 'nameError');
    }

    if (e.target.id === 'brand_id') {
        required('brand_id', 'brandError');
    }

    if (e.target.id === 'category_id') {
        required('category_id', 'categoryError');
    }

    if (e.target.id === 'serial_number') {
        checkSerial(e.target.value);
    }
}, true);

function required(id, errId) {
    const el = document.getElementById(id);
    const err = document.getElementById(errId);

    if (!el.value) {
        err.classList.remove('d-none');
        el.classList.add('is-invalid');
    } else {
        err.classList.add('d-none');
        el.classList.remove('is-invalid');
    }
}

function checkSerial(val) {
    const original = "{{ $product->serial_number ?? '' }}";
    const serialError = document.getElementById('serialError');
    const serialInput = document.getElementById('serial_number');
    const dropdown = document.getElementById('takenSerialsDropdown');
    const content = document.getElementById('takenSerialsContent');

    if (!val || val == original) {
        serialError.classList.add('d-none');
        serialInput.classList.remove('is-invalid');
        if (dropdown) dropdown.style.display = 'none';
        return;
    }

    fetch("{{ route('admin.products.checkSerial') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            serial_number: val,
            product_id: "{{ $product->id }}"
        })
    })
    .then(r => r.json())
    .then(data => {
        if (data.exists) {
            serialError.innerText = 'Serial number already exists';
            serialError.classList.remove('d-none');
            serialInput.classList.add('is-invalid');
        } else {
            serialError.classList.add('d-none');
            serialInput.classList.remove('is-invalid');
        }

        if (data.taken_serials && data.taken_serials.length > 0) {
            content.innerHTML = '';
            data.taken_serials.forEach(serial => {
                const item = document.createElement('div');
                item.classList.add('taken-serial-item');
                item.innerText = serial;
                item.style.padding = '8px 12px';
                item.style.borderBottom = '1px solid #f0f0f0';
                content.appendChild(item);
            });
            dropdown.style.display = 'block';
        } else {
            if (dropdown) dropdown.style.display = 'none';
        }
    });
}

// Add input listener for autocomplete behavior
document.getElementById('serial_number').addEventListener('input', function(e) {
    checkSerial(e.target.value);
});
</script>
@endsection
