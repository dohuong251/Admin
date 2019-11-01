<?php

/*
|--------------------------------------------------------------------------
| lsp Routes
|--------------------------------------------------------------------------
|
| Here is where you can register lsp routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "lsp" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('layouts.blank');
});


Route::group(['as' => 'admin.', 'prefix' => 'admin'], function () {

    Auth::routes();
    Route::get('/login', 'Auth\LoginController@getLogin')->name('login');

    Route::post('/login', 'Auth\LoginController@postLogin');

    Route::middleware('auth')->group(function () {
        Route::get('/logout', 'Auth\LoginController@logOut')->name('logout');
        Route::get('/home', 'HomeController@index')->name('home');

        /**
         * https://laravel.com/docs/5.7/controllers#resource-controllers
         * index: show tất cả record
         * show: hiển thị thông tin 1 record
         * create: trang tạo
         * store: post request tạo mới record
         * edit: trang chỉnh sửa
         * update: put request chứa thông tin chỉnh sửa của record
         * destroy: xóa 1 record
         * delete: xóa nhiều record
         *
         */
        // live stream layer
        Route::group(['as' => 'lsp.', 'prefix' => 'livestreamplayer'], function () {
            // users
            Route::group(['as' => 'user.', 'prefix' => 'users'], function () {
                Route::get('/', 'lsp\UserController@index')->name('index');
                Route::get('/{userId}/streams', 'lsp\UserController@streams')->name('streams');
                Route::get('/{userId}', 'lsp\UserController@show')->name('show');
                Route::put('/{userId}', 'lsp\UserController@update')->name('update');
                Route::delete('/{userId}', 'lsp\UserController@destroy')->name('destroy');
                Route::delete('/', 'lsp\UserController@delete')->name('delete');
            });

            // streams
            Route::group(['as' => 'streams.', 'prefix' => 'streams'], function () {
                Route::get('/', 'lsp\StreamController@index')->name('index');
                Route::get('/create', 'lsp\StreamController@create')->name('create');
                Route::post('/', 'lsp\StreamController@store')->name('store');
                Route::get('/complain', 'lsp\StreamController@complain')->name('complain');
                Route::post('/suspend', 'lsp\StreamController@suspend')->name('suspend')    ;
                Route::get('/features', 'lsp\StreamController@feature')->name('feature');
                Route::get('/{songId}', 'lsp\StreamController@show')->name('show');
                Route::put('/{songId}', 'lsp\StreamController@update')->name('update');
                Route::delete('/{songId}', 'lsp\StreamController@destroy')->name('destroy');
            });

            // messages
            Route::group(['as' => 'messages.', 'prefix' => 'messages'], function () {
                Route::get('/', 'lsp\MessageController@index')->name('index');
                Route::post('/', 'lsp\MessageController@store')->name('store');
                Route::delete('/', 'lsp\MessageController@delete')->name('delete');
            });

            Route::get('/analytic', 'lsp\AnalyticController@index')->name('analytic');
        });

//        sales
        Route::group(['as' => 'sales.', 'prefix' => 'sales'], function () {
            Route::get('/order', 'lsp\OrderController@index')->name('order');
            Route::get('/subscription', 'lsp\SubscriptionController@index')->name('subscription');
            Route::get('/license', 'lsp\LicenseController@index')->name('license');
        });

//        tools
        Route::group(['as' => 'tools.', 'prefix' => 'tools'], function () {
            Route::get('/config', 'lsp\ConfigController@index')->name('config');
            Route::get('/notification', 'lsp\NotificationController@index')->name('notification');
            Route::get('/sendBroadcast', 'lsp\SendBroadcastController@index')->name('sendBroadcast');
            Route::get('/testRule', 'lsp\TestRuleController@index')->name('testRule');
        });
//        app
        Route::get('/app', 'lsp\AppController@index')->name('app');
    });

});


