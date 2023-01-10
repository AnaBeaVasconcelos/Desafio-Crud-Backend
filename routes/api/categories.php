<?php

use App\Http\Controllers\Categories\CategoriesController ;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes Private
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'categories'], function () {
    Route::get('/', [CategoriesController ::class, 'showAllCategories']);
    Route::post('/', [CategoriesController ::class, 'createCategories']);
    Route::put('/{id}', [CategoriesController ::class, 'updateCategories']);
    Route::delete('/{id}', [CategoriesController ::class, 'deleteCategories']);
    Route::put('/block/{categories}', [CategoriesController ::class, 'blockCategories']);
});
