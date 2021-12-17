<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;

class ProductController extends Controller
{
    public function index() {
        if(isset(request()->category)) {
            $products = Product::with('category')->whereHas('category', function ($query) {
                $query->where('slug', request()->category);
            })->get(); 
        }
        else if(isset(request()->range)) {
            if(request()->range === '0-700') {
                $products = Product::where('price', '<=', '700')->get();
            }
            else if(request()->range === '700-2500') {
                $products = Product::where('price', '>=', '700')->where('price', '<=', '2500')->get();
            }
            else {
                $products = Product::where('price', '>=', '2500')->get();
            }
        }
        else {
            $products = Product::orderBy('created_at', 'desc')->paginate(9); 
        }

        $cart = Cart::all();
        $productQuantity = [];
        $categories = Category::all();
        
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
            'categories' => $categories,
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
