<?php

// use App\Http\Controllers\backend\BCateogryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontend\{
    HomeController,
    LoginController,
    RegisterController,
    ContactController,
    AboutController,
    CartController,
    MyOrderController,
    ShopController
};
use App\Http\Controllers\backend\{
    BDashboardController,
    BProductController,
    BCateogryController,
    BBrandController,
    BOrderController,
    BSaleController,
    BWarehouseController,
    IncomeController,
    UserController
};
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\API\AdminAuthController;

// Frontend Routes (Unauthenticated)
Route::name('frontend.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/about', [AboutController::class, 'about'])->name('about');
    Route::get('/contact', [ContactController::class, 'contact'])->name('contact');
    Route::get('/shop', [ShopController::class, 'shop'])->name('shop');

    // Authentication Routes
    Route::prefix('auth')->group(function () {
        Route::get('/login', [LoginController::class, 'login'])->name('login');
        Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
        Route::get('/register', [RegisterController::class, 'register'])->name('register');
        Route::post('/register', [RegisterController::class, 'registerUser'])->name('register.post');
    });

    // API route to fetch single product details
    Route::get('/api/products/{id}', function ($id) {
        $product = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->select(
                'products.id',
                'products.name as product_name',
                'products.slug',
                'products.image',
                'products.description',
                'products.price',
                'products.quantity',
                'products.is_active',
                'products.is_featured',
                'categories.name as category_name',
                'brands.name as brand_name'
            )
            ->where('products.id', $id)
            ->where('products.is_active', 1)
            ->first();

        return response()->json($product);
    });

    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'cart'])->name('cart');
        Route::get('/view', [CartController::class, 'viewCart'])->name('cart.view');
        Route::post('/add', [CartController::class, 'addToCart'])->name('cart.add');
        Route::post('/remove', [CartController::class, 'removeCart'])->name('cart.remove');
        Route::post('/update', [CartController::class, 'updateCart'])->name('cart.update');
    });



    // Authenticated User Routes
    Route::middleware('auth')->group(function () {
        Route::get('/myorder', [MyOrderController::class, 'myorder'])->name('myorder');
        Route::get('/order/{orderId}/invoice', [MyOrderController::class, 'printInvoice'])->name('order.printInvoice');

            // Checkout Routes

    Route::prefix('checkout')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/placeOrder', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');
        Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
        Route::get('/cancel/{order}', [CheckoutController::class, 'cancel'])->name('checkout.cancel');
    });

    });
});

Route::get('lang/{locales}', function ($locales) {
    if (in_array($locales, ['en', 'kh', 'fr'])) { // Add supported languages
        Session::put('locales', $locales);
    }
    return redirect()->back();
});

// routes/web.php
Route::get('/test-email', function() {
    $order = \App\Models\Order::with(['orderItems.product', 'address', 'user'])->first();

    try {
        Mail::to('ymrchannel369@gmail.com')->send(new \App\Mail\OrderConfirmationMail($order));
        return 'Email sent successfully!';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});


// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Authentication Routes
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'getloginpage'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'postlogin'])->name('login.post');
    });

    // Authenticated Admin Routes
    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [BDashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/data', [BDashboardController::class, 'getChartData']);

        // Resource Routes
        Route::resource('brand', BBrandController::class)->except(['show']);
        Route::resource('category', BCateogryController::class)->except(['show']);
        Route::resource('product', BProductController::class);
        Route::resource('users', UserController::class);

        // Order Routes
        Route::get('/order', [BOrderController::class, 'index'])->name('orders.index');
        Route::get('/order/{id}', [BOrderController::class, 'show'])->name('orders.show');
        Route::post('/order/{id}', [BOrderController::class, 'updateStatus'])->name('order.updateStatus');
        Route::delete('/order/{id}', [BOrderController::class, 'destroy'])->name('order.destroy');

        // Income/Sales Routes
        Route::get('/income', [IncomeController::class, 'index'])->name('income');
        Route::get('/income/data', [IncomeController::class, 'getIncomeData'])->name('income.data');
        Route::get('/sales', [BSaleController::class, 'index'])->name('sales');
        Route::get('/sales/chart-data', [BSaleController::class, 'getChartData']);

        // Warehouse Routes
        Route::get('/warehouse', [BWarehouseController::class, 'index'])->name('warehouse');
        Route::get('/warehouse/filter', [BWarehouseController::class, 'filter'])->name('warehouse.filter');
        Route::post('/warehouse/{product}/update-stock', [BWarehouseController::class, 'updateStock'])->name('warehouse.update-stock');
    });
});
