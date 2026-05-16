<div>





    <ul>

            <li>
                <strong>{{ $products->name }}</strong> - ${{ $products->price }}
                @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="max-width: 100px;">
                @endif
            </li>

    </ul>
</div>
