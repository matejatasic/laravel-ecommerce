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
                                <button class="{{ $cartProduct->id }} btn btn-danger w-75 removeBtn">Remove</button>
                            </div>
                            <div class="col-md-1 pr-2 d-flex">
                                <select name="quantity" id="{{ $cartProduct->id }}" class="form-control align-self-center quantitySelect">
                                    @for ($i = 1; $i <= $cartProduct->product->quantity; $i++)
                                        <option {{ $cartProduct->quantity === $i ? 'selected' : '' }} value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-2 d-flex justify-content-center">
                                <p class="align-self-center cartPrice {{ $cartProduct->product_id }}">{{ $cartProduct->product->price * $cartProduct->quantity }}$</p>
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

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(() => {
            let token = "{{ csrf_token() }}";

            $('.quantitySelect').change((e) => {
                e.stopPropagation();
                e.stopImmediatePropagation();

                let select = $(e.target).find(':selected');
                let id = $(e.target)[0].id;
                let quantity = select.val();
                $.ajax({
                    url: `/cart/${id}`,
                    method: 'PUT',
                    data: {
                        '_token': token,
                        'quantity': quantity,
                    },
                    success: (res) => {
                        window.location.href = "{{ route('cart.index') }}";
                    },
                    error: (request, status, error) => {
                        console.log(request.responseText);
                    }
                })
            });

            $('.removeBtn').click((e) => {
                e.stopPropagation();
                e.stopImmediatePropagation();

                let button = $(e.target);
                let id = button.attr('class').split(' ')[0];
                
                $.ajax({
                    url: '/cart/' + id,
                    method: 'DELETE',
                    data: {
                        '_token': token,
                    },
                    success: (res) => {
                        window.location.href = "{{ route('cart.index') }}";
                    },
                    error: (request, status, error) => {
                        console.log(request.responseText);
                    }
                })
            });
        });
    </script>
@endsection
