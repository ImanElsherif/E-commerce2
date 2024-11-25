@extends('layouts.app')

@php
    $categories = App\Models\Category::all();
@endphp

@section('content')
    <div class="container">
        <!-- Category Filter Dropdown -->
        <form method="GET" action="{{ route('filter') }}">
            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="category" class="form-label">Filter by Category</label>
                    <select name="category_id" id="category" class="form-select" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>

        <!-- Display Products -->
        <div class="row">
            @foreach ($products as $product)
                <div class="col-md-4 mb-4">
                    <!-- Card for each product -->
                    <div class="product-card shadow-lg rounded">
                        @if ($product->image_path)
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="card-img-top product-image">
                        @else
                            <div class="product-img-placeholder">
                                <span>No Image</span>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="product-title">{{ $product->name }}</h5>
                            <p class="product-category"><strong>Description:</strong> {{ $product->description }}</p>
                            <p class="product-price"><strong>Price:</strong> ${{ $product->price }}</p>

                            <!-- Stock Information -->
                            @if ($product->stock_quantity > 0)
                                <p class="product-stock"><strong>Stock:</strong> {{ $product->stock_quantity }}</p>
                            @else
                                <p class="product-stock"><span class="text-danger"><strong>Out of Stock</strong></span></p>
                            @endif

                            <!-- Add to Cart Button -->
                            @if ($product->stock_quantity > 0)
                                @auth
                                    <!-- If the user is logged in, show the Add to Cart button -->
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                        @csrf
                                        <div class="input-group">
                                            <input type="number" name="quantity" style="margin-bottom: 15px;margin-left: 5px;" class="form-control" min="1" max="{{ $product->stock_quantity }}" value="1" required>
                                            <button type="submit" style="background-color: #43707b; color: white; border: none; margin-bottom: 15px;margin-right: 15px;" class="btn shadow-sm fas fa-shopping-cart"> Add to Cart</button>
                                        </div>
                                    </form>
                                @else
                                    <!-- If the user is not logged in, show a login message with a button -->
                                    <div class="alert alert-info d-flex align-items-center" role="alert">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <span><strong>Login</strong> to add items to your cart.</span>
                                        <a href="{{ route('login') }}" class="btn btn-primary ms-auto" style="background-color: #43707b; color: white; border: none;" >Login</a>
                                    </div>
                                @endauth
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
