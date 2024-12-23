

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Product routes
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::post('/products', [ProductController::class, 'store']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);

// Cart routes
Route::get('/cart', [CartController::class, 'viewCart']); // View cart
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');; // Add to cart
Route::delete('/cart/{id}', [CartController::class, 'remove']); // Remove from cart
Route::delete('/cart/remove/{product_id}', [CartController::class, 'removeFromCart']);


// Order routes
Route::get('/orders', [OrderController::class, 'index']); // View all orders
Route::post('/orders/place', [OrderController::class, 'placeOrder']); // Place an order
Route::get('/orders/{id}', [OrderController::class, 'show']); // View single order