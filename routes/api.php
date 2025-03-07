<?php

use App\Http\Controllers\Api\Admin\ProductController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PublicController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:2,1')->group(function () {
    Route::get('/public/products', [PublicController::class, 'allProducts']);
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::apiResource('products', ProductController::class);

        Route::apiResource('users', UserController::class);

        Route::post('products/{id}/restore', [ProductController::class, 'restore']);
        Route::delete('products/{id}/force-delete', [ProductController::class, 'forceDelete']);
    });
});
