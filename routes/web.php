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

Route::get('/', function () {
    return view('auth.register');
 })->name('register.form');

Route::get('/login', function () {
    return view('auth.login');
})->name('login.form'); 

Route::get('/login', function () {
    return view('auth.login');
})->name('login'); 



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
Route::get('/address/create', [AddressController::class, 'createAddress'])->name('address.create');
    Route::post('/address', [AddressController::class, 'storeAddress'])->name('address.store');
    Route::get('/addresses', [AddressController::class, 'addresses'])->name('addresses.index');
    Route::get('/address/{address}/edit', [AddressController::class, 'editAddress'])->name('address.edit');
    Route::put('/address/{address}', [AddressController::class, 'updateAddress'])->name('address.update');
    Route::post('/address/select', [AddressController::class, 'selectAddress'])->name('address.select');





Route::get('/cart', [CartController::class, 'index'])->name('cart');