<?php

use App\Http\Controllers\API\CartController;
use Illuminate\Support\Facades\Route;

Route::resource('carts', CartController::class);