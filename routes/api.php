<?php

use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::resource('users', UserController::class)->middleware(['auth:api']);

Route::prefix('auth')->group(function () {
    Route::post('/login', [ApiAuthController::class, 'login']);

    Route::post('/register', [ApiAuthController::class, 'register']);

    Route::post('/refresh-token', [ApiAuthController::class, 'refreshToken']);

    Route::post('/logout', [ApiAuthController::class, 'logout'])->middleware('auth:api');
});


