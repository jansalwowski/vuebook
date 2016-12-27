<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', 'RegistrationController@store');
Route::get('/user', 'AuthController@index')->middleware('auth:api');

Route::get('/users/{username}', 'Users\UsersController@show');

Route::group(['prefix' => 'posts', 'name' => 'posts'], function () {
    Route::get('', 'PostsController@index');
    Route::post('', 'PostsController@store')->name('.store')->middleware('auth:api');
    Route::get('{post}', 'PostsController@show')->name('.show');
    Route::patch('{post}', 'PostsController@update')->name('.update')->middleware('auth:api');
    Route::delete('{post}', 'PostsController@destroy')->name('.delete')->middleware('auth:api');

    Route::group(['prefix' => '{post}/comments', 'name' => '.comments'], function () {
        Route::get('', 'PostCommentsController@index');
        Route::post('', 'PostCommentsController@store')->name('.store')->middleware('auth:api');
    });

    Route::group(['prefix' => '{post}/likes', 'name' => '.likes'], function () {
        Route::get('', 'PostLikesController@index');
        Route::post('', 'PostLikesController@store')->name('.store')->middleware('auth:api');
        Route::delete('', 'PostLikesController@destroy')->name('.delete')->middleware('auth:api');
    });
});

Route::group(['prefix' => 'comments', 'name' => 'comments'], function () {
    Route::get('{comment}', 'CommentsController@show');
    Route::patch('{comment}', 'CommentsController@update')->name('.update')->middleware('auth:api');
    Route::delete('{comment}', 'CommentsController@destroy')->name('.delete')->middleware('auth:api');

    Route::group(['prefix' => '{comment}/likes', 'name' => '.likes'], function () {
        Route::get('', 'CommentLikesController@index');
        Route::post('', 'CommentLikesController@store')->name('.store')->middleware('auth:api');
        Route::delete('', 'CommentLikesController@destroy')->name('.delete')->middleware('auth:api');
    });
});

Route::get('wall', 'WallController@index')->name('wall')->middleware('auth:api');