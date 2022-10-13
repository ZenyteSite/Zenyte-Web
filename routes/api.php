<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('home')->name('home')->group(function () {
    Route::post('status', 'HomePageController@getPlayerCount')->name('.status');
    Route::post('discord', 'HomePageController@getDiscord')->name('.discord');
});
Route::prefix('market')->name('market')->group(function () {
   Route::match(['post', 'get'], '/', 'MarketController@getData');
});
Route::group(['middleware' => 'isForumLoggedIn'], function () {
    Route::prefix('store')->name('store')->group(function () {
        Route::post('/categories', 'StoreController@categories')->name('.categories');
    });
    Route::group(['middleware' => 'isForumAdmin'], function () {
        Route::prefix('products')->name('products')->group(function () {
            Route::get( '/', 'ProductController@index');
            Route::post('deleteExtraImage', 'ProductController@deleteExtraImage')->name('.deleteExtraImage');
            Route::get('{product}/getDescription', 'ProductController@getDescription')->name('.getDescription');
        });
    });
});