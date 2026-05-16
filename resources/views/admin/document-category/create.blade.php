@extends('layouts.admin')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="container-fluid">
        <div class="page-title">
            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Flash Error Message --}}
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Flash Success Message --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Generic Message --}}
            @if (session('message'))
                <div class="alert alert-info">
                    {{ session('message') }}
                </div>
            @endif
            <div class="row">
                <div class="col-6">
                    <h3>Create Download Category</h3>
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
                        <li class="breadcrumb-item">Download Category</li>
                        <li class="breadcrumb-item active">Create Download Category </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            @if (session('message'))
                <div class="alert alert-success mb-3">{{ session('message') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger mb-3">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h3>
                        <a href="{{ route('admin.document-category.index') }}"
                            class="btn btn-danger btn-sm text-white float-end">Back</a>
                    </h3>
                </div>
                <div class="card-body">
                    <form id="createCategoryForm" action="{{ route('admin.document-category.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <!-- Name -->
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input class="form-control @error('name') is-invalid @enderror" type="text" id="name"
                                    name="name" value="{{ old('name') }}">

                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <small class="text-danger d-none" id="nameError"></small>
                            </div>
                        </div>

                        <div class="mb-3 row" style="display: none;">
                            <label class="col-sm-3 col-form-label">Slug</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" id="slug" name="slug" value="{{ old('slug') }}"
                                    readonly>
                            </div>
                        </div>


                        <!-- Description -->
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Description</label>
                            <div class="col-sm-9">
                                <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                            </div>
                        </div>

                        <!-- Serial Number -->
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Serial Number</label>
                            <div class="col-sm-9">
                                <div class="position-relative">
                                    <input class="form-control" type="text" id="serial_number" name="serial_number"
                                        autocomplete="off">
                                    <small class="text-danger d-none" id="serialError"></small>
                                    <div id="takenSerialsDropdown" class="taken-serials-dropdown shadow-sm"
                                        style="display: none;">
                                        <h6 class="dropdown-header text-muted border-bottom mb-2 pb-2"
                                            style="font-size: 0.85rem;">Taken Serial Numbers</h6>
                                        <div id="takenSerialsContent" class="list-group list-group-flush"></div>
                                    </div>
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

                        <!-- Parent Category -->
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Parent Categories</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="parent_id">
                                    <option value="">None</option>
                                    @foreach ($parentCategories as $category)
                                        <option value="{{ $category->id }}" {{ old('parent_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Image -->
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Image</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="file" name="image">
                                <small class="text-muted">Recommended Size: 360x360px</small>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function() {
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
        document.querySelector('input[name="name"]').addEventListener('input', function () {
            let slug = this.value.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
            document.getElementById('slug').value = slug;
        });

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
                    serial_number: null, // Skip serial check in this call
                    id: ""
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
            const serialError = document.getElementById('serialError');
            const serialInput = document.getElementById('serial_number');
            const dropdown = document.getElementById('takenSerialsDropdown');
            const content = document.getElementById('takenSerialsContent');

            if (!val) {
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
                    id: ""
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