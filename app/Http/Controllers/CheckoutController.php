<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class CheckoutController extends Controller
{
    public function index() {
        $cart = Cart::where('user_id', Auth::id())->get();
        $subtotal = 0;
        
        foreach($cart as $cartProduct) {
            $subtotal += $cartProduct->product->price * $cartProduct->quantity;
        }

        $tax = $subtotal / 10;

        return view('checkout', [
            'cart' => $cart,
            'subtotal' => $subtotal,
            'tax' => $tax,
        ]);
    }

    public function store(Request $request) {
        
    }
}
