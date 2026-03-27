<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::redirect('/categories', '/collection');
Route::get('/collection', [CollectionController::class, 'index'])->name('collection.index');
Route::get('/collection/{category}', [CollectionController::class, 'show'])->name('collection.show');

Route::get('/offers', [OfferController::class, 'index'])->name('offers.index');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{product}', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
