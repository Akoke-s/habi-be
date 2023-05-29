<?php

use App\Http\Controllers\API\{
    AuthController, 
    CategoryController,
    ColorController,
    ProductController
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::controller(AuthController::class)->group(function() {
//     Route::prefix('auth')->group(function() {
        
        
//     });
// });

Route::prefix('auth')->group(function() {
    Route::controller(AuthController::class)->group(function() {
        Route::post('register', 'register');
        Route::post('verify-account', 'verify_user_email');
        Route::post('login', 'login');
        Route::middleware('auth:sanctum')->group(function() {
            Route::post('update-password', 'update_password');
        });
    });

    Route::middleware('auth:sanctum')->group(function() {
        // Route::resources([
        //     'categories', CategoryController::class,
        //     // 'products', ProductController::class
        // ]);
        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
        // Route::controller(ProductController::class)->group(function() {
        //     Route::get('products', 'index');
        // });

        Route::resource('colors', ColorController::class)->except(['index']);
        Route::get('colors/{product:slug}/product', [ColorController::class, 'index']);
        Route::post('colors/{product:slug}', [ColorController::class, 'store']);
    });
    
});
