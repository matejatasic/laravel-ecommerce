@extends('layouts.app')

@section('content')
    <div class="row mb-5" id="adress-bar">
        <div class="col-md-4 text-center pt-3">
            <p>Home > Shop</p>
        </div>
        <div class="col-md-8"></div>
    </div>
    <div class="container">
        <div class="row">
            <!-- sidebar -->
            <div class="col-md-3" id="sidebar">
                <div class="row">
                    <div class="col-md-12">
                        <p><b>Categories</b></p>
                        <ul class="list-unstyled">
                            <li><a href="#">Laptops</a></li>
                            <li><a href="#">Mobile Phones</a></li>
                            <li><a href="#">Tablets</a></li>
                            <li><a href="#">PCs</a></li>
                            <li><a href="#">TVs</a></li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <p><b>Prices</b></p>
                        <ul class="list-unstyled">
                            <li><a href="#">0 - 700$</a></li>
                            <li><a href="#">700 - 2500$</a></li>
                            <li><a href="#">2500$+</a></li>
                        </ul>    
                    </div>
                </div>
            </div>
            <!-- !sidebar -->
            <div class="col-md-9">
                <h1>Shop</h1>
                <div class="row mt-4 d-flex flex-row justify-content-between">
                    <div class="col-md-3">
                        <div class="card">
                            <a href="#"><img src="{{ asset('images/microsoft_surface.png') }}" class="card-img-top" alt="product"></a>
                            <div class="card-body">
                                <h5 class="card-title"><a href="#" class="text-secondary">Microsoft Surface</a></h5>
                                <p>Price: 350$</p>
                                <a href="#" class="btn btn-warning w-100">Add to cart</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <a href="#"><img src="{{ asset('images/microsoft_surface.png') }}" class="card-img-top" alt="product"></a>
                            <div class="card-body">
                                <h5 class="card-title"><a href="#" class="text-secondary">Microsoft Surface</a></h5>
                                <p>Price: 350$</p>
                                <a href="#" class="btn btn-warning w-100">Add to cart</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <a href="#"><img src="{{ asset('images/microsoft_surface.png') }}" class="card-img-top" alt="product"></a>
                            <div class="card-body">
                                <h5 class="card-title"><a href="#" class="text-secondary">Microsoft Surface</a></h5>
                                <p>Price: 350$</p>
                                <a href="#" class="btn btn-warning w-100">Add to cart</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
