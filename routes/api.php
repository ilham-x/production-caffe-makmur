<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\MejaController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| PUBLIC API
|--------------------------------------------------------------------------
*/

// Login
Route::post('/login', [AuthController::class, 'login']);

// Customer
Route::get('/menu/{meja}', [CustomerController::class, 'index']);

Route::post('/cart/add', [CustomerController::class, 'addToCart']);

Route::post('/cart/update', [CustomerController::class, 'updateCart']);

Route::post('/cart/remove', [CustomerController::class, 'removeCartPost']);

Route::post('/checkout', [CustomerController::class, 'checkout']);

Route::post('/komplain/customer', [CustomerController::class, 'komplain']);


// Xendit
Route::post('/xendit/webhook', [CustomerController::class, 'webhook']);

Route::post('/xendit/callback', [CustomerController::class, 'callback']);


/*
|--------------------------------------------------------------------------
| PROTECTED API
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    // Logout*-]
    Route::post('/logout', [AuthController::class, 'logout']);

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard/admin', [AdminController::class, 'dashboard']);

    Route::get('/dashboard/laporan', [AdminController::class, 'penjualan']);

    /*
    |--------------------------------------------------------------------------
    | CASHIER
    |--------------------------------------------------------------------------
    */

    Route::get('/cashier', [CashierController::class, 'index']);

    Route::post('/meja/toggle/{id}', [CashierController::class, 'toggleMeja']);

    Route::post('/cashier/cart/add', [CashierController::class, 'addToCart']);

    Route::put('/cashier/cart/update', [CashierController::class, 'updateCart']);

    Route::post('/cashier/cart/delete', [CashierController::class, 'deleteCart']);

    Route::post('/cashier/checkout', [CashierController::class, 'checkout']);

    Route::post('/cashier/bayar/{id}', [CashierController::class, 'bayar']);

    Route::put('/cashier/updateStatus/{id}', [CashierController::class, 'updateStatus']);

    Route::post('/cashier/komplain/{id}/approve',
        [CashierController::class, 'approveKomplain']);

    Route::post('/cashier/komplain/{id}/reject',
        [CashierController::class, 'rejectKomplain']);

    Route::get('/cashier/check-orders', function () {
        return response()->json([
            'count' => \App\Models\Pesanan::count()
        ]);
    });

    /*
    |--------------------------------------------------------------------------
    | ADMIN RESOURCE
    |--------------------------------------------------------------------------
    */

    Route::apiResource('produk', ProdukController::class);

    Route::apiResource('kategori', KategoriController::class);

    Route::apiResource('meja', MejaController::class);
    Route::apiResource('kasir', UserController::class);

    Route::apiResource('transaksi', TransaksiController::class);
});
