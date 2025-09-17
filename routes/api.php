<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\AddressController;
use App\Models\Store;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/stores', [StoreController::class, 'store']);



Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
});

// Route::group(['middleware' => ['jwt.auth']], function () {  
//     Route::get('/address', [AddressController::class, 'index'])->name('address.index');
//     Route::get('/address/create', [AddressController::class, 'create'])->name('address.create');
//     Route::post('/address', [AddressController::class, 'store'])->name('address.store');
// });
// 
Route::middleware(['auth:api'])->group(function () {
   

    // Customer addresses
      Route::get('/customer/addresses', [AddressController::class, 'index']);
    Route::post('/customer/addresses', [AddressController::class, 'store']);
    Route::put('/customer/addresses/{id}', [AddressController::class, 'update']);
    Route::delete('/customer/addresses/{id}', [AddressController::class, 'destroy']);
});