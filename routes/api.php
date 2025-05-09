<?php

use App\Http\Controllers\backend\BDashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserAuthController;
use App\Http\Controllers\API\AdminAuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public API Routes
Route::prefix('auth')->group(function () {
    Route::post('/login', [UserAuthController::class, 'login']);
    Route::post('/register', [UserAuthController::class, 'register']);

    // Sanctum CSRF Cookie
    Route::get('/csrf-cookie', function () {
        return response()->json(['message' => 'CSRF cookie set']);
    });
});

// Authenticated User Routes
Route::middleware('auth:api')->prefix('auth')->group(function () {
    Route::post('/logout', [UserAuthController::class, 'logout']);
    Route::get('/me', [UserAuthController::class, 'me']);
});

// Admin Authentication Routes
Route::prefix('admin/auth')->group(function () {
    Route::post('/login', [AdminAuthController::class, 'login']);
});

// Authenticated Admin Routes
Route::middleware('auth:admin-api')->prefix('admin')->group(function () {
    Route::post('/auth/logout', [AdminAuthController::class, 'logout']);
    Route::get('/auth/me', [AdminAuthController::class, 'me']);

    // Add other admin API endpoints here
    Route::get('/dashboard', [BDashboardController::class, 'dashboard']);

});
