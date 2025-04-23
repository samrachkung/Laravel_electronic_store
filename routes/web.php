<?php

use App\Http\Controllers\backend\BBrandController;
use App\Http\Controllers\backend\BCateogryController;
use App\Http\Controllers\backend\BDashboardController;
use App\Http\Controllers\backend\BProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\frontend\aboutController;
use App\Http\Controllers\frontend\cartController;
use App\Http\Controllers\frontend\contactController;
use App\Http\Controllers\frontend\homeController;
use App\Http\Controllers\frontend\loginController;
use App\Http\Controllers\frontend\myOrderController;
use App\Http\Controllers\frontend\myProfileController;
use App\Http\Controllers\frontend\OrderController;
use App\Http\Controllers\frontend\registerController;
use App\Http\Controllers\frontend\shopController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\BOrderController;


// Frontend routes

Route::controller(homeController::class)->group(function () {
    Route::get('/', 'index');
});

Route::controller(loginController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'authenticate')->name('authenticate');
    Route::post('/logout', 'logout')->name('logout');
});

Route::controller(registerController::class)->group(function () {
    Route::get('/register', 'register')->name('register');
    Route::post('/register', 'registerUser')->name('registerUser');
});

Route::controller(shopController::class)->group(function () {
    Route::get('/shop', 'shop');
});

Route::controller(contactController::class)->group(function () {
    Route::get('/contact', 'contact');
});

Route::controller(aboutController::class)->group(function () {
    Route::get('/about', 'about');
});

Route::controller(CartController::class)->group(function () {
    Route::get('/cart', 'cart');
    Route::post('/cart/add', 'addToCart')->name('cart.add');
    Route::post('/cart/update', 'updateCart')->name('cart.update');
    Route::post('/cart/remove', 'removeCart')->name('cart.remove');
    Route::get('/cart/view', 'viewCart')->name('cart.view');

});


Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/placeOrder', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');
});



Route::controller(myOrderController::class)->group(function () {
    Route::get('/myorder', 'myorder');
});

// route get language
Route::get('lang/{locales}', function ($locales) {
    if (in_array($locales, ['en', 'kh', 'fr'])) { // Add supported languages
        Session::put('locales', $locales);
    }
    return redirect()->back();
});



// Backend routes


Route::controller(BDashboardController::class)->group(function () {
    Route::get('/dashboard', 'index');
});

Route::resource('/product', BProductController::class);
Route::resource('/category', BCateogryController::class);
Route::resource('/brand', BBrandController::class);

Route::controller(BOrderController::class)->group(function () {
    Route::get('/order', 'index');
    Route::get('/order/{id}', 'show');
    Route::post('/order/{id}', 'updateStatus') ->name('order.updateStatus');
    Route::delete('/order/{id}', 'destroy') ->name('order.destroy');
});

Route::get('order/{orderId}/invoice', [myOrderController::class, 'printInvoice'])->name('order.printInvoice');
