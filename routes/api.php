<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/products', [ProductController::class, 'getProducts']);
Route::get('/productswithcategories', [ProductController::class, 'getProductsWithCategories']);


Route::get('/categories', [CategoryController::class, 'getCategories']);

