
<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Dashboard_pemilik;
use App\Http\Controllers\Dashboard_admin;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard_pemilik', [Dashboard_pemilik::class, 'index'])->name('dashboard-pemilik');

Route::get('/dashboard_admin', [Dashboard_admin::class, 'index'])->name('dashboard-admin');

Route::get('/produk', [ProductController::class, 'index'])->name('products');
