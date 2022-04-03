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
    Route::get('/halamanutama','admincontroller@HalamanHome');
    Route::get('/stock/detail/{id}','admincontroller@stockFilter');
    Route::get('/stock/transaction/{id}','admincontroller@transaction');


    Route::get('/stock/addstock','admincontroller@addStock');
    Route::get('/stock/issue','admincontroller@issuePage');

    //Receipt and Issue
    Route::post('/stock/add','admincontroller@receipt');
    Route::post('/stock/issue','admincontroller@issue');

    //Get Id Item Json
    Route::get('/item/{id}','admincontroller@getItem');

    //Export 
    Route::get('/transaction/export/excel/{params}', 'ExportController@excelExport');
    Route::get('/transaction/export/pdf/{params}', 'ExportController@exportPDF');

    //Export 
    Route::get('/stock/export/excel/{params}', 'ExportController@stockexcelExport');
    Route::get('/stock/export/pdf/{params}', 'ExportController@stockexportPDF');
});