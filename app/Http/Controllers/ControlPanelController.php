<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Redirect;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\ConfigLiveevent;
use App\Event;

class ControlPanelController extends Controller
{

    // Display main control panel info (list of events)
    public function index() {

        // Get all user's events from DB
        $user_id = auth()->user()->id;
        
        $user_events = \DB::table('events')
            ->select('id', 'created_at')
            ->where('user_id', $user_id)
            ->get();

        return view('control-panel', [
            'user_events' => $user_events
        ]);

    }

	// Display whole configuration
    public function edit($id) {

    	//ConfigLiveevent::write('uploadedImages', 'true');

    	//return ConfigLiveevent::read('source.web.uploadTexts');

    	//ConfigLiveevent::writeConfig('twitter_state', 'false');

    	$name = ConfigLiveevent::readConfig('name');
    	$security = ConfigLiveevent::readConfig('security');
    	$language = ConfigLiveevent::readConfig('language');
    	$web_enabled = ConfigLiveevent::readConfig('web_enabled');
    	$web_upload_images = ConfigLiveevent::readConfig('web_upload_images');
    	$web_upload_text = ConfigLiveevent::readConfig('web_upload_text');
        $twitter_enabled = ConfigLiveevent::readConfig('twitter_enabled');
    	

    	return view('control-panel', [
    		'name' => $name, 
    		'security' => $security, 
    		'language' => $language,
    		'web_enabled' => $web_enabled,
    		'web_upload_images' => $web_upload_images,
    		'web_upload_text' => $web_upload_text,
            'twitter_enabled' => $twitter_enabled
    	]);

    }

    // Show form to create new event
    public function create() {

        // For now the form is integrated in the list view

    }

    // Store new event
    public function store() {

        // Store event in 'events' table
        $user_id = auth()->user()->id;

        $newEvent = new Event;
        $newEvent->user_id = $user_id;
        $newEvent->save();

        // Make a copy of the 'config.template' file and name it with id of project

        $contents = file_get_contents(app_path('ConfigFiles/config_template'));
        file_put_contents(app_path('ConfigFiles/config'. $newEvent->id), $contents);
        
        //Using 'Storage::copy($origin, $destination)' did not work. After trying many things, it is possible that is is due to a composer dependency not installed

        // Create new route(s) for this event



        return Redirect::back();

    }

    // Update the specified configuration parameter of an event
    public function update($id, $configParam) {

    	if (request('hidden') == 'string') {

    		ConfigLiveevent::writeConfig($configParam, request('newValue'));

    	} else if (request('hidden') == 'boolean') {

            if (request('boolean') == True) {
                ConfigLiveevent::writeConfig($configParam, 'true');
            } else {
                ConfigLiveevent::writeConfig($configParam, 'false');
            }

    	}
    	
		return back();

    }

    // Delete event and all related content in DB
    public function destroy($id)
    {
        // Among other things, delete all the records in the 'tweets', 'uploadedImages' tables that correspond to this event.
    }

}
