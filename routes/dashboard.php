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

Route::group([
    'prefix' => 'dashboard',
    'middleware' => ['web', 'auth']
], function(){
    Route::get('/', function(){
        return view('layouts.dashboard');
    })->name('index');
    
    Route::group([
        'prefix' => 'clear'
    ], function(){
        Route::get('/cache', function(){
            Log::info('Clear Cache Artisan triggered by : '.get_class(auth()->user()).' - '.auth()->user()->id);

            Artisan::call('cache:clear');
            return redirect()->route('dashboard.index')->with([
                'action' => 'Clear Cache',
                'message' => 'Successfully clear cache'
            ]);
        })->name('clear.cache');

        Route::get('/config', function(){
            Log::info('Clear Config Cache Artisan triggered by : '.get_class(auth()->user()).' - '.auth()->user()->id);

            Artisan::call('config:clear');
            return redirect()->route('dashboard.index')->with([
                'action' => 'Clear Config Cache',
                'message' => 'Successfully clear config cache'
            ]);
        })->name('clear.config');

        Route::get('/view', function(){
            Log::info('Clear View Cache Artisan triggered by : '.get_class(auth()->user()).' - '.auth()->user()->id);

            Artisan::call('view:clear');
            return redirect()->route('dashboard.index')->with([
                'action' => 'Clear View Cache',
                'message' => 'Successfully clear view cache'
            ]);
        })->name('clear.view');
    });

    // Provinsi
    Route::get('/provinsi', 'ProvinsiController@index')->name('provinsi.index');
    Route::post('/provinsi', 'ProvinsiController@store')->name('provinsi.store');
    Route::put('/provinsi/{id}', 'ProvinsiController@update')->name('provinsi.update');
    // Kabupaten
    Route::get('/kabupaten', 'KabupatenController@index')->name('kabupaten.index');
    Route::post('/kabupaten', 'KabupatenController@store')->name('kabupaten.store');
    Route::put('/kabupaten/{id}', 'KabupatenController@update')->name('kabupaten.update');
    // Kecamatan
    Route::get('/kecamatan', 'KecamatanController@index')->name('kecamatan.index');
    Route::post('/kecamatan', 'KecamatanController@store')->name('kecamatan.store');
    Route::put('/kecamatan/{id}', 'KecamatanController@update')->name('kecamatan.update');

    // Profile
    Route::get('/profile', 'ProfileController@index')->name('profile.index');
    Route::put('/profile', 'ProfileController@update')->name('profile.update');
    Route::put('/profile/password', 'ProfileController@updatePassword')->name('profile.update.password');

    // Settings
    Route::resource('/setting', 'SettingsController');
});

Route::group([
    'prefix' => 'json',
    'middleware' => ['web', 'auth'],
    'as' => 'json.'
], function(){
    Route::group([
        'prefix' => 'datatable',
        'as' => 'datatable.'
    ], function(){
        Route::get('/provinsi', 'ProvinsiController@datatableAll')->name('provinsi.all');
        Route::get('/kabupaten', 'KabupatenController@datatableAll')->name('kabupaten.all');
        Route::get('/kecamatan', 'KecamatanController@datatableAll')->name('kecamatan.all');
    });

    // Provinsi
    Route::get('/provinsi', 'ProvinsiController@jsonAll')->name('provinsi.all');
    Route::get('/provinsi/{id}', 'ProvinsiController@jsonId')->name('provinsi.id');
    // Kabupaten
    Route::get('/kabupaten', 'KabupatenController@jsonAll')->name('kabupaten.all');
    Route::get('/kabupaten/{id}', 'KabupatenController@jsonId')->name('kabupaten.id');
    // Kecamatan
    Route::get('/kecamatan', 'KecamatanController@jsonAll')->name('kecamatan.all');
    Route::get('/kecamatan/{id}', 'KecamatanController@jsonId')->name('kecamatan.id');
});