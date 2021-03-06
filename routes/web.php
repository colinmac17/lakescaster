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
    $bHome = true;
    $aSimpleSpots = SpotController::getSimpleSpots();
    return view('welcome', compact('aaSpots', 'bHome', 'aLakes', 'aSimpleSpots'));
});

Route::get('developers', function(){
    $aaSpots = SpotController::$aaSpotsByLatandLon;
    $aLakes = SpotController::$aLakes;
    $aSimpleSpots = SpotController::getSimpleSpots();
    return view('developers', compact('aaSpots', 'aLakes', 'aSimpleSpots'));
});

//Email Auth Routes
Auth::routes();

//Social Auth Routes
Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

//User Account Routes
Route::post('/account/delete', 'AccountController@deleteAccount');
Route::get('user/settings', 'AccountController@index');
Route::get('/account/recover', function(){
    $aaSpots = SpotController::$aaSpotsByLatandLon;
    $aLakes = SpotController::$aLakes;
    $aSimpleSpots = SpotController::getSimpleSpots();
    return view('auth.deleted', compact('aaSpots', 'aLakes', 'aSimpleSpots'));
})->name('recover');
Route::post('/account/recover/{id}', 'AccountController@recoverAccount');

// App Routes
Route::get('dashboard', 'DashboardController@index')->name('dashboard');
Route::get('spots', 'SpotController@getAllSpots');
Route::get('spots/{lake}/{spot}/{id}', 'SpotController@findByLatAndLongitude');
Route::get('spots/{lake}/{spot}/{id}/forecast', 'SpotController@findByLatAndLongitude');
Route::get('spots/{lake}/{spot}/{id}/media', 'SpotController@findByLatAndLongitude');
Route::get('spots/{lake}/{spot}/{id}/reviews', 'SpotController@findByLatAndLongitude');
Route::post('spot/search', 'SpotController@searchSpots');
Route::post('spots/{lake}/{spot}/{id}/review', 'ReviewController@submitReview');

//API Routes
Route::get('api/spots/{lake}/{spot}/{id}', 'APIController@getSpotById');
Route::get('api/spots/{lake}', 'APIController@getSpotsByLake');
Route::get('api/spots', 'APIController@getAllSpots');


//Route::get('/spot/s/{name}/{id}', 'SpotController@findBySurflineId');
//Route::get('/spot/m/{name}/{id}', 'SpotController@findByMagicSeaweedId');
