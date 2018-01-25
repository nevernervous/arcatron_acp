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

Route::get('/live', [
    'as'   => 'showLive',
    'uses' => 'LiveController@showLive'
]);

Route::get('/profile', [
    'as'   => 'showProfile',
    'uses' => 'ProfileController@showProfile'
]);

Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/users', [
        'as'    => 'showUsers',
        'uses'  => 'UsersController@showUsers'
    ]);
});

Route::get('/search', [
    'as'   => 'showSearch',
    'uses' => 'SearchController@showSearch'
]);

Route::get('/logs', [
    'as'   => 'showLogs',
    'uses' => 'LogsController@showLogs'
]);