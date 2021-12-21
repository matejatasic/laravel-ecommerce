<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;

class AdminController extends Controller
{
    public function dashboard() {
        $product_count = Product::where('quantity', '>', 0)->count();
        $order_count = Order::where('error', null)->count();
        $customer_count = count(Order::select('user_id')->distinct()->get());

        return view('admin.dashboard', [
            'product_count' => $product_count,
            'order_count' => $order_count,
            'customer_count' => $customer_count,
        ]);
    }

    public function getOrders() {
        $orders = Order::where('error', null)->paginate(5);
        
        return view('admin.orders', [
            'orders' => $orders,
        ]);
    }

    public function showOrder($id) {
        $order = Order::find($id);

        return response()->json([
            'data' => $order,
        ]);
    }
}
