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

view()->share('pageTitle', 'Untitled');

Route::get('/', 'HomeController@welcome');

Route::group(['middleware' => 'auth'], function() {
    Route::get('/logout', 'Auth\\AuthController@logout');
    Route::get('/home', 'HomeController@index');
});

Route::get('login', 'Auth\\AuthController@getLogin');
Route::post('login', 'Auth\\AuthController@postLogin');
Route::get('register', 'Auth\\AuthController@getRegister');
Route::post('register', 'Auth\\AuthController@postRegister');
