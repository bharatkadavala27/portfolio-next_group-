@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Product Details</h2>

        <!-- Product Basic Details -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h4>Basic Details</h4>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ $product->name }}</p>
                <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                <p><strong>Category:</strong> {{ $product->category->name ?? 'N/A' }}</p>
                <p><strong>Subcategory:</strong> {{ $product->subcategory->name ?? 'N/A' }}</p>
                <p><strong>Serial Number:</strong> {{ $product->serial_number }}</p>
                <p><strong>Description:</strong> {{ $product->description ?? 'No description provided.' }}</p>
            </div>
        </div>

        <!-- Attributes Section -->
        @foreach ($product->attributes ?? [] as $attribute)
            <div class="card mb-4">
                <div class="card-header bg-secondary text-white">
                    <h4>{{ $attribute->title }}</h4>
                </div>
                <div class="card-body">
                    {{-- <p>{{ $attribute->description ?? 'No description provided.' }}</p> --}}

                    <!-- Short Attributes Table -->
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Key</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attribute->short_attributes ?? [] as $shortAttribute)
                                <tr>
                                    <td>{{ $shortAttribute['key'] ?? 'N/A' }}</td>
                                    <td>{{ $shortAttribute['value'] ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Display message if no short attributes are available -->
                    @if (empty($attribute->short_attributes))
                        <p><strong>No short attributes available for this attribute.</strong></p>
                    @endif
                </div>
            </div>
        @endforeach

        <!-- If no attributes available, show this message -->
        @if (empty($product->attributes))
            <p><strong>Attributes:</strong> No attributes available.</p>
        @endif

        <!-- Documents Section -->
        @foreach ($product->documents ?? [] as $document)
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h4>Documents</h4>
                </div>
                <div class="card-body">
                    <ul>
                        <li>
                            <a href="{{ asset($document->file_path) }}" target="_blank" class="btn btn-link">
                                {{ $document->type ?? 'Document' }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        @endforeach

        <!-- If no documents available, show this message -->
        @if (empty($product->documents))
            <p><strong>Documents:</strong> No documents available.</p>
        @endif

        <!-- Images Section -->
        @foreach (json_decode($product->images, true) ?? [] as $image)
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h4>Images</h4>
                </div>
                <div class="card-body">
                    <img src="{{ asset($image) }}" alt="Product Image" class="img-fluid rounded">
                </div>
            </div>
        @endforeach

        <!-- If no images available, show this message -->
        @if (empty($product->images) || json_decode($product->images, true) == null)
            <p><strong>Images:</strong> No images available.</p>
        @endif
    </div>
@endsection
