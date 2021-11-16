@extends('layouts.app')

@section('content')
    <!-- hero -->
    <div class="hero-container">
        <div id="block-text">
            <h1>Laravel Ecommerce</h1>
            <p>This app includes multiple products, categories, adding and removing from a cart and much more</p>
            <div id="block-buttons" class="col-md-4 mx-auto">
                <a href="#" class="btn btn-primary mr-3">Blog</a>
                <a href="#" class="btn btn-primary">Github</a>
            </div>
        </div>
    </div>
    <!-- !hero -->

    <div class="container mt-3">
        <!-- heading -->
        <div class="row px-auto">
            <div class="col-md-10 mx-auto">
                <h2 class="text-center">Laravel Ecommerce</h2>
                <p class="mt-3">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus vel justo vestibulum orci egestas egestas. Lorem ipsum dolor sit amet, 
                    consectetur adipiscing elit. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. 
                    Donec tristique orci nec arcu.
                </p>
            </div>
        </div>
        <!-- !heading -->

        <!-- filter-buttons -->
        <div class="row mb-5">
            <div id="filter-btns" class="col-md-10 mx-auto d-flex justify-content-center">
                <button class="btn btn-info mr-3">All</button>
                <button class="btn btn-info">Featured</button>
            </div>
        </div>
        <!-- !filter-buttons -->

        <!-- products -->
        <div class="row">
            <div class="col-md-12 d-flex flex-row justify-content-around">
                <div class="col-md-3">
                    <div class="card">
                        <img src="{{ asset('images/microsoft_surface.png') }}" class="card-img-top" alt="product">
                        <div class="card-body">
                          <h5 class="card-title">Microsoft Surface</h5>
                          <div>
                              <span>Rating:</span>&nbsp;
                              <span><i class="fas fa-star"></i></span>
                              <span><i class="fas fa-star"></i></span>
                              <span><i class="fas fa-star"></i></span>
                              <span><i class="fas fa-star"></i></span>
                              <span><i class="fas fa-star"></i></span>
                          </div>
                          <p>Price: 350$</p>
                          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                          <a href="#" class="btn btn-warning w-100">Add to cart</a>
                        </div>
                      </div>
                </div>
            </div>
        </div>
        <!-- !products -->
    </div>
@endsection
