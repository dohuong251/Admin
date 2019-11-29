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
    return redirect()->route('admin.home');
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
                Route::get('/', 'Lsp\UserController@index')->name('index');
                Route::get('/{userId}/streams', 'Lsp\UserController@streams')->name('streams');
                Route::get('/{userId}', 'Lsp\UserController@show')->name('show');

                Route::put('/{userId}', 'Lsp\UserController@update')->name('update');

                Route::delete('/{userId}', 'Lsp\UserController@destroy')->name('destroy');
                Route::delete('/', 'Lsp\UserController@delete')->name('delete');
            });

            // streams
            Route::group(['as' => 'streams.', 'prefix' => 'streams'], function () {
                Route::get('/', 'Lsp\StreamController@index')->name('index');
                Route::get('/create', 'Lsp\StreamController@create')->name('create');
                Route::get('/dashboard', 'Lsp\StreamController@filter')->name('dashboard');
                Route::get('/complain', 'Lsp\StreamController@complain')->name('complain');
                Route::get('/features', 'Lsp\StreamController@feature')->name('feature');
                Route::get('/{songId}', 'Lsp\StreamController@show')->name('show');

                Route::post('/', 'Lsp\StreamController@store')->name('store');
                Route::post('/suspend', 'Lsp\StreamController@suspend')->name('suspend');

                Route::put('/{songId}', 'Lsp\StreamController@update')->name('update');

                Route::delete('/{songId}', 'Lsp\StreamController@destroy')->name('destroy');
                Route::delete('/', 'Lsp\StreamController@delete')->name('delete');
            });

            // messages
            Route::group(['as' => 'messages.', 'prefix' => 'messages'], function () {
                Route::get('/', 'Lsp\MessageController@index')->name('index');
                Route::post('/', 'Lsp\MessageController@store')->name('store');
                Route::delete('/', 'Lsp\MessageController@delete')->name('delete');
            });

            Route::group(['as' => 'analytic.', 'prefix' => 'analytic'], function () {
                Route::get('/statistics', 'Lsp\StatisticsController@index')->name('statistics');
                Route::get('/statistics/filter', 'Lsp\StatisticsController@filter')->name('statistics.filter');
                Route::get('/statistics/search', 'Lsp\StatisticsController@search')->name('statistics.search');

                Route::get('/realtime', 'Lsp\RealtimeAnalyticController@index')->name('realtime');
                Route::get('/realtime/filter', 'Lsp\RealtimeAnalyticController@filter')->name('realtime.filter');
            });
        });

//        sales
        Route::group(['as' => 'sales.', 'prefix' => 'sales'], function () {
            Route::get('/order', 'Lsp\OrderController@index')->name('order');
            Route::get('/subscription', 'Lsp\SubscriptionController@index')->name('subscription');
            Route::get('/license', 'Lsp\LicenseController@index')->name('license');
        });

//        tools
        Route::group(['as' => 'tools.', 'prefix' => 'tools'], function () {
            Route::get('/config', 'Tool\ConfigController@index')->name('config');
            Route::post('/config', 'Tool\ConfigController@store')->name('store');
            Route::put('/config', 'Tool\ConfigController@update')->name('update');

            Route::get('/notification', 'Tool\NotificationController@index')->name('notification');
            Route::post('/notification', 'Tool\NotificationController@store')->name('notification.store');
            Route::get('/notification/create', 'Tool\NotificationController@create')->name('notification.create');
            Route::get('/notification/{notificationId}', 'Tool\NotificationController@show')->name('notification.show');
            Route::put('/notification/{notificationId}', 'Tool\NotificationController@update')->name('notification.update');
            Route::delete('/notification', 'Tool\NotificationController@delete')->name('notification.delete');

            Route::get('/sendBroadcast', 'Tool\SendBroadcastController@index')->name('sendBroadcast');

            Route::get('/testRule', 'Tool\TestRuleController@index')->name('testRule');
            Route::post('/testRule', 'Tool\TestRuleController@decryptUrl')->name('decrypt_url');
            Route::put('/testRule', 'Tool\TestRuleController@updateRule')->name('testRule.update_rule');
        });
//        app
        Route::group(['as' => 'apps.', 'prefix' => 'apps'], function () {
            Route::get('/', 'App\AppController@index')->name('index');

            Route::get('/{appId}', 'App\AppController@show')->name('show');
        });

        Route::group(['as' => 'promotions.', 'prefix' => 'promotions'], function () {
            Route::get('/', 'Promotion\PromotionController@index')->name('index');
            Route::post('/start','Promotion\PromotionController@startPromo')->name('start');
            Route::post('/stop','Promotion\PromotionController@stopPromo')->name('stop');
        });
    });

});


