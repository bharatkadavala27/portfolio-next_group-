@extends('layouts.admin')

@section('content')

    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Download Brand</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}" data-bs-original-title="" title="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-home">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                            </a>
                        </li>
                        <li class="breadcrumb-item">Document Brand</li>
                        <li class="breadcrumb-item active">Document Brand Edit</li>
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
                    <h3>Edit Document Brand
                        <a href="{{ route('admin.document-brand.index') }}"
                            class="btn btn-danger btn-sm text-white float-end">Back</a>
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.document-brand.update', $documentBrand->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Brand Name -->
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Brand Name</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" id="name" name="name"
                                    value="{{ $documentBrand->name }}">
                                <small class="text-danger d-none" id="nameError">Name is required</small>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Description</label>
                            <div class="col-sm-9">
                                <textarea class="form-control"
                                    name="description">{{ $documentBrand->description }}</textarea>
                            </div>
                        </div>

                        <!-- Serial Number -->
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Serial Number</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="number" id="serial_number" name="serial_number"
                                    value="{{ $documentBrand->serial_number }}">
                                <small class="text-danger d-none" id="serialError"></small>
                            </div>
                        </div>

                        <!-- Update Image -->
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Update Image</label>
                            <div class="col-sm-9">
                                <input type="file" name="image" class="form-control">
                                @if ($documentBrand->image)
                                    <div class="mt-3">
                                        <img src="{{ asset($documentBrand->image) }}" alt="Document Brand Image"
                                            style="width: 150px; height: auto;">
                                        <button type="button" class="btn btn-danger btn-sm mt-2" id="remove-image-button"
                                            data-id="{{ $documentBrand->id }}">Remove</button>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Update Document Brand</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const removeButton = document.getElementById('remove-image-button');
            if (removeButton) {
                removeButton.addEventListener('click', function () {
                    const documentBrandId = this.getAttribute('data-id');
                    if (confirm('Are you sure you want to remove this image?')) {
                        fetch(`/admin/document-brands/${documentBrandId}/remove-image`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                            },
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert(data.message);
                                    location.reload();
                                } else {
                                    alert(data.message);
                                }
                            })
                            .catch(error => console.error('Error:', error));
                    }
                });
            }
        });

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

            if (!val || val == original) {
                document.getElementById('serialError').classList.add('d-none');
                document.getElementById('serial_number').classList.remove('is-invalid');
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
                .then(d => {
                    if (d.exists) {
                        document.getElementById('serialError').innerText = 'Serial number already exists';
                        document.getElementById('serialError').classList.remove('d-none');
                        document.getElementById('serial_number').classList.add('is-invalid');
                    } else {
                        document.getElementById('serialError').classList.add('d-none');
                        document.getElementById('serial_number').classList.remove('is-invalid');
                    }
                });
        }
    </script>

@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function () {
            $('textarea[name="description"]').summernote({
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