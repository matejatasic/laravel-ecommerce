@extends('layouts.app')

@section('content')
    <div class="row mb-5" id="adress-bar">
        <div class="col-md-4 text-center pt-3">
            <p>Home > Shop > Product</p>
        </div>
        <div class="col-md-8"></div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-5">
                <img src="{{ asset('images/microsoft_surface.png') }}" class="card-img-top" alt="product">
            </div>
            <div class="col-md-5">
                <h2>Microsoft Surface</h2>
                <p class="text-secondary">12.4" 1536 x 1024, 8GB LPDDR4x</p>
                <div>
                    <span>Rating:</span>&nbsp;
                    <span><i class="fas fa-star"></i></span>
                    <span><i class="fas fa-star"></i></span>
                    <span><i class="fas fa-star"></i></span>
                    <span><i class="fas fa-star"></i></span>
                    <span><i class="fas fa-star"></i></span>
                </div>
                <p id="price">350.00$</p>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="#" class="btn btn-warning w-100">Add to cart</a>
            </div>
        </div>
    </div>
@endsection