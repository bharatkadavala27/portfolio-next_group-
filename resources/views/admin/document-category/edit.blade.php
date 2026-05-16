<!-- filepath: e:\xampp\htdocs\bharat-april\05-04-2025\next-technology\resources\views\admin\document-category\edit.blade.php -->
@extends('layouts.admin')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Edit Document Category</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-home">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                            </a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.document-categories.index') }}">Document
                                Categories</a></li>
                        <li class="breadcrumb-item active">Edit Document Category</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h3>Edit Category</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.document-categories.update', $category->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name', $category->name) }}">
                                <small class="text-danger d-none" id="nameError"></small>
                            </div>

                            <div class="mb-3" style="display: none;">
                                <label for="slug" class="form-label">Slug</label>
                                <input type="text" name="slug" id="slug" class="form-control"
                                    value="{{ old('slug', $category->slug) }}">
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description"
                                    class="form-control">{{ old('description', $category->description) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="serial_number" class="form-label">Serial Number</label>
                                <div class="position-relative">
                                    <input type="number" name="serial_number" id="serial_number" class="form-control"
                                        value="{{ old('serial_number', $category->serial_number) }}" autocomplete="off">
                                    <small class="text-danger d-none" id="serialError"></small>
                                    <div id="takenSerialsDropdown" class="taken-serials-dropdown shadow-sm"
                                        style="display: none;">
                                        <h6 class="dropdown-header text-muted border-bottom mb-2 pb-2"
                                            style="font-size: 0.85rem;">Taken Serial Numbers</h6>
                                        <div id="takenSerialsContent" class="list-group list-group-flush"></div>
                                    </div>
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
                                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                                    border-radius: 4px;
                                    padding: 10px;
                                    max-height: 250px;
                                    overflow-y: auto;
                                    margin-top: 5px;
                                }
                            </style>

                            <div class="mb-3">
                                <label for="parent_id" class="form-label">Parent Category</label>
                                <select name="parent_id" id="parent_id" class="form-control">
                                    <option value="">None</option>
                                    @foreach($parentCategories as $parent)
                                        <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                            {{ $parent->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Image</label>
                                <input type="file" name="image" id="image" class="form-control">
                                <small class="text-muted">Recommended Size: 360x360px</small>
                                @if($category->image)
                                    <img src="{{ asset('document_categories/' . $category->image) }}" alt="Category Image"
                                        class="img-thumbnail mt-2" width="150">
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary">Update Category</button>
                            <a href="{{ route('admin.document-categories.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
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
    <script>
        const nameInput = document.querySelector('input[name="name"]');
        const slugInput = document.getElementById('slug');

        if (nameInput) {
            nameInput.addEventListener('input', function () {
                let slug = this.value.toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                    .replace(/^-+|-+$/g, '');
                slugInput.value = slug;
            });
        }

        document.addEventListener('blur', function (e) {
            if (e.target.id === 'name') {
                checkLive();
            }

            if (e.target.id === 'serial_number') {
                checkLive();
            }
        }, true);

        function checkLive() {
            const nameEl = document.getElementById('name');
            const name = nameEl.value;

            // Verify Name only here (Serial checked separately via autocomplete)
            fetch("{{ route('admin.document-categories.check') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    name: name,
                    serial_number: null,
                    id: "{{ $category->id ?? '' }}"
                })
            })
                .then(res => res.json())
                .then(data => {
                    // Name
                    if (!name.trim()) {
                        document.getElementById('nameError').innerText = 'Name is required';
                        document.getElementById('nameError').classList.remove('d-none');
                        nameEl.classList.add('is-invalid');
                    }
                    else if (data.name_exists) {
                        document.getElementById('nameError').innerText = 'Name already exists';
                        document.getElementById('nameError').classList.remove('d-none');
                        nameEl.classList.add('is-invalid');
                    } else {
                        document.getElementById('nameError').classList.add('d-none');
                        nameEl.classList.remove('is-invalid');
                    }
                });
        }

        function checkSerial(val) {
            const original = "{{ $category->serial_number ?? '' }}";
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

            fetch("{{ route('admin.document-categories.checkSerial') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    serial_number: val,
                    id: "{{ $category->id ?? '' }}"
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
        document.getElementById('serial_number').addEventListener('input', function (e) {
            checkSerial(e.target.value);
        });
    </script>

@endsection