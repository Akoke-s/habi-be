<?php

use App\Http\Controllers\API\{CartController, OrderController};
use Illuminate\Support\Facades\Route;

Route::resource('carts', CartController::class);
Route::resource('orders', OrderController::class);