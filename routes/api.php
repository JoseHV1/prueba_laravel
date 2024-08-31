<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;

// TO DO the middleware is not working properly that's why this comment is made
// Route::middleware(['auth'])->group(function () {
    // Routes of Customers
    Route::apiResource('customers', CustomerController::class);
// });

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::get('unauthenticated', [AuthController::class, 'unauthenticated'])->name('login');
