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

Route::get('/dooduang', 'DooduangController@index')->name('dooduang.index');
Route::get('/random-card', 'DooduangController@randomCard')->name('dooduang.random-card');
Route::get('/card/switch', 'DooduangController@switchCard')->name('card.switch');
Route::get('/card/used', 'DooduangController@usedCard')->name('card.used');
