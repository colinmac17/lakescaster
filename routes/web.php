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
    $aLakes = SpotController::$aLakes;
    return view('welcome', compact('aaSpots', 'aLakes'));
});

Auth::routes();

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

//Route::get('/spot/s/{name}/{id}', 'SpotController@findBySurflineId');

//Route::get('/spot/m/{name}/{id}', 'SpotController@findByMagicSeaweedId');

Route::get('/spot/{lake}/{spot}/{id}', 'SpotController@findByLatAndLongitude');
