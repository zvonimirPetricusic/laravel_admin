<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CategoriesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/product', function () {
    return view('product');
});


Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/users', [UsersController::class, 'index'])->name('users');
Route::get('/categories', [CategoriesController::class, 'index'])->name('categories');