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
Route::redirect('/', url('dashboard'));
Auth::routes(['register' => false]);
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::get('/dashboard/progressEselon2', 'DashboardController@progressEselon2');
Route::get('/dashboard/progressPerUnit', 'DashboardController@progressPerUnit');
Route::get('/dashboard/komposisiJP', 'DashboardController@komposisiJP');
Route::get('/dashboard/top3_peg', 'DashboardController@top3_peg');
Route::get('/dashboard/top3_es3', 'DashboardController@top3_es3');

Route::get('/pegawai', 'PegawaiController@index')->name('pegawai.view');
Route::get('/pegawai/form', 'PegawaiController@form');
Route::post('/pegawai/adminFill', 'PegawaiController@fill')->name('pegawai.adminFill');
Route::post('pegawai/insert', 'PegawaiController@insert')->name('pegawai.insert');
Route::post('/pegawai/delete', 'PegawaiController@delete')->name('pegawai.delete');
Route::get('/pegawai/edit/{nip}', 'PegawaiController@edit')->name('pegawai.edit');
Route::post('/pegawai/update/{nip}', 'PegawaiController@update')->name('pegawai.update');
Route::post('/pegawai/import', 'PegawaiController@import')->name('pegawai.import');
Route::get('/pegawai/download', 'PegawaiController@downloadExcel');

Route::get('/kompetensi', 'KompetensiController@index')->name('kompetensi.view');
Route::get('/kompetensi/form', 'KompetensiController@form');
Route::post('/kompetensi/insert', 'KompetensiController@insert')->name('kompetensi.insert');
Route::post('/kompetensi/import', 'KompetensiController@import')->name('kompetensi.import');
Route::get('/kompetensi/download', 'KompetensiController@downloadExcel');
Route::get('/kompetensi/detil/{nip}', 'KompetensiController@detilKompetensi');
Route::post('/kompetensi/delete', 'KompetensiController@delete')->name('kompetensi.delete');
Route::get('/kompetensi/edit/{nip}/{id_komp}', 'KompetensiController@edit')->name('kompetensi.edit');
Route::post('/kompetensi/update/{nip}/{id_komp}', 'KompetensiController@update')->name('kompetensi.update');
