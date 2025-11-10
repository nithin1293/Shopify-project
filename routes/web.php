<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\AddressController;
use App\Models\Store;
use App\Http\Controllers\RazorpayController;
use App\Http\Controllers\OrderDetailsController;

 Route::get('/', function () {
    return view('auth.register');
 })->name('register.form');

Route::get('/login', function () {
    return view('auth.login');
})->name('login.form'); 



Route::get('/dashboard', function () {
    $stores = Store::all(); // fetch all stores
    return view('auth.dashboard', compact('stores'));
})->name('dashboard');



Route::get('/customerDashboard', function () {
    $stores = Store::all(); // fetch all stores
    return view('auth.customerDashboard', compact('stores'));
})->name('customerDashboard');


Route::get('/dashboard/store/{id}', [DashboardController::class, 'viewStore'])->name('dashboard.store.view');
// Route::get('/customer/dashboard/store/{id}', [CustomerDashboardController::class, 'viewStore'])->name('customer_dashboard.store.view');
// Route::get('/customer/dashboard', [CustomerDashboardController::class, 'index'])->name('customer_dashboard');
Route::get('/admindashboard/store/{id}', [DashboardController::class, 'showStore'])->name('customize.view');


Route::get('/dashboard/store/{id}/products', [DashboardController::class, 'storeProducts']);
Route::get('/store', [StoreController::class, 'create'])->name('store.view');
Route::post('/store', [StoreController::class, 'store'])->name('store.insert');
Route::get('/theme', function () {
    return view('theme'); 
})->name('theme.view');

Route::post('/theme', [ThemeController::class, 'store'])->name('theme.store');


Route::get('/products', [ProductController::class, 'create'])->name('products.view');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
// Route::get('/customer_dashboard', function () {
//     return view('customer_dashboard');
// })->name('customer_dashboard');
Route::get('/cart', function () {
    return view('cart');
})->name('cart.show');
use App\Http\Controllers\CartController;

Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::get('/addresses', [AddressController::class, 'indexWeb'])->name('addresses.index');
Route::get('/addresses/create', [AddressController::class, 'createWeb'])->name('addresses.create');
Route::post('/addresses/select/{id}', [AddressController::class, 'selectAddress'])->name('addresses.select');
Route::get('/razorpay', [RazorpayController::class, 'index'])-> name('razorpay.index');
Route::post('/razorpay/payment', [RazorpayController::class, 'payment'])->name('razorpay.payment');
Route::post('/razorpay/success', [RazorpayController::class, 'success'])->name('razorpay.success');


Route::post('/orders', [OrderDetailsController::class, 'store']);
Route::get('/orders', [OrderDetailsController::class, 'index'])->name('orders.index');
