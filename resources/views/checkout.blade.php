@extends('layouts.app')

@section('extra-css')
    <script src="https://js.stripe.com/v3/"></script>
@endsection

@section('content')
    <div class="container pt-4 mb-3">
        <div class="row">
            <div class="col-md-12 mb-4">
                <h1>Checkout</h1>
                <hr>
            </div>
            <div class="col-md-6">
                <form action="{{ route('checkout.store') }}" id="payment-form" method="POST">
                    <div class="row">
                        <!-- billing Details -->
                        <div class="col-md-12">
                            <h2>Billing Details</h2>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" value="{{ auth()->user()->email }}" readonly>
                            </div>
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" class="form-control" name="address" value="{{ old('name') }}" required>
                            </div>
                            <div class="form-row">
                                <div class="form-group col">
                                    <label>City</label>
                                    <input type="text" class="form-control" name="city" value="{{ old('city') }}" required>
                                </div>
                                <div class="form-group col">
                                    <label>Province</label>
                                    <input type="text" class="form-control" name="province" value="{{ old('province') }}" required>
                                </div>
                            </div>
                            <div class="form-row mb-4">
                                <div class="form-group col">
                                    <label>Postal Code</label>
                                    <input type="text" class="form-control" name="postalcode" value="{{ old('postalcode') }}" required>
                                </div>
                                <div class="form-group col">
                                    <label>Phone</label>
                                    <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>
                                </div>
                            </div>
                        </div>
                        <!-- billing details -->

                        <!-- payment details -->
                        <div class="col-md-12">
                            <h2>Payment Details</h2>    
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Name on Card</label>
                                <input type="text" class="form-control" name="name_on_card" required>    
                            </div>
                            <div class="form-group">
                                <label>Credit or debit card number</label>
                                <div id="card-element">
                                    
                                </div>
                                <div id="card-errors" role="alert"></div>    
                            </div>
                        </div>
                        <!-- !payment details -->
                        
                        <input type="submit" id="complete-order" class="btn btn-primary ml-3 mt-2" value="Complete Order">
                    </div>
                </form>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Your Order</h2>
                    </div>
                    <div class="col-md-12 mt-3" id="orders">
                        @foreach ($cart as $cartProduct)
                            <div class="card mb-3">
                                <div class="row no-gutters">
                                    <div class="col-md-3 mt-4">
                                        <img src="{{ asset('images/'.$cartProduct->product->image) }}" alt="cart_product_image">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $cartProduct->product->name }}</h5>
                                            <p class="card-text">{{ $cartProduct->product->details }}</p>
                                            <p>{{ $cartProduct->product->price }}$</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3 d-flex justify-content-center align-items-center">
                                        <p class="text-center order-quantity">{{ $cartProduct->quantity }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="jumbotron row">
                            <div class="col-md-10 d-flex flex-column">
                                <p>Subtotal:</p>
                                <p>Tax(10%):</p>
                                <p><strong>Total:</strong></p>
                            </div>
                            <div class="col-md-2 d-flex flex-column justify-content-start">
                                <p>{{ $subtotal }}$</p>
                                <p>{{ round($tax) }}$</p>
                                <p><strong>{{ round($tax) + $subtotal }}$</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        (function(){
            // Create a Stripe client
            var stripe = Stripe('pk_test_JKVJPMynL8ckk7ivBxoroTlT');
            // Create an instance of Elements
            var elements = stripe.elements();
            // Custom styling can be passed to options when creating an Element.
            // (Note that this demo uses a wider set of styles than the guide below.)
            var style = {
            base: {
                color: '#32325d',
                lineHeight: '18px',
                fontFamily: '"Roboto", Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
            };
            // Create an instance of the card Element
            var card = elements.create('card', {
                style: style,
                hidePostalCode: true
            });
            // Add an instance of the card Element into the `card-element` <div>
            card.mount('#card-element');
            // Handle real-time validation errors from the card Element.
            card.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
            });
            // Handle form submission
            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function(event) {
            event.preventDefault();
            // Disable the submit button to prevent repeated clicks
            document.getElementById('complete-order').disabled = true;
            var options = {
                name: document.getElementById('name_on_card').value,
                address_line1: document.getElementById('address').value,
                address_city: document.getElementById('city').value,
                address_state: document.getElementById('province').value,
                address_zip: document.getElementById('postalcode').value
            }
            stripe.createToken(card, options).then(function(result) {
                if (result.error) {
                // Inform the user if there was an error
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
                // Enable the submit button
                document.getElementById('complete-order').disabled = false;
                } else {
                // Send the token to your server
                stripeTokenHandler(result.token);
                }
            });
            });
            function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
            // Submit the form
            form.submit();
            }
        })();
    </script>
@endsection