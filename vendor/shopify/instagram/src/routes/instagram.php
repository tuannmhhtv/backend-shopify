<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([
    'prefix' => config('shopify.instagram.route_prefix'),
    'middleware' => ['web'],
    'namespace' => 'Shopify\InstagramApp\app\Http\Controllers',
], function () {

    Route::get('/', 'MainController@index');
    Route::get('app', 'MainController@index');
    Route::get('app-authorize', 'MainController@appAuthorize')->name('appAuthorize');

    Route::get('get-token', 'MainController@getTokenFromInstagram')->name('getInstagramToken');

    Route::prefix('ajax')->group(function () {

        Route::post('save-token', 'MainController@saveInstagramToken')->name('saveInstagramToken');

        Route::get('getInstagramToken', 'MainController@getInstagramTokenforShop');
    });
});