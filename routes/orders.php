<?php

use Inertia\Inertia;
use Laravel\Fortify\Features;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\WithCartContext;
use App\Http\Controllers\Order\CartController;
use App\Http\Controllers\Order\ProductController;
use App\Http\Controllers\Order\CartItemController;

Route::middleware([
    'auth', 
    'verified', 
    WithCartContext::class
])->as('order.')->group(function () {

    Route::get('/products', [ProductController::class, 'index'])->name('products.index');

    Route::get('/cart/{cart}/summary', [CartController::class, 'summary'])->name('cart.summary');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    Route::resource('cart-items', CartItemController::class)->only(['store', 'update', 'destroy']);

});