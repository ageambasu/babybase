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

Auth::routes(['register' => false]);
Route::get('/', 'HomeController@index')->name('home.index');

Route::get('/babies', 'BabiesController@index')->name('babies.index')->middleware('auth');
Route::post('/babies', 'BabiesController@store')->name('babies.store')->middleware('auth');
Route::get('/babies/create', 'BabiesController@create')->name('babies.create')->middleware('auth');
Route::get('/babies/{baby}', 'BabiesController@show')->name('babies.show')->middleware('auth');
Route::get('/babies/{baby}/edit', 'BabiesController@edit')->name('babies.edit')->middleware('auth');
Route::put('/babies/{baby}', 'BabiesController@update')->name('babies.update')->middleware('auth');