@extends('layouts.app')

@section('title', 'Downloads')

@section('content')
    <style>
        .card-hover:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            /* Removed color: black!important; to fix invisible text */
        }

        .card {
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        div:hover {
            cursor: pointer;
        }

        a:hover {
            text-decoration: none;
            border: none;
        }
    </style>

    <div class="container my-5">
        <h3 class="mb-4">Explore by Document Category</h3>


        <div class="row row-cols-1 row-cols-md-3 g-3" name="document-categories">
            @if (isset($categories) && $categories->count() > 0)
                @foreach ($categories as $category)
                    @if (is_null($category->parent_id)) <!-- Only show main categories -->
                        <div class="col">
                            <a href="{{ url('category/' . $category->id . '/documents') }}" class="text-decoration-none text-dark">
                                <div id="myButton" class="card shadow-sm border-0 p-3 d-flex flex-row align-items-center">
                                    @if($category->image)
                                        <img src="{{ asset('document_categories/' . $category->image) }}" alt="{{ $category->name }}"
                                            class="me-3" style="width: 50px; height: 50px; object-fit: contain;">
                                    @else
                                        <i class="bi bi-box-seam fs-3 text-primary me-3"></i>
                                    @endif
                                    <div class="flex-grow-1" id="myButton">
                                        <h5 class="mb-1" id="myButton">{{ $category->name }}</h5>
                                        @if($category->description)
                                            <p class="mb-0 text-muted small">{!! Str::limit($category->description, 100) !!}</p>
                                        @endif
                                        <style>
                                            #myButton:hover {
                                                /* background-color: red; */
                                                color: black;
                                            }
                                        </style>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                @endforeach
            @else
                <div class="col">
                    <div class="alert alert-warning">No categories available.</div>
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('downloadAllBtn').addEventListener('click', function () {
            // You can replace this with your actual download all logic
            alert('Download All functionality to be implemented.');
        });
    </script>
@endsection