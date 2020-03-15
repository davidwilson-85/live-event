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

/*
Route::get('/', function () {
    return view('welcome');
});
*/



// ========================================================================
// Routes for Live View
Route::get('/weightedlive', function() {
	return view('weighted-live');
});
Route::get('/weightedlive/ajax', 'ContentJockeyController@weightedLive');


// ========================================================================
// Route to force calling Twitter API
Route::get('/test_twitter', 'TwitterAPIcaller@index');


// ========================================================================
// Control panel routes
Route::get('/controlpanel', 'ControlPanelController@index')->middleware('auth');
Route::post('/controlpanel/newevent', 'ControlPanelController@store')->middleware('auth');
Route::get('/controlpanel/{id}', 'ControlPanelController@edit')->middleware('auth');
Route::patch('/controlpanel/{id}/{configParam}', 'ControlPanelController@update')->middleware('auth');
//Route::patch('/controlpanel/boolean/{configParam}', 'ControlPanelController@update');


// ========================================================================
// Auth routes
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


// ========================================================================
// Web upload routes. This block should always be in position XXX, and the order of the route statements within the block must not be altered.
Route::post('/upload_image', 'WebUploadController@uploadImage');
Route::get('/climatechange', 'WebUploadController@index');
Route::get('/{event_alias}', 'WebUploadController@index');
