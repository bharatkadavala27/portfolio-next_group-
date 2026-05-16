@extends('layouts.app')

@section('title', 'About Us')

@section('content')
    <div class="container mt-3">
        <div class="row mb-4">
            <div class="col-md-12 text-center">
                <h4 class="display-4">About Us</h4>
                <div class="underline mx-auto mb-4"></div>
            </div>
        </div>

        <!-- About Us Section 1 -->
        <div class="row mb-5 align-items-center">
            <div class="col-md-6">
                <img src="{{ asset($aboutSettings->about_us_image_1) }}" alt="{{ $aboutSettings->about_us_title_1 }}"
                    class="img-fluid rounded shadow mb-3">
            </div>
            <div class="col-md-6">
                <h2 class="text-primary">{{ $aboutSettings->about_us_title_1 }}</h2>
                <div class="text-muted">{!! $aboutSettings->about_us_description_1 !!}</div>
            </div>
        </div>

        <!-- About Us Section 2 -->
        <div class="row mb-5 align-items-center">
            <div class="col-md-6 order-md-2">
                <img src="{{ asset($aboutSettings->about_us_image_2) }}" alt="{{ $aboutSettings->about_us_title_2 }}"
                    class="img-fluid rounded shadow mb-3">
            </div>
            <div class="col-md-6">
                <h2 class="text-primary">{{ $aboutSettings->about_us_title_2 }}</h2>
                <div class="text-muted">{!! $aboutSettings->about_us_description_2 !!}</div>
            </div>
        </div>

        <!-- About Us Section 3 -->
        <div class="row mb-5 align-items-center">
            <div class="col-md-6">
                <img src="{{ asset($aboutSettings->about_us_image_3) }}" alt="{{ $aboutSettings->about_us_title_3 }}"
                    class="img-fluid rounded shadow mb-3">
            </div>
            <div class="col-md-6">
                <h2 class="text-primary">{{ $aboutSettings->about_us_title_3 }}</h2>
                <div class="text-muted">{!! $aboutSettings->about_us_description_3 !!}</div>
            </div>
        </div>

        <!-- Mission, Vision, and Goals Section -->
        <h2 class="text-center mb-4">Our Mission, Vision, and Goals</h2>
        <div class="row">
            <div class="col-md-4 mb-4 d-flex align-items-stretch h-100">
                <div class="card shadow w-100">
                    <div class="d-flex justify-content-center align-items-center" style="height: 250px;">
                        <img src="{{ asset($aboutSettings->mission_image) }}" class="img-fluid rounded"
                            alt="{{ $aboutSettings->mission_title }}" style="object-fit: cover; max-height: 100%;">
                    </div>
                    <div class="card-body d-flex flex-column" style="border-top:1px solid rgba(0, 0, 0, 0.322);">
                        <h5 class="card-title text-center text-primary">{{ $aboutSettings->mission_title }}</h5>
                        <div class="card-text text-muted flex-grow-1" style="max-height: 100px; overflow-y: auto;">
                            {!! $aboutSettings->mission_description !!}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4 d-flex align-items-stretch h-100">
                <div class="card shadow w-100">
                    <div class="d-flex justify-content-center align-items-center" style="height: 250px;">
                        <img src="{{ asset($aboutSettings->vision_image) }}" class="img-fluid rounded"
                            alt="{{ $aboutSettings->vision_title }}" style="object-fit: cover; max-height: 100%;">
                    </div>
                    <div class="card-body d-flex flex-column" style="border-top:1px solid rgba(0, 0, 0, 0.322);">
                        <h5 class="card-title text-center text-primary">{{ $aboutSettings->vision_title }}</h5>
                        <div class="card-text text-muted flex-grow-1" style="max-height: 100px; overflow-y: auto;">
                            {!! $aboutSettings->vision_description !!}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4 d-flex align-items-stretch h-100">
                <div class="card shadow w-100">
                    <div class="d-flex justify-content-center align-items-center" style="height: 250px;">
                        <img src="{{ asset($aboutSettings->goals_image) }}" class="img-fluid rounded"
                            alt="{{ $aboutSettings->goals_title }}" style="object-fit: cover; max-height: 100%;">
                    </div>
                    <div class="card-body d-flex flex-column" style="border-top:1px solid rgba(0, 0, 0, 0.322);">
                        <h5 class="card-title text-center text-primary">{{ $aboutSettings->goals_title }}</h5>
                        <div class="card-text text-muted flex-grow-1" style="max-height: 100px; overflow-y: auto;">
                            {!! $aboutSettings->goals_description !!}</div>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection