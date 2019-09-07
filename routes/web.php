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

Route::get('/home', 'AdminController@index')->name('admin_dashboard');

Route::get('/game/new', 'AdminGameController@create')->name('admin_game_create');

Route::get('/game/{game}', 'AdminGameController@view')->name('admin_game_view');

Route::get('/', function() {
    return view('welcome');
});
