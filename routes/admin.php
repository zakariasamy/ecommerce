<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
// we added prefix to all file using route service provider instead of putting it in group
// in the next line - auth:admin means guard admin which is configed in config/auth
Route::group(['namespace' => 'Admin', 'middleware' => 'auth:admin'], function () {
    Route::get('', 'AdminController@index')->name('admin.dashboard');
});

Route::group(['namespace' => 'Admin', 'middleware' => 'guest:admin'], function () {
    Route::get('login', 'LoginController@login')->name('admin.login');
    Route::post('login', 'LoginController@store')->name('admin.post.login');
});

