<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::get('/', function () {
    return view('welcome');
});

Route::post('/register', [AuthController::class, 'Register']);

Route::post('/login', [AuthController::class, 'Login']);

Route::post('/logout', [AuthController::class, 'Logout']);

Route::post('/refresh', [AuthController::class, 'Refresh']);








