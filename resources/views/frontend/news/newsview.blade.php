@extends('layouts.app')

@section('title', $article->header ?? 'News Details')

@section('content')

    <div class="container mt-5">
        <div class="row justify-content-center">
            <!-- News Article Card -->
            <div class="col-md-8">
                <div class="card shadow-lg border-light">
                    <!-- Image -->
                    <img src="{{ asset($article->image) }}" class="card-img-top rounded-3" alt="{{ $article->header }}"
                        style="height: 400px; object-fit: cover;">

                    <div class="card-body">
                        <!-- Article Header -->
                        <h3 class="card-title font-weight-bold">{{ $article->header }}</h3>

                        <!-- Main Description -->
                        <p class="card-text text-muted mb-4">{!! $article->description !!}</p>

                        <!-- Short Details Section -->
                        <div class="short-details mt-4">
                            {{-- <h5 class="font-weight-bold">Details Information</h5> --}}
                            @foreach ($article->details as $index => $detail)
                                <div class="detail-box mb-4 border p-3 rounded shadow-sm">
                                    <!-- Short Image in Full Width -->
                                    <div class="mb-3">
                                        @if ($detail->short_image)
                                            <center>
                                                <img src="{{ asset($detail->short_image) }}" alt="{{ $detail->short_title }}"
                                                    class="img-fluid rounded" style="max-height: 200px; object-fit: cover;">
                                            </center>
                                            <hr>
                                        @else

                                        @endif
                                    </div>

                                    <!-- Short Title -->
                                    <h3 class="font-weight-bold">{{ $detail->short_title }}</h3>

                                    <!-- Short Description -->
                                    <p class="text-muted">{!! $detail->short_description !!}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection