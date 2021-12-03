@extends('layouts.app')

@section('content')
    <div class="row mb-5" id="adress-bar">
        <div class="col-md-4 text-center pt-3">
            <p>Home > Shop > {{ $product->name }}</p>
        </div>
        <div class="col-md-8"></div>
    </div>
    <div class="container">
        <div id="errors">
            @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert danger">{{$error}}</div>
                    @endforeach
            @endif
        </div>
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
                @if (Session::has('cart') && array_key_exists($product->id, session()->get('cart')))
                    <button class="btn btn-warning w-100" disabled>Added</button>   
                @else
                    <button class="btn btn-warning w-100 addBtn"id="{{ $product->id }}">Add to cart</button>    
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
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
        })
    </script>
@endsection
