<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\PromiseController;



// Các route public //

Route::post('/register', [AuthController::class, 'Register']);

Route::post('/login', [AuthController::class, 'Login']);

Route::post('/change_password', [ResetPasswordController::class, 'changePassword']);

Route::post('/reset_password', [ResetPasswordController::class, 'resetPassword']);

// Các route được bảo vệ (protected route) //

Route::middleware('auth:api')->group(function () {

    Route::post('/logout', [AuthController::class, 'Logout']);

    Route::post('/refresh', [AuthController::class, 'Refresh']);

    Route::apiResource('/subscriptions', SubscriptionController::class);

    Route::apiResource('/promises', PromiseController::class);


});











