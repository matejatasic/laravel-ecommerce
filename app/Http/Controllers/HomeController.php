<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(request()->featured) {
            $products = Product::where('featured', 1)->paginate(9);
        }
        else {
            $products = Product::take(9)->get();
        }

        $cart = Cart::all();
        $productQuantity = [];

        foreach($cart as $product) {
            if(!array_key_exists($product->product_id, $productQuantity)) {
                $productQuantity[$product->product_id] = $product->quantity;
            }
            else {
                $productQuantity[$product->product_id] += $product->quantity;    
            } 
        }
        
        return view('home', [
            'products' => $products,
            'productQuantity' => $productQuantity,
        ]);
    }
}
