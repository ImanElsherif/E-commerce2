@extends('layouts.app')

@section('content')

<div class="container mt-4">
    <h1 class="center mb-4 fas fa-shopping-cart"> Your Cart</h1>

    @if ($cart && $cart->items->count() > 0)
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <ul class="list-group">
                    @foreach ($cart->items as $item)
                    <li class="list-group-item d-flex justify-content-between align-items-center py-4">
    <!-- Product Image -->
    <div class="product-image-wrapper me-3">
            <img src="{{ asset('/' . $item->product->images->first()->file_path) }}" alt="{{ $item->product->name }}" class="product-image">
    </div>

    <!-- Product Details -->
    <div class="product-details flex-grow-1">
        <strong class="product-title">{{ $item->product->name }}</strong>
        <p class="mb-1 product-price">Price: ${{ $item->product->price }}</p>
        <p class="mb-0 text-muted product-quantity">Quantity: {{ $item->quantity }}</p>
    </div>

    <!-- Actions -->
    <div class="product-actions-cart d-flex align-items-center">
        <!-- Update Quantity Form -->
        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex align-items-center">
            @csrf
            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control me-2 text-center" style="width: 70px;">
            <button type="submit" class="btn btn-primary btn-sm">Update</button>
        </form>

        <!-- Remove Product Form -->
        <form action="{{ route('cart.delete', $item->id) }}" method="POST" class="ms-2">
            @csrf
            <button type="submit" class="btn btn-danger btn-sm">Remove</button>
        </form>
    </div>
</li>

                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Checkout Section -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <a href="{{ url('/') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Continue Shopping
            </a>
            <form action="{{ route('cart.checkout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-shopping-cart"></i> Complete Order
                </button>
            </form>
        </div>
    @else
        <div class="text-center my-5">
            <h3>Your cart is empty</h3>
            <p class="text-muted">You haven't added anything to your cart yet.</p>
            <a href="{{ url('/') }}" class="btn btn-primary mt-3" style="background-color: #43707b; color: white;">
                <i class="fas fa-shopping-bag" ></i> Start Shopping
            </a>
        </div>
    @endif
</div>

@endsection


