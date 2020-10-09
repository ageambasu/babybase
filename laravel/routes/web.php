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

Auth::routes();
Route::get('/', 'HomeController@index')->name('home.index');

Route::get('/babies/filter', 'BabiesController@filter')->name('babies.filter')->middleware('auth');

Route::get('/babies', 'BabiesController@index')->name('babies.index')->middleware('auth');
Route::post('/babies', 'BabiesController@store')->name('babies.store');
Route::get('/babies/create', 'BabiesController@create')->name('babies.create');
Route::get('/babies/{baby}', 'BabiesController@show')->name('babies.show')->middleware('auth');
Route::get('/babies/{baby}/edit', 'BabiesController@edit')->name('babies.edit')->middleware('auth');
Route::put('/babies/{baby}', 'BabiesController@update')->name('babies.update')->middleware('auth');
Route::delete('/babies/{baby}', 'BabiesController@destroy')->name('babies.destroy')->middleware('isAdmin');

Route::get('/studies', 'StudiesController@index')->name('studies.index')->middleware('auth');
Route::post('/studies', 'StudiesController@store')->name('studies.store')->middleware('auth');
Route::get('/studies/create', 'StudiesController@create')->name('studies.create')->middleware('auth');
Route::get('/studies/{study}', 'StudiesController@show')->name('studies.show')->middleware('auth');
Route::get('/studies/{study}/edit', 'StudiesController@edit')->name('studies.edit')->middleware('auth');
Route::put('/studies/{study}', 'StudiesController@update')->name('studies.update')->middleware('auth');
Route::delete('/studies/{study}', 'StudiesController@destroy')->name('studies.destroy')->middleware('isAdmin');

Route::get('/users', 'UsersController@index')->name('users.index')->middleware('isAdmin');
Route::post('/users', 'UsersController@store')->name('users.store')->middleware('isAdmin');
Route::get('/users/create', 'UsersController@create')->name('users.create')->middleware('isAdmin');
Route::get('/users/{user}', 'UsersController@show')->name('users.show')->middleware('isAdmin');
Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit')->middleware('isAdmin');
Route::put('/users/{user}', 'UsersController@update')->name('users.update')->middleware('isAdmin');
Route::delete('/users/{user}', 'UsersController@destroy')->name('users.destroy')->middleware('isAdmin');