<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {

    // we added prefix to all file using route service provider instead of putting it in group
    // in the next line - auth:admin means guard admin which is configed in config/auth
    Route::group(['namespace' => 'Admin', 'middleware' => 'auth:admin', 'prefix' => 'admin'], function () {
        Route::get('', 'AdminController@index')->name('admin.dashboard');
        Route::get('logout', 'LoginController@logout')->name('admin.logout');

        Route::group(['prefix' => 'settings'], function () {
            Route::get('shipping-methods/{type}', 'SettingController@editShippingMethods')->name('edit.shipping.methods');
            Route::put('shipping-methods', 'SettingController@updateShippingMethods')->name('update.shipping.methods');
        });

        Route::group(['prefix' => 'profile'], function () {
            Route::get('edit', 'ProfileController@edit')->name('edit.profile');
            Route::put('update', 'ProfileController@update')->name('update.profile');
        });
    });

    Route::group(['namespace' => 'Admin', 'middleware' => 'guest:admin', 'prefix' => 'admin'], function () {
        Route::get('login', 'LoginController@login')->name('admin.login');
        Route::post('login', 'LoginController@store')->name('admin.post.login');
    });
}
);
