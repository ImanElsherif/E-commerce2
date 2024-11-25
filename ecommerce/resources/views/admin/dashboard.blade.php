@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-5">Admin Dashboard - Manage Categories</h1>

        <!-- Display success or error message -->
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @elseif(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <!-- Categories Section -->
            <div class="col-md-12">
                <div class="category-section">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="category-title">Categories</h3>
                        <a href="{{ route('categories.create') }}" style="background-color: #43707b; color: white; border: none;"  class="btn shadow-sm fas fa-plus-circle"> Add Category</a>
                    </div>
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <!-- Category Name as a link to the products page -->
                                            <td><a href="{{ route('categories.show', $category->id) }}">{{ $category->name }}</a></td>
                                            <td>{{ $category->description }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                    
                                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
