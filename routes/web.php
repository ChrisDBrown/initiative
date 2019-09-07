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

Route::get('/home', 'Admin\DashboardController@view')->name('admin_dashboard');

Route::get('/game/new', 'Admin\GameController@create')->name('admin_game_create');
Route::post('/game/new', 'Admin\GameController@store')->name('admin_game_store');

Route::get('/game/{game}', 'Admin\GameController@view')->name('admin_game_view');

Route::get('/', function() {
    return view('welcome');
});
