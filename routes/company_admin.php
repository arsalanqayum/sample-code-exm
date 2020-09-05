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

Route::group(['namespace' => 'CompanyAdmin' , 'prefix' => 'v1', 'middleware' => 'auth:api'], function() {
    Route::apiResource('companies.instant_alerts', 'InstantAlertController');
    Route::post('companies/{company}/instant_alerts/{id}/start', 'InstantAlertController@start');

    // Recipients
    Route::get('instant_alerts/{instantAlert}/recipients','InstantAlertRecipientController@index');
    Route::post('instant_alerts/{instantAlert}/recipients','InstantAlertRecipientController@store');
    Route::post('instant_alerts/{instantAlert}/recipients/destroy','InstantAlertRecipientController@destroy');

    Route::apiResource('orders', 'OrderController');

    Route::post('orders/{id}/pay-reward', 'OrderController@payReward');
});