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
Route::get('/invite/group/{label}/code/{code}', 'Panda\PandaGroupController@invite')->name('group.invite');
Auth::routes(['verify' => true]);

/**
 * Protected routes for verified users...
 */
Route::group(['middleware' => 'verified'], function () {
    Route::group(['prefix' => 'ajax'], function () {
        Route::get('reset/points', 'Panda\PandaUserController@reset');
        Route::get('like/type/{type}/id/{id}', 'Panda\PandaLikeController@like')->name('like.toggle');
        Route::post('comment/type/{type}/id/{id}', 'Panda\PandaCommentController@comment')->name('comment.store');
        // Ajax group actions
        Route::group(['prefix' => 'group'], function () {
            Route::get('{label}/members', 'Panda\PandaGroupController@getUsersOverviewGroup')->name('ajax.group.members');
            Route::get('index', 'Panda\PandaGroupController@getGroupsByUser')->name('ajax.group.index');
        });
    });

    Route::group(['namespace' => 'Panda'], function () {
        // Get the Panda group
        Route::group(['prefix' => 'group'], function () {
            Route::get('index', 'PandaGroupController@index')->name('group.index');
            Route::get('new', 'PandaGroupController@create')->name('group.new');
            Route::post('new', 'PandaGroupController@store')->name('group.new.store');
            Route::get('edit/{pandaGroup}', 'PandaGroupController@edit')->name('group.edit');
            Route::post('edit/{pandaGroup}', 'PandaGroupController@store')->name('group.edit.store');
            Route::get('remove/{pandaGroup}', 'PandaGroupController@remove')->name('group.remove');
            Route::get('remove/{pandaGroup}/user/{userId}', 'PandaGroupController@removeUserFromGroup')->name('group.remove.user');
            Route::get('{label}', 'PandaGroupController@show')->name('group.show');
        });

    });
    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', 'Auth\UserProfileController@show')->name('profile');
    });
});


Route::get('/home', 'HomeController@index')->name('home');