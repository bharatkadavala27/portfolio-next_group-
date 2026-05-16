<!-- Recently Viewed Items Section -->
<div class="layout-category-container">
    <div class="recently-viewed mt-5">
        <h5 class="theme-text fw-bold mb-4" style="font-size: 26px">Recently Viewed Items</h5>
        <div class="row row-cols-1 row-cols-md-3 g-4" style="justify-content: flex-start;">
            @forelse ($recentlyViewedItems as $item)
                <div class="col">
                    <div class="card border-0" style="width: 300px; height: 105px; border:none!important;">
                        <div class="d-flex align-items-center p-3">
                            @php
                                $images = is_string($item->images)
                                    ? json_decode($item->images, true)
                                    : $item->images;

                                $imageUrl = asset('images/no-image.png');
                                if (!empty($images) && is_array($images) && count($images) > 0) {
                                    $normalizedImage = $images[0];
                                    if (stripos($normalizedImage, 'uploads/products/') !== 0 &&
                                        stripos($normalizedImage, 'Uploads/products/') !== 0) {
                                        $normalizedImage = 'uploads/products/' . ltrim($normalizedImage, '/');
                                    }
                                    $imageUrl = asset($normalizedImage);
                                }
                            @endphp

                            <a href="{{ url('/product', $item->id) }}"
                               style="width: 70px; height: 70px; margin-right: 15px;">
                                <img src="{{ $imageUrl }}" alt="{{ $item->name }}"
                                     style="width: 100%; height: 100%; object-fit: contain;">
                            </a>
                            <div class="flex-grow-1">
                                <h6 class="card-title text-muted mb-1" style="font-size: 10px;">
                                    {{ $item->serial_number }}
                                </h6>
                                <a href="{{ url('/product', $item->id) }}" class="text-decoration-none">
                                    <p class="card-text text-dark mb-0 fw-semibold" style="font-size: 12px;">
                                        {{ $item->name }}
                                    </p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted">No recently viewed items.</p>
            @endforelse
        </div>
    </div>
</div>
