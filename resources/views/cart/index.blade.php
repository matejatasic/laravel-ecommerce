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
                <div id="errors">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">{{$error}}</div>
                        @endforeach
                    @endif
                </div>
                @if (Session::has('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif
                @foreach ($cart as $cartProduct)
                    <div class="card mb-3">
                        <div class="row no-gutters">
                            <div class="col-md-2">
                                <a href="{{ route('products.show', $cartProduct->product_id) }}"><img src="{{ asset('images/'.$cartProduct->product->image) }}" alt="product"></a>
                            </div>
                            <div class="col-md-5">
                                <div class="card-body">
                                    <a href="{{ route('products.show', $cartProduct->product_id) }}"><h5 class="card-title">{{ $cartProduct->product->name }}</h5></a>
                                    <p class="card-text">{{ $cartProduct->product->details }}</p>
                                </div>
                            </div>
                            <div class="col-md-2 d-flex flex-column justify-content-around">
                                <form action="{{ route('cart.saveForLater', $cartProduct->id) }}" method="POST">
                                    @csrf

                                    <input class="btn btn-success w-75" type="submit" value="Save for later">
                                </form>
                                <form action="{{ route('cart.delete', $cartProduct->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <input class="btn btn-danger w-75" type="submit" value="Remove">
                                </form>
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
                <a href="{{ route('checkout.index') }}" class="btn btn-primary">Proceed to Checkout</a>
            </div>
            
            @if (count($saveForLater) === 0)
                <p>No products have been saved for later</p>
            @else
                <div class="col-md-12">
                    <h2>{{ count($saveForLater) }} item(s) saved for later</h2>
                </div>
                <div class="col-md-10 mt-3 mb-4" id="savedItems">
                    @foreach ($saveForLater as $savedItem)
                            <div class="card mb-3">
                                <div class="row no-gutters">
                                    <div class="col-md-2">
                                        <a href="{{ route('products.show', $savedItem->product_id) }}"><img src="{{ asset('images/'.$savedItem->product->image) }}" alt="product"></a>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="card-body">
                                            <a href="{{ route('products.show', $savedItem->product_id) }}"><h5 class="card-title">{{ $savedItem->product->name }}</h5></a>
                                            <p class="card-text">{{ $savedItem->product->details }}</p>
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-flex flex-column justify-content-around">
                                        <form action="{{ route('cart.moveToCart', $savedItem->id) }}" method="POST">
                                            @csrf

                                            <input class="btn btn-success w-75" type="submit" value="Move to cart">
                                        </form>
                                        <form action="{{ route('cart.delete', $savedItem->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <input class="btn btn-danger w-75" type="submit" value="Remove">
                                        </form>
                                    </div>
                                    <div class="col-md-3 d-flex justify-content-center">
                                        <p class="align-self-center cartPrice {{ $savedItem->product_id }}">{{ $savedItem->product->price }}$</p>
                                    </div>
                                </div>
                            </div>
                    @endforeach
                </div>
            @endif
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
                let id = $(e.target)[0].id;;
                let quantity = select.val();
                $.ajax({
                    url: `/cart/${id}`,
                    method: 'PUT',
                    data: {
                        '_token': token,
                        'quantity': quantity,
                    },
                    success: (res) => {
                        if(res === 'ok') {
                            window.location.href = "{{ route('cart.index') }}";     
                        }
                        else {
                            if(res === 0) {
                                $('#errors').html(`
                                    <div class="alert alert-danger">There are not enough items in the stock! There are no left!</div>    
                                `);
                            }
                            else {
                                $('#errors').html(`
                                    <div class="alert alert-danger">There are not enough items in the stock! Only ${res} left!</div>    
                                `);
                            }
                        }
                    },
                    error: (request, status, error) => {
                        console.log(request.responseText);
                    }
                })
            });
        });
    </script>
@endsection
