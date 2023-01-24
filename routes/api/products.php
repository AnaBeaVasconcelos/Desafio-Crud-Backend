<?php

use App\Http\Controllers\Products\ProductsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes Private
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'products'], function () {
    // Route::get('/', [ProductsController::class, 'showAllProducts']);
    Route::get('/', [ProductsController::class, 'getAll']);
    Route::post('/', [ProductsController::class, 'createProduct']);
    Route::put('/{id}', [ProductsController::class, 'updateProduct']);
    Route::delete('/{id}', [ProductsController::class, 'deleteProduct']);
    Route::put('/block/{products}', [ProductsController::class, 'blockProduct']);
});
