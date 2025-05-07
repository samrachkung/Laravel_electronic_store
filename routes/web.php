<?php


use App\Http\Controllers\backend\BSalecontroller;
use App\Http\Controllers\backend\Auth\AuthController;
use App\Http\Controllers\backend\BBrandController;
use App\Http\Controllers\backend\BCateogryController;
use App\Http\Controllers\backend\BDashboardController;
use App\Http\Controllers\backend\BProductController;
use App\Http\Controllers\backend\BWarehouseController;
use App\Http\Controllers\backend\IncomeController;
use App\Http\Controllers\backend\PermissionController;
use App\Http\Controllers\backend\RoleController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\frontend\aboutController;
use App\Http\Controllers\frontend\cartController;
use App\Http\Controllers\frontend\contactController;
use App\Http\Controllers\frontend\homeController;
use App\Http\Controllers\frontend\loginController;
use App\Http\Controllers\frontend\myOrderController;
use App\Http\Controllers\frontend\registerController;
use App\Http\Controllers\frontend\shopController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\BOrderController;


// Frontend routes

Route::controller(homeController::class)->group(function () {
    Route::get('/', 'index');
});

Route::name('frontend.')->group(function () {
    // Public routes
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Authentication routes
    Route::prefix('auth')->group(function () {
        // Login routes
        Route::controller(loginController::class)->group(function () {
            Route::get('/login', 'login')->name('login');
            Route::post('/login', 'authenticate')->name('login.post');
            Route::post('/logout', 'logout')->name('logout');
        });

        // Registration routes
        Route::controller(registerController::class)->group(function () {
            Route::get('/register', 'register')->name('register');
            Route::post('/register', 'registerUser')->name('register.post');
        });
    });

    // Add other frontend routes here (shop, cart, etc.)
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

// // Authentication Routes
// Route::controller(AuthController::class)->group(function () {
//     // // Login Routes
//     // Route::get('/login', 'getloginpage')->name('login');
//     // Route::post('/login', 'postlogin')->name('login.post');
//     // // Route::post('/logout', 'logout')->name('logout');

//     // Registration Routes
//     Route::get('/register', 'getregisterpage')->name('register');
//     Route::post('/register', 'postregister')->name('register.post');
// });
Route::controller(BDashboardController::class)->group(function () {
    Route::get('/dashboard', [BDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard/data', [BDashboardController::class, 'getChartData']);
});

Route::resource('/product', BProductController::class);
Route::resource('/category', BCateogryController::class);
Route::resource('/brand', BBrandController::class);

Route::controller(BOrderController::class)->group(function () {
    Route::get('/order', 'index');
    Route::get('/order/{id}', 'show')->name('orders.show');
    Route::post('/order/{id}', 'updateStatus')->name('order.updateStatus');
    Route::delete('/order/{id}', 'destroy')->name('order.destroy');


});
Route::get('/income', [IncomeController::class, 'index'])->name('admin.income');
Route::get('/income/data', [IncomeController::class, 'getIncomeData'])->name('admin.income.data');
Route::get('/orders/{order}', [IncomeController::class, 'show'])->name('admin.orders.show');
Route::put('/orders/{order}/status', [IncomeController::class, 'updateStatus'])->name('admin.orders.status');

Route::get('sales', [BSalecontroller::class, 'index'])->name('admin.sales');
Route::get('sales/chart-data', [BSalecontroller::class, 'getChartData']);

Route::get('warehouse', [BWarehouseController::class, 'index'])->name('admin.warehouse');
Route::post('warehouse/{product}/update-stock', [BWarehouseController::class, 'updateStock'])->name('admin.warehouse.update-stock');
Route::get('warehouse/filter', [BWarehouseController::class, 'filter'])->name('admin.warehouse.filter');
// User Management
Route::resource('/users', UserController::class)->except(['show']);

Route::middleware(['auth'])->group(function () {

});

Route::get('/order/{orderId}/invoice', [myOrderController::class, 'printInvoice'])->name('order.printInvoice');
