@extends('layouts.admin')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="container-fluid">
        <div class="page-title">


            <div class="row">
                <div class="col-6">
                    <h3>Category</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin') }}" data-bs-original-title="" title="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-home">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                            </a>
                        </li>
                        <li class="breadcrumb-item">Category</li>
                        <li class="breadcrumb-item active">Category Add</li>
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

            <div class="card">
                <div class="card-header">
                    <h3>Add Category
                        <a href="{{ url('admin/categories') }}" class="btn btn-danger btn-sm text-white float-end">Back</a>
                    </h3>
                </div>
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
                <div class="card-body">
                    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- Name -->
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}">
                                <small class="text-danger d-none" id="nameError"></small>


                            </div>
                        </div>

                        <!-- Slug -->
                        {{-- <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Slug</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="slug">
                            </div>
                        </div> --}}

                        <!-- Description -->
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Description</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="description"
                                    id="description">{{ old('description') }}</textarea>
                                <small class="text-danger d-none" id="descError"></small>

                            </div>
                        </div>

                        <!-- Serial Number -->
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Serial Number</label>
                            <div class="col-sm-9 position-relative">
                                <input class="form-control" type="text" name="serial_number" id="serial_number"
                                    autocomplete="off" value="{{ old('serial_number') }}">
                                <small class="text-danger d-none" id="serialError"></small>
                                <div id="takenSerialsDropdown" class="taken-serials-dropdown shadow-sm"
                                    style="display: none;">
                                    <h6 class="dropdown-header text-muted border-bottom mb-2 pb-2"
                                        style="font-size: 0.85rem;">Taken Serial Numbers</h6>
                                    <div id="takenSerialsContent" class="list-group list-group-flush"></div>
                                </div>
                                <style>
                                    .taken-serials-dropdown {
                                        position: absolute;
                                        top: 100%;
                                        left: 12px;
                                        right: 12px;
                                        z-index: 1000;
                                        background: #fff;
                                        border: 1px solid rgba(0, 0, 0, 0.1);
                                        border-radius: 4px;
                                        padding: 10px;
                                        max-height: 250px;
                                        overflow-y: auto;
                                        margin-top: 5px;
                                    }

                                    .taken-serials-dropdown::-webkit-scrollbar {
                                        width: 6px;
                                    }

                                    .taken-serials-dropdown::-webkit-scrollbar-thumb {
                                        background: #ccc;
                                        border-radius: 3px;
                                    }

                                    .taken-serial-item {
                                        padding: 8px 12px;
                                        color: #333;
                                        font-size: 0.9rem;
                                        border-bottom: 1px solid #f0f0f0;
                                        cursor: default;
                                    }

                                    .taken-serial-item:last-child {
                                        border-bottom: none;
                                    }
                                </style>
                            </div>
                        </div>

                        <!-- Show on Footer -->
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Show on Footer</label>
                            <div class="col-sm-9">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="show_on_footer"
                                        name="show_on_footer" value="1" {{ old('show_on_footer') ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>

                        <!-- Parent Category -->
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Parent Categories</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="parent_id">
                                    <option value="">None</option>
                                    @php $selectedCategoryId = old('parent_id'); @endphp
                                    @foreach ($parentCategories as $category)
                                        <!-- Display category and recursively display its children -->
                                        @include('admin.category.partials.category_option', ['category' => $category, 'level' => 0, 'selectedCategoryId' => $selectedCategoryId])
                                    @endforeach
                                </select>
                            </div>
                        </div>




                        <!-- Image -->
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Image
                                <small class="text-muted d-block">
                                    (Recommended size: 300px width × 370px height, PNG with transparent background)
                                </small>
                            </label>
                            <div class="col-sm-9">
                                <input class="form-control" type="file" name="image">
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

    <script>
        let serialTimer;
        document.addEventListener('input', function (e) {
            if (e.target.id === 'serial_number') {
                clearTimeout(serialTimer);
                serialTimer = setTimeout(() => {
                    checkSerial(e.target.value);
                }, 300);
            }
        });

        document.addEventListener('blur', function (e) {

            if (e.target.id === 'name') {
                requiredCheck('name', 'nameError', 'Category name is required');
            }

        }, true);

        function requiredCheck(id, errorId, msg) {
            const el = document.getElementById(id);
            const err = document.getElementById(errorId);

            if (!el.value.trim()) {
                err.innerText = msg;
                err.classList.remove('d-none');
                el.classList.add('is-invalid');
            } else {
                err.classList.add('d-none');
                el.classList.remove('is-invalid');
            }
        }

        function checkSerial(val) {
            if (!val) {
                document.getElementById('serialError').classList.add('d-none');
                document.getElementById('serial_number').classList.remove('is-invalid');
                const dropdown = document.getElementById('takenSerialsDropdown');
                if (dropdown) dropdown.style.display = 'none';
                return;
            }

            fetch("{{ route('admin.categories.checkSerial') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ serial_number: val })
            })
                .then(res => res.json())
                .then(data => {
                    const err = document.getElementById('serialError');
                    const el = document.getElementById('serial_number');
                    const dropdown = document.getElementById('takenSerialsDropdown');
                    const content = document.getElementById('takenSerialsContent');

                    if (data.exists) {
                        err.innerText = 'Serial number already exists';
                        err.classList.remove('d-none');
                        el.classList.add('is-invalid');
                    } else {
                        err.classList.add('d-none');
                        el.classList.remove('is-invalid');
                    }

                    // Always show dropdown if we have matching serials found (autocomplete behavior)
                    if (data.taken_serials && data.taken_serials.length > 0) {
                        content.innerHTML = '';
                        data.taken_serials.forEach(serial => {
                            const item = document.createElement('div');
                            item.classList.add('taken-serial-item');
                            item.innerText = serial;
                            content.appendChild(item);
                        });
                        dropdown.style.display = 'block';
                    } else {
                        if (dropdown) dropdown.style.display = 'none';
                    }
                });
        }
    </script>


@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#description').summernote({
                placeholder: 'Enter category description...',
                tabsize: 2,
                height: 200,
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
@endsection