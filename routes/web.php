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

use App\Http\Controllers\SpotController;

//Landing Page
Route::get('/', function () {
    $aaSpots = SpotController::$aaSpotsByLatandLon;
    return view('welcome', compact('aaSpots'));
});

Route::get('/developers', function(){
    $aaSpots = SpotController::$aaSpotsByLatandLon;
    return view('developers', compact('aaSpots'));
});

Auth::routes();

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

//Route::get('/spot/s/{name}/{id}', 'SpotController@findBySurflineId');

//Route::get('/spot/m/{name}/{id}', 'SpotController@findByMagicSeaweedId');

Route::get('/spot/{lake}/{spot}/{id}', 'SpotController@findByLatAndLongitude');


//API Routes

Route::get('/api/spots/{lake}/{spot}/{id}', 'APIController@getSpotById');
Route::get('/api/spots/{lake}', 'APIController@getSpotsByLake');
Route::get('/api/spots', 'APIController@getAllSpots');
