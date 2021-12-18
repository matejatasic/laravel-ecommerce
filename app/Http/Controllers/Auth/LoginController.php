<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Cart;
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    public function redirectTo() {
        if(Auth::user()->isAdmin()) {
            return '/admin';
        }
        else {
            return '/';
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticated(Request $request, $user) {
        $cart = Cart::where('user_id', Auth::id())->get();
        $userCart = [];

        if($cart->count() > 1) {
            foreach($cart as $cartItem) {
                $cartProduct = $cartItem->product;
                $userCart[$cartProduct->id] = [
                    "name" => $cartProduct->name,
                    "quantity" => $cartProduct->quantity,
                    "details" => $cartProduct->details,
                    "price" => $cartProduct->price,
                    "image" => $cartProduct->image,
                ];
            }
        }
        else if($cart->count() === 1) {
            $cartProduct = $cart[0]->product;
            $userCart[$cartProduct->id] = [
                "name" => $cartProduct->name,
                "quantity" => $cartProduct->quantity,
                "details" => $cartProduct->details,
                "price" => $cartProduct->price,
                "image" => $cartProduct->image,    
            ];
        }

        Session::put('cart', $userCart);
    }

    public function getLogout() {
        Auth::logout();

        Session::forget('cart');

        return redirect('/');
    }
}
