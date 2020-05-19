<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Redirect;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\ConfigLiveevent;
use App\Event;
use App\Tweet;
use App\UploadedImage;
use App\UploadedText;

class ControlPanelController extends Controller
{

    // Display main control panel info (list of events)
    public function index() {

        // Get all user's events from DB
        $user_id = auth()->user()->id;
        
        $user_events = \DB::table('events')
            ->select('id','created_at')
            ->where('user_id', $user_id)
            ->get();

        foreach ($user_events as $user_event) {
            $user_event->short_name = ConfigLiveevent::readConfig($user_event->id, 'short_name');   
        }

        return view('control-panel', [
            'user_events' => $user_events
        ]);

    }

	// Display whole configuration
    public function edit($event_id) {

        // Check if logged-in user is the owner of the event (or system administrator). If not, return forbidden.
        // Reason: typing the id of the project in the address bar...

        if (auth()->user()->id != Event::find($event_id)->user_id 
            AND auth()->user()->role != 'system_admin') {

            return 'This information is only avaiable for the owner of the event.';
        
        }

    	//ConfigLiveevent::write('uploadedImages', 'true');

    	//return ConfigLiveevent::read('source.web.uploadTexts');

    	//ConfigLiveevent::writeConfig('twitter_state', 'false');

    	$name = ConfigLiveevent::readConfig($event_id, 'name');
        $short_name = ConfigLiveevent::readConfig($event_id, 'short_name');
        $title_image = ConfigLiveevent::readConfig($event_id, 'title_image');
    	$security = ConfigLiveevent::readConfig($event_id, 'security');
    	$date = ConfigLiveevent::readConfig($event_id, 'date');
        $time_start = ConfigLiveevent::readConfig($event_id, 'time_start');
        $time_stop = ConfigLiveevent::readConfig($event_id, 'time_stop');
        $language = ConfigLiveevent::readConfig($event_id, 'language');
    	$web_enabled = ConfigLiveevent::readConfig($event_id, 'web_enabled');
    	$web_upload_images = ConfigLiveevent::readConfig($event_id, 'web_upload_images');
    	$web_upload_text = ConfigLiveevent::readConfig($event_id, 'web_upload_text');
        $twitter_enabled = ConfigLiveevent::readConfig($event_id, 'twitter_enabled');
        $twitter_hashtags = ConfigLiveevent::readConfig($event_id, 'twitter_hashtags');

    	return view('control-panel-update', [
            'event_id' => $event_id,
            'event_alias' => $short_name,
    		'name' => $name,
            'title_image' => $title_image, 
    		'security' => $security,
            'date' => $date,
            'time_start' => $time_start,
            'time_stop' => $time_stop, 
    		'language' => $language,
    		'web_enabled' => $web_enabled,
    		'web_upload_images' => $web_upload_images,
    		'web_upload_text' => $web_upload_text,
            'twitter_enabled' => $twitter_enabled,
            'twitter_hashtags' => $twitter_hashtags
    	]);

    }

    // Change the event image of an event
    public function uploadImage(Request $request) {
        
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {

            // Process image, change its name, and save it in folder /uploadedImages
            $image = $request->file('image');
            $image_name = 'image_prj_'. request('event_id') .'.'. $image->getClientOriginalExtension();
            $dir_dest = public_path('/images/eventImages');
            $image->move($dir_dest, $image_name);

            // Write name of image in confog file. I need to do this because file extension (jpg, jpeg, png) is not know in advance
            ConfigLiveevent::writeConfig(request('event_id'), 'title_image', $image_name);

            // Por hacer: en caso de que el archivo de imagen no sobreescriba al preexistente, podría eliminarlo aquí.

            return back();
        }

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

        // Create new route(s) for this event -> For now this is sorted out outside this function. See 'WebUploadController@index' for uploading to an event.

        return Redirect::back();

    }

    // Update the specified configuration parameter of an event
    public function update($event_id, $configParam) {

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
    public function destroy($event_id)
    {
        // Check if logged-in user is the owner of the event (or system administrator). If not, return forbidden.
        // Reason: typing the id of the project in the address bar...

        if (auth()->user()->id != Event::find($event_id)->user_id 
            AND auth()->user()->role != 'system_admin') {

            return 'This action is only avaiable for the owner of the event.';
        
        }


        // Delete record in the events table (maybe events could be left in the table, and add a attribute status=current/deleted)
        $event = Event::find($event_id);
        $event->delete();

        // Delete config file of event
        $config_file = app_path('ConfigFiles/config_id'. $event_id);
        unlink($config_file);

        // Delete records that belong to this event in tables tweets, uploaded_imgs, uploaded_txts 
        Tweet::where('event_id', '=', $event_id)->delete();
        UploadedImage::where('event_id', '=', $event_id)->delete();
        UploadedText::where('event_id', '=', $event_id)->delete();

        // Delete stored images in this event
        //
        //
        //

        return back();
    }

}
