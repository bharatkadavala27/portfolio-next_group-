@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <h3>Edit Document Type</h3>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Edit Document Type</h5>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error! Please fix the following:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('admin.document-types.update', $documentType->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ old('name', $documentType->name) }}">
                        <small class="text-danger d-none" id="nameError">Name is required</small>
                    </div>

                    <div class="mb-3">
                        <label for="serial_number" class="form-label">Serial Number</label>
                        <div class="position-relative">
                            <input type="number" class="form-control" id="serial_number" name="serial_number"
                                value="{{ old('serial_number', $documentType->serial_number) }}" autocomplete="off">
                            <small class="text-danger d-none" id="serialError"></small>
                            <div id="takenSerialsDropdown" class="taken-serials-dropdown shadow-sm" style="display: none;">
                                <h6 class="dropdown-header text-muted border-bottom mb-2 pb-2" style="font-size: 0.85rem;">
                                    Taken Serial Numbers</h6>
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
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description"
                            rows="3">{{ old('description', $documentType->description) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image
                            <small class="text-muted d-block">
                                (Recommended size: 70 X 70px , PNG with transparent or white background)
                            </small>
                        </label>
                        @if($documentType->image)
                            <div class="mb-2">
                                <img src="{{ asset('document-types/' . $documentType->image) }}" alt="Current Image"
                                    style="max-width: 200px">
                            </div>
                        @endif
                        <input type="file" class="form-control" id="image" name="image">
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
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

            if (!el.value) {
                err.classList.remove('d-none');
                el.classList.add('is-invalid');
            } else {
                err.classList.add('d-none');
                el.classList.remove('is-invalid');
            }
        }

        function checkSerial(val) {
            const original = "{{ $documentType->serial_number ?? '' }}";
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

            fetch("{{ route('admin.document-types.checkSerial') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    serial_number: val,
                    id: "{{ $documentType->id ?? '' }}"
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