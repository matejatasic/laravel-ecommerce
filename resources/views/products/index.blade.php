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
                <div id="errors">
                    @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert danger">{{$error}}</div>
                            @endforeach
                    @endif
                </div>
                <div class="row mt-4 d-flex flex-row justify-content-between">
                    @foreach ($products as $product)
                        <div class="col-md-4 mb-4">
                            <div class="card px-2">
                                <a href="{{ route('products.show', $product->id) }}"><img src="{{ asset('images/'.$product->image) }}" class="card-img-top" alt="product"></a>
                                <div class="card-body">
                                <a href="{{ route('products.show', $product->id) }}" class="product-title"><h5 class="card-title">{{ $product->name }}</h5></a>
                                <div>
                                    <span>Rating:</span>&nbsp;
                                    <span><i class="fas fa-star"></i></span>
                                    <span><i class="fas fa-star"></i></span>
                                    <span><i class="fas fa-star"></i></span>
                                    <span><i class="fas fa-star"></i></span>
                                    <span><i class="fas fa-star"></i></span>
                                </div>
                                <p>Price: {{ $product->price }}$</p>
                                @if (Session::has('cart') && array_key_exists($product->id, session()->get('cart')))
                                    <button class="btn btn-warning w-100" disabled>Added</button>   
                                @else
                                    <button class="btn btn-warning w-100 addBtn" id="{{ $product->id }}">Add to cart</button>    
                                @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(() => {
            let cartQuantity = $('#cart-quantity');

            $('.addBtn').click((e) => {
                e.stopPropagation();
                e.stopImmediatePropagation();

                let button = $(e.target);
                let id = button[0].id;
                let token = "{{ csrf_token() }}";

                $.ajax({
                    url: '/cart/' + id,
                    method: 'POST',
                    data: {
                        '_token': token,
                    },
                    beforeSend() {
                        button.prop('disabled', true);
                        button.text('Adding...');
                    },
                    success: (res) => {
                        if(res === 0) {
                            $('#errors').html(`
                                <div class="alert alert-danger">You must be logged in to add to the cart!</div>    
                            `);   
                            button.prop('disabled', false);
                            button.text('Add to cart');
                        }
                        else {
                            cartQuantity.text(res);
                            button.text('Added');
                        }
                    },
                    error: (request, status, error) => {
                        button.prop('disabled', false);
                        button.text('Add to cart');
                        $('#errors').html(`
                            <div class="alert alert danger">There was an error while trying to add the item to the cart!</div>    
                        `);
                        console.log(request.responseText);
                    }
                });
            });
        })
    </script>
@endsection
