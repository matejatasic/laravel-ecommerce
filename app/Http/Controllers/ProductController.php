<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;

class ProductController extends Controller
{
    public function index($category_id = 0) {
        if($category_id === 0) {
            $products = Product::orderBy('created_at', 'desc')->paginate(9);
        }
        else {
            $products = Product::where('category_id', $category_id)->paginate(9);    
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
            'category_id' => $category_id,
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
