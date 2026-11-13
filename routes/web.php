<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Dashboard_admin;
use App\Http\Controllers\Dashboard_pemilik;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StatistikController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

// Halaman publik
Route::get('/', [HomeController::class, 'index'])->name('home');


Route::get('/dashboard_pemilik', [Dashboard_pemilik::class, 'index'])->name('dashboard-pemilik');

Route::get('/dashboard_admin', [Dashboard_admin::class, 'index'])->name('dashboard-admin');


Route::get('/produk', [ProductController::class, 'index'])->name('products');
Route::get('/produk/{slug}', [ProductController::class, 'show'])->name('products.show');

// Checkout satu produk dari halaman detail
Route::post('/checkout/single/{slug}', [ProductController::class, 'checkoutSingle'])
    ->name('checkout.single');

// Checkout seluruh produk dari keranjang
Route::post('/checkout/cart', [ProductController::class, 'checkoutCart'])
    ->name('checkout.cart');

// Halaman checkout
Route::get('/checkout', [ProductController::class, 'checkout'])
    ->name('checkout.index');

// Proses pesanan
Route::post('/checkout/process', [ProductController::class, 'processCheckout'])
    ->name('checkout.process');

Route::get('/checkout/success', [ProductController::class, 'checkoutSuccess'])
    ->name('checkout.success');
    


Route::get('/statistik', [StatistikController::class, 'index'])->name('statistiks');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkouts');

// Khusus tamu (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.process');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])
        ->middleware('throttle:5,1')
        ->name('register.process');
});

// Sudah login
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // /dashboard otomatis diarahkan sesuai role
    Route::get('/dashboard', function () {
        return request()->user()->role === 'admin'
            ? redirect()->route('dashboard-admin')
            : redirect()->route('dashboard-pemilik');
    })->name('dashboard');

    // Khusus admin
    Route::middleware('role:admin')->group(function () {
        Route::get('/dashboard_admin', [Dashboard_admin::class, 'index'])->name('dashboard-admin');
    });

    // Khusus penjual (pemilik usaha)
    Route::middleware('role:penjual')->group(function () {
        Route::get('/dashboard_pemilik', [Dashboard_pemilik::class, 'index'])->name('dashboard-pemilik');
    });
});


