<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\ConfigLiveevent;

class ControlPanelController extends Controller
{

	// Display whole configuration
    public function index() {

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

    // Update the specified configuration parameter
    public function update($configParam) {

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

}
