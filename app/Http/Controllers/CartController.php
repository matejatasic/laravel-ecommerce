<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Cart;
use App\Models\SaveForLater;
use Session;

class CartController extends Controller
{
    public function index() {
        $cart = Cart::where('user_id', Auth::id())->get();
        $saveForLater = SaveForLater::where('user_id', Auth::id())->get();
        $subtotal = 0;
        foreach($cart as $cartProduct) {
            $subtotal += $cartProduct->product->price * $cartProduct->quantity;
        }
        $tax = $subtotal / 10;

        return view('cart.index', [
            'cart' => $cart,
            'saveForLater' => $saveForLater,
            'subtotal' => $subtotal,
            'tax' => $tax,
        ]);
    }

    public function store($id) {
        if(!Auth::check()) {
            return response()->json(0, 200);    
        }
        $product = Product::find($id);
        
        $cart = new Cart;

        $cart->product_id = $id;
        $cart->user_id = Auth::id();
        $cart->save();

        $userCart = session()->get('cart');
        $userCart[$id] = [
            "name" => $product->name,
            "quantity" => 1,
            'details' => $product->details,
            "price" => $product->price,
            "image" => $product->image,
        ];
        session()->put('cart', $userCart);
        
        return response()->json(count($userCart), 200);
    }

    public function update(Request $request, $id) {
        $cart = Cart::find($id);
        $cart->quantity = $request->quantity;
        $cart->save();

        return response()->json(1, 200);
    }

    public function delete($id) {
        $cart = Cart::find($id);
        $userCart =  session()->get('cart');

        unset($userCart[$cart->product_id]);
        session()->put('cart', $userCart); 
        $cart->delete();

        Session::flash('success', 'Successfully deleted the product from the cart!');
        return redirect()->route('cart.index');
    }

    public function saveForLater($id) {
        $cartProduct = Cart::find($id);
        $saveForLater = new SaveForLater;
        $userCart =  session()->get('cart');

        $saveForLater->product_id = $cartProduct->product_id;
        $saveForLater->user_id = Auth::id();
        $saveForLater->save();

        unset($userCart[$cartProduct->product_id]);
        session()->put('cart', $userCart); 
        $cartProduct->delete();

        Session::flush('success', 'Item successfully saved for later!');
        return redirect()->route('cart.index');
    }
}
