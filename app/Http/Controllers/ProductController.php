<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index() {
        $products = Product::take(9)->get();
        
        return view('products.index', [
            'products' => $products,
        ]);
    }

    public function show($id) {
        $product = Product::find($id);

        return view('products.show', [
            'product' => $product,
        ]);
    }
}
