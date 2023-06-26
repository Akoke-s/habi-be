<?php

use App\Http\Controllers\API\{CartController, OrderController};
use App\Http\Controllers\API\Guest\GuestController;
use Illuminate\Support\Facades\Route;

Route::controller(GuestController::class)->group(function() {
    Route::get('categories', 'getCategories');
    Route::get('categories/{category:slug}', 'category');
});