@extends('layouts.admin')

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
                    <h3>Download Brand</h3>
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
                        <li class="breadcrumb-item">Document Brand</li>
                        <li class="breadcrumb-item active">Document Brands Create/Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ $documentBrand ? 'Edit Brand' : 'Create Brand' }}
                        <a href="{{ route('admin.document-brands.index') }}"
                            class="btn btn-danger btn-sm text-white float-end">Back</a>
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.document-brands.save', $documentBrand->id ?? '') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Document Brand Name</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" id="name" name="name"
                                    value="{{ old('name', $documentBrand->name ?? '') }}">
                                <small class="text-danger d-none" id="nameError">Name is required</small>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Description</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="description"
                                    name="description">{{ old('description', $documentBrand->description ?? '') }}</textarea>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Serial Number</label>
                            <div class="col-sm-9">
                                <div class="position-relative">
                                    <input type="number" class="form-control" id="serial_number" name="serial_number"
                                        value="{{ old('serial_number', $documentBrand->serial_number ?? ($nextSerialNumber ?? 1)) }}"
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

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Document Brand Image</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" id="image" name="image">
                                @if (isset($documentBrand) && $documentBrand->image)
                                    <div class="mt-2">
                                        <img src="{{ asset($documentBrand->image) }}" alt="{{ $documentBrand->name }}"
                                            class="img-thumbnail" style="max-width: 150px;">
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="submit"
                                class="btn btn-primary">{{ $documentBrand ? 'Update Document Brand' : 'Create Document Brand' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('blur', function (e) {
            if (e.target.id === 'name') {
                required('name', 'nameError');
            }

            if (e.target.id === 'serial_number') {
                checkSerial(e.target.value);
            }
        }, true);

        function required(id, errId) {
            const el = document.getElementById(id);
            const err = document.getElementById(errId);

            if (!el.value.trim()) {
                err.classList.remove('d-none');
                el.classList.add('is-invalid');
            } else {
                err.classList.add('d-none');
                el.classList.remove('is-invalid');
            }
        }

        function checkSerial(val) {
            const original = "{{ $documentBrand->serial_number ?? '' }}";
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

            fetch("{{ route('admin.document-brands.checkSerial') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    serial_number: val,
                    id: "{{ $documentBrand->id ?? '' }}"
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