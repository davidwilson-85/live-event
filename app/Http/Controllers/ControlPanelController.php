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
            ->select('id', 'event_alias', 'created_at')
            ->where('user_id', $user_id)
            ->get();

        return view('control-panel', [
            'user_events' => $user_events
        ]);

    }

	// Display whole configuration
    public function edit($id) {

        // Check if logged-in user is the owner of the event to edit (or system administrator). If not, return forbidden.

        if (auth()->user()->id != Event::find($id)->user_id 
            AND auth()->user()->role != 'system_admin') {

            return 'This information is only avaiable for the owner of the event.';
        
        }

    	//ConfigLiveevent::write('uploadedImages', 'true');

    	//return ConfigLiveevent::read('source.web.uploadTexts');

    	//ConfigLiveevent::writeConfig('twitter_state', 'false');

    	$name = ConfigLiveevent::readConfig($id, 'name');
        $short_name = ConfigLiveevent::readConfig($id, 'short_name');
    	$security = ConfigLiveevent::readConfig($id, 'security');
    	$language = ConfigLiveevent::readConfig($id, 'language');
    	$web_enabled = ConfigLiveevent::readConfig($id, 'web_enabled');
    	$web_upload_images = ConfigLiveevent::readConfig($id, 'web_upload_images');
    	$web_upload_text = ConfigLiveevent::readConfig($id, 'web_upload_text');
        $twitter_enabled = ConfigLiveevent::readConfig($id, 'twitter_enabled');
    	

    	return view('control-panel-update', [
            'id' => $id,
            'event_alias' => $short_name,
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
        $newEvent->event_alias = request('event-alias');
        $newEvent->save();

        // Make a copy of the 'config.template' file and name it with id of project

        $contents = file_get_contents(app_path('ConfigFiles/config_template'));
        file_put_contents(app_path('ConfigFiles/config_id'. $newEvent->id), $contents);
        
        //Using 'Storage::copy($origin, $destination)' did not work. After trying many things, it is possible that is is due to a composer dependency not installed

        // Set name and alias in the file

        ConfigLiveevent::writeConfig($newEvent->id, 'id', $newEvent->id);
        ConfigLiveevent::writeConfig($newEvent->id, 'name', request('name'));
        ConfigLiveevent::writeConfig($newEvent->id, 'short_name', request('event-alias'));

        // Create new route(s) for this event



        return Redirect::back();

    }

    // Update the specified configuration parameter of an event
    public function update($event_id, $configParam) {

        // WARNING!!!
        // Check that the user trying to change event is the owner

    	if (request('hidden') == 'string') {

    		ConfigLiveevent::writeConfig($event_id, $configParam, request('newValue'));

    	} else if (request('hidden') == 'boolean') {

            if (request('boolean') == True) {
                ConfigLiveevent::writeConfig($event_id, $configParam, 'true');
            } else {
                ConfigLiveevent::writeConfig($event_id, $configParam, 'false');
            }

    	}
    	
		return back();

    }

    // Delete event and all related content in DB
    public function destroy($id)
    {
        // WARNING!!!
        // Check that the user trying to change event is the owner

        // Delete
        // - all the records in the 'tweets', 'uploadedImages' tables that correspond to this event.
        // - config file.
        // - stored images
    }

}
