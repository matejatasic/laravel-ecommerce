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
                <h1>{{ count($cart) }} item(s) in the cart</h1>
            </div>
            <div class="col-md-10 mt-3" id="cart">
                @foreach ($cart as $cartProduct)
                    
                    <div class="card mb-3">
                        <div class="row no-gutters">
                            <div class="col-md-2">
                                <img src="{{ asset('images/'.$cartProduct->product->image) }}" alt="product">
                            </div>
                            <div class="col-md-5">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $cartProduct->product->name }}</h5>
                                    <p class="card-text">{{ $cartProduct->product->details }}</p>
                                    
                                </div>
                            </div>
                            <div class="col-md-2 d-flex flex-column justify-content-around">
                                <button class="btn btn-success w-75">Save for later</button>
                                <button class="btn btn-danger w-75">Remove</button>
                            </div>
                            <div class="col-md-1 pr-2 d-flex">
                                <select name="quantity" id="{{ $cartProduct->product_id }}" class="form-control align-self-center">
                                    @for ($i = 1; $i <= $cartProduct->product->quantity; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-2 d-flex justify-content-center">
                                <p class="align-self-center cartPrice">{{ $cartProduct->product->price }}$</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-md-10 mt-4">
                <div class="jumbotron row">
                    <div class="col-md-4">
                        <p>Shipping is free. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odit, nulla nemo fugiat consequuntur animi aperiam?</p>
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4 d-flex flex-column">
                        <p>Subtotal: {{ $subtotal }}$</p>
                        <p>Tax(10%): {{ round($tax) }}$</p>
                        <p><strong>Total: {{ round($tax) + $subtotal }}$</strong></p>
                    </div>
                </div>
            </div>
            <div class="col-md-10 mb-5 d-flex justify-content-between">
                <a href="{{ route('products.index') }}" class="btn btn-dark">Continue Shopping</a>
                <a href="#" class="btn btn-success">Proceed to Checkout</a>
            </div>
        </div>
@endsection
