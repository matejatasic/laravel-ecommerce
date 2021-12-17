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
        $price = $this->getPrice($cart);
        
        return view('cart.index', [
            'cart' => $cart,
            'saveForLater' => $saveForLater,
            'subtotal' => $price['subtotal'],
            'tax' => $price['tax'],
        ]);
    }

    public function store($id) {
        if(Cart::where('product_id', $id)->where('user_id', Auth::id())->exists()) {
            return response()->json('already_in_cart', 200);
        }
        
        $qty = 0;
        $product = Product::find($id);
        $cart = Cart::where('product_id', $id)->get();
        
        foreach($cart as $cartProduct) {
            $qty += $cartProduct['quantity'];
        }
        
        if(($product->quantity - $qty) <= 0) {
            return response()->json('out_of_stock', 200);   
        }
        
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
        $qty = 0;
        $productCart = Cart::where('product_id', $cart->product_id)->get();

        foreach($productCart as $cartProduct) {
            $qty += $cartProduct['quantity'];
        }

        if(($qty + $request->quantity) > $cart->product->quantity) {
            return response()->json($cart->product->quantity - $qty, 200);     
        }

        $cart->quantity = $request->quantity;
        $cart->save();

        return response()->json('ok', 200);
    }

    public function delete($id) {
        $cart = Cart::find($id);
        $saveForLater = SaveForLater::find($id);

        if($cart) {
            $userCart =  session()->get('cart');
            unset($userCart[$cart->product_id]);
            session()->put('cart', $userCart); 
            $cart->delete();

            Session::flash('success', 'Successfully removed the product from the cart!');
        }
        else {
            $saveForLater->delete();

            Session::flash('success', 'Successfully removed the product from save for later!');
        }

        return redirect()->route('cart.index');
    }

    public function saveForLater($id) {
        $cartProduct = Cart::find($id);

        if(SaveForLater::where('product_id', $cartProduct->product_id)->where('user_id', Auth::id())->exists()) {
            return redirect()->route('cart.index')->withErrors('alreadySaved', 'This item has already been saved for later!');
        }

        $saveForLater = new SaveForLater;
        $userCart =  session()->get('cart');

        $saveForLater->product_id = $cartProduct->product_id;
        $saveForLater->user_id = Auth::id();
        $saveForLater->save();
        
        unset($userCart[$cartProduct->product_id]);
        session()->put('cart', $userCart); 
        $cartProduct->delete();

        Session::flash('success', 'Item successfully saved for later!');
        return redirect()->route('cart.index');
    }
    
    public function moveToCart($id) {
        $saveForLater = SaveForLater::find($id);
        $qty = 0;

        if(Cart::where('product_id', $saveForLater->product_id)->where('user_id', Auth::id())->exists()) {
            return redirect()->route('cart.index')->withErrors('alreadyInCart', 'This item has already been added to the cart!');   
        }

        $sameProducts = Cart::where('product_id', $saveForLater->product_id)->get();

        foreach($sameProducts as $cartProduct) {
            $qty += $cartProduct['quantity'];
        }

        if(Product::where('product_id' , $saveForLater->product_id)->count() < $qty) {
            return redirect()->route('cart.index')->withErrors('out_of_stock', 'This item is out of stock!');   
        }

        $cart = new Cart;
        $userCart =  session()->get('cart');

        $cart->product_id = $saveForLater->product_id;
        $cart->user_id = Auth::id();
        $cart->save();
        
        $userCart[$cart->product_id] = [
            "name" => $cart->product->name,
            "quantity" => 1,
            'details' => $cart->product->details,
            "price" => $cart->product->price,
            "image" => $cart->product->image,    
        ];
        session()->put('cart', $userCart); 
        $saveForLater->delete();

        Session::flash('success', 'Item successfully moved to the cart!');
        return redirect()->route('cart.index');
    }
}
