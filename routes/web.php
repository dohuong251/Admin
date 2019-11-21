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
                Route::get('/dashboard', 'lsp\StreamController@filter')->name('dashboard');
                Route::get('/complain', 'lsp\StreamController@complain')->name('complain');
                Route::get('/features', 'lsp\StreamController@feature')->name('feature');
                Route::get('/{songId}', 'lsp\StreamController@show')->name('show');

                Route::post('/', 'lsp\StreamController@store')->name('store');
                Route::post('/suspend', 'lsp\StreamController@suspend')->name('suspend');

                Route::put('/{songId}', 'lsp\StreamController@update')->name('update');

                Route::delete('/{songId}', 'lsp\StreamController@destroy')->name('destroy');
                Route::delete('/', 'lsp\StreamController@delete')->name('delete');
            });

            // messages
            Route::group(['as' => 'messages.', 'prefix' => 'messages'], function () {
                Route::get('/', 'lsp\MessageController@index')->name('index');
                Route::post('/', 'lsp\MessageController@store')->name('store');
                Route::delete('/', 'lsp\MessageController@delete')->name('delete');
            });

            Route::group(['as' => 'analytic.', 'prefix' => 'analytic'], function () {
                Route::get('/statistics', 'lsp\StatisticsController@index')->name('statistics');
                Route::get('/statistics/filter', 'lsp\StatisticsController@filter')->name('statistics.filter');
                Route::get('/statistics/search', 'lsp\StatisticsController@search')->name('statistics.search');
                Route::get('/realtime', 'lsp\RealtimeAnalyticController@index')->name('realtime');
            });
        });

//        sales
        Route::group(['as' => 'sales.', 'prefix' => 'sales'], function () {
            Route::get('/order', 'lsp\OrderController@index')->name('order');
            Route::get('/subscription', 'lsp\SubscriptionController@index')->name('subscription');
            Route::get('/license', 'lsp\LicenseController@index')->name('license');
        });

//        tools
        Route::group(['as' => 'tools.', 'prefix' => 'tools'], function () {
            Route::get('/config', 'tool\ConfigController@index')->name('config');
            Route::post('/config', 'tool\ConfigController@store')->name('store');
            Route::put('/config', 'tool\ConfigController@update')->name('update');

            Route::get('/notification', 'tool\NotificationController@index')->name('notification');
            Route::post('/notification', 'tool\NotificationController@store')->name('notification.store');
            Route::get('/notification/create', 'tool\NotificationController@create')->name('notification.create');
            Route::get('/notification/{notificationId}', 'tool\NotificationController@show')->name('notification.show');
            Route::put('/notification/{notificationId}', 'tool\NotificationController@update')->name('notification.update');
            Route::delete('/notification', 'tool\NotificationController@delete')->name('notification.delete');

            Route::get('/sendBroadcast', 'tool\SendBroadcastController@index')->name('sendBroadcast');

            Route::get('/testRule', 'tool\TestRuleController@index')->name('testRule');
            Route::post('/testRule', 'tool\TestRuleController@decryptUrl')->name('decrypt_url');
            Route::put('/testRule', 'tool\TestRuleController@updateRule')->name('testRule.update_rule');
        });
//        app
        Route::group(['as' => 'apps.', 'prefix' => 'apps'], function () {
            Route::get('/', 'app\AppController@index')->name('index');

            Route::get('/{appId}', 'app\AppController@show')->name('show');
        });

        Route::group(['as' => 'promotions.', 'prefix' => 'promotions'], function () {
            Route::get('/', 'promotion\PromotionController@index')->name('index');
        });
    });

});


