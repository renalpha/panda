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
    return view('welcome');
});

Auth::routes(['verify' => true]);

/**
 * Protected routes for verified users...
 */
Route::group(['middleware' => 'verified'], function () {
    Route::group(['prefix' => 'ajax'], function () {
        Route::get('group/{label}/members', 'Panda\PandaGroupController@getUsersOverviewGroup')->name('ajax.group.members');
    });

    Route::group(['namespace' => 'Panda'], function () {
        // Get the Panda group
        Route::get('group/{label}', 'PandaGroupController@show');
    });
    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', 'Auth\UserProfileController@show')->name('profile');
    });
});


Route::get('/home', 'HomeController@index')->name('home');