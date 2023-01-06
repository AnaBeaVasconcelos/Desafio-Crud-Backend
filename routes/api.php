<?php

use App\Http\Controllers\Products\ProductsController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('products')->group(function () {
    Route::get('/', [ProductsController::class, 'GetAllProducts']);
    Route::get('/{id}', [ProductsController::class, 'GetProduct']);
    Route::post('/', [ProductsController::class, 'CreateProduct']);
    Route::put('/{id}', [ProductsController::class, 'UpdateProduct']);
    Route::delete('/{id}', [ProductsController::class, 'DeleteProduct']);
});
