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

Route::group(['namespace' => 'Company' , 'prefix' => 'v1'], function() {
    Route::post('register/companies', 'RegisterController@store');
    Route::post('register/companies/verify','RegisterController@verify');
    Route::get('companies/{slug}', 'CompanyController@show');

    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('company', 'CompanyController@index');

        Route::get('contact_lists/{id}/contacts', 'ContactController@index');

        Route::post('contacts/import', 'ContactController@import');
        Route::post('contacts/import/store','ContactController@storeContact');

        Route::get('companies/{slug}/contact_lists','ContactListController@index');
        Route::post('companies/{slug}/contact_lists','ContactListController@store');
        Route::patch('companies/{slug}/contact_lists/{id}','ContactListController@update');

        //Templates
        Route::apiResource('templates', 'TemplateController')->names('templates');

        // Campaign
        Route::get('campaigns/{id}','CampaignController@show');
        Route::post('campaigns/{id}/startCampaign','CampaignController@startCampaign');
        Route::get('companies/{slug}/campaigns','CampaignController@index');
        Route::post('campaigns','CampaignController@store');
        Route::patch('campaigns/{id}', 'CampaignController@update');
        Route::delete('campaigns/{id}', 'CampaignController@destroy');

        // Sequence Type
        Route::apiResource('campaigns.sequence_types', 'SequenceTypeController');

        Route::post('campaigns/{id}/import_sequence','CampaignController@importSequence');

        Route::post('copy-campaign-template', 'CampaignController@copyCampaignTemplate');
    });
});

Route::group(['namespace' => 'Company' , 'prefix' => 'company', 'middleware' => ['auth:api']], function() {
    Route::post('campaigns/{campaign_id}/recipients/destroyMultiple', 'Campaign\RecipientController@destroyMultiple');
    Route::apiResource('campaigns.recipients','Campaign\RecipientController')->only(['store','destroy', 'index']);
    Route::apiResource('campaigns.accounts', 'Campaign\AccountController')->only(['index', 'destroy', 'update']);
    Route::post('campaigns/{campaign}/accounts/payOwners', 'Campaign\AccountController@payOwners');

    Route::get('stats', 'StatController@index');

    // Tags
    Route::get('tags', 'TagController@index');

    Route::apiResource('contacts', 'ContactController');

    Route::get('owners/{user_id}', 'OwnerController@show');

    // Owner product
    Route::get('owners/{user_id}/products', 'ProductController@index');
    Route::patch('owners/{user_id}/products/{product_id}', 'ProductController@update');

    // Balance
    Route::get('balance', 'BalanceController@index');
    Route::post('balance', 'BalanceController@store');

    //Trx
    Route::get('transactions', 'TransactionController@index');
});