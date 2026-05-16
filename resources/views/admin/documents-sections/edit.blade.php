@extends('layouts.admin')

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-header pt-5">
            <h4>Edit Document Section</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.documents-sections.update', $document->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="document_name" class="form-label">Document Name</label>
                    <input type="text" name="document_name" class="form-control" id="document_name"
                        value="{{ old('document_name', $document->document_name) }}">
                    <small class="text-danger d-none" id="docNameError">Document name is required</small>
                    @error('document_name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="document_type" class="form-label">Document Type</label>
                    <select name="document_type" class="form-control" id="document_type">
                        <option value="">Select Document Type</option>
                        @foreach ($documentTypes as $type)
                            <option value="{{ $type->id }}" {{ old('document_type', $document->document_type) == $type->name ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-danger d-none" id="docTypeError">Document type is required</small>
                    @error('document_type')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="document_category" class="form-label">Document Category</label>
                    <select name="document_category" class="form-control" id="document_category">
                        <option value="">Select Document Category</option>
                        @foreach ($documentCategories as $category)
                            @php
                                $isParent = $category->children && $category->children->count() > 0;
                                $selected = '';
                                if (old('document_category')) {
                                    $selected = old('document_category') == $category->id ? 'selected' : '';
                                } else {
                                    // existing document stores category name in document_category
                                    $selected = $document->document_category == $category->name ? 'selected' : '';
                                }
                            @endphp
                            <option value="{{ $category->id }}" {{ $selected }} {{ $isParent ? 'disabled' : '' }}>
                                {!! $category->formatted_name !!}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-danger d-none" id="docCategoryError">Document category is required</small>
                    @error('document_category')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="document_brand" class="form-label">Document Brand</label>
                    <select name="document_brand" class="form-control" id="document_brand">
                        <option value="">Select Document Brand</option>
                        @foreach ($documentBrands as $brand)
                            <option value="{{ $brand->id }}" {{ old('document_brand', $document->document_brand) == $brand->name ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-danger d-none" id="docBrandError">Document brand is required</small>
                    @error('document_brand')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" class="form-control"
                        id="description">{{ old('description', $document->description) }}</textarea>
                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>


                <!-- Filter Name(s) and Options (dynamic) -->
                <div class="mb-3">
                    <label class="form-label">Filters</label>

                    <div id="filters-container">
                        {{-- Prepare initial index and old values; fall back to $document->filters --}}
                        @php
                            $oldFilters = old('filter_id', []);
                            $oldOptions = old('filter_option_id', []);

                            // If no old input, build from existing document filters (FilterOption models)
                            if (!is_array($oldFilters) || empty($oldFilters)) {
                                $oldFilters = $document->filters->map(function ($opt) {
                                    return $opt->filter_id;
                                })->toArray();
                            }
                            if (!is_array($oldOptions) || empty($oldOptions)) {
                                $oldOptions = $document->filters->pluck('id')->toArray();
                            }

                            if (empty($oldFilters)) {
                                $oldFilters = [''];
                            }
                            if (empty($oldOptions)) {
                                $oldOptions = [''];
                            }
                        @endphp

                        @foreach ($oldFilters as $i => $oldFilterValue)
                            <div class="filter-pair mb-2 d-flex align-items-start" data-index="{{ $i }}">
                                <select name="filter_id[]" class="form-control me-2 filter-select">
                                    <option value="">Select Filter</option>
                                    @foreach ($filters as $filter)
                                        <option value="{{ $filter->id }}" {{ (string) $oldFilterValue === (string) $filter->id ? 'selected' : '' }}>{{ $filter->name }}</option>
                                    @endforeach
                                </select>

                                @php
                                    $filterObj = $filters->firstWhere('id', $oldFilterValue);
                                    $optionsList = $filterObj ? $filterObj->options : collect();
                                    $selectedOptionValue = isset($oldOptions[$i]) ? $oldOptions[$i] : '';
                                @endphp
                                <select name="filter_option_id[]" class="form-control me-2 filter-option-select"
                                    data-selected="{{ $selectedOptionValue }}">
                                    <option value="">Select Option</option>
                                    @foreach($optionsList as $opt)
                                        <option value="{{ $opt->id }}" {{ (string) $selectedOptionValue === (string) $opt->id ? 'selected' : '' }}>{{ $opt->name }}</option>
                                    @endforeach
                                </select>

                                <button type="button" class="btn btn-success btn-add me-1" title="Add">+</button>
                                <button type="button" class="btn btn-danger btn-remove" title="Remove">−</button>
                            </div>
                        @endforeach
                    </div>

                    @error('filter_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    @error('filter_option_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="file_link" class="form-label">File Link (Optional)</label>
                    <input type="url" name="file_link" class="form-control" id="file_link"
                        value="{{ old('file_link', $document->file_link) }}"
                        placeholder="Enter file URL if not uploading directly">
                    @error('file_link')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>



                <div class="mb-3">
                    <label for="version_date" class="form-label">Version Date</label>
                    <input type="date" name="version_date" class="form-control" id="version_date"
                        value="{{ old('version_date', $document->version_date ? $document->version_date->format('Y-m-d') : '') }}">
                    @error('version_date')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="version" class="form-label">Version</label>
                    <input type="text" name="version" class="form-control" id="version"
                        value="{{ old('version', $document->version) }}" placeholder="e.g., 1.0">
                    @error('version')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="size" class="form-label">Size</label>
                    <input type="text" name="size" class="form-control" id="size" value="{{ old('size', $document->size) }}"
                        placeholder="e.g., 1MB">
                    @error('size')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Current Documents</label>
                    @if($document->documents)
                        <div class="list-group mb-3">
                            @foreach(explode(',', $document->documents) as $index => $file)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="{{ asset(explode(',', $document->file_path)[$index] ?? '') }}" target="_blank">
                                        {{ $file }}
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm delete-file"
                                        data-file="{{ explode(',', $document->file_path)[$index] ?? '' }}"
                                        data-document-id="{{ $document->id }}">
                                        Remove
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>No documents currently attached.</p>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="documents" class="form-label">Add New Documents</label>
                    <input type="file" name="documents[]" class="form-control" multiple>
                    <small class="text-danger d-none" id="fileError">Upload document files OR provide file link</small>
                    @error('documents')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    @error('documents.*')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.documents-sections.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>

    @push('script')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Debug log to confirm script is running
                console.log('Document deletion script initialized');

                // Set up CSRF token for all AJAX requests
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                // Debug log to show CSRF token is set
                console.log('CSRF token configured');

                // Using event delegation for delete buttons
                $(document).on('click', '.delete-file', function (e) {
                    e.preventDefault();
                    console.log('Delete button clicked'); // Debug log

                    const button = $(this);
                    const file = button.data('file');
                    const documentId = button.data('document-id');
                    const listItem = button.closest('.list-group-item');

                    console.log('File:', file); // Debug log
                    console.log('Document ID:', documentId); // Debug log

                    if (!confirm('Are you sure you want to remove this file?')) {
                        return;
                    }

                    // Show loading state
                    button.prop('disabled', true).html('<span>Removing...</span>');

                    // Debug log the URL
                    console.log('Delete URL:', '{{ route("admin.documents-sections.delete-file") }}');

                    $.ajax({
                        url: '{{ route("admin.documents-sections.delete-file") }}',
                        type: 'POST',
                        data: {
                            file: file,
                            document_id: documentId
                        },
                        dataType: 'json',
                        success: function (response) {
                            console.log('Success response:', response); // Debug log
                            if (response.success) {
                                // Fade out and remove the item
                                listItem.fadeOut(300, function () {
                                    $(this).remove();
                                    // Check if this was the last document
                                    if ($('.list-group-item').length === 0) {
                                        $('.list-group').replaceWith('<p>No documents currently attached.</p>');
                                    }

                                    // Show success notification using bootstrap-notify
                                    $.notify({
                                        message: 'File removed successfully'
                                    }, {
                                        type: 'success',
                                        delay: 3000,
                                        placement: {
                                            from: 'top',
                                            align: 'right'
                                        }
                                    });
                                });
                            } else {
                                button.prop('disabled', false).text('Remove');
                                showError(response.message || 'Failed to remove file');
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Error response:', error); // Debug log
                            console.error('XHR:', xhr); // Debug log
                            button.prop('disabled', false).text('Remove');
                            const message = xhr.responseJSON?.message || 'An error occurred while removing the file';
                            showError(message);
                        }
                    });
                });

                function showError(message) {
                    // Use bootstrap-notify for error messages
                    $.notify({
                        message: message
                    }, {
                        type: 'danger',
                        delay: 3000,
                        placement: {
                            from: 'top',
                            align: 'right'
                        }
                    });
                }
            });
        </script>
    @endpush

    @push('script')
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                let filters = @json($filters) || [];
                if (!Array.isArray(filters)) {
                    try { filters = Object.values(filters); } catch (e) { filters = []; }
                }

                const container = document.getElementById('filters-container');
                if (!container) return;

                function populateOptionsForSelect(filterSelect, optionSelect) {
                    const selectedId = filterSelect.value;
                    // preserve any currently selected option value so we can restore it after repopulating
                    const prevSelected = optionSelect.value || optionSelect.getAttribute('data-selected') || '';
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
                    // restore previously selected value if still present
                    if (prevSelected) {
                        optionSelect.value = prevSelected;
                    }
                }

                function attachDirectListeners() {
                    Array.from(container.querySelectorAll('.filter-pair')).forEach(pair => {
                        const filterSel = pair.querySelector('.filter-select');
                        const optionSel = pair.querySelector('.filter-option-select');
                        const addBtn = pair.querySelector('.btn-add');
                        const remBtn = pair.querySelector('.btn-remove');

                        if (filterSel) {
                            filterSel.addEventListener('change', function () { populateOptionsForSelect(this, optionSel); });
                        }

                        if (addBtn) {
                            addBtn.addEventListener('click', function () { addFilterPair(); });
                        }

                        if (remBtn) {
                            remBtn.addEventListener('click', function () {
                                if (container.querySelectorAll('.filter-pair').length > 1) pair.remove();
                                else { if (filterSel) filterSel.value = ''; if (optionSel) optionSel.innerHTML = '<option value="">Select Option</option>'; }
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
                    addBtn.type = 'button'; addBtn.className = 'btn btn-success btn-add me-1'; addBtn.textContent = '+';

                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button'; removeBtn.className = 'btn btn-danger btn-remove'; removeBtn.textContent = '−';

                    wrapper.appendChild(filterSel); wrapper.appendChild(optionSel); wrapper.appendChild(addBtn); wrapper.appendChild(removeBtn);
                    container.appendChild(wrapper);

                    filterSel.addEventListener('change', function () { populateOptionsForSelect(this, optionSel); });
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

                // Initialize existing pairs (ensure buttons are type=button and populate options where needed)
                Array.from(container.querySelectorAll('.filter-pair')).forEach(pair => {
                    const addBtn = pair.querySelector('.btn-add');
                    const remBtn = pair.querySelector('.btn-remove');
                    if (addBtn) addBtn.type = 'button'; if (remBtn) remBtn.type = 'button';

                    const filterSel = pair.querySelector('.filter-select');
                    const optionSel = pair.querySelector('.filter-option-select');
                    if (filterSel && filterSel.value) populateOptionsForSelect(filterSel, optionSel);
                });

                attachDirectListeners();
            });
        </script>
    @endpush

    <script>
        document.addEventListener('blur', function (e) {
            if (e.target.id === 'document_name') required('document_name', 'docNameError');
            if (e.target.id === 'document_type') required('document_type', 'docTypeError');
            if (e.target.id === 'document_category') required('document_category', 'docCategoryError');
            if (e.target.id === 'document_brand') required('document_brand', 'docBrandError');
        }, true);

        function required(id, errorId) {
            const el = document.getElementById(id);
            const err = document.getElementById(errorId);
            if (!el.value.trim()) {
                err.classList.remove('d-none');
                el.classList.add('is-invalid');
                return false;
            } else {
                err.classList.add('d-none');
                el.classList.remove('is-invalid');
                return true;
            }
        }

        // Special case: documents OR file_link
        document.querySelector('form').addEventListener('submit', function (e) {
            const files = document.querySelector('input[name="documents[]"]').files.length;
            const link = document.getElementById('file_link').value.trim();
            if (!files && !link) {
                e.preventDefault();
                document.getElementById('fileError').classList.remove('d-none');
            } else {
                document.getElementById('fileError').classList.add('d-none');
            }
        });
    </script>

@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#description').summernote({
                placeholder: 'Enter your description here...',
                tabsize: 2,
                height: 100,
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
@endpush