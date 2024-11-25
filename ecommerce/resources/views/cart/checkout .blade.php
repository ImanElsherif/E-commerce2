@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center my-5">Your Cart</h1>

        @if($cart && $cart->items->count() > 0)
            <div class="row">
                @foreach ($cart->items as $cartItem)
                    <div class="col-md-12 mb-4">
                        <div class="cart-item card shadow-lg rounded">
                            <div class="card-body">
                                <h5 class="product-title">{{ $cartItem->product->name }}</h5>
                                <p class="product-category"><strong>Category:</strong> {{ $cartItem->product->category->name }}</p>
                                <p class="product-price"><strong>Price:</strong> ${{ $cartItem->product->price }}</p>
                                <p class="product-quantity"><strong>Quantity:</strong> {{ $cartItem->quantity }}</p>
                                <p class="product-stock"><strong>Stock Available:</strong> {{ $cartItem->product->stock_quantity }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Buttons for Checkout or Continue Shopping -->
            <div class="text-center">
                <a href="{{ route('home') }}" class="btn btn-secondary">Continue Shopping</a>
                <form action="{{ route('checkout.complete') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-primary">Complete Order</button>
                </form>
            </div>
        @else
            <p>Your cart is empty!</p>
            <a href="{{ route('home') }}" class="btn btn-secondary">Go to Home Page</a>
        @endif
    </div>
@endsection
