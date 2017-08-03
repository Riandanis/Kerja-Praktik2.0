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
    return view('home');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/pdf', 'HomeController@pdf');

Route::get('/agenda/{id}', 'AgendaController@index');
Route::post('/agenda/store/{id}', 'AgendaController@store');
Route::post('/agenda/edit/{id}', 'AgendaController@update');
Route::get('/agenda/delete/{id}', 'AgendaController@destroy');

Route::get('/topik/tambah', 'TopikController@create');

Route::get('/rapat', 'RapatController@index');
Route::get('/rapatnya', 'RapatController@create')->name('rapatnya');
Route::get('/detil','RapatController@show')->name('detil');
Route::post('/rapatnya/store', 'RapatController@store');

