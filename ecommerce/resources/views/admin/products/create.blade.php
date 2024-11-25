@extends('layouts.app')

@php
    $categories = App\Models\Category::all();
@endphp

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <!-- Card Header -->
                    <div class="card-header" style="background-color: #43707b; color: white; border: none;">
                        <h3 class="mb-0">Create New Product</h3>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body">
                        <!-- Display Validation Errors -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Product Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Product Name</label>
                                <input 
                                    type="text" 
                                    name="name" 
                                    id="name" 
                                    class="form-control @error('name') is-invalid @enderror" 
                                    value="{{ old('name') }}" 
                                    placeholder="Enter product name" 
                                    required
                                >
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Category</label>
                                <select 
                                    name="category_id" 
                                    id="category_id" 
                                    class="form-select @error('category_id') is-invalid @enderror" 
                                    required
                                >
                                    <option value="" disabled selected>Select a category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Price -->
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input 
                                    type="number" 
                                    name="price" 
                                    id="price" 
                                    class="form-control @error('price') is-invalid @enderror" 
                                    value="{{ old('price') }}" 
                                    placeholder="Enter product price" 
                                    required
                                >
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Stock Quantity -->
                            <div class="mb-3">
                                <label for="stock_quantity" class="form-label">Stock Quantity</label>
                                <input 
                                    type="number" 
                                    name="stock_quantity" 
                                    id="stock_quantity" 
                                    class="form-control @error('stock_quantity') is-invalid @enderror" 
                                    value="{{ old('stock_quantity') }}" 
                                    placeholder="Enter stock quantity" 
                                    required
                                >
                                @error('stock_quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Product Image -->
                            <div class="mb-3">
                                <label for="image" class="form-label">Product Image</label>
                                <input 
                                    type="file" 
                                    name="image" 
                                    id="image" 
                                    class="form-control @error('image') is-invalid @enderror"
                                >
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea 
                                    name="description" 
                                    id="description" 
                                    class="form-control @error('description') is-invalid @enderror" 
                                    rows="4" 
                                    placeholder="Enter product description"
                                >{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary" style="background-color: #43707b; color: white; border: none;">
                                    <i class="fas fa-plus-circle"></i> Create Product
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
