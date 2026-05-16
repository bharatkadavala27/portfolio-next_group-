@extends('layouts.admin')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@section('content')

    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Brand</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html" data-bs-original-title="" title=""><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-home">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg></a></li>
                        <li class="breadcrumb-item">Brand</li>
                        <li class="breadcrumb-item active">Brands Create/Edit</li>
                    </ol>
                </div>
            </div>
        </div>
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



    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ $brand ? 'Edit Brand' : 'Create Brand' }}
                        <a href="{{ url('admin/brands')}}" class="btn btn-danger btn-sm text-white float-end">Back</a>
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.brands.save', $brand->id ?? '') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Brand Name</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" id="name" name="name"
                                    value="{{ old('name', $brand->name ?? '') }}">
                                <small class="text-danger d-none" id="nameError">Required</small>

                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Description</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="description"
                                    name="description">{{ old('description', $brand->description ?? '') }}</textarea>
                                <small class="text-danger d-none" id="descError">Required</small>

                            </div>
                        </div>

                        {{-- <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Category</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="category_id" name="category_id">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $brand->category_id ?? '') ==
                                        $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Serial Number</label>
                            <div class="col-sm-9 position-relative">
                                <input type="number" class="form-control" id="serial_number" name="serial_number"
                                    value="{{ old('serial_number', $brand->serial_number ?? $nextSerialNumber) }}"
                                    autocomplete="off">
                                <small class="text-danger d-none" id="serialError"></small>
                                <div id="takenSerialsDropdown" class="taken-serials-dropdown shadow-sm" style="display: none;">
                                    <h6 class="dropdown-header text-muted border-bottom mb-2 pb-2" style="font-size: 0.85rem;">Taken Serial Numbers</h6>
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
                                        border: 1px solid rgba(0,0,0,0.1);
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

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Show on Footer</label>
                            <div class="col-sm-9">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="show_on_footer"
                                        name="show_on_footer" value="1" {{ old('show_on_footer', $brand->show_on_footer ?? 0) == 1 ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Brand Image
                                <small class="text-muted d-block">
                                    (Recommended: W1000 × H600, PNG, Background transparent/white)
                                </small>
                            </label>

                            <div class="col-sm-9">
                                <input type="file" class="form-control" id="image" name="image">
                                @if($brand && $brand->image)
                                    <div class="mt-2">
                                        <img src="{{ asset($brand->image) }}" alt="{{ $brand->name }}" class="img-thumbnail"
                                            style="max-width: 150px;">
                                    </div>
                                @endif
                            </div>
                        </div>


                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">{{ $brand ? 'UPDATE' : 'SAVE' }}</button>
                        </div>
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
                placeholder: 'Enter brand description...',
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
                validateRequired('name', 'nameError', 'Brand name is required');
            }

            if (e.target.id === 'description') {
                validateRequired('description', 'descError', 'Description is required');
            }

        }, true);

        function validateRequired(id, errorId, msg) {
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
            if (!val) return;

            fetch("{{ route('admin.brands.checkSerial') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    serial_number: val,
                    brand_id: "{{ $brand->id ?? '' }}"
                })
            })
                .then(res => res.json())
                .then(data => {
                    const err = document.getElementById('serialError');
                    const el = document.getElementById('serial_number');
                    const dropdown = document.getElementById('takenSerialsDropdown');
                    const content = document.getElementById('takenSerialsContent');

                    if (data.exists) {
                        err.innerText = 'Serial number already used';
                        err.classList.remove('d-none');
                        el.classList.add('is-invalid');

                        if (data.taken_serials && data.taken_serials.length > 0) {
                            content.innerHTML = '';
                            data.taken_serials.forEach(serial => {
                                const item = document.createElement('div');
                                item.classList.add('taken-serial-item');
                                item.innerText = serial; // Removed 'Taken Serial Numbers: ' prefix as it's in the header now
                                content.appendChild(item);
                            });
                            dropdown.style.display = 'block';
                        }
                    } else {
                        err.classList.add('d-none');
                        el.classList.remove('is-invalid');
                        if (dropdown) {
                            dropdown.style.display = 'none';
                        }
                    }
                });
        }
    </script>
@endsection