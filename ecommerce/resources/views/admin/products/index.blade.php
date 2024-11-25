@extends('layouts.app')
@php
$categories = App\Models\Category::all();
@endphp

@section('content')
    <div class="container">
        <h1 class="text-center my-5">Admin Dashboard - Manage Products</h1>

        <!-- Add Product Button -->
        <div class="text-right mb-4">
            <a href="{{ route('products.create') }}" class="btn shadow-sm fas fa-plus-circle" style="background-color: #43707b; color: white; border: none;">
                Add New Product
            </a>
        </div>

        <!-- Product List -->
        <div class="product-list">
            @foreach ($categories as $category)
                <div class="category-section">
                    <h3 class="category-title">{{ $category->name }}</h3>
                    <div class="category-products">
                        @foreach ($category->products as $product)
                            <div class="product-card">
                                <!-- Product Image -->
                                @if ($product->image_path)
                                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="product-image">
                                @else
                                    <div class="product-img-placeholder">
                                        <span>No Image Available</span>
                                    </div>
                                @endif

                                <!-- Product Details -->
                                <div class="card-body">
                                    <h5 class="product-title">{{ $product->name }}</h5>
                                    <p class="product-price">Price: ${{ number_format($product->price, 2) }}</p>
                                    <p class="product-stock">
                                        Stock: 
                                        <span class="{{ $product->stock_quantity > 0 ? 'in-stock' : 'out-of-stock' }}">
                                            {{ $product->stock_quantity > 0 ? $product->stock_quantity : 'Out of Stock' }}
                                        </span>
                                    </p>

                                    <!-- Admin Actions -->
                                    <div class="product-actions">
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
