<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Header -->
        <nav class="navbar navbar-expand-lg navbar-light">
            @auth
                @if(auth()->user()->role == 'admin') 
                    <!-- For admin, show text without link -->
                    <a class="navbar-brand fas fa-gem"> JEWELS</a>
                @else
                    <!-- For user and guest, show the text with a link -->
                    <a class="navbar-brand fas fa-gem" href="{{ url('/') }}"> JEWELS</a>
                @endif
            @else
                <!-- For guest, show the text with a link -->
                <a class="navbar-brand fas fa-gem" href="{{ url('/') }}"> JEWELS</a>
            @endauth
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <!-- Cart Icon for authenticated users -->
                        @if(auth()->user()->role == 'user')
                            <li class="nav-item">
                                <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                                    <i class="fas fa-shopping-cart"></i> <!-- Cart Icon -->
                                </a>
                            </li>
                        @endif

                        <!-- Links for admin users only -->
                        @if(auth()->user()->role == 'admin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">Categories</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('products.index') }}">Products</a>
                            </li>
                            <!-- Orders Link for Admin -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.orders.index') }}">Orders</a>
                            </li>
                        @endif

                        <!-- Logout link -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @else
                        <!-- Login and Register links for guests -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="py-4">
            @yield('content') <!-- Content will be injected here from child views -->
        </div>
    </div>

    <!-- Scripts (e.g., Bootstrap JS) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
