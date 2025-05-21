<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\FaqAdminController;
use App\Http\Controllers\Admin\CategoryAdminController;
use App\Http\Controllers\Admin\ThemeAdminController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Admin\OrderAdminController;


// Ruta home
Route::get('/', function () {
    return view('welcome');
});




// RUTAS ADMIN (requieren login + ser admin)
Route::middleware(['web','auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn () => view('admin.dashboard'))->name('dashboard');

    Route::resource('products', ProductController::class)->names('products');
    Route::resource('faqs', FaqAdminController::class)->names('faqs');
    Route::resource('categories', CategoryAdminController::class)->names('categories');
    Route::resource('themes', ThemeAdminController::class)->names('themes');
    Route::resource('users', UserAdminController::class)->names('users');
    Route::resource('orders', OrderAdminController::class)->names('orders');
    Route::resource('roles', RoleAdminController::class)->names('roles');
    Route::resource('permissions', PermissionAdminController::class)->names('permissions');
    Route::resource('settings', SettingAdminController::class)->names('settings');
    Route::resource('coupons', CouponAdminController::class)->names('coupons');
});


Route::get('/ping', function () {
    return 'pong';
});

Route::get('/login', function () {
    return redirect('/'); // o cualquier otra página segura
})->name('login');

