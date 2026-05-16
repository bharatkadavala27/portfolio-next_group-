@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Shopping Cart</h2>
    <div class="row">
        <div class="col-md-8">
            <!-- Cart Items -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Cart Items</h4>
                </div>
                <div class="card-body">
                    <!-- Loop through cart items -->
                    @foreach($cartItems as $item)
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <img src="{{ asset('assets/products/' . $item->product->image) }}" class="img-fluid" alt="{{ $item->product->name }}">
                        </div>
                        <div class="col-md-6">
                            <h5>{{ $item->product->name }}</h5>
                            <p>{{ $item->product->description }}</p>
                            <p>Price: ${{ $item->product->price }}</p>
                        </div>
                        <div class="col-md-3 d-flex align-items-center">
                            <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex w-100">
                                @csrf
                                @method('PUT')
                                <input type="number" name="quantity" class="form-control me-2" value="{{ $item->quantity }}" min="1">
                                <button type="submit" class="btn btn-primary me-2">Update</button>
                            </form>
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Remove</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <!-- Cart Summary -->
            <div class="card">
                <div class="card-header">
                    <h4>Summary</h4>
                </div>
                <div class="card-body">
                    <p>Subtotal: ${{ $subtotal }}</p>
                    <p>Tax: ${{ $tax }}</p>
                    <p>Total: ${{ $total }}</p>
                    <a href="/checkout" class="btn btn-primary w-100">Proceed to Checkout</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
