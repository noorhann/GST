<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => '/auth'], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::group(['prefix' => 'products/'], function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{id}', [ProductController::class, 'show']);
    Route::get('/category/{category}', [ProductController::class, 'getByCategory']);

    Route::post('/', [ProductController::class, 'create']);


});

Route::group(['prefix' => 'categories/'], function () {
    Route::get('/', [CategoryController::class, 'index']);
});

Route::group(['prefix' => 'banners/'], function () {
    Route::get('/', [BannerController::class, 'index']);
});

Route::group(['prefix' => 'cart/'], function () {
    Route::post('/', [CartController::class, 'create']);
});