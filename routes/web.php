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

if (env('APP_ENV') === 'production') {
    URL::forceSchema('https');
}

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/invite/group/{label}/code/{code}', 'Panda\PandaGroupController@invite')->name('group.invite');

Auth::routes(['verify' => true]);

/**
 * Protected routes for verified users...
 */
Route::group(['middleware' => ['verified', 'auth']], function () {

    // Ajax routing
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

    Route::group(['namespace' => 'Admin', 'middleware' => 'auth', 'prefix' => 'admin'], function () {
        Route::get('/dashboard', 'DashboardController@dashboard')->name('admin.dashboard');

        Route::group(['prefix' => 'photo'], function () {

            Route::group(['prefix' => 'album'], function () {
                Route::get('/', 'PhotoAlbumController@index')->name('admin.album.index');
                Route::get('/new', 'PhotoAlbumController@createAlbum')->name('admin.album.new');
                Route::post('/new', 'PhotoAlbumController@storeAlbum')->name('admin.album.new.store');
                Route::get('/edit/{photo}', 'PhotoAlbumController@editAlbum')->name('admin.album.edit');
                Route::post('/edit/{photo}', 'PhotoAlbumController@storeAlbum')->name('admin.album.edit.store');
            });

            Route::get('/new', 'PhotoAlbumController@newPhoto')->name('admin.photo.new');
            Route::post('/new', 'PhotoAlbumController@storePhoto')->name('admin.photo.new.store');
            Route::get('/edit/{photo}', 'PhotoAlbumController@editPhoto')->name('admin.photo.edit');
            Route::post('/edit/{photo}', 'PhotoAlbumController@storePhoto')->name('admin.photo.new.store');

            Route::post('/upload', 'PhotoAlbumController@upload')->name('admin.photo.upload');
        });
    });
                // Get the Panda group
    Route::group(['namespace' => 'Panda', 'prefix' => 'group'], function () {
        Route::get('index', 'PandaGroupController@index')->name('group.index');
        Route::get('new', 'PandaGroupController@create')->name('group.new');
        Route::post('new', 'PandaGroupController@store')->name('group.new.store');
        Route::get('edit/{pandaGroup}', 'PandaGroupController@edit')->name('group.edit');
        Route::post('edit/{pandaGroup}', 'PandaGroupController@store')->name('group.edit.store');
        Route::get('remove/{pandaGroup}', 'PandaGroupController@remove')->name('group.remove');
        Route::get('remove/{pandaGroup}/user/{userId}', 'PandaGroupController@removeUserFromGroup')->name('group.remove.user');
        Route::get('{label}', 'PandaGroupController@show')->name('group.show');
    });

    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', 'Auth\UserProfileController@show')->name('profile');
    });
});