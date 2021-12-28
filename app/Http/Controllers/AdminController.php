<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; 
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use Session;

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

    public function getProducts() {
        $products = Product::paginate(5);

        return view('admin.products', [
            'products' => $products,
        ]);
    }

    public function showProduct($id) {
        $product = Product::find($id);

        return response()->json([
            'data' => $product,
            'category' => $product->category->name,
        ]);
    }

    public function editProduct($id) {
        $product = Product::find($id);
        $categories = Category::all();

        return response()->json([
            'data' => $product,
            'categories' => $categories,
        ]);
    }

    public function updateProduct(Request $request, $id) {
        $product = Product::find($id);
        $old_image_name;
        $image_name;
        
        $this->validate($request, [
            'name' => $request->name !== $product->name ? 'required|unique:products,name|max:50' : 'required|max:50',
            'slug' => $request->slug !== $product->slug ? 'required|unique:products,slug|max:30' : 'required|max:30',
            'details' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|integer',
            'featured' => 'nullable|in:1,0',
            'quantity' => 'required|integer',
            'category' => 'nullable|exists:categories,id',
            'image' => 'nullable|mimes:jpg,png,svg',
        ]);

        if($request->hasFile('img_path') && $request->img_path->isValid()) {
            $old_image_name = $product->image;
            $image_name = time() . 'product_image' . $request->image->extension();
            $request->image->move(public_path('images/'), $new_image_name);

            File::delete(public_path('images/'.$old_image_name));
        }
        else {
            $image_name = $product->image;
        }

        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->details = $request->details;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->featured = $request->featured ? $request->featured : $product->featured;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category ? $request->category : $product->category_id;
        $product->image = $image_name;
        $product->save();

        Session::flash('success', 'You have successfully update the product!');

        return redirect()->route('admin.getProducts');
    }
}
