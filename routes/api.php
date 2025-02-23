<?php

use App\Http\Controllers\Api\PublicController;
use App\Http\Controllers\Api\Admin\ProductController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:2,1')->group(function () {
    Route::get('/products', [PublicController::class, 'allProducts']); // 🔥 Público
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::apiResource('products', ProductController::class);

        Route::post('products/{id}/restore', [ProductController::class, 'restore']);
        Route::delete('products/{id}/force-delete', [ProductController::class, 'forceDelete']);
    });
});
