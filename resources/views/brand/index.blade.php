@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold text-primary">Our Brands</h1>
                <p class="lead text-muted">Discover our premium selection of trusted brands</p>
            </div>
        </div>


        <div class="row g-4">
            @foreach($brands as $brand)
                <div class="col-sm-6 col-lg-3">
                    <div class="card h-100 border shadow-sm rounded-3 overflow-hidden hover-lift">
                        <div class="card-header text-white p-3 bg-primary">
                            <h5 class="card-title mb-0 fw-bold">{{ $brand->name }}</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="row g-0">
                                <div class="col-5 d-flex align-items-center justify-content-center p-3 bg-light">
                                    <img src="{{ asset($brand->image) }}" class="img-fluid brand-logo"
                                        alt="{{ $brand->name }} logo">
                                </div>
                                <div class="col-7 p-3">
                                    <p class="card-text text-dark mb-0">
                                        {!! \Illuminate\Support\Str::words(strip_tags($brand->description), 12, '...') !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0 text-center p-3">
                            <a href="{{ route('brand.products', $brand->id) }}" class="btn btn-sm btn-primary w-100">View
                                Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($brands->isEmpty())
            <div class="row mt-5">
                <div class="col-12 text-center">
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle me-2"></i> No brands available at the moment.
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('styles')
    <style>
        .brand-logo {
            max-height: 120px;
            object-fit: contain;
            transition: transform 0.3s ease;
        }

        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
        }

        a,
        a:visited {
            text-decoration: none !important;
            border: none;
        }

        a:hover {
            text-decoration: none !important;
            color: #1a1a1a !important;
            border: none;
        }
    </style>
@endpush