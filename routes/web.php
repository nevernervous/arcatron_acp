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
    return redirect()->route('showLive');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function() {
    Route::get('live', [
        'as'   => 'showLive',
        'uses' => 'LiveController@showLive'
    ]);
    Route::get('live/status', [
        'as'   => 'getDeviceStatuses',
        'uses' => 'LiveController@getDeviceStatuses'
    ]);
    Route::get('live/ack', [
        'as'   => 'ack',
        'uses' => 'LiveController@ack'
    ]);

    Route::get('profile', [
        'as'   => 'showProfile',
        'uses' => 'ProfileController@showProfile'
    ]);

    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('users', [
            'as'    => 'showUsers',
            'uses'  => 'UsersController@showUsers'
        ]);
        Route::get('users/all', [
            'as'    => 'getAllUsers',
            'uses'  => 'UsersController@getAllUsers'
        ]);
        Route::post('users/add', [
            'as'    => 'postAddUser',
            'uses'  => 'UsersController@postAddUser'
        ]);
    });

    Route::get('search', [
        'as'   => 'showSearch',
        'uses' => 'SearchController@showSearch'
    ]);

    Route::post('search', [
        'as'   => 'postSearch',
        'uses' => 'SearchController@postSearch'
    ]);

    Route::get('logs', [
        'as'   => 'showLogs',
        'uses' => 'LogsController@showLogs'
    ]);
});