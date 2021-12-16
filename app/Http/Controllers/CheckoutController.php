<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Cartalyst\Stripe\Exception\CardErrorException;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Mail\OrderMade;
use Session;

class CheckoutController extends Controller
{
    public function index() {
        $cart = Cart::where('user_id', Auth::id())->get();
        $price = $this->getPrice($cart);

        return view('checkout', [
            'cart' => $cart,
            'subtotal' => $price['subtotal'],
            'tax' => $price['tax'],
        ]);
    }

    public function store(Request $request) {
        $cart = Cart::where('user_id', Auth::id())->get();
        $price = $this->getPrice($cart);
        $contents = $cart->map(function($item) {
            return $item->product->slug . ', ' . $item->quantity;
        })->values()->toJson();
        $quantity = 0;


        foreach($cart as $cartProduct) {
            $quantity += $cartProduct->quantity;
        }

        try {
            $charge = Stripe::charges()->create([
                'amount' => $price['subtotal'] + $price['tax'],
                'currency' => 'EUR',
                'source' => $request->stripeToken,
                'receipt_email' => $request->email,
                'metadata' => [
                    'contents' => $contents,
                    'quantity' => $quantity,
                ],
            ]);
            
            $order = $this->addOrders($request, null, $price, $cart);
            Mail::send(new OrderMade($order));

            $this->removeItemQuantity($cart);
            
            session()->put('cart', []);

            Session::flash('success', 'Thank you for your purchase! Your payment has been accepted!');
            return redirect()->route('products.index');
        }
        catch(CardErrorException $e) {
            $this->addOrders($request, $e->getMessage(), $price, $cart);
            return back()->withErrors('There was an error while trying to accept payment. Message: ' . $e->getMessage());
        }
    }

    private function addOrders($request, $error, $price, $cart) {
        $order = Order::create([
            'user_id' => Auth::id(),
            'email' => $request->email,
            'name' => $request->name,
            'adress' => $request->address,
            'city' => $request->city,
            'province' => $request->province,
            'postalcode' => $request->postalcode,
            'phone' => $request->phone,
            'name_on_card' => $request->name_on_card,
            'subtotal' => $price['subtotal'],
            'tax' => $price['tax'],
            'total' => $price['subtotal'] + $price['tax'],
            'error' => $error,
        ]);
        
        foreach($cart as $cartProduct) {
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $cartProduct->product_id,
                'quantity' => $cartProduct->quantity
            ]);
        }

        return $order;
    }

    private function removeItemQuantity($cart) {
        foreach($cart as $cartProduct) {
            $product = Product::find($cartProduct->product_id);

            $product->update(['quantity' => $product->quantity - $cartProduct->quantity]);
            $cartProduct->delete();
        }
    }
}
