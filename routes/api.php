<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UsersController;
use App\Http\Controllers\API\CategoriesController;
use App\Http\Controllers\API\ProductsController;
use App\Http\Controllers\API\ImagesController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/products', [ProductsController::class, 'index']);
Route::get('/products/get/{product_id}', [ProductsController::class, 'show']);

Auth::routes();
// users
Route::post('/users', [UsersController::class, 'store']);
Route::get('/users', [UsersController::class, 'index']);
//categories
Route::get('/categories/getCategories', [CategoriesController::class, 'getCategories']);
Route::get('/categories/getSubcategories/{category_id}', [CategoriesController::class, 'getSubcategories']);
Route::post('/categories', [CategoriesController::class, 'store']);
Route::get('/categories', [CategoriesController::class, 'index']);
//products
Route::post('/products', [ProductsController::class, 'store']);

//images
Route::get('/images/{product_id}', [ImagesController::class, 'show']);