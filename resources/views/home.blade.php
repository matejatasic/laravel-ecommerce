@extends('layouts.app')

@section('content')
    <!-- hero -->
    <div id="hero-container">
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
            <div class="col-md-12 d-flex justify-content-around">
                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-md-3 mb-4">
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
                                @if (array_key_exists($product->id, session()->get('cart')))
                                    <button class="btn btn-warning w-100" disabled>Added</button>   
                                @else
                                    <button class="btn btn-warning w-100 addBtn"id="{{ $product->id }}">Add to cart</button>    
                                @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- !products -->
    </div>

    <div id="blog-container" class="row d-flex flex-column mt-4">
        <div class="row mt-2">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <h2 class="text-center">Our Blog</h2>
                        <p class="mt-3">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus vel justo vestibulum orci egestas egestas. Lorem ipsum dolor sit amet, 
                            consectetur adipiscing elit. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. 
                            Donec tristique orci nec arcu.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row flex-fill mt-2">
          <div class="col-md-12 d-flex flex-column">
            <div class="d-flex flex-row justify-content-around h-100">
                <div class="col-md-3 text-center">
                    <img src="{{ asset('images/post1.png') }}" class="w-75" alt="post-image">
                    <h3 class="mt-2">Post heading</h3>
                    <p class="text-left">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima ipsa officia veritatis fugiat labore eveniet autem cumque dignissimos quisquam 
                        commodi atque laudantium fugit beatae voluptatum quae saepe neque in expedita itaque possimus laboriosam ducimus, architecto aspernatur fuga! 
                        Laudantium aperiam debitis sunt asperiores, fugit eius laborum modi inventore. Ducimus possimus libero dolorum, ex nostrum tempore odit obcaecati tenetur. Quis, eius hic.
                    </p>
                    <a href="#" class="btn btn-primary">Read more</a>
                </div>
                <div class="col-md-3 text-center">
                    <img src="{{ asset('images/post2.png') }}" class="w-75" alt="post-image">
                    <h3 class="mt-2">Post heading</h3>
                    <p class="text-left">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima ipsa officia veritatis fugiat labore eveniet autem cumque dignissimos quisquam 
                        commodi atque laudantium fugit beatae voluptatum quae saepe neque in expedita itaque possimus laboriosam ducimus, architecto aspernatur fuga! 
                        Laudantium aperiam debitis sunt asperiores, fugit eius laborum modi inventore. Ducimus possimus libero dolorum, ex nostrum tempore odit obcaecati tenetur. Quis, eius hic.
                    </p>
                    <a href="#" class="btn btn-primary">Read more</a>
                </div>
                <div class="col-md-3 text-center"> 
                    <img src="{{ asset('images/post3.png') }}" class="w-75" alt="post-image">
                    <h3 class="mt-2">Post heading</h3>
                    <p class="text-left">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima ipsa officia veritatis fugiat labore eveniet autem cumque dignissimos quisquam 
                        commodi atque laudantium fugit beatae voluptatum quae saepe neque in expedita itaque possimus laboriosam ducimus, architecto aspernatur fuga! 
                        Laudantium aperiam debitis sunt asperiores, fugit eius laborum modi inventore. Ducimus possimus libero dolorum, ex nostrum tempore odit obcaecati tenetur. Quis, eius hic.
                    </p>
                    <a href="#" class="btn btn-primary">Read more</a>
                </div>
            </div>
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
                    button.text('Added');
                },
                error: (request, status, error) => {
                    button.prop('disabled', false);
                    button.text('Add to cart');
                    $('#errors').html(`
                        <div class="alert alert danger">There was an error while trying to add the item to the cart</div>    
                    `);
                    console.log(request.responseText);
                }
            });
        })
    </script>
@endsection
