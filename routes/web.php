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
    return view('auth.login');
});

Auth::routes();
Route::middleware(['auth'])->group(function() {
    Route::get('/', function () {
        return redirect('/home');
    });

  Route::get('/home', 'RapatController@index')->name('home');
  Route::get('/rapat/tambah', 'RapatController@create');
  Route::get('/allRapat', 'RapatController@renderRapat');
  Route::get('/pdf', 'HomeController@pdf');

  Route::get('/agenda/{id}', 'AgendaController@index');
  Route::post('/agenda/topik/{id}', 'AgendaController@topik');
  Route::post('/agenda/store/{id}', 'AgendaController@store');
  Route::post('/agenda/edit/{id}', 'AgendaController@update');
  Route::get('/agenda/delete/{id}', 'AgendaController@destroy');

  Route::get('/topik', 'AgendaController@renderTopik');
  Route::get('/topik/edit/{id}', 'TopikController@edit');
  Route::get('/topik/tambah/{rapat}/{id}', 'TopikController@create');
  Route::post('/topik/store/{rapat}/{id}', 'TopikController@store');
  Route::get('/topik/{rapat}/{id}', 'TopikController@index');
  Route::get('/hapus/topik/{id}', 'TopikController@destroy');
  Route::get('/renderAll', 'TopikController@renderAll');
  Route::get('/action','ActionController@index');
  Route::post('/action/update/{id}','ActionController@update');
  Route::get('/action/delete/{id}','ActionController@destroy');
  Route::get('/rapat/edit/{id}','RapatController@edit');
  Route::post('/rapat/update/{id}','RapatController@update');

  Route::get('/rapat', 'RapatController@rapat');
  Route::get('/rapatnya', 'RapatController@create')->name('rapatnya');
  Route::get('/detil','RapatController@show')->name('detil');
  Route::post('/rapat/store', 'RapatController@store');
  Route::get('/rapat/{id}', 'HomeController@pdfgen');

  Route::get('/getRapat', 'RapatController@getRapat');

  Route::get('/pdftest/{id}', 'HomeController@pdftest');



});



