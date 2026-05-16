@extends('layouts.admin')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">{{ isset($product) ? 'Edit Product' : 'Create Product' }}</h2>
        <form id="product-form" action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @isset($product)
                @method('PUT')
            @endisset

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session()->has('temp_files'))
                <div class="alert alert-info">
                    <p>Previously uploaded files have been saved and will be included with your submission.</p>
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
                            value="{{ old('name', $product->name ?? '') }}">
                        <small class="text-danger d-none" id="nameError">Product name required</small>
                    </div>

                    <!-- Product Price -->
                    <div class="form-group mb-4">
                        <label for="price">Price</label>
                        <input type="number" name="price" id="price" class="form-control"
                            value="{{ old('price', $product->price ?? '') }}">
                    </div>

                    <!-- Category -->
                    <div class="form-group mb-4">
                        <label for="category_id">Category</label>
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
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

                    <!-- Subcategories container -->
                    <div id="subcategories-container"></div>

                    <!-- Brand -->
                    <div class="form-group mb-4">
                        <label for="brand_id">Brand</label>
                        <select name="brand_id" id="brand_id" class="form-control">
                            <option value="">Select Brand</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}"
                                    {{ (int)old('brand_id', $product->brand_id ?? '') === (int)$brand->id ? 'selected' : '' }}>
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
                            $oldFilters = old('filter_id', []);
                            $oldOptions = old('filter_option_id', []);
                            if (!is_array($oldFilters) || empty($oldFilters)) {
                                $oldFilters = [''];
                            }
                            if (!is_array($oldOptions) || empty($oldOptions)) {
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


                    <!-- Short Description (Bullet Points) -->
<div class="form-group mb-4">
    <label for="short_description">Short Description (Bullet Points)</label>
    <div id="short-description-container">
        @php
            $shortDescription = old('short_description', $product->short_description ?? []);
        @endphp
        @if(!empty($shortDescription))
            @foreach($shortDescription as $i => $line)
                <div class="d-flex mb-2 short-desc-item">
                    <input type="text" name="short_description[]" class="form-control me-2" 
                           value="{{ $line }}" placeholder="Enter short description line">
                    <button type="button" class="btn btn-danger remove-line">-</button>
                </div>
            @endforeach
        @else
            <div class="d-flex mb-2 short-desc-item">
                <input type="text" name="short_description[]" class="form-control me-2" 
                       placeholder="Enter short description line">
                <button type="button" class="btn btn-primary add-line">+</button>
            </div>
        @endif
    </div>
</div>



                    <!-- Description -->
                    <div class="form-group mb-4">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control">{{ old('description', $product->description ?? '') }}</textarea>
                    </div>

                    <!-- Serial Number -->
                    <div class="form-group mb-4">
                        <label for="serial_number">Model Number</label>
                        <div class="position-relative">
                            <input type="text" name="serial_number" id="serial_number" class="form-control"
                                value="{{ old('serial_number', $product->serial_number ?? $nextSerialNumber) }}" autocomplete="off">
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
                                z-index: 1050; /* Bootstrap modal is 1050, tooltip 1080. */
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
                    </div>                    <!-- Product Images -->
                    <div class="form-group mb-4">
                        <label for="images">Product Images
                             <small class="text-muted d-block">
        (Recommended size: 1000px width × 1000px height, PNG with transparent background)
    </small>
                        </label>
                        <input type="file" name="images[]" id="image-upload-input" class="form-control" accept="image/*" multiple>
                        <div id="image-preview-container" class="d-flex flex-wrap mt-3 gap-2"></div>
                        <p class="text-muted mt-2 small">Selected images will appear here. Drag and drop to reorder.</p>
                    @if (session()->has('temp_files') && isset(session('temp_files')['images']))

    <div class="mt-3">
        <h5>Selected Images <small class="text-muted">(Drag to reorder)</small></h5>
        <div id="sortable-temp-images" class="d-flex flex-wrap border rounded p-3" style="min-height: 150px; background: #f9f9f9;">
      @foreach (session('temp_files')['images'] ?? [] as $index => $image)
    <div class="sortable-image me-3 mb-3 position-relative" draggable="true" data-path="{{ $image }}" data-index="{{ $index }}" style="cursor: grab; user-select: none;">
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

        @if ($imageData)
            <img src="data:{{ $mimeType }};base64,{{ $imageData }}" 
                 alt="Temporary Image"
                 class="img-thumbnail" width="100" height="100"
                 style="pointer-events: none;">
        @else
            <div class="img-thumbnail d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                <span class="text-muted">Image</span>
            </div>
        @endif
        
        <div class="position-absolute top-0 end-0 d-flex gap-1">
            <button type="button" 
                    class="btn btn-danger btn-sm remove-temp-image"
                    data-image="{{ $image }}">×</button>
        </div>
        <div class="position-absolute bottom-0 start-50 translate-middle-x bg-dark text-white px-2 py-1 rounded" style="font-size: 0.75rem; opacity: 0.8;">{{ $index + 1 }}</div>
    </div>
@endforeach
        </div>
        <!-- Hidden inputs to store order for temp images -->
        <div id="temp-image-order-container" style="display:none;">
            @foreach (session('temp_files')['images'] ?? [] as $image)
                <input type="hidden" name="temp_images_order[]" value="{{ $image }}">
            @endforeach
        </div>
    </div>
                      @elseif (isset($product) && $product->images)
    <div class="mt-3">
        <h5>Existing Images</h5>
        <div class="d-flex flex-wrap">
            @foreach (json_decode($product->images, true) ?? [] as $image)
                @php
                    // Normalize path for DB images
                    $normalizedImage = $image;
                    if (stripos($image, 'uploads/products/') !== 0 && stripos($image, 'Uploads/products/') !== 0) {
                        $normalizedImage = 'uploads/products/' . ltrim($image, '/');
                    }
                @endphp

                <div class="position-relative me-2 mb-2">
                    <img src="{{ asset($normalizedImage) }}" 
                         alt="Product Image"
                         class="img-thumbnail" width="100" height="100">
                    <button type="button" 
                            class="btn btn-danger btn-sm position-absolute top-0 end-0"
                            onclick="removeImage('{{ $normalizedImage }}', {{ $product->id }})">X</button>
                </div>
            @endforeach
        </div>
    </div>
@endif
                    </div>
                </div>
            </div>

            {{-- Product Documents --}}
            <div class="card shadow-sm mt-4">
                <div class="card-header">
                    <h4 class="card-title">Documents</h4>
                </div>
                <div class="card-body">
                    <div id="documents-container" class="mb-4">
                        @if (isset($product) && $product->documents->count() > 0)
                            @foreach ($product->documents as $index => $document)
                                <div class="document mb-3 p-3 border rounded" id="document-{{ $index }}">
                                    <input type="hidden" name="documents[{{ $index }}][id]" value="{{ $document->id }}">
                                    <div class="form-group mb-3">
                                        <label for="documents[{{ $index }}][document_name]" class="form-label">Document Name</label>
                                        <input type="text" name="documents[{{ $index }}][document_name]" class="form-control" value="{{ old('documents.' . $index . '.document_name', $document->document_name ?? '') }}" placeholder="Enter document name">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="documents[{{ $index }}][type]" class="form-label">Type</label>
                                        <select name="documents[{{ $index }}][type]" class="form-control">
                                            <option value="">Select Document Type</option>
                                            @foreach ($documentTypes as $documentType)
                                                <option value="{{ $documentType->id }}"
                                                    {{ old('documents.' . $index . '.type', $document->type) == $documentType->id ? 'selected' : '' }}>
                                                    {{ $documentType->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="documents[{{ $index }}][file_path]" class="form-label">File</label>
                                        <input type="file" name="documents[{{ $index }}][file_path]" class="form-control">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="documents[{{ $index }}][path]">Document Path</label>
                                        <input type="text" name="documents[{{ $index }}][path]" class="form-control"
                                            id="documents_{{ $index }}_path"
                                            value="{{ old('documents.' . $index . '.path', $document->path ?? '') }}">
                                    </div>
                                    @if ($document->file_path)
                                        <div class="mt-2 mb-3">
                                            <h6>Existing Document:</h6>
                                            <a href="{{ asset($document->file_path) }}" target="_blank" class="btn btn-sm btn-info">View Document</a>
                                            <button type="button" class="btn btn-sm btn-warning remove-file"
                                                data-file="{{ $document->file_path }}"
                                                data-product="{{ $product->id }}"
                                                data-document="{{ $document->id }}">Delete File</button>
                                        </div>
                                    @endif
                                    <button type="button" class="btn btn-danger remove-document">Remove</button>
                                </div>
                            @endforeach
                        @else                    @if (session()->has('temp_files.documents'))
                        @foreach(session('temp_files.documents') as $index => $document)
                            <div class="document mb-3 p-3 border rounded" id="document-{{ $index }}">
                                <div class="form-group mb-3">
                                    <label for="documents[{{ $index }}][type]" class="form-label">Type</label>
                                    <select name="documents[{{ $index }}][type]" class="form-control">
                                        <option value="">Select Document Type</option>
                                        @foreach ($documentTypes as $documentType)
                                            <option value="{{ $documentType->id }}"
                                                {{ $document['type'] == $documentType->id ? 'selected' : '' }}>
                                                {{ $documentType->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="documents[{{ $index }}][file_path]" class="form-label">File</label>
                                    <input type="hidden" name="documents[{{ $index }}][temp_file_path]" value="{{ $document['file_path'] }}">
                                    <div class="alert alert-info">
                                        File selected: {{ basename($document['file_path']) }}
                                    </div>
                                    <input type="file" name="documents[{{ $index }}][file_path]" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="documents[{{ $index }}][path]">File Link (Optional)</label>
                                    <input type="text" name="documents[{{ $index }}][path]" class="form-control"
                                        id="documents_{{ $index }}_path" value="{{ $document['path'] ?? old('documents.' . $index . '.path') }}"  placeholder="Enter file URL if not uploading directly">
                                </div>
                                <button type="button" class="btn btn-danger remove-document">Remove</button>
                            </div>
                        @endforeach
                    @else
                        <div class="document mb-3 p-3 border rounded" id="document-0">
                            <div class="form-group mb-3">
                                <label for="documents[0][document_name]" class="form-label">Document Name</label>
                                <input type="text" name="documents[0][document_name]" class="form-control" placeholder="Enter document name" value="{{ old('documents.0.document_name') }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="documents[0][type]" class="form-label">Type</label>
                                <select name="documents[0][type]" class="form-control">
                                    <option value="">Select Document Type</option>
                                    @foreach ($documentTypes as $documentType)
                                        <option value="{{ $documentType->id }}"
                                            {{ old('documents.0.type') == $documentType->id ? 'selected' : '' }}>
                                            {{ $documentType->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="documents[0][file_path]" class="form-label">File</label>
                                <input type="file" name="documents[0][file_path]" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="documents[0][path]">File Link (Optional)</label>
                                <input type="text" name="documents[0][path]" class="form-control"
                                    id="documents_0_path"  placeholder="Enter file URL if not uploading directly" value="{{ old('documents.0.path') }}">
                            </div>
                            <button type="button" class="btn btn-danger remove-document">Remove</button>
                        </div>
                    @endif
                        @endif
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-success btn-sm text-white float-end" id="add-document">+ Add Document</button>
                    </div>
                </div>
            </div>

            {{-- Attributes --}}
            <div class="card shadow-sm mt-4">
                <div class="card-header">
                    <h4 class="card-title">Attributes</h4>
                </div>
                <div class="card-body">
                    <div id="attributes" class="mb-4">
                        @php
                            $oldAttributes = old('attributes', []);
                        @endphp
                        @if (count($oldAttributes) > 0)
                            @foreach($oldAttributes as $index => $attribute)
                                <div class="card attribute-row mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">Attribute {{ $index + 1 }}</h5>
                                        <div class="form-group mb-3">
                                            <label for="attributes[{{ $index }}][title]">Title</label>
                                            <input type="text" name="attributes[{{ $index }}][title]" class="form-control"
                                                placeholder="Attribute Title" value="{{ $attribute['title'] ?? '' }}">
                                        </div>
                                        <div class="card p-3 mb-3">
                                            <h6>Short Attributes</h6>
                                            <div class="short-attributes-container">
                                                @if(isset($attribute['short_attributes']) && is_array($attribute['short_attributes']))
                                                    @foreach($attribute['short_attributes'] as $shortIndex => $shortAttribute)
                                                        <div class="row short-attribute-row mb-2">
                                                            <div class="col-md-4">
                                                                <input type="text" name="attributes[{{ $index }}][short_attributes][{{ $shortIndex }}][key]"
                                                                    class="form-control" placeholder="Key" value="{{ $shortAttribute['key'] ?? '' }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="values-container">
                                                                    <div class="d-flex mb-2">
                                                                        <input type="text" name="attributes[{{ $index }}][short_attributes][{{ $shortIndex }}][values][]"
                                                                            class="form-control me-2" placeholder="Value" value="{{ $shortAttribute['values'][0] ?? '' }}">
                                                                        <button type="button" class="btn btn-sm btn-primary add-value">+</button>
                                                                    </div>
                                                                    @if(isset($shortAttribute['values']) && is_array($shortAttribute['values']))
                                                                        @foreach(array_slice($shortAttribute['values'], 1) as $valueIndex => $value)
                                                                            <div class="d-flex mb-2">
                                                                                <input type="text" name="attributes[{{ $index }}][short_attributes][{{ $shortIndex }}][values][]"
                                                                                    class="form-control me-2" placeholder="Value" value="{{ $value }}">
                                                                                <button type="button" class="btn btn-sm btn-danger remove-value">-</button>
                                                                            </div>
                                                                        @endforeach
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
                                    <div class="form-group mb-3">
                                        <label for="attributes[0][title]">Title</label>
                                        <input type="text" name="attributes[0][title]" class="form-control"
                                            placeholder="Attribute Title">
                                    </div>
                                    <div class="card p-3 mb-3">
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
                                        <button type="button" class="btn btn-primary btn-sm add-short-attribute mt-2">+ Add Short Attribute</button>
                                    </div>
                                    <button type="button" class="btn btn-danger remove-attribute">Remove Attribute</button>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-success text-white float-end" id="add-attribute">+ Add Attribute</button>
                    </div>
                </div>
            </div>

            <div class="mt-4 mb-5">
                <button type="submit"
                    class="btn btn-primary">{{ isset($product) ? 'Update Product' : 'Create Product' }}</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary ml-2">Cancel</a>
            </div>
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
        // Convert PHP data to JavaScript
        const documentTypes = @json($documentTypes);
        
        // Filters Logic
        document.addEventListener("DOMContentLoaded", function() {
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
                if (!container) return;

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
        });

        
        document.addEventListener('DOMContentLoaded', function () {
            // Helper function to get the next index for elements
            function getNextIndex(selector) {
                return document.querySelectorAll(selector).length;
            }

            // Helper function to generate document type options
            function generateDocumentTypeOptions() {
                let options = '<option value="">Select Document Type</option>';
                documentTypes.forEach(function(docType) {
                    options += `<option value="${docType.id}">${docType.name}</option>`;
                });
                return options;
            }

            // Add Document
            const addDocumentBtn = document.getElementById('add-document');
            if (addDocumentBtn) {
                addDocumentBtn.addEventListener('click', function () {
                    const index = getNextIndex('.document');
                    const documentRow = document.createElement('div');
                    documentRow.classList.add('document', 'mb-3', 'p-3', 'border', 'rounded');
                    documentRow.id = `document-${index}`;
                    documentRow.innerHTML = `
                        <div class="form-group mb-3">
                            <label for="documents[${index}][document_name]" class="form-label">Document Name</label>
                            <input type="text" name="documents[${index}][document_name]" class="form-control" placeholder="Enter document name">
                        </div>
                        <div class="form-group mb-3">
                            <label for="documents[${index}][type]" class="form-label">Type</label>
                            <select name="documents[${index}][type]" class="form-control">
                                ${generateDocumentTypeOptions()}
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="documents[${index}][file_path]" class="form-label">File</label>
                            <input type="file" name="documents[${index}][file_path]" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="documents[${index}][path]">File Link (Optional)</label>
                            <input type="text" name="documents[${index}][path]" class="form-control" id="documents_${index}_path" placeholder="Enter file URL if not uploading directly">
                        </div>
                        <button type="button" class="btn btn-danger remove-document">Remove</button>
                    `;
                    document.getElementById('documents-container').appendChild(documentRow);
                });
            }

            // Remove Document and File (using event delegation)
            const documentsContainer = document.getElementById('documents-container');
            if (documentsContainer) {
                documentsContainer.addEventListener('click', function (e) {
                    if (e.target.classList.contains('remove-document')) {
                        const documents = document.querySelectorAll('.document');
                        if (documents.length > 1) {
                            e.target.closest('.document').remove();
                        } else {
                            const inputs = e.target.closest('.document').querySelectorAll('input, select');
                            inputs.forEach(input => {
                                if (input.type === 'file') {
                                    input.value = '';
                                } else if (input.type !== 'hidden') {
                                    input.value = '';
                                }
                            });
                        }
                    }

                    if (e.target.classList.contains('remove-file')) {
                        const fileElement = e.target;
                        const file = fileElement.dataset.file;
                        const productId = fileElement.dataset.product;
                        const documentId = fileElement.dataset.document;

                        if (confirm('Are you sure you want to delete this file?')) {
                            fetch('/admin/products/remove-file', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({
                                    file: file,
                                    productId: productId,
                                    documentId: documentId
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    fileElement.closest('.mt-2').remove();
                                    alert('File removed successfully');
                                } else {
                                    alert(data.message);
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('An error occurred while removing the file');
                            });
                        }
                    }
                });
            }

            // Add Attribute
            const addAttributeBtn = document.getElementById('add-attribute');
            if (addAttributeBtn) {
                addAttributeBtn.addEventListener('click', function () {
                    const index = getNextIndex('.attribute-row');
                    const attributeRow = document.createElement('div');
                    attributeRow.classList.add('card', 'attribute-row', 'mb-3');
                    attributeRow.innerHTML = `
                        <div class="card-body">
                            <h5 class="card-title">Attribute ${index + 1}</h5>
                            <div class="form-group mb-3">
                                <label for="attributes[${index}][title]">Title</label>
                                <input type="text" name="attributes[${index}][title]" class="form-control" placeholder="Attribute Title">
                            </div>
                            <div class="card p-3 mb-3">
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
            }

            // Remove Attribute (using event delegation)
            const attributesContainer = document.getElementById('attributes');
            if (attributesContainer) {
                attributesContainer.addEventListener('click', function (e) {
                    if (e.target.classList.contains('remove-attribute')) {
                        const attributes = document.querySelectorAll('.attribute-row');
                        if (attributes.length > 1) {
                            e.target.closest('.attribute-row').remove();
                        } else {
                            const inputs = e.target.closest('.attribute-row').querySelectorAll('input');
                            inputs.forEach(input => {
                                if (input.type !== 'hidden') {
                                    input.value = '';
                                }
                            });
                        }
                    }

                    // Add Short Attribute
                    if (e.target.classList.contains('add-short-attribute')) {
                        const attributeRow = e.target.closest('.attribute-row');
                        const shortAttributesContainer = attributeRow.querySelector('.short-attributes-container');
                        const attributeIndex = Array.from(document.querySelectorAll('.attribute-row')).indexOf(attributeRow);
                        const shortAttributeIndex = shortAttributesContainer.querySelectorAll('.short-attribute-row').length;

                        const shortAttributeRow = document.createElement('div');
                        shortAttributeRow.classList.add('row', 'short-attribute-row', 'mb-2');
                        shortAttributeRow.innerHTML = `
                            <div class="col-md-4">
                                <input type="text" name="attributes[${attributeIndex}][short_attributes][${shortAttributeIndex}][key]" class="form-control" placeholder="Key">
                            </div>
                            <div class="col-md-6">
                                <div class="values-container">
                                    <div class="d-flex mb-2">
                                        <input type="text" name="attributes[${attributeIndex}][short_attributes][${shortAttributeIndex}][values][]" class="form-control me-2" placeholder="Value">
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

                    // Remove Short Attribute
                    if (e.target.classList.contains('remove-short-attribute')) {
                        const shortAttributeRow = e.target.closest('.short-attribute-row');
                        const shortAttributesContainer = shortAttributeRow.parentElement;
                        if (shortAttributesContainer.querySelectorAll('.short-attribute-row').length > 1) {
                            shortAttributeRow.remove();
                        } else {
                            const inputs = shortAttributeRow.querySelectorAll('input');
                            inputs.forEach(input => {
                                input.value = '';
                            });
                        }
                    }
                });
            }

            // Remove Image (using event delegation)
            const imagesContainer = document.querySelector('.d-flex.flex-wrap');
            if (imagesContainer) {
                imagesContainer.addEventListener('click', function (e) {
                    if (e.target.classList.contains('remove-image')) {
                        const imageElement = e.target;
                        const image = imageElement.dataset.image;
                        const productId = imageElement.dataset.product;

                        if (confirm('Are you sure you want to delete this image?')) {
                            fetch('/admin/products/remove-image', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({
                                    image: image,
                                    productId: productId
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    imageElement.closest('.position-relative').remove();
                                    alert('Image removed successfully');
                                } else {
                                    alert(data.message);
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('An error occurred while removing the image');
                            });
                        }
                    }
                });
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
        });

        // Remove Temporary Image
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-temp-image')) {
        const imageElement = e.target;
        const image = imageElement.dataset.image;

        if (confirm('Remove this temporary image?')) {
            fetch('/admin/products/remove-temp-image', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ image: image })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    imageElement.closest('.position-relative').remove();
                } else {
                    alert(data.message || 'Failed to remove temp image');
                }
            })
            .catch(err => {
                console.error(err);
                alert('Error removing temp image');
            });
        }
    }
});

// Short Description (Dynamic Lines)
document.addEventListener('click', function(e) {
    // Add line
    if (e.target.classList.contains('add-line')) {
        const container = document.getElementById('short-description-container');
        const newLine = document.createElement('div');
        newLine.classList.add('d-flex', 'mb-2', 'short-desc-item');
        newLine.innerHTML = `
            <input type="text" name="short_description[]" class="form-control me-2" placeholder="Enter short description line">
            <button type="button" class="btn btn-danger remove-line">-</button>
        `;
        container.appendChild(newLine);
    }

    // Remove line
    if (e.target.classList.contains('remove-line')) {
        e.target.closest('.short-desc-item').remove();
    }
});

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

// ---------------------------------------------------------
// Image Reordering Logic for Create Page
// ---------------------------------------------------------
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('image-upload-input');
    const previewContainer = document.getElementById('image-preview-container');
    const form = document.getElementById('product-form');
    
    // Only run if elements exist (create page)
    if (!imageInput || !previewContainer) return;

    // Store files in an array to manage order
    let uploadedFiles = [];

    // Handle File Selection
    imageInput.addEventListener('change', function(e) {
        const newFiles = Array.from(e.target.files);
        
        // Add new files to our managed array
        uploadedFiles = uploadedFiles.concat(newFiles);
        
        // Clear input value so change event fires even if same files selected again (optional, but good practice)
        // But we need to keep them for the form submission if user doesn't touch anything. 
        // Actually, we will override the input.files on submit, so it's fine.
        
        renderPreviews();
    });

    // Hidden Replace Input
    let replaceIndex = -1;
    const replaceInput = document.createElement('input');
    replaceInput.type = 'file';
    replaceInput.id = 'replace-file-input';
    replaceInput.accept = 'image/*';
    replaceInput.style.display = 'none';
    form.appendChild(replaceInput);

    replaceInput.addEventListener('change', function(e) {
        if (this.files && this.files[0] && replaceIndex !== -1) {
            uploadedFiles[replaceIndex] = this.files[0];
            renderPreviews();
            // Reset input
            this.value = '';
            replaceIndex = -1;
        }
    });

    // Render Preview Thumbnails
    function renderPreviews() {
        previewContainer.innerHTML = '';
        
        uploadedFiles.forEach((file, index) => {
            const reader = new FileReader();
            
            const previewDiv = document.createElement('div');
            previewDiv.classList.add('position-relative', 'preview-item', 'border', 'rounded', 'p-1');
            previewDiv.style.width = '100px';
            previewDiv.style.height = '100px';
            previewDiv.style.cursor = 'grab';
            previewDiv.setAttribute('draggable', 'true');
            previewDiv.dataset.index = index;

            // Image
            const img = document.createElement('img');
            img.classList.add('w-100', 'h-100', 'object-fit-cover', 'rounded');
            
            reader.onload = function(e) {
                img.src = e.target.result;
            }
            reader.readAsDataURL(file);
            
            // Remove Button
            const removeBtn = document.createElement('button');
            removeBtn.innerHTML = '×';
            removeBtn.classList.add('btn', 'btn-danger', 'btn-sm', 'position-absolute', 'top-0', 'end-0', 'p-0');
            removeBtn.style.width = '20px';
            removeBtn.style.height = '20px';
            removeBtn.style.lineHeight = '1';
            removeBtn.onclick = function(e) {
                e.preventDefault(); 
                removeFile(index);
            };

            // Replace Button
            const replaceBtn = document.createElement('button');
            replaceBtn.innerHTML = '↻'; // Refresh icon for replace
            replaceBtn.title = 'Replace Image';
            replaceBtn.classList.add('btn', 'btn-info', 'btn-sm', 'position-absolute', 'top-0', 'start-0', 'p-0', 'text-white');
            replaceBtn.style.width = '20px';
            replaceBtn.style.height = '20px';
            replaceBtn.style.lineHeight = '1';
            replaceBtn.onclick = function(e) {
                e.preventDefault(); 
                replaceIndex = index;
                replaceInput.click();
            };

            // Number Badge
            const badge = document.createElement('div');
            badge.className = 'position-absolute bottom-0 start-50 translate-middle-x bg-dark text-white px-2 py-1 rounded';
            badge.style.fontSize = '0.75rem';
            badge.style.opacity = '0.8';
            badge.textContent = index + 1;

            previewDiv.appendChild(img);
            previewDiv.appendChild(badge);
            previewDiv.appendChild(removeBtn);
            previewDiv.appendChild(replaceBtn); // Add replace button
            previewContainer.appendChild(previewDiv);

            // Drag Events
            previewDiv.addEventListener('dragstart', handleDragStart);
            previewDiv.addEventListener('dragover', handleDragOver);
            previewDiv.addEventListener('drop', handleDrop);
            previewDiv.addEventListener('dragend', handleDragEnd);
        });
    }

    // Remove File
    function removeFile(index) {
        uploadedFiles.splice(index, 1);
        renderPreviews();
    }

    // Drag & Drop State
    let dragSrcEl = null;

    function handleDragStart(e) {
        dragSrcEl = this;
        e.dataTransfer.effectAllowed = 'move';
        this.style.opacity = '0.4';
    }

    function handleDragOver(e) {
        if (e.preventDefault) {
            e.preventDefault();
        }
        e.dataTransfer.dropEffect = 'move';
        return false;
    }

    function handleDragEnd(e) {
        this.style.opacity = '1';
        // Remove visual cues if any
    }

    function handleDrop(e) {
        if (e.stopPropagation) {
            e.stopPropagation();
        }

        if (dragSrcEl !== this) {
            // Get indices
            const srcIndex = parseInt(dragSrcEl.dataset.index);
            const targetIndex = parseInt(this.dataset.index);

            // Reorder array
            const movedItem = uploadedFiles[srcIndex];
            uploadedFiles.splice(srcIndex, 1);
            uploadedFiles.splice(targetIndex, 0, movedItem);

            renderPreviews();
        }
        return false;
    }

    // Intercept Form Submission
    if (form) {
        form.addEventListener('submit', function(e) {
            console.log('Form submit intercepted');
            console.log('uploadedFiles.length:', uploadedFiles.length);
            
            // Only intervene if we have managed files
            if (uploadedFiles.length > 0) {
                console.log('Processing uploaded files...');
                
                 // Create a new DataTransfer object
                const dataTransfer = new DataTransfer();
                
                // Create container for hidden inputs if not exists
                let hiddenContainer = document.getElementById('image-order-inputs');
                if (!hiddenContainer) {
                    hiddenContainer = document.createElement('div');
                    hiddenContainer.id = 'image-order-inputs';
                    hiddenContainer.style.display = 'none';
                    form.appendChild(hiddenContainer);
                }
                hiddenContainer.innerHTML = '';

                const orderArray = [];
                uploadedFiles.forEach(file => {
                    dataTransfer.items.add(file);
                    orderArray.push(file.name);
                    
                    // Add hidden input for original name to ensure backend knows the order
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'new_image_order[]';
                    input.value = file.name;
                    hiddenContainer.appendChild(input);
                });

                console.log('Image order being sent:', orderArray);
                console.log('Hidden inputs created:', hiddenContainer.querySelectorAll('input').length);
                
                // Visual confirmation for debugging
                // alert('Sending ' + uploadedFiles.length + ' images in order: ' + orderArray.join(', '));

                // Assign the ordered files back to the input
                imageInput.files = dataTransfer.files;
            }
        });
    }
});


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
            product_id: "{{ $product->id ?? '' }}"
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

    // Drag-and-drop image sequence for temp images (during creation)
    (function() {
        function initTempImageSort() {
            const container = document.getElementById('sortable-temp-images');
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
                    const allImages = Array.from(container.querySelectorAll('.sortable-image'));
                    const draggedIndex = allImages.indexOf(draggedElement);
                    const targetIndex = allImages.indexOf(this);
                    
                    if (draggedIndex < targetIndex) {
                        this.parentNode.insertBefore(draggedElement, this.nextSibling);
                    } else {
                        this.parentNode.insertBefore(draggedElement, this);
                    }
                    
                    updateTempImageOrder();
                }
                return false;
            }

            function updateTempImageOrder() {
                const orderContainer = document.getElementById('temp-image-order-container');
                orderContainer.innerHTML = '';
                
                let index = 1;
                container.querySelectorAll('.sortable-image').forEach(item => {
                    const path = item.dataset.path;
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'temp_images_order[]';
                    input.value = path;
                    orderContainer.appendChild(input);
                    
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
                    updateTempImageOrder();
                    console.log('✓ Temp image order updated before submit');
                });
            }
            
            console.log('✓ Temp sortable images initialized');
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initTempImageSort);
        } else {
            initTempImageSort();
        }
    })();

    </script>
@endsection