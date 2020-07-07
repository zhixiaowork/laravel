<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {

    // 不需要验证token的api
    Route::group([], function () {

        // auth
        Route::group(['prefix' => 'auth'], function () {
            Route::post('login', 'AuthController@postLogin');
        });
    });

    // 需要验证token的api
    Route::group(['middleware' => 'auth.api'], function () {
        
        // auth
        Route::group(['prefix' => 'auth', ], function () {
            Route::get('logout', 'AuthController@postLogout');

        });

        // 用户信息
        Route::group(['prefix' => 'admin'], function () {
            Route::get('info', 'AdminController@getInfo');
        });

    });

});
