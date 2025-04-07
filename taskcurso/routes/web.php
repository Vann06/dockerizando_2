<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// Ruta home
Route::get('/', function () {
    return view('welcome');
});

// Admin panel para productos
Route::resource('admin/products', ProductController::class)->names('admin.products');

Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin.products.create');

Route::post('/admin/products', [ProductController::class, 'store'])->name('admin.products.store');

// Rutas REST del recurso
Route::resource('products', ProductController::class);

