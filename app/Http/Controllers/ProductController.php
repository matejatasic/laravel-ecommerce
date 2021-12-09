<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;

class ProductController extends Controller
{
    public function index() {
        $products = Product::take(9)->get();
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
        
        return view('products.index', [
            'products' => $products,
            'productQuantity' => $productQuantity,
        ]);
    }

    public function show($id) {
        $product = Product::find($id);
        $cart = Cart::where('product_id', $id)->get();
        $productQuantity = 0;
        
        foreach($cart as $cartProduct) {
            $productQuantity += $cartProduct->quantity;
        }
        
        return view('products.show', [
            'product' => $product,
            'productQuantity' => $productQuantity,
        ]);
    }
}
