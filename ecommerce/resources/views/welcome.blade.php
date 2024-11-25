<!-- resources/views/welcome.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Welcome to Our Store</h1>
        <div class="row">
            <!-- Categories Section -->
            <div class="col-md-6">
                <h3>Categories</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->description }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Products Section -->
            <div class="col-md-6">
                <h3>Products</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            @foreach ($category->products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>${{ $product->price }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
