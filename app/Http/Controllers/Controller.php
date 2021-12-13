<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getPrice($cart) {
        $subtotal = 0;
        
        foreach($cart as $cartProduct) {
            $subtotal += $cartProduct->product->price * $cartProduct->quantity;
        }

        return [
            'subtotal' => $subtotal,
            'tax' => $subtotal / 10
        ];
    }
}
