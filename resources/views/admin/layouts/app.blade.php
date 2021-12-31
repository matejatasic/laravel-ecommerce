<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel Ecommerce</title>

    <!-- Font awesome -->
    <!-- Your fontawesome kit here -->

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Extra css -->
    @yield('extra-css')
</head>
<body class="">
    <!-- navbar -->
    <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                Ecommerce
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">Shop</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Blog</a></li>
                    @if (Auth::check() && Auth::user()->isAdmin())
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>    
                    @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                                <i class="fas fa-shopping-cart"></i>
                                <span id="cart-quantity">{{ count(session()->get('cart')) }}</span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('cart.index') }}">
                                    Cart
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <!-- !navbar -->

    <div class="container-fluid">
        <div class="row">
            <!-- sidebar -->
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-primary sidebar collapse">
                <div class="sidebar-sticky h-100 pt-5">
                    <ul class="nav flex-column justify-content-between h-75">
                        <li class="nav-item">
                            <a class="nav-link active text-white" href="{{ route('admin.dashboard') }}">
                                Dashboard <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('admin.getOrders') }}">
                                Orders
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('admin.getProducts') }}">
                                Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('admin.getCustomers') }}">
                                Customers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('admin.getCategories') }}">
                                Categories
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- !sidebar -->

            <!-- main -->
            <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4 pt-3">
                @yield('content')
            </main>
            <!-- main -->

            <!-- footer -->
            <footer class="col-md-12 bg-dark text-white py-3 mt-auto">
                <div class="row">
                    <div class="col-md-8 text-center">
                        <p>Copyright&copy;. All rights reserved by Mateja</p>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-4">
                                <p>Follow us on:</p>
                            </div>
                            <div class="col-md-4 d-flex justify-content-between">
                                <a href="#"><i class="fab fa-facebook"></i></a>
                                <a href="#"><i class="fab fa-youtube"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                                <a href="#"><i class="fab fa-github"></i></a>
                            </div>
                            <div class="col-md-5"></div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- footer -->
        </div>
    </div>

    @yield('scripts')
</body>
</html>
