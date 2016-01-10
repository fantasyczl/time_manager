<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return redirect('/auth/login');
});

Route::get('/home', function() {
    return redirect('/dashboard');
});

Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');


Route::group(['middleware' => 'auth'], function() {
    Route::get('dashboard', 'DashboardController@index');
    Route::resource('projects', 'ProjectController');

    Route::post('tasks/ajax/addTask', 'TaskController@ajaxAddTask');
    Route::resource('tasks', 'TaskController');

    Route::group(['prefix' => 'date'], function() {
        Route::get('/', 'DateController@index');
        Route::get('{y}', 'DaysController@getYear');
        Route::get('{y}/{m}', 'DateController@getMonth');
        Route::get('{y}/{m}/{d}', 'DateController@getDay');
    });
});
