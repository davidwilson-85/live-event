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



Route::get('/', 'LiveViewController@index');
Route::get('/weightedlive', 'ContentJockeyController@weightedLive');


Route::get('/test_twitter', 'TwitterAPIcaller@index');

Route::get('/climatechange', 'WebUploadController@index');
Route::post('/upload_image', 'WebUploadController@uploadImage');

// Control panel routes
Route::get('/controlpanel', 'ControlPanelController@index');
Route::patch('/controlpanel/{configParam}', 'ControlPanelController@update');
//Route::patch('/controlpanel/boolean/{configParam}', 'ControlPanelController@update');