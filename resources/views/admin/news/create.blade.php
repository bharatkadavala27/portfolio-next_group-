@extends('layouts.admin')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>News</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.html">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-home">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                            </a>
                        </li>
                        <li class="breadcrumb-item">News</li>
                        <li class="breadcrumb-item active">News Add</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>{{ isset($news->id) ? 'Edit News' : 'Create News' }}
                        <a href="{{ url('admin/news') }}" class="btn btn-danger btn-sm text-white float-end">Back</a>
                    </h3>
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

                    <form
                        action="{{ isset($news->id) ? route('admin.news.update', $news->id) : route('admin.news.store') }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @if (isset($news->id))
                            @method('PUT')
                        @endif

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">News Header</label>
                            <div class="col-sm-9">
                                <input type="text" name="header" id="header"
                                    class="form-control @error('header') is-invalid @enderror"
                                    value="{{ old('header', $news->header ?? '') }}">
                                @error('header')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                                <small class="text-danger d-none" id="headerError"></small>

                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Main Description</label>
                            <div class="col-sm-9">
                                <textarea name="description" id="description"
                                    class="form-control @error('description') is-invalid @enderror">{{ old('description', $news->description ?? '') }}</textarea>
                                @error('description')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                                <small class="text-danger d-none" id="descError"></small>

                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Main Image</label>
                            <div class="col-sm-9">
                                <input type="file" name="image" id="mainImageInput"
                                    class="form-control @error('image') is-invalid @enderror">
                                <small class="text-secondary">Recommended Size: 1200px (W) x 600px (H)</small>
                                @error('image')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                                @if ($errors->any() && !isset($news->image))
                                    <div class="alert alert-warning mt-2 py-1 px-2 mb-0" style="font-size: 0.85rem;">
                                        <i class="fa fa-exclamation-triangle"></i> Please re-select the main image (file inputs
                                        cannot be preserved after validation errors).
                                    </div>
                                @endif
                                @if (isset($news->image))
                                    <img src="{{ asset($news->image) }}" alt="{{ $news->header }}" class="img-thumbnail mt-2"
                                        style="width: 150px;">
                                @endif
                                <img id="mainImagePreview" class="img-thumbnail mt-2 d-none" style="width: 150px;">
                            </div>
                        </div>

                        {{-- Short Details --}}
                        <div class="card-header">
                            <h3> Add Short Details
                                <button type="button" class="btn btn-success btn-sm text-white float-end" id="add-detail">+
                                    Add Detail</button>
                            </h3>
                        </div>

                        <div class="card-body short-details">
                            @php
                                // Merge details from model (edit mode) and old input (validation failure)
                                $detailsData = [];
                                if (isset($news) && isset($news->details) && $news->details->count()) {
                                    foreach ($news->details as $i => $detail) {
                                        $detailsData[] = [
                                            'id' => $detail->id,
                                            'short_title' => old("details.$i.short_title", $detail->short_title),
                                            'short_description' => old("details.$i.short_description", $detail->short_description),
                                            'short_image_url' => $detail->short_image ? asset($detail->short_image) : null,
                                        ];
                                    }
                                } elseif (old('details')) {
                                    foreach (old('details') as $i => $detail) {
                                        $detailsData[] = [
                                            'id' => $detail['id'] ?? null,
                                            'short_title' => $detail['short_title'] ?? '',
                                            'short_description' => $detail['short_description'] ?? '',
                                            'short_image_url' => null,
                                        ];
                                    }
                                }
                            @endphp

                            @foreach ($detailsData as $index => $detail)
                                <div class="detail-box mb-4 border p-3 rounded">
                                    @if (!empty($detail['id']))
                                        <input type="hidden" name="details[{{ $index }}][id]" value="{{ $detail['id'] }}">
                                    @endif
                                    <h4>Short Detail #{{ $index + 1 }}</h4>

                                    <div class="mb-3 row">
                                        <label for="details[{{ $index }}][short_title]" class="col-sm-3 col-form-label">Short
                                            Title</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="details[{{ $index }}][short_title]" class="form-control"
                                                value="{{ $detail['short_title'] }}">
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="details[{{ $index }}][short_description]"
                                            class="col-sm-3 col-form-label">Short Description</label>
                                        <div class="col-sm-9">
                                            <textarea name="details[{{ $index }}][short_description]"
                                                class="form-control summernote-short">{!! $detail['short_description'] !!}</textarea>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="details[{{ $index }}][short_image]" class="col-sm-3 col-form-label">Short
                                            Image</label>
                                        <div class="col-sm-9">
                                            <input type="file" name="details[{{ $index }}][short_image]" class="form-control">
                                            <small class="text-secondary">Recommended Size: 800px (W) x 400px (H)</small>
                                            @if (!empty($detail['short_image_url']))
                                                <img src="{{ $detail['short_image_url'] }}" alt="{{ $detail['short_title'] }}"
                                                    class="img-thumbnail mt-2" style="width: 100px;">
                                            @elseif ($errors->any())
                                                <div class="alert alert-warning mt-2 py-1 px-2 mb-0" style="font-size: 0.85rem;">
                                                    <i class="fa fa-exclamation-triangle"></i> Please re-select the image.
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-danger remove-detail mt-2">Remove Detail</button>
                                    <hr>
                                </div>
                            @endforeach
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">{{ isset($news->id) ? 'Update' : 'Create' }}
                            News</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const addDetailButton = document.getElementById('add-detail');
            const shortDetailsSection = document.querySelector('.short-details');

            addDetailButton.addEventListener('click', () => {
                const detailCount = shortDetailsSection.querySelectorAll('.detail-box').length;

                const newDetail = `
                                                    <div class="detail-box mb-4 border p-3 rounded">
                                                        <h4>Short Detail #${detailCount + 1}</h4>
                                                        <div class="mb-3 row">
                                                            <label for="details[${detailCount}][short_title]" class="col-sm-3 col-form-label">Short Title</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="details[${detailCount}][short_title]" class="form-control" >
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="details[${detailCount}][short_description]" class="col-sm-3 col-form-label">Short Description</label>
                                                            <div class="col-sm-9">
                                                                <textarea name="details[${detailCount}][short_description]" class="form-control summernote-short" ></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="details[${detailCount}][short_image]" class="col-sm-3 col-form-label">Short Image</label>
                                                            <div class="col-sm-9">
                                                                <input type="file" name="details[${detailCount}][short_image]" class="form-control">
                                                                <small class="text-secondary">Recommended Size: 800px (W) x 400px (H)</small>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn btn-danger remove-detail mt-2">Remove Detail</button>
                                                        <hr>
                                                    </div>
                                                `;

                shortDetailsSection.insertAdjacentHTML('beforeend', newDetail);
            });

            shortDetailsSection.addEventListener('click', (e) => {
                if (e.target.classList.contains('remove-detail')) {
                    const detailBox = e.target.closest('.detail-box');
                    detailBox.remove();

                    const detailBoxes = shortDetailsSection.querySelectorAll('.detail-box');
                    detailBoxes.forEach((box, index) => {
                        box.querySelector('h4').textContent = `Short Detail #${index + 1}`;
                        box.querySelectorAll('input, textarea').forEach((input) => {
                            const name = input.getAttribute('name');
                            if (name) {
                                input.setAttribute('name', name.replace(/\[\d+\]/, `[${index}]`));
                            }
                        });
                    });
                }
            });

            // Main image preview
            const mainImageInput = document.getElementById('mainImageInput');
            const mainImagePreview = document.getElementById('mainImagePreview');
            if (mainImageInput && mainImagePreview) {
                mainImageInput.addEventListener('change', function () {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            mainImagePreview.src = e.target.result;
                            mainImagePreview.classList.remove('d-none');
                        };
                        reader.readAsDataURL(this.files[0]);
                    } else {
                        mainImagePreview.classList.add('d-none');
                    }
                });
            }
        });


        document.addEventListener('blur', function (e) {

            if (e.target.id === 'header') {
                requiredCheck('header', 'headerError', 'News header is required');
            }

            if (e.target.id === 'description') {
                requiredCheck('description', 'descError', 'Description is required');
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

    </script>
@endsection


@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function () {
            // Summernote options for Short Description
            var summernoteOptions = {
                placeholder: 'Enter short description...',
                tabsize: 2,
                height: 150,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['help']]
                ]
            };

            // Initialize Summernote for existing short descriptions
            $('.summernote-short').summernote(summernoteOptions);

            // Initialize Summernote for Main Description
            $('#description').summernote({
                placeholder: 'Enter news description...',
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

            // Re-bind Summernote for new dynamic fields
            const addDetailButton = document.getElementById('add-detail');
            if (addDetailButton) {
                addDetailButton.addEventListener('click', () => {
                    // Short delay to allow DOM update
                    setTimeout(() => {
                        $('.summernote-short').summernote(summernoteOptions);
                    }, 100);
                });
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // We need to capture the click BEFORE the new element exists in the DOM to attach Summernote
            // However, the previous script block handles the click event to add HTML.
            // Here we just modify the template literal to include the class.
            // NOTE: The previous script block is vanilla JS and this one is jQuery mixed.
            // To ensure clean separation, we will rely on identifying the new element by class.
        });
    </script>
@endsection