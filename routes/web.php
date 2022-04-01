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
    return view('start');
});

Auth::routes();

//Sebelum Login akan diarahkan ke halaman start
Route::get('/start','admincontroller@index');

//logout akan diarakan ke halaman login
Route::get('/logout','admincontroller@logout');

//Setelah berhasil login akan ke halaman stock barang
Route::get('/home', 'admincontroller@stockBarang')->name('home');

//halaman ini akan hanya dapat diakses setelah login
Route::group(['middleware'=>['auth']],function () {
    Route::get('/stock','admincontroller@stockBarang');
});