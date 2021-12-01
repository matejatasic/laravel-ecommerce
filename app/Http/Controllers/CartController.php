<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Cart;

class CartController extends Controller
{
    public function store($id) {
        $product = Product::find($id);
        
        $cart = new Cart;

        $cart->product_id = $id;
        $cart->user_id = Auth::id();
        $cart->save();

        $userCart = session()->get('cart');
        $userCart = [
            $id => [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image,
            ],
        ];
        session()->put('cart', $userCart);
        
        return response()->json('OK', 200);
    }
}
