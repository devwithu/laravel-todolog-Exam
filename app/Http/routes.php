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

Route::get('/', 'WelcomeController@index');  //1

Route::auth();

Route::get('/home', 'HomeController@index');

Route::get('auth/github', 'Auth\AuthController@redirectToGitHub');
Route::get('auth/github/callback', 'Auth\AuthController@handleGitHubCallback');

Route::group(['middleware' => 'auth'], function()
{
    Route::resource('project', 'ProjectController');
    Route::resource('project.task', 'ProjectTaskController');
});
