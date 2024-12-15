<?php

use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckSocialParams;

Route::middleware('auth:api')->group( function () {
    Route::resource('users', UserController::class)->only(['index', 'show', 'update']);
});

Route::middleware('auth:api')->group( function () {
    Route::resource('posts', PostController::class);
});

Route::middleware('auth:api')->group( function () {
    Route::resource('brands', BrandController::class)->only(['index', 'show']);
});

Route::middleware('auth:api')->group( function () {
    Route::resource('products', ProductController::class)->only(['index', 'show']);
});

Route::prefix('auth')->group(function () {
    Route::post('/login', [ApiAuthController::class, 'login']);

    Route::post('/register', [ApiAuthController::class, 'register']);

    Route::post('/refresh-token', [ApiAuthController::class, 'refreshToken']);

    Route::post('/logout', [ApiAuthController::class, 'logout'])->middleware('auth:api');

    Route::get('/me', [ApiAuthController::class, 'getMe'])->middleware('auth:api');

    Route::get('/login/{social}', [SocialAuthController::class, 'redirectSocialLogin'])->name('auth.login.social.redirect')->middleware(CheckSocialParams::class);

    Route::get('/callback-login/{social}', [SocialAuthController::class, 'processSocialLogin'])->name('auth.login.social.process')->middleware(CheckSocialParams::class);
});

Route::prefix('admin')->middleware(['auth:api', 'role:admin'])->group(function() {
    Route::resource('products', ProductController::class);
    Route::resource('brands', BrandController::class);
    Route::resource('users', UserController::class);
    Route::resource('posts', PostController::class);
});


