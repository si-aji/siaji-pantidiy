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

Route::group([
    'namespace' => 'Front'
], function(){
    Route::get('/', 'HomeController')->name('index');

    Route::get('/panti', 'PantiController@index')->name('panti');
    Route::get('/{type}/{slug}', 'SinglePageController@index')->name('page');
});