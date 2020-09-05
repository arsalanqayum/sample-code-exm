<?php

/*
|--------------------------------------------------------------------------
| Owner Api Routes Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "api" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Owner' , 'prefix' => 'owner'], function() {
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('stats', 'StatController@index');

        Route::apiResource('products', 'ProductController')->names('owner.products');

        Route::get('categories/{category_id}/category_attributes', 'CategoryAttributeController@index');

        Route::post('payouts', 'PayoutController@store');
    });

    Route::post('register', 'RegisterController@store');
    Route::post('verify', 'RegisterController@verify');
});