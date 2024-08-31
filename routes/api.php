<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;

Route::middleware(['verifyTokenUser'])->group(function () {
    // Route logout
    Route::post('logout', [AuthController::class, 'logout']);

    // Routes of Customers
    Route::apiResource('customers', CustomerController::class);
});

Route::middleware(['guest'])->group(function () {
    // Route login
    Route::post('login', [AuthController::class, 'login']);

    // Route register users
    Route::post('register', [AuthController::class, 'register']);
});
