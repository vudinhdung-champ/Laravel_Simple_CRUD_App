<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResetPasswordController;


Route::get('/', function () {
    return view('welcome');
});

Route::post('/register', [AuthController::class, 'Register']);

Route::post('/login', [AuthController::class, 'Login']);

Route::post('/logout', [AuthController::class, 'Logout']);

Route::post('/refresh', [AuthController::class, 'Refresh']);

Route::post('/change_password', [ResetPasswordController::class, 'Change_Password']);

Route::post('/reset_password', [RestPasswordController::class, 'Reset_Password']);









