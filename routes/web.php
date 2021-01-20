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

Route::get('livestreamplayer/analytic/country-user/{userId}', 'Lsp\CountryAnalyticController@countryForUser')->name('country-for-user');
Route::get('admin/livestreamplayer/analytic/country/filter', 'Lsp\CountryAnalyticController@filter')->name('admin.lsp.analytic.country.filter');
Route::get('admin/livestreamplayer/analytic/country/search', 'Lsp\CountryAnalyticController@search')->name('admin.lsp.analytic.country.search');


Route::group(['as' => 'admin.', 'prefix' => 'admin'], function () {

    Auth::routes();
    Route::get('/login', 'Auth\LoginController@getLogin')->name('login');

    Route::post('/login', 'Auth\LoginController@postLogin');

    Route::middleware('auth')->group(function () {
        Route::get('/logout', 'Auth\LoginController@logOut')->name('logout');
        Route::get('/home', 'HomeController@index')->name('home');
        Route::get('/home/statistic', 'HomeController@filter')->name('home.filter');

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

            // review stream
            Route::get('/review-streams','Lsp\StreamController@reviewStreams')->name('review_streams');
            Route::get('review-streams/review-copyright','Lsp\StreamController@reviewCopyright')->name('review_copyright');

            // streams
            Route::group(['as' => 'streams.', 'prefix' => 'streams'], function () {
                Route::get('/', 'Lsp\StreamController@index')->name('index');
                Route::get('/create', 'Lsp\StreamController@create')->name('create');
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
                Route::get('/country', 'Lsp\CountryAnalyticController@index')->name('country');
                Route::get('/realtime', 'Lsp\RealtimeAnalyticController@index')->name('realtime');
                Route::get('/realtime/filter', 'Lsp\RealtimeAnalyticController@filter')->name('realtime.filter');
                Route::get('/realtime/activeUser', 'Lsp\RealtimeAnalyticController@getRealTimeActiveUser')->name('realtime.active_user');
            });
        });

//        sales
        Route::group(['as' => 'sales.', 'prefix' => 'sales'], function () {
            Route::get('/order', 'Order\OrderController@index')->name('order');
            Route::get('/order/customer', 'Order\OrderController@show')->name('order.show');
            Route::get('/order/{orderId}', 'Order\OrderController@edit')->name('order.edit');
            Route::put('/order/{orderId}', 'Order\OrderController@update')->name('order.update');
            Route::delete('/order/{orderId}', 'Order\OrderController@destroy')->name('order.destroy');

            Route::get('/subscription', 'Order\SubscriptionController@index')->name('subscription');
            Route::get('/subscription/edit/{subscriptionId}', 'Order\SubscriptionController@edit')->name('subscription.edit');
            Route::put('/subscription/edit/{subscriptionId}', 'Order\SubscriptionController@update')->name('subscription.update');
            Route::delete('/subscription/{subscriptionId}', 'Order\SubscriptionController@destroy')->name('subscription.destroy');

            Route::get('/license', 'Order\LicenseController@index')->name('license');
            Route::delete('/license/{licenseId}', 'Order\LicenseController@destroy')->name('license.destroy');
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
            Route::get('/overview', 'App\AppController@overview')->name('overview');
            Route::get('/create', 'App\AppController@create')->name('create');
            Route::post('/', 'App\AppController@store')->name('store');
            Route::delete('/{appVersionId}', 'App\AppController@destroy')->name('destroy');

            Route::get('/editVersion', 'App\AppController@editVersion')->name('edit_version');
            Route::put('/editVersion', 'App\AppController@update')->name('update');
            Route::get('/{appId}', 'App\AppController@show')->name('show');
            Route::get('/{appId}/addVersion', 'App\AppController@addVersion')->name('add_version');
            Route::post('/{appId}/addVersion', 'App\AppController@storeVersion')->name('store_version');
        });

        Route::group(['as' => 'promotions.', 'prefix' => 'promotions'], function () {
            Route::get('/', 'Promotion\PromotionController@index')->name('index');
            Route::post('/start', 'Promotion\PromotionController@startPromo')->name('start');
            Route::post('/stop', 'Promotion\PromotionController@stopPromo')->name('stop');
        });

        Route::group(['as' => 'ustv.', 'prefix' => 'ustv'], function () {
            Route::get('/dashboard', 'Ustv\Dashboard@index')->name('dashboard');
            Route::get('/dashboard/search', 'Ustv\Dashboard@searchChannel')->name('dashboard.search');
            Route::get('/dashboard/filter', 'Ustv\Dashboard@filter')->name('dashboard.filter');

            Route::get('/channels', 'Ustv\ChannelController@allChannelIndex')->name('channels');
            Route::post('/channels', 'Ustv\ChannelController@store')->name('channels.store');
            Route::get('/channels/create', 'Ustv\ChannelController@create')->name('channels.create');
            Route::get('/channels/{channelId}', 'Ustv\ChannelController@edit')->name('channels.edit');
            Route::put('/channels/{channelId}', 'Ustv\ChannelController@update')->name('channels.update');
            Route::delete('/channels', 'Ustv\ChannelController@delete')->name('channels.delete');

            Route::post('/channels/url', 'Ustv\ChannelController@storeUrl')->name('url.store');
            Route::put('/channels/url/{urlId}', 'Ustv\ChannelController@updateUrl')->name('url.update');
            Route::delete('/channels/url/{urlId}', 'Ustv\ChannelController@deleteUrl')->name('url.delete');
        });
    });

});


