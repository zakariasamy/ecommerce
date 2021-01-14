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

    Route::get('/' ,function(){
        return view('front.home');
    });


    Route::group(['namespace' => 'Site', 'middleware' => 'guest'], function () {
        //guest  user
      //  route::get('/', 'HomeController@home')->name('home')->middleware('VerifiedUser');



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



});
