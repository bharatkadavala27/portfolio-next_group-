@extends('layouts.app')

@section('title', 'News')

@section('content')

    <div class="container">
        <div class="row mt-4">
            <div class="container mb-4 mt-4">
                <div class="row">
                    @foreach ($news as $article)
                        <div class="col-md-4 d-flex align-items-stretch mb-4 h-100">
                            <a href="{{ route('newsview', $article->id) }}" class="card-link">
                                <div class="card h-100">
                                    <a href="{{ route('newsview', $article->id) }}">
                                        <img src="{{ asset($article->image) }}" class="card-img-top fixed-image"
                                            alt="{{ $article->header }}">
                                    </a>
                                    <div class="card-body">
                                        <h3 class="card-title text-truncate">{{ $article->header }}</h3>
                                        <p class="card-text text-truncate">
                                            {!! Str::limit(strip_tags($article->description), 150, '...') !!}
                                        </p>
                                        <!-- Adjusted limit to 150 characters -->
                                        <a href="{{ route('newsview', $article->id) }}" class="btn btn-primary">Read
                                            More</a>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection

<style>
    .fixed-image {
        height: 196px;
        /* Set a fixed height */
        width: 100%;
        /* Make the image fill the width of its container */
        object-fit: cover;
        /* Crop or fit the image to the specified dimensions */
    }

    .card {
        height: 100%;
        width: 100%;
        /* Ensure cards stretch to the same height */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .card-body {
        flex-grow: 1;
        /* Ensures body content adjusts dynamically */
    }
</style>