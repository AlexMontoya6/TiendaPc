<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/products', [ProductController::class, 'getProducts'])->name('api.products.index');
Route::get('/productswithcategories', [ProductController::class, 'getProductsWithCategories'])->name('api.categories.show');

Route::get('/categories', [CategoryController::class, 'getCategories'])->name('api.categories.index');


