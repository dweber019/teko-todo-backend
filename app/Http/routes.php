<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['prefix' => 'api', 'middleware' => ['api']], function () {

    /*
     * Authenticate
     */
    Route::resource('authenticate', 'AuthenticateController', ['only' => ['index', 'store']]);
    Route::put('authenticate', 'AuthenticateController@update');

    /*
     * Users
     */
    Route::resource('users', 'UserController');

    /*
    * Tasklists
    */
    Route::group(['prefix' => 'tasklists'], function () {
        Route::get('{id}/tasks', 'TasklistController@getTasks');
    });
    Route::resource('tasklists', 'TasklistController');

    /*
    * Tasks
    */
    Route::group(['prefix' => 'tasks'], function () {
        Route::get('favorites', 'TaskController@getFavorites');
        Route::get('archived', 'TaskController@getArchived');
    });
    Route::resource('tasks', 'TaskController');

});
