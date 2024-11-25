@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h1 class="text-center mb-4">Edit Category</h1>

        <div class="card shadow-lg">
            <div class="card-body">
                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Category Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $category->name) }}" required>
                            @error('name')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="description" class="form-label">Category Description</label>
                            <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success btn-lg mt-4 px-4 py-2">Update Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
