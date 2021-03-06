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

Route::group(['middleware' => 'auth'], function(){
    Route::get('/projects','ProjectsController@index');
    Route::post('/projects','ProjectsController@store');
    Route::patch('/projects/{project}','ProjectsController@update');
    Route::delete('/projects/{project}','ProjectsController@destroy');
    Route::get('/projects/create','ProjectsController@create');
    Route::get('/projects/{project}/edit','ProjectsController@edit');
    Route::get('/projects/{project}','ProjectsController@show');

    //Route::resource('projects', 'ProjectsController');

    Route::post('/projects/{project}/tasks','ProjectTasksController@store');
    Route::patch('/projects/{project}/tasks/{task}','ProjectTasksController@update');
    Route::delete('/projects/{project}/tasks/{task}','ProjectTasksController@destroy');


    Route::post('/projects/{project}/invitations','ProjectInvitationsController@store');
});



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
