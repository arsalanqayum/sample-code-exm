<?php

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
Route::post('login','AuthController@login');

Route::post('twilio-message-webhook', 'TwilioController@messageWebhook');

Route::get('categories','CategoryController@index');

Route::get('categories/{category}/category_attributes', 'CategoryAttributeController@index');

Route::post('productSearch', 'HomeController@search');

Route::get('categories/{category}/products/{slug}', 'ProductController@show');

Route::post('buyers', 'BuyerController@store');
Route::post('buyers/verify', 'BuyerController@verify');

Route::get('video_rooms/{uuid}', 'VideoRoomController@show');

// Articles & article categories
Route::get('articles', 'Admin\ArticleController@index');
Route::get('article_categories', 'Admin\ArticleCategoryController@index');

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('auth', 'AuthController@user');

    Route::post('logout', 'AuthController@logout');

    //Wallet/Balance
    Route::get('balance', 'BalanceController@index');

    Route::group(['namespace' => 'Stripe', 'prefix' => 'stripe'], function() {
        Route::get('accounts', 'AccountController@show');
        Route::post('accounts', 'AccountController@store');
        Route::patch('accounts/{account_id}', 'AccountController@update');

        Route::post('person', 'PersonController@store');

        Route::apiResource('charges', 'ChargeController')->only(['store']);

        Route::apiResource('payment_intents', 'PaymentIntentController')->only(['store']);

        Route::apiResource('balance', 'BalanceController')->only(['index']);

        Route::post('external_accounts' ,'ExternalAccountController@store');
    });
});