<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title></title>
    <style>
        #email-card {
            width: 60%;
            border: 1px solid rgb(102, 102, 102);
            margin: 2rem auto;
            font-family: 'Oswald';
        }

        #email-heading {
            text-align: center;
            padding: 0.5rem auto;
        }

        #email-heading > h1 {
            font-size: 1.5rem;
        }

        #email-body {
            padding: 0.5rem 2rem;
        }

        #email-body > p:first-child {
            margin-bottom: 1rem;
        }

        #email-body > a {
            margin: 0.5rem auto;
            width: 10rem;
            display: block;
            background: #24a7d3;
            color: #333;
            padding: 0.4rem 1.3rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            outline: none;
            transition: all 0.2s ease-in;
            text-decoration: none;
            text-align: center;
            font-family: 'Oswald';
        }

        #card {
            border: 1px solid gray;
            border-radius: 2px;
            background: rgb(211, 211, 211);
            padding: 1rem;
            margin-bottom: 0.5rem;
        }

        #email-footer {
            margin-top: 2rem;
        }

        #email-footer > p {
            margin-bottom: 0;
        }
    }
    </style>
</head>
<body>
    <div id="email-card">
        <div id="email-heading">
            <h1>Order Received</h1>
            <p>Thank you for you order.</p>
        </div>
        <div id="email-body">
            <h4>**Order ID:** {{ $order->id }}</h4>
            <h4>**Order Email:** {{ $order->email }}</h4>
            <h4>**Order Name:** {{ $order->name }}</h4>
            <h4>**Order Total:** {{ $order->total }}$</h4>

            <h4>**Items Ordered**</h4>
            @foreach ($order->products as $product)
                <div id="card">
                    <p>Name: {{ $product->name }}</p>
                    <p>Price: {{ $product->price }}$</p>
                    <p>Quantity: {{ $product->pivot->quantity }}</p>
                </div>
            @endforeach

            <p>You can get further details about your order by logging in to our site</p>
            <a href="{{ route('home') }}" class="btn btn-primary">Go To Website</a>
            <p>Thank you for choosing us.</p>
            <div id="email-footer">
                <p>Best regards,</p>
                <p>Laravel Ecommerce</p>
            </div>
        </div>
    </div>
</body>
</html>
