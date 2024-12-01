{{-- resources/views/product/show.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h1 class="text-center mb-5 display-4">{{ $product->name }}</h1>

        <!-- Product Container -->
        <div class="row">
            <!-- Product Images -->
            <div class="col-md-6 d-flex justify-content-center align-items-center">
                <div class="exzoom" id="exzoom">
                    <div class="exzoom_img_box">
                        <ul class='exzoom_img_ul'>
                            @foreach ($product->images as $image)
                                <li>
                                    <img src="{{ asset('/' . $image->file_path) }}"
                                         alt="{{ $product->name }}"
                                         class="main-image"
                                         style="width: 100%; height: auto; object-fit: contain;" />
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="exzoom_nav"></div>
                    <p class="exzoom_btn">
                        <a href="javascript:void(0);" class="exzoom_prev_btn"> < </a>
                        <a href="javascript:void(0);" class="exzoom_next_btn"> > </a>
                    </p>
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-md-6">
                <div class="product-details">
                    <h3 class="product-price text-success" style="font-size: 1.8rem; font-weight: bold;">
                        Price: ${{ number_format($product->price, 2) }}
                    </h3>
                    <label style="font-size: 1.8rem; line-height: 1.6;font-weight: bold;">Description</label>
                    <p class="product-description text-muted" style="font-size: 1.2rem; line-height: 1.6;">
                        {{ $product->description }}
                    </p>
                    <p class="product-stock" style="font-size: 1.5rem; margin-top: 20px;">
                        <strong>Stock: </strong>
                        <span class="{{ $product->stock_quantity > 0 ? 'text-success' : 'text-danger' }}">
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
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $("#exzoom").exzoom({
                "navWidth": 60,
                "navHeight": 60,
                "navItemNum": 5,
                "navItemMargin": 7,
                "navBorder": 1,
                "autoPlay": false,
                "autoPlayTimeout": 2000
            });
        });
    </script>
@endpush
