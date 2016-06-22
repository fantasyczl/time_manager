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

Route::group(['prefix' => 'auth'], function() {
    Route::get('login', 'Auth\AuthController@getLogin');
    Route::post('login', 'Auth\AuthController@postLogin');
    Route::get('logout', 'Auth\AuthController@getLogout');
    Route::get('register', 'Auth\AuthController@getRegister');
    Route::post('register', 'Auth\AuthController@postRegister');
});

Route::group(['prefix' => 'password'], function() {
    Route::get('email', 'Auth\PasswordController@getEmail');
    Route::post('email', 'Auth\PasswordController@postEmail');
    Route::get('reset/{token}', 'Auth\PasswordController@getReset');
    Route::post('reset', 'Auth\PasswordController@postReset');
});

Route::group(['middleware' => 'auth'], function() {
    Route::get('dashboard', 'DashboardController@index');

    Route::resource('projects', 'ProjectController');
    Route::put('projects/ajax/saveOrders', 'ProjectController@ajaxSaveOrders');
    Route::get('projects/ajax/showTasksInDay', 'ProjectController@ajaxShowTasksInDay');

    Route::post('tasks/ajax/addTask', 'TaskController@ajaxAddTask');
    Route::resource('tasks', 'TaskController');

    Route::group(['prefix' => 'email'], function() {
        Route::get('/', 'EmailController@getEmail');
        Route::post('/', 'EmailController@postEmail');
    });

    Route::group(['prefix' => 'date'], function() {
        Route::get('/', 'DateController@index');
        Route::get('{y}', 'DaysController@getYear');
        Route::get('{y}/{m}', 'DateController@getMonth');
        Route::get('{y}/{m}/{d}', 'DateController@getDay');
    });

    Route::resource('schedules', 'ScheduleController');

    Route::resource('test', 'TestController');
});
