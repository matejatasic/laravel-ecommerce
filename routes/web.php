<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::post('/products/search', [ProductController::class, 'search']);
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

Route::group(['middleware' => 'auth' ], function() {
    // Admin
    Route::group(['middleware' => 'admin'], function() {
        // Dashboard
        Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        
        // Orders
        Route::get('/admin/orders', [AdminController::class, 'getOrders'])->name('admin.getOrders');
        Route::get('/admin/orders/{id}', [AdminController::class, 'showOrder']);
        
        // Products
        Route::get('/admin/products', [AdminController::class, 'getProducts'])->name('admin.getProducts');
        Route::get('/admin/products/{id}', [AdminController::class, 'showProduct']);
        Route::post('/admin/products/add', [AdminController::class, 'addProduct']);
        Route::get('/admin/products/edit/{id}', [AdminController::class, 'editProduct']);
        Route::put('/admin/products/update/{id}', [AdminController::class, 'updateProduct']);
        Route::delete('/admin/products/delete/{id}', [AdminController::class, 'deleteProduct']);
        
        // Customers
        Route::get('/admin/customers', [AdminController::class, 'getCustomers'])->name('admin.getCustomers');
        
        // Categories
        Route::get('/admin/categories', [AdminController::class, 'getCategories'])->name('admin.getCategories');
        Route::post('/admin/categories/add', [AdminController::class, 'addCategory']);
        Route::get('/admin/categories/edit/{id}', [AdminController::class, 'editCategory']);
        Route::put('/admin/categories/update/{id}', [AdminController::class, 'updateCategory']);
        Route::delete('/admin/categories/delete/{id}', [AdminController::class, 'deleteCategory']);
    });

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/{id}', [CartController::class, 'store'])->name('cart.store');
    Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'delete'])->name('cart.delete');
    Route::post('/cart/save/{id}', [CartController::class, 'saveForLater'])->name('cart.saveForLater');
    Route::post('/cart/add/{id}', [CartController::class, 'moveToCart'])->name('cart.moveToCart');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
});
