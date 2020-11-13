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

        #################### Categories ################
        Route::group(['prefix' => 'categories'], function () {
            Route::get('/', 'CategoryController@index')->name('admin.categories');
            Route::get('create', 'CategoryController@create')->name('admin.categories.create');
            Route::post('store', 'CategoryController@store')->name('admin.categories.store');
            Route::get('edit/{id}', 'CategoryController@edit')->name('admin.categories.edit');
            Route::put('update/{id}', 'CategoryController@update')->name('admin.categories.update');
            Route::get('delete/{id}', 'CategoryController@destroy')->name('admin.categories.delete');

        });
        #################### End Categories ################



        ################################## brands ######################################
        Route::group(['prefix' => 'brands'], function () {
            Route::get('/','BrandController@index') -> name('admin.brands');
            Route::get('create','BrandController@create') -> name('admin.brands.create');
            Route::post('store','BrandController@store') -> name('admin.brands.store');
            Route::get('edit/{id}','BrandController@edit') -> name('admin.brands.edit');
            Route::put('update/{id}','BrandController@update') -> name('admin.brands.update');
            Route::get('delete/{id}','BrandController@destroy') -> name('admin.brands.delete');
        });
        ################################## end brands #######################################

        ################################## products routes ######################################
        Route::group(['prefix' => 'products'], function () {
            Route::get('/','ProductController@index') -> name('admin.products');
            Route::get('general-information','ProductController@create') -> name('admin.products.general.create');
            Route::post('store-general-information','ProductController@store') -> name('admin.products.general.store');
            Route::post('store-images','ProductController@storeImage') -> name('admin.products.image');
            Route::post('delete-image','ProductController@deleteImage') -> name('admin.products.image.delete');

            Route::get('try','ProductController@try') -> name('admin.products.general.try');

            ############################ Attributes (like color - size) ############################
            Route::group(['prefix' => 'attributes'], function () {
                Route::get('/','AttributeController@index') -> name('admin.products.attributes');
                Route::get('create','AttributeController@create') -> name('admin.products.attributes.create');
                Route::post('store','AttributeController@store') -> name('admin.products.attributes.store');
                Route::get('edit/{id}','AttributeController@edit') -> name('admin.products.attributes.edit');
                Route::put('update/{id}','AttributeController@update') -> name('admin.products.attributes.update');
                Route::get('delete/{id}','AttributeController@destroy') -> name('admin.products.attributes.delete');
            });
            ############################ end Attributes ############################

        ################################## Attribute options ######################################
                Route::group(['prefix' => 'options'], function () {
                    Route::get('/','OptionController@index') -> name('admin.options');
                    Route::get('create','OptionsController@create') -> name('admin.products.options.create');
                    Route::post('store','OptionsController@store') -> name('admin.options.store');
                    Route::get('delete/{id}','OptionsController@destroy') -> name('admin.options.delete');
                //Route::get('edit/{id}','AttributesController@edit') -> name('admin.attributes.edit');
                    //Route::post('update/{id}','AttributesController@update') -> name('admin.attributes.update');
                });
        ################################## end options    #######################################
        });
        ################################## end Product    #######################################


        ################################## Tags ######################################

        Route::group(['prefix' => 'tags'], function () {
            Route::get('/','TagController@index') -> name('admin.tags');
            Route::get('create','TagController@create') -> name('admin.tags.create');
            Route::post('store','TagController@store') -> name('admin.tags.store');
            Route::get('edit/{id}','TagController@edit') -> name('admin.tags.edit');
            Route::put('update/{id}','TagController@update') -> name('admin.tags.update');
            Route::get('delete/{id}','TagController@destroy') -> name('admin.tags.delete');
        });

        ################################## End Tags ######################################


    });

    Route::group(['namespace' => 'Admin', 'middleware' => 'guest:admin', 'prefix' => 'admin'], function () {
        Route::get('login', 'LoginController@login')->name('admin.login');
        Route::post('login', 'LoginController@store')->name('admin.post.login');
    });

});

