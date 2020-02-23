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
    	$web_uploadImages = ConfigLiveevent::readConfig('web_uploadImages');
    	$web_uploadText = ConfigLiveevent::readConfig('web_uploadText');
    	

    	return view('control-panel', [
    		'name' => $name, 
    		'security' => $security, 
    		'language' => $language,
    		'web_enabled' => $web_enabled,
    		'web_uploadImages' => $web_uploadImages,
    		'web_uploadText' => $web_uploadText
    	]);

    }

    // Update the specified configuration parameter
    public function update($configParam) {

    	if (request('hidden') == 'string') {

    		ConfigLiveevent::writeConfig($configParam, request('newValue'));

    	} else if (request('hidden') == 'boolean') {

    		$status = ConfigLiveevent::readConfig($configParam);
    		$status = ($status == 'true' ? 'false' : 'true');

    		ConfigLiveevent::writeConfig($configParam, $status);

    	}
    	
		return back();

    }

}
