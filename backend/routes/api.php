<?php

use App\Http\Controllers\ProductManagement\CategoryController;
use App\Http\Controllers\ProductManagement\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/categories_product_add', [CategoryController::class, 'categoriesProductAdd']);
Route::apiResource('categories', CategoryController::class);
Route::post('products/update/{id}', [ProductController::class, 'update']);
Route::apiResource('products', ProductController::class);