<div class="row row-cols-1 row-cols-md-3 g-4">
    @foreach ($products as $product)
        <div class="col">
            <div class="card h-100">
                @php
                    $images = json_decode(str_replace('\\', '/', $product->images), true);
                @endphp

                @if (!empty($images) && is_array($images))
                    <img src="{{ url($images[0]) }}" alt="Product Image" class="card-img-top" style="object-fit: cover; height: 200px;">
                @else
                    <img src="{{ asset('images/placeholder.png') }}" alt="No Imageiiii" class="card-img-top" style="object-fit: cover; height: 200px;">
                @endif

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ $product->serial_number }}</p>
                    <div class="mt-auto">
                        <a href="{{ url('/product', $product->id) }}" class="btn btn-primary mb-2">View Details</a>
                        <a href="#" class="btn btn-link">Documents</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
