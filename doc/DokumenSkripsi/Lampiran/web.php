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

// root


Route::get('/', function () {
    return view('index');
});

Route::get('/ipa', function(){
    return view('ipa');
});

Route::get('/ips', function(){
    return view('ips');
});

Route::post('/pengujian','PengujianController@index');

Route::post('/result','SiswaController@index');

// result
Route::get('/result', function () {
    return view('result');
});

Route::get('/pengujian',function(){
    return view('pengujian');
});


Route::get('/login', function () {
    return view('login');
});

// Route::get('/test','TestController@index');
