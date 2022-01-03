<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; 
use App\Models\User;
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
        $categories = Category::all();

        return view('admin.products', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    public function showProduct($id) {
        $product = Product::find($id);

        return response()->json([
            'data' => $product,
            'category' => $product->category->name,
        ]);
    }

    public function addProduct(Request $request) {
        $product = new Product;

        $this->validate($request, [
            'name' => 'required|unique:products,name|max:50',
            'slug' => 'required|unique:products,slug|max:30',
            'details' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|integer',
            'featured' => 'required|in:1,0',
            'quantity' => 'required|integer',
            'category' => 'required|exists:categories,id',
            'image' => 'required|mimes:jpg,png,svg',
        ]);

        $image_name = time() . 'product_image' . $request->image->extension();
        $request->image->move(public_path('images/'), $image_name);

        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->details = $request->details;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->featured = $request->featured;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category;
        $product->image = $image_name;
        $product->save();

        Session::flash('success', 'You have successfully added the product!');

        return redirect()->route('admin.getProducts');
    }

    public function editProduct($id) {
        $product = Product::find($id);

        return response()->json([
            'data' => $product,
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
            $request->image->move(public_path('images/'), $image_name);

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

        Session::flash('success', 'You have successfully updated the product!');

        return redirect()->route('admin.getProducts');
    }

    public function deleteProduct($id) {
        $product = Product::find($id);
        $product->delete();

        Session::flash('success', 'You have successfully deleted the product!');
        return redirect()->route('admin.getProducts');
    }

    public function getCustomers() {
        $customers = User::has('orders')->paginate(5);
        
        return view('admin.customers', [
            'customers' => $customers,
        ]);
    }

    public function getCategories() {
        $categories = Category::paginate(5);

        return view('admin.categories', [
            'categories' => $categories,
        ]);
    }

    public function addCategory(Request $request) {
        $category = new Category;

        $this->validate($request, [
            'name' => 'required|unique:categories,name|max:50',
            'slug' => 'required|unique:categories,slug|max:30',
        ]);

        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->save();

        Session::flash('success', 'You have successfully added the category!');

        return redirect()->route('admin.getCategories');    
    }

    public function editCategory($id) {
        $category = Category::find($id);

        return response()->json([
            'data' => $category,
        ]);    
    }

    public function updateCategory(Request $request, $id) {
        $category = Category::find($id);

        $this->validate($request, [
            'name' => 'required',
            'slug' => $request->slug === $category->slug ? 'required' : 'required|unique:categories,slug',
        ]);

        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->save();

        Session::flash('success', 'You have successfully updated the category!');
        return redirect()->route('admin.getCategories');
    }

    public function deleteCategory($id) {
        $category = Category::find($id);
        $category->delete();

        Session::flash('success', 'You have successfully deleted the category!');
        return redirect()->route('admin.getCategories');
    }
}
