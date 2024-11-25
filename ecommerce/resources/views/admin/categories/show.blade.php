<!-- resources/views/categories/show.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $category->name }} - Products</h1>
        <div class="row">
            @foreach ($category->products as $product)
                <div class="col-md-4 mb-4">
                    <div class="product-card">
                        <!-- Product Image -->
                    @if ($product->image_path)
                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="product-image">
                    @else
                        <div class="product-img-placeholder">
                            <span>No Image Available</span>
                        </div>
                    @endif

                        <div class="card-body">
                            <h5 class="product-title">{{ $product->name }}</h5>
                            <p class="product-price">Price: ${{ $product->price }}</p>
                            <p class="product-stock">
                                        Stock: 
                                        <span class="{{ $product->stock_quantity > 0 ? 'in-stock' : 'out-of-stock' }}">
                                            {{ $product->stock_quantity > 0 ? $product->stock_quantity : 'Out of Stock' }}
                                        </span>
                                    </p>
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
                </div>
            @endforeach
        </div>
    </div>
@endsection
