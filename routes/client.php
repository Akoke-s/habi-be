<?php

use App\Http\Controllers\API\{CartController, OrderController};
use App\Http\Controllers\API\Guest\GuestController;
use Illuminate\Support\Facades\Route;

Route::controller(GuestController::class)->group(function() {
    Route::get('categories', 'getCategories');
    Route::get('categories/{department:slug}', 'category');
    Route::get('categories/products/{department:slug}', 'productsForType');
    Route::get('departments', 'getDepartments');
    Route::get('departments/{department:slug}', 'department');
    Route::get('types', 'getTypes');
    Route::get('types/{type:slug}', 'type');
    Route::get('products', 'products');
    Route::get('products/{product:slug}', 'product');
});