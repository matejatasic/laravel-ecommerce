@extends('layouts.app')

@section('content')
    <div class="row mb-5" id="adress-bar">
        <div class="col-md-4 text-center pt-3">
            <p>Home > Shopping Cart</p>
        </div>
        <div class="col-md-8"></div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>{{ count(session()->get('cart')) }} item(s) in the cart</h1>
            </div>
            <div class="col-md-10 mt-3" id="cart">
                @foreach (session()->get('cart') as $cartProduct)
                    <div class="card mb-3">
                        <div class="row no-gutters">
                            <div class="col-md-2">
                                <img src="{{ asset('images/'.$cartProduct['image']) }}" alt="product">
                            </div>
                            <div class="col-md-5">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $cartProduct['name'] }}</h5>
                                    <p class="card-text">{{ $cartProduct['details'] }}</p>
                                    
                                </div>
                            </div>
                            <div class="col-md-2 d-flex flex-column justify-content-around">
                                <button class="btn btn-success w-75">Save for later</button>
                                <button class="btn btn-danger w-75">Remove</button>
                            </div>
                            <div class="col-md-1 pr-2 d-flex">
                                <input type="number" class="form-control align-self-center">
                            </div>
                            <div class="col-md-2 d-flex justify-content-center">
                                <p class="align-self-center cartPrice">{{ $cartProduct['price'] }}$</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
@endsection
