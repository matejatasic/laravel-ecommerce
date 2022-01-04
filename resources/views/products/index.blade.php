@extends('layouts.app')

@section('content')
    <div class="row mb-5" id="adress-bar">
        <div class="col-md-4 col-sm-4 col-6 text-center pt-3">
            <p>Home > Shop</p>
        </div>
        <div class="col-md-8 col-sm-8 col-8"></div>
    </div>
    <div class="container">
        <div class="row">
            <!-- sidebar -->
            <div class="col-md-3 col-sm-3 col-3" id="sidebar">
                <div class="row">
                    <div class="col-md-12">
                        <p><b>Categories</b></p>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('products.index') }}">All</a></li>
                            @foreach ($categories as $category)
                                <li><a href="{{ route('products.index', ['category' => $category->slug]) }}">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <p><b>Prices</b></p>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('products.index', ['range' => '0-700']) }}">0 - 700$</a></li>
                            <li><a href="{{ route('products.index', ['range' => '700-2500']) }}">700 - 2500$</a></li>
                            <li><a href="{{ route('products.index', ['range' => '2500+']) }}">2500$+</a></li>
                        </ul>    
                    </div>
                </div>
            </div>
            <!-- !sidebar -->
            <div class="col-md-9 col-sm-9 col-9">
                <h1>Shop</h1>
                @if (Session::has('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif
                <div id="errors">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">{{$error}}</div>
                        @endforeach
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="search" placeholder="Find a product...">
                        <div class="dropdown-menu w-100" id="searchDropdown">
                            
                        </div>
                    </div>
                </div>
                <div class="row mt-4 d-flex flex-row">
                    @if($products->isEmpty())
                        <p>There are no products that match the criteria or no products at all.</p>    
                    @else
                        @foreach ($products as $product)
                            <div class="col-md-4 col-sm-6 col-12 mb-4">
                                <div class="card px-2">
                                    <a href="{{ route('products.show', $product->slug) }}"><img src="{{ asset('images/'.$product->image) }}" class="card-img-top" alt="product"></a>
                                    <div class="card-body">
                                    <a href="{{ route('products.show', $product->slug) }}" class="product-title"><h5 class="card-title">{{ $product->name }}</h5></a>
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
                                    @elseif(array_key_exists($product->id, $productQuantity) && $productQuantity[$product->id] === $product->quantity)
                                        <button class="btn btn-warning w-100" disabled>Out of stock</button>  
                                    @else
                                        <button class="btn btn-warning w-100 addBtn" id="{{ $product->id }}">Add to cart</button>    
                                    @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
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
            let token = "{{ csrf_token() }}";

            $('.addBtn').click((e) => {
                e.stopPropagation();
                e.stopImmediatePropagation();

                let button = $(e.target);
                let id = button[0].id;

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
                        if(res === 'already_in_cart') {
                            $('#errors').html(`
                                <div class="alert alert-danger">You must be logged in to add to the cart!</div>    
                            `);   
                            button.prop('disabled', false);
                            button.text('Add to cart');
                        }
                        else if(res === 'out_of_stock') {
                            $('#errors').html(`
                                <div class="alert alert-danger">There are not enough items in the stock!</div>    
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
                            <div class="alert alert-danger">There was an error while trying to add the item to the cart!</div>    
                        `);
                        console.log(request.responseText);
                    }
                });
            });

            $('#search').keyup((e) => {
                let value = e.target.value;
                let dropdown = $('#searchDropdown');

                if(value.length > 2) {
                    $.ajax({
                        url: '/products/search',
                        method: 'POST',
                        data: {
                            'value': value,
                            '_token': token,
                        },
                        success: (res) => {
                            dropdown.css('display', 'block');
                            
                            if(res.length === 0) {
                                dropdown.html('<p class="ml-3">No results</p>');
                            }
                            else {
                                let html = '';
                                for(let product of res) {
                                    html += `
                                        <a class="dropdown-item" href="/products/${product.id}">${product.name}</a>   
                                    `;
                                    
                                    dropdown.html(html);
                                }
                            }     
                        },
                        error: (request, status, error) => {
                            console.log(request.responseText);
                        }
                    });
                }
                else {
                    dropdown.css('display', 'none');
                }
            });
        })
    </script>
@endsection
