<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/', 'HomePageController@index');
Route::get('status', 'Store\PaypalController@getPaymentStatus');
Route::match(['get', 'post'], '/vote/callback', 'VoteController@callback');
Route::group(['middleware' => 'isForumLoggedIn'], function () {
    Route::prefix('vote')->name('vote')->group(function () {
        Route::get('/', 'VoteController@index');
        Route::get('/{site}/site', 'VoteController@proceedToVote')->name('.proceedToVoteSite');
    });
    Route::prefix('store')->name('store')->group(function () {
        Route::get('/', 'Store\StoreController@index');
        Route::post('/emptyCart', 'Store\StoreController@emptyCart')->name('.emptyCart');
        Route::get('/getCartTotal', 'Store\StoreController@getCartTotal')->name('.getCartTotal');
        Route::get('/getCurrentCredits', 'Store\StoreController@getCurrentCredits')->name('.getCurrentCredits');
        Route::post('/addToCart', 'Store\StoreController@addToCart')->name('.addToCart');
        Route::get('/buyCredits', 'Store\BuyCreditsController@index')->name('.buyCredits');
        Route::post('/paypalCheckout', 'Store\PaypalController@checkout')->name('.paypalCheckout');
        Route::get('/checkout', 'Store\StoreController@checkout')->name('.itemCheckout');
    });
    Route::prefix('account')->name('account')->group(function () {
       Route::match(['get','post'],'/{username?}', 'AccountController@index');
    });
    Route::group(['middleware' => 'isForumStaff'], function () {
       Route::prefix('modcp')->name('modcp')->group(function () {
            Route::get('/', 'ModCpController@index');
           Route::prefix('punishments')->name('.punishments')->group(function () {
               Route::match(['get','post'],'/', 'ModCP\PunishmentController@index');
               Route::get('/view/{punishmentAction}', 'ModCP\PunishmentController@view')->name('.view');
               Route::post('{punishmentAction}/uploadProof', 'ModCP\PunishmentController@uploadProof')->name('.uploadProof');
               Route::get('{punishmentAction}/deleteProof', 'ModCP\PunishmentController@deleteProof')->name('.deleteProof');
           });
           Route::prefix('logging')->name('.logging')->group(function () {
               Route::match(['get','post'],'/', 'ModCP\LoggingController@index');
               Route::get('/view/{log}', 'ModCP\LoggingController@view')->name('.view');
           });
           Route::prefix('osgp')->name('.osgp')->group(function () {
               Route::match(['get','post'], '/', 'ModCP\OSGPController@index');
               Route::post('/submit', 'ModCP\OSGPController@submitOSGP')->name('.submit');
           });
       });
        Route::group(['middleware' => 'isForumAdmin'], function () {
            Route::redirect('/admin', '/admincp');
            Route::prefix('admincp')->name('admincp')->group(function () {
                Route::get('/', 'AdminCpController@index');
                Route::get('refreshCache', 'AdminCpController@refreshCache')->name('.refreshCache');
                Route::prefix('vote')->name('.vote')->group(function () {
                    Route::get('/', 'AdminCP\VoteController@index');
                    Route::match(['get', 'post'], '/create', 'AdminCP\VoteController@create')->name('.create');
                    Route::match(['get', 'post'], '{voteSite}/edit', 'AdminCP\VoteController@edit')->name('.edit');
                    Route::get('{voteSite}/delete', 'AdminCP\VoteController@delete')->name('.delete');
                });
                Route::prefix('advertisements')->name('.advertisements')->group(function () {
                    Route::match(['get', 'post'],'/', 'AdminCP\AdvertisementController@index');
                    Route::match(['get', 'post'], '/create', 'AdminCP\AdvertisementController@create')->name('.create');
                    Route::match(['get', 'post'], '{advertisementSite}/edit', 'AdminCP\AdvertisementController@edit')->name('.edit');
                    Route::get('{advertisementSite}/delete', 'AdminCP\AdvertisementController@delete')->name('.delete');
                });
                Route::prefix('products')->name('.products')->group(function () {
                    Route::match(['get', 'post'],'/', 'AdminCP\ProductController@index');
                    Route::match(['get', 'post'], '/create', 'AdminCP\ProductController@create')->name('.create');
                    Route::match(['get', 'post'], '{product}/edit', 'AdminCP\ProductController@edit')->name('.edit');
                    Route::match(['get', 'post'], 'setVisibility/{product}', 'AdminCP\ProductController@setVisibility')->name('.setVisibility');
                    Route::match(['get', 'post'], '{product}/setFeatured', 'AdminCP\ProductController@setFeatured')->name('.setFeatured');
                    Route::get('{product}/delete', 'AdminCP\ProductController@delete')->name('.delete');
                });
                Route::prefix('categories')->name('.categories')->group(function () {
                    Route::match(['get', 'post'],'/', 'AdminCP\CategoryController@index');
                    Route::match(['get', 'post'], '/create', 'AdminCP\CategoryController@create')->name('.create');
                    Route::match(['get', 'post'], '{category}/edit', 'AdminCP\CategoryController@edit')->name('.edit');
                    Route::get('{category}/delete', 'AdminCP\CategoryController@delete')->name('.delete');
                });
                Route::prefix('creditpackages')->name('.creditpackages')->group(function () {
                    Route::match(['get', 'post'],'/', 'AdminCP\CreditPackageController@index');
                    Route::match(['get', 'post'], '/create', 'AdminCP\CreditPackageController@create')->name('.create');
                    Route::match(['get', 'post'], '{creditpackage}/edit', 'AdminCP\CreditPackageController@edit')->name('.edit');
                    Route::get('{creditpackage}/delete', 'AdminCP\CreditPackageController@delete')->name('.delete');
                });
                Route::prefix('payments')->name('.payments')->group(function () {
                    Route::match(['get', 'post'],'/', 'AdminCP\PaymentsController@index');
                });
                Route::prefix('bonds')->name('.bonds')->group(function () {
                    Route::match(['get', 'post'],'/', 'AdminCP\BondsController@index');
                });
                Route::prefix('osgp')->name('.osgp')->group(function () {
                    Route::match(['get', 'post'],'/', 'AdminCP\OSGPController@index');
                });
                Route::prefix('credits')->name('.credits')->group(function () {
                    Route::match(['get', 'post'],'/', 'AdminCP\CreditController@index');
                    Route::match(['get', 'post'], '/giveCredits', 'AdminCP\CreditController@giveCredits')->name('.giveCredits');
                    Route::match(['get', 'post'],'/creditLog', 'AdminCP\CreditController@creditLog')->name('.creditLog');
                });
            });
        });
    });
});
Route::prefix('market')->name('market')->group(function () {
   Route::match(['get', 'post'], '/', 'MarketController@index');
});
