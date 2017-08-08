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
        return view('home');
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
  Route::post('/topik/update/{id}', 'TopikController@update');
  Route::get('/topik/tambah/{rapat}/{id}', 'TopikController@create');
  Route::post('/topik/store/{rapat}/{id}', 'TopikController@store');
  Route::get('/topik/{rapat}/{id}', 'TopikController@index');
  Route::get('/topik/delete/{id}', 'TopikController@destroy');
  Route::get('/renderAll', 'TopikController@renderAll');

  Route::get('/rapat', 'RapatController@rapat');
  Route::get('/rapatnya', 'RapatController@create')->name('rapatnya');
  Route::get('/detil','RapatController@show')->name('detil');
  Route::post('/rapatnya/store', 'RapatController@store');

});

Route::get('/pdfgen', 'HomeController@pdf');
Route::get('/pdf',array('as'=>'htmltopdfview','uses'=>'HomeController@pdfgen'));


