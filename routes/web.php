<?php

use App\Http\Controllers\Pages\BasketController;
use App\Http\Controllers\Pages\CatalogController;
use App\Http\Controllers\Pages\IndexController;
use App\Http\Controllers\Pages\OrderController;
use App\Http\Controllers\Pages\ProductController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [IndexController::class, 'index']);

Route::get('/catalog/{categoryId}', [CatalogController::class, 'catalog'])->name('catalog');

Route::get('/home', [IndexController::class, 'index'])->name('home');

Route::get('/logout', [IndexController::class, 'logout'])->name('logout');

Route::get('/product/{productId}', [ProductController::class, 'product'])->name('product');

Route::get('/basket', [BasketController::class, 'basket'])->name('basket');

Route::post('/basket/add-product', [BasketController::class, 'addProductToBasket'])->name('add-product-to-basket');

Route::post('/basket/remove-product', [BasketController::class, 'removeProductFromBasket'])->name('remove-product-from-basket');

Route::post('/basket/remove-all-products', [BasketController::class, 'removeAllProductsFromBasket'])->name('remove-all-products-from-basket');

Route::get('/orders', [OrderController::class, 'getAllOrders'])->name('orders');

Route::post('/orders/add-order', [OrderController::class, 'addBasketToOrder'])->name('add-basket-to-order');

Route::post('/orders/delete-order', [OrderController::class, 'deleteOrder'])->name('delete-order');

Route::post('/orders/clear-orders-history', [OrderController::class, 'clearOrderHistory'])->name('clear-orders-history');

Route::post('/orders/pay-order', [OrderController::class, 'payOrder'])->name('pay-order');

Auth::routes();

//Auth::routes(['verify' => true]);
//
//Route::get('/email/verify', function () {
//    return view('auth.verify-email');
//})->middleware(['auth'])->name('verification.notice');
//
//Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//    $request->fulfill();
//    return redirect('/home');
//})->middleware(['auth', 'signed'])->name('verification.verify');
//
//Route::post('/email/verification-notification', function (Request $request) {
//    $request->user()->sendEmailVerificationNotification();
//    return back()->with('status', 'verification-link-sent');
//})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
