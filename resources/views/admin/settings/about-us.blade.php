@extends('layouts.admin')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@section('content')

    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Setting</h3>
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
                        <li class="breadcrumb-item">About Us</li>
                        <li class="breadcrumb-item active">About-Us Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <!-- Card Wrapper for About Us Settings -->
    <div class="container-fluid">
        <form action="{{ url('admin/settings/about-us') }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- @method('PUT') <!-- Use PUT method if updating existing settings --> --}}

            <!-- Card Wrapper for About Us Settings -->
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <h3 class="mt-2">About Us Setting</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Section 1 -->
                        <div class="col-md-4 mb-3">
                            <label for="about_us_image_1" class="form-label">Image 1</label>
                            <input type="file" id="about_us_image_1" name="about_us_image_1" class="form-control">
                            <small class="text-secondary">Recommended Size: 800px (W) x 600px (H)</small>
                            <img src="{{ asset($setting->about_us_image_1 ?? '') }}" width="100" alt="Image 1">

                            <label for="about_us_title_1" class="form-label mt-2">Title 1</label>
                            <input type="text" id="about_us_title_1" name="about_us_title_1" class="form-control"
                                value="{{ $setting->about_us_title_1 ?? '' }}">
                            @error('about_us_title_1')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                            <label for="about_us_description_1" class="form-label mt-2">Description 1</label>
                            <textarea id="about_us_description_1" name="about_us_description_1" class="form-control" rows="3">{{ $setting->about_us_description_1 ?? '' }}</textarea>
                            @error('about_us_description_1')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Section 2 -->
                        <div class="col-md-4 mb-3">
                            <label for="about_us_image_2" class="form-label">Image 2</label>
                            <input type="file" id="about_us_image_2" name="about_us_image_2" class="form-control">
                            <small class="text-secondary">Recommended Size: 800px (W) x 600px (H)</small>
                            <img src="{{ asset($setting->about_us_image_2 ?? '') }}" width="100" alt="Image 2">

                            <label for="about_us_title_2" class="form-label mt-2">Title 2</label>
                            <input type="text" id="about_us_title_2" name="about_us_title_2" class="form-control"
                                value="{{ $setting->about_us_title_2 ?? '' }}">
                            @error('about_us_title_2')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                            <label for="about_us_description_2" class="form-label mt-2">Description 2</label>
                            <textarea id="about_us_description_2" name="about_us_description_2" class="form-control" rows="3">{{ $setting->about_us_description_2 ?? '' }}</textarea>
                            @error('about_us_description_2')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Section 3 -->
                        <div class="col-md-4 mb-3">
                            <label for="about_us_image_3" class="form-label">Image 3</label>
                            <input type="file" id="about_us_image_3" name="about_us_image_3" class="form-control">
                            <small class="text-secondary">Recommended Size: 800px (W) x 600px (H)</small>
                            <img src="{{ asset($setting->about_us_image_3 ?? '') }}" width="100" alt="Image 3">

                            <label for="about_us_title_3" class="form-label mt-2">Title 3</label>
                            <input type="text" id="about_us_title_3" name="about_us_title_3" class="form-control"
                                value="{{ $setting->about_us_title_3 ?? '' }}">
                            @error('about_us_title_3')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                            <label for="about_us_description_3" class="form-label mt-2">Description 3</label>
                            <textarea id="about_us_description_3" name="about_us_description_3" class="form-control" rows="3">{{ $setting->about_us_description_3 ?? '' }}</textarea>
                            @error(' about_us_description_3')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>


            <!-- Card Wrapper for About Us Settings -->
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <h3 class="mt-2">Our Mission, Vision, and Goals</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Our Mission Section -->
                        <div class="col-md-4 mb-3">
                            <label for="mission_image" class="form-label">Mission Image</label>
                            <input type="file" id="mission_image" name="mission_image" class="form-control">
                            <small class="text-secondary">Recommended Size: 400px (W) x 250px (H)</small>
                            <img src="{{ asset($setting->mission_image ?? '') }}" width="100" alt="Mission Image">

                            <label for="mission_title" class="form-label mt-2">Mission Title</label>
                            <input type="text" id="mission_title" name="mission_title" class="form-control"
                                value="{{ $setting->mission_title ?? '' }}">
                            @error('mission_title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                            <label for="mission_description" class="form-label mt-2">Mission Description</label>
                            <textarea id="mission_description" name="mission_description" class="form-control" rows="3">{{ $setting->mission_description ?? '' }}</textarea>
                            @error('mission_description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Our Vision Section -->
                        <div class="col-md-4 mb-3">
                            <label for="vision_image" class="form-label">Vision Image</label>
                            <input type="file" id="vision_image" name="vision_image" class="form-control">
                            <small class="text-secondary">Recommended Size: 400px (W) x 250px (H)</small>
                            <img src="{{ asset($setting->vision_image ?? '') }}" width="100" alt="Vision Image">

                            <label for="vision_title" class="form-label mt-2">Vision Title</label>
                            <input type="text" id="vision_title" name="vision_title" class="form-control"
                                value="{{ $setting->vision_title ?? '' }}">
                            @error('vision_title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                            <label for="vision_description" class="form-label mt-2">Vision Description</label>
                            <textarea id="vision_description" name="vision_description" class="form-control" rows="3">{{ $setting->vision_description ?? '' }}</textarea>
                            @error('vision_description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Our Goals Section -->
                        <div class="col-md-4 mb-3">
                            <label for="goals_image" class="form-label">Goals Image</label>
                            <input type="file" id="goals_image" name="goals_image" class="form-control">
                            <small class="text-secondary">Recommended Size: 400px (W) x 250px (H)</small>
                            <img src="{{ asset($setting->goals_image ?? '') }}" width="100" alt="Goals Image">

                            <label for="goals_title" class="form-label mt-2">Goals Title</label>
                            <input type="text" id="goals_title" name="goals_title" class="form-control"
                                value="{{ $setting->goals_title ?? '' }}">
                            @error('goals_title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                            <label for="goals_description" class="form-label mt-2">Goals Description</label>
                            <textarea id="goals_description" name="goals_description" class="form-control" rows="3">{{ $setting->goals_description ?? '' }}</textarea>
                            @error('goals_description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" class="btn btn-primary text-white">Update Settings</button>
            </div>
        </form>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function() {
            var summernoteOptions = {
                placeholder: 'Enter description...',
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
            };

            $('#about_us_description_1').summernote(summernoteOptions);
            $('#about_us_description_2').summernote(summernoteOptions);
            $('#about_us_description_3').summernote(summernoteOptions);
            $('#mission_description').summernote(summernoteOptions);
            $('#vision_description').summernote(summernoteOptions);
            $('#goals_description').summernote(summernoteOptions);
        });
    </script>
@endsection