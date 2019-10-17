<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('layouts.blank');
});

Route::prefix('admin')->group(function () {
    Route::name('admin.')->group(function () {

        Auth::routes();
        Route::get('/login', 'Auth\LoginController@getLogin')->name('login');

        Route::post('/login', 'Auth\LoginController@postLogin');

        Route::middleware('auth')->group(function () {
            Route::get('/logout', 'Auth\LoginController@logOut')->name('logout');
            Route::get('/home', 'HomeController@index')->name('home');
            //        live stream layer

            Route::prefix('livestreamplayer')->group(function () {
                Route::name('lsp.')->group(function () {
                    Route::get('/users', 'web\UserController@index')->name('users');
//                Route::get('/users-source','web\UserController@datatable_source')->name('users_source');
                    Route::get('/user/{userId}/streams-source', 'web\UserController@streams')->name('user_streams');
                    Route::get('/user/{userId}', 'web\UserController@show')->name('user');
                    Route::put('/user/{userId}', 'web\UserController@update');
                    Route::delete('/users', 'web\UserController@destroy');
//                Route::delete('/user/{userId}', 'web\UserController@delete')->name('user.delete');

                    Route::get('/stream/dashboard', 'web\StreamController@filter')->name('stream_dashboard');
                    Route::get('/streams', 'web\StreamController@index')->name('streams');
                    Route::get('/streams/{songId}', 'web\StreamController@show')->name('stream');


                    Route::get('/message', 'web\MessageController@index')->name('message');
                    Route::get('/analytic', 'web\AnalyticController@index')->name('analytic');
                });
            });
//        sales

            Route::prefix('sales')->group(function () {
                Route::name('sales.')->group(function () {
                    Route::get('/order', 'web\OrderController@index')->name('order');
                    Route::get('/subscription', 'web\SubscriptionController@index')->name('subscription');
                    Route::get('/license', 'web\LicenseController@index')->name('license');
                });
            });

//        tools

            Route::prefix('tools')->group(function () {
                Route::name('tools.')->group(function () {
                    Route::get('/config', 'web\ConfigController@index')->name('config');
                    Route::get('/notification', 'web\NotificationController@index')->name('notification');
                    Route::get('/sendBroadcast', 'web\SendBroadcastController@index')->name('sendBroadcast');
                    Route::get('/testRule', 'web\TestRuleController@index')->name('testRule');
                });
            });
//        app
            Route::get('/app', 'web\AppController@index')->name('app');
        });

    });
});


