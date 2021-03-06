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
// Routes for testing
Route::get('/test', function() {
	//return session()->all();
	return session('theme');
});
Route::get('/test_twitter', 'TwitterAPIcaller@checkEventsScheduling');
Route::get('/test_twitter2/{event_id}/{keyword}', 'TwitterAPIcaller@callTwitter');


// ========================================================================
// Routes for Live View
Route::get('/liveview/init/{event_id}', 'ContentJockeyController@liveView_Initialize');
Route::get('/liveview/ajax', 'ContentJockeyController@liveView_Refresh');


// ========================================================================
// Control panel routes
Route::get('/controlpanel', 'ControlPanelController@index')->middleware('auth');
Route::get('/controlpanel/billing', 'ControlPanelController@index')->middleware('auth');
Route::post('/controlpanel/newevent', 'ControlPanelController@store')->middleware('auth');
Route::get('/controlpanel/deleteevent/{event_id}', 'ControlPanelController@destroy')->middleware('auth');
Route::get('/controlpanel/editevent/{event_id}', 'ControlPanelController@edit')->middleware('auth');
Route::patch('/controlpanel/{event_id}/{configParam}', 'ControlPanelController@update')->middleware('auth'); // add /event/editConfigParam/ or similar to this route
Route::post('/controlpanel/editevent/{event_id}/uploadImage', 'ControlPanelController@uploadImage')->middleware('auth');
//Route::patch('/controlpanel/boolean/{configParam}', 'ControlPanelController@update');


// ========================================================================
// Theme routes [https://laracasts.com/discuss/channels/laravel/what-i-can-do-to-have-dark-mode-in-laravel-6]
Route::get('/theme/switch', function() {
	if (!session()->has('theme')) {
		session(['theme' => 'dark']);
	}
	session('theme') == 'light' ? session(['theme' => 'dark']) : session(['theme' => 'light']);
	return back();
});


// ========================================================================
// Auth routes
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


// ========================================================================
// Web upload routes. This block should always be in position XXX, and the order of the route statements within the block must not be altered.
Route::post('/upload_image', 'WebUploadController@uploadImage');
Route::post('/upload_text', 'WebUploadController@uploadText');
//Route::get('/climatechange', 'WebUploadController@index');
Route::get('/{event_alias}', 'WebUploadController@index');
