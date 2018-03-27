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
    $bHome = true;
    return view('welcome', compact('aaSpots', 'bHome'));
});

Route::get('developers', function(){
    $aaSpots = SpotController::$aaSpotsByLatandLon;
    return view('developers', compact('aaSpots'));
});

//Email Auth Routes
Auth::routes();

//Social Auth Routes
Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

//User Account Routes
Route::post('/account/delete', 'AccountController@deleteAccount');
Route::get('user/settings', 'AccountController@index');

// App Routes
Route::get('dashboard', 'DashboardController@index')->name('dashboard');
Route::get('spots/{lake}/{spot}/{id}', 'SpotController@findByLatAndLongitude');
Route::get('spots/{lake}/{spot}/{id}/forecast', 'SpotController@findByLatAndLongitude');
Route::get('spots/{lake}/{spot}/{id}/media', 'SpotController@findByLatAndLongitude');
Route::get('spots/{lake}/{spot}/{id}/reviews', 'SpotController@findByLatAndLongitude');
Route::post('spot/search', 'SpotController@searchSpots');

//API Routes
Route::get('api/spots/{lake}/{spot}/{id}', 'APIController@getSpotById');
Route::get('api/spots/{lake}', 'APIController@getSpotsByLake');
Route::get('api/spots', 'APIController@getAllSpots');


//Route::get('/spot/s/{name}/{id}', 'SpotController@findBySurflineId');
//Route::get('/spot/m/{name}/{id}', 'SpotController@findByMagicSeaweedId');
