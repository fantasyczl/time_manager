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
    if (Auth::check()) {
        return redirect('/dashboard');
    } else {
        return redirect('/login');
    }
});

Auth::routes();

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

    Route::resource('users', 'UserController');
});
