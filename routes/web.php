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
    ShopController,
    ForgotPasswordController
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

        // Registration with OTP Routes
        Route::get('/register', [RegisterController::class, 'register'])->name('register');
        Route::post('/register/send-otp', [RegisterController::class, 'sendOTP'])->name('register.send-otp');
        Route::post('/register/verify-otp', [RegisterController::class, 'verifyOTP'])->name('register.verify-otp');
        Route::post('/register/resend-otp', [RegisterController::class, 'resendOTP'])->name('register.resend-otp');

        // Password Reset Routes
        Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPassword'])->name('password.forgot');
        Route::post('/forgot-password/send-otp', [ForgotPasswordController::class, 'sendPasswordResetOTP'])->name('password.send-otp');
        Route::post('/forgot-password/verify-otp', [ForgotPasswordController::class, 'verifyPasswordResetOTP'])->name('password.verify-otp');
        Route::post('/forgot-password/reset', [ForgotPasswordController::class, 'resetPassword'])->name('password.reset');
        Route::post('/forgot-password/resend-otp', [ForgotPasswordController::class, 'resendPasswordResetOTP'])->name('password.resend-otp');
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

        // Checkout Routes (Authenticated)
        Route::prefix('checkout')->group(function () {
            Route::get('/', [CheckoutController::class, 'index'])->name('checkout.index');
            Route::post('/placeOrder', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');
            Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
            Route::get('/cancel/{order}', [CheckoutController::class, 'cancel'])->name('checkout.cancel');
            // KHQR specific routes
            Route::get('/khqr/{order}', [CheckoutController::class, 'showKHQR'])->name('checkout.khqr');
            Route::get('/khqr/{order}/check-status', [CheckoutController::class, 'checkKHQRStatus'])->name('checkout.khqr.check');
            Route::get('/khqr/{order}/expired', [CheckoutController::class, 'khqrExpired'])->name('checkout.khqr.expired');
        });
    });
});

Route::get('lang/{locales}', function ($locales) {
    if (in_array($locales, ['en', 'kh', 'fr'])) { // Add supported languages
        Session::put('locales', $locales);
    }
    return redirect()->back();
});


Route::get('/test-gmail', function () {
    try {
        \Log::info('Testing Gmail configuration...');

        // Test 1: Basic email
        Mail::raw('This is a test email from Gmail SMTP!', function ($message) {
            $message->to('samrach088@gmail.com')
                ->subject('Gmail SMTP Test');
        });

        \Log::info('Basic Gmail test completed');

        // Test 2: OTP email
        $otp = '123456';
        $email = 'samrach088@gmail.com'; // Change to your email for testing
        Mail::to($email)->send(new \App\Mail\OTPMail($otp, 'registration'));

        \Log::info('Gmail OTP email test completed');

        return response()->json([
            'success' => true,
            'message' => 'Gmail test completed. Check your email and logs.'
        ]);

    } catch (\Exception $e) {
        \Log::error('Gmail test failed: ' . $e->getMessage());
        \Log::error('Full error: ' . $e->getFile() . ':' . $e->getLine() . ' - ' . $e->getTraceAsString());

        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'details' => 'Check Laravel logs for more information'
        ], 500);
    }
});

Route::get('/test-otp', function () {
    try {
        $otpService = app()->make(App\Services\OTPService::class);
        $otp = $otpService->generateOTP('ymrchannel369@gmail.com', 'registration');
        return response()->json(['success' => true, 'otp' => $otp]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
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
