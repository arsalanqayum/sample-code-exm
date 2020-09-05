<?php

/*
|--------------------------------------------------------------------------
| Company Api Routes Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "api" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'middleware' => 'auth:api'], function() {
    Route::group(['namespace' => 'Admin'], function() {
        Route::get('stats', 'StatController@index');
        Route::get('buyers', 'BuyerController@index');

        Route::apiResource('owners', 'OwnerController')->only(['show', 'update', 'index']);

        Route::apiResource('owner_chats', 'OwnerChatController')->only(['show', 'index']);

        Route::apiResource('products', 'ProductController')->only(['index', 'update', 'show']);

        Route::apiResource('categories', 'CategoryController')->except(['show']);

        Route::post('article_categories', 'ArticleCategoryController@store');

        Route::post('articles', 'ArticleController@store');
    });
});