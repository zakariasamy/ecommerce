<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| site Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {

   // route::get('/' ,function(){
     //   return view('front.home');
   // });


    Route::group(['namespace' => 'Site'], function () {

        route::get('/', 'HomeController@home');
        route::get('category/{slug}', 'CategoryController@productsBySlug')->name('category');
        route::get('product/{slug}', 'ProductController@productsBySlug')->name('product.details');

    });

    Route::group(['namespace' => 'Site', 'middleware' => 'auth'], function () {
        // must be authenticated user

        Route::get('verify', 'VerificationCodeController@getVerifyPage')->name('get.verification.form');
        // check the code user entered
        Route::post('verify-user/', 'VerificationCodeController@verify')->name('verify-user');


    });

    Route::group(['namespace' => 'Site', 'middleware' => ['auth', 'VerifiedUser']], function () {
        // must be authenticated user and verified
        Route::get('profile', function () {
            return 'You Are Authenticated ';
        });
    });

    Route::group(['namespace' => 'Site', 'middleware' => 'auth'], function () {
        Route::post('wishlist', 'WishlistController@store')->name('wishlist.store');
        Route::delete('wishlist', 'WishlistController@destroy')->name('wishlist.destroy');
        Route::get('wishlist/products', 'WishlistController@index')->name('wishlist.products.index');
    });

            /**
         *  Cart routes
         */
        Route::group(['prefix' => 'cart'], function () {
            Route::get('/', 'CartController@getIndex')->name('site.cart.index');
            Route::post('/cart/add/{slug?}', 'CartController@postAdd')->name('site.cart.add');
            Route::post('/update/{slug}', 'CartController@postUpdate')->name('site.cart.update');
            Route::post('/update-all', 'CartController@postUpdateAll')->name('site.cart.update-all');
        });

});
