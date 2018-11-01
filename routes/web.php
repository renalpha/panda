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

Route::get('/', 'HomeController@index');
Route::get('/invite/group/{label}', 'Panda\PandaGroupController@invite')->name('group.invite');
Auth::routes(['verify' => true]);

/**
 * Protected routes for verified users...
 */
Route::group(['middleware' => 'verified'], function () {
    Route::group(['prefix' => 'ajax'], function () {
        Route::get('group/{label}/members', 'Panda\PandaGroupController@getUsersOverviewGroup')->name('ajax.group.members');
        Route::get('group/index', 'Panda\PandaGroupController@getGroupsByUser')->name('ajax.group.index');
    });

    Route::group(['namespace' => 'Panda'], function () {
        // Get the Panda group
        Route::get('group/index', 'PandaGroupController@index')->name('group.index');
        Route::get('group/new', 'PandaGroupController@create')->name('group.new');
        Route::post('group/new', 'PandaGroupController@store')->name('group.new.store');
        Route::get('group/edit/{pandaGroup}', 'PandaGroupController@edit')->name('group.edit');
        Route::post('group/edit/{pandaGroup}', 'PandaGroupController@store')->name('group.edit.store');
        Route::get('group/remove/{pandaGroup}', 'PandaGroupController@remove')->name('group.remove');
        Route::get('group/{label}', 'PandaGroupController@show')->name('group.show');
    });
    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', 'Auth\UserProfileController@show')->name('profile');
    });
});


Route::get('/home', 'HomeController@index')->name('home');