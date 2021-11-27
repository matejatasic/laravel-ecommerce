@extends('layouts.app')

@section('content')
    <div class="row mb-5" id="adress-bar">
        <div class="col-md-4 text-center pt-3">
            <p>Home > Shop > {{ $product->name }}</p>
        </div>
        <div class="col-md-8"></div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-5">
                <img src="{{ asset('images/'.$product->image) }}" class="card-img-top" alt="product">
            </div>
            <div class="col-md-5">
                <h2>{{ $product->name }}</h2>
                <p class="text-secondary">{{ $product->details }}</p>
                <div>
                    <span>Rating:</span>&nbsp;
                    <span><i class="fas fa-star"></i></span>
                    <span><i class="fas fa-star"></i></span>
                    <span><i class="fas fa-star"></i></span>
                    <span><i class="fas fa-star"></i></span>
                    <span><i class="fas fa-star"></i></span>
                </div>
                <p id="price">{{ $product->price }}$</p>
                <p class="card-text">{{ $product->description }}</p>
                <a href="#" class="btn btn-warning w-100">Add to cart</a>
            </div>
        </div>
    </div>
@endsection
