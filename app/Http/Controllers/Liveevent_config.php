<?php

namespace App\Http\Controllers;

class Liveevent_config {

	// This class reads and writes the LiveEvent config file. At the moment methods are static for conciseness when using them in controllers, but this might change. At the moment this file is json formatted. Advantage is that after decoding into an array, reading and writing is very convenient. Disadvantage is that file cannot have comments.
	// Description of elements in config file:
	// - uploadedImages (true/false): enable/dsable the use of images through the web app
	// - uploadedTexts (true/false): enable/dsable the use of texts through the web app
	// - twitter (true/false): enable/dsable the use of twitter hashtags
	//
	//
	//
	//
	//
	//
	//

	public static function read($param) {

		// Gets whole config file into memory and then reads json attribute $param

		$json_string = file_get_contents(app_path('Http/Controllers/config'));
		$decoded = json_decode($json_string, true);

		return $decoded[$param];

	}

	public static function write($param, $value) {

		// Gets whole config file, overwrites json attribute $param with value $value

		$json_string = file_get_contents(app_path('Http/Controllers/config'));
		$decoded = json_decode($json_string, true);

		$decoded[$param] = $value;

		$encoded = json_encode($decoded);
		file_put_contents(app_path('Http/Controllers/config'), $encoded);

	}

}

