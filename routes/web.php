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

Route::Auth();

Route::get('/', function () {
    return view('content.public.index.index');
})->name('index');

Route::get('/fancy-template', function(){
    return view('layouts.fancy');
});