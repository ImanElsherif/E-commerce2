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
