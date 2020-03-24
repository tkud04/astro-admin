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

#Route::get('/', function(){return "<h2 style='color: red;'>Out of service</h2>";});

Route::get('/', 'MainController@getIndex');

Route::get('login', 'LoginController@getLogin');
Route::post('login', 'LoginController@postLogin');
Route::get('register', 'LoginController@getRegister');
Route::post('register', 'LoginController@postRegister');
Route::get('logout', 'LoginController@getLogout');

Route::get('drivers', 'MainController@getDrivers');
Route::get('driver', 'MainController@getDriver');
Route::get('add-driver', 'MainController@getAddDriver');
Route::post('add-driver', 'MainController@postAddDriver');
Route::get('edit-driver', 'MainController@getEditDriver');
Route::post('edit-driver', 'MainController@postEditDriver');