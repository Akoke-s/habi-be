<?php

use App\Http\Controllers\API\{
    AuthController, 
    CategoryController,
    CategoryTypeController,
    ColorController,
    DepartmentController,
    ProductController,
    SizeController
};
use App\Http\Controllers\API\Guest\GuestController;
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
        
        Route::resource('categories', CategoryController::class);
        Route::resource('departments', DepartmentController::class)->only([
            'index', 'show', 'store', 'update', 'destroy'
        ]);
        Route::resource('types', CategoryTypeController::class)->only([
            'index', 'show', 'store', 'update', 'destroy'
        ]);
        // Route::get('categories/{category:slug}', [CategoryController::class, 'bySlug']);
        Route::resource('products', ProductController::class);

        Route::resource('colors', ColorController::class)->except(['index']);
        Route::get('colors/{product:slug}/product', [ColorController::class, 'index']);
        Route::post('colors/{product:slug}', [ColorController::class, 'store']);

        Route::prefix('sizes')->group(function() {
            Route::controller(SizeController::class)->group(function() {
                Route::get('/{color:slug}/color', 'index');
                Route::get('/{size:id}', 'show');
                Route::post('/{color:slug}/color', 'store');
                Route::put('/{size:id}', 'update');
                Route::delete('/{size:id}', 'destroy');
            });
        });
    });

    Route::controller(GuestController::class)->group(function() {
        Route::get('categories', 'getCategories');
        Route::get('categories/{category:slug}', 'category');
        Route::get('departments', 'getDepartments');
        Route::get('departments/{department:slug}', 'department');
        Route::get('types', 'getTypes');
        Route::get('types/{type:slug}', 'type');
        Route::get('products', 'products');
        Route::get('products/{slug}', 'product');
    });
    
});
