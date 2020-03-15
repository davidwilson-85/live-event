<?php

namespace App\Http\Controllers;

class ConfigLiveevent {

	// This class reads and writes the LiveEvent config file. At the moment methods are static for conciseness when using them in controllers, but this might change. 

	// I wrote read and write methods to work with JSON- and directive-type of config files. At the moment I am using the directive type.

	// Directive-type advantages: 
	// Comments
	// Directive-type disadvantages:
	// I do not know about PHP buit in functions to read or write in a single line.

	// JSON-type advantages: 
	// After decoding into an array, reading and writing is very convenient.
	// JSON-type disadvantages:
	// File cannot have comments.
	// Difficult to write because of variable array depth
	

	// Function to read the value of a parameter in the configuration file
	// Uses the 'param':'value' type of configuration file
	// Loops through the file to find the parameter $parma
	// Returns a string with the value of param
	public static function readConfig($event_id, $param) {

		$file = fopen(app_path('ConfigFiles/config_id'. $event_id), 'r');
		
		while (!feof($file)) {

			$split = explode(':', fgets($file));
			if ($split[0] == $param) {
				return trim($split[1]);
			}
		
		}

	}

	// Function to overwrite the value of a parameter in the configuration file
	// Uses the 'param':'value' type of configuration file
	// Loads file content in array $file in a line-by-line fashion
	// Loops through array to find key of line that starts with $param
	// Updates the info of the key with $param and $value
	// For now it simply returns 'ok' 
	public static function writeConfig($event_id, $param, $value) {

		$file = file(app_path('ConfigFiles/config_id'. $event_id));

		foreach ($file as $key => $line) {
			// Check if $param matches the beggining (strictly) of the line
			if (strpos(trim($line), $param) === 0) { break; }
		}

		$file[$key] = $param .": ". trim($value) ."\n";
		file_put_contents(app_path('ConfigFiles/config_id'. $event_id), $file);

		return 'ok';

	}

	public static function readJson($param) {

		// Gets whole config file into memory and then reads json attribute $param

		$json_string = file_get_contents(app_path('Http/Controllers/config'));
		$decoded = json_decode($json_string, true);

		$param_elements = explode('.', $param);

		//return $param_elements;

		if (count($param_elements) == 1) {
			return $decoded[$param_elements[0]];
		} else if (count($param_elements) == 2) {
			return $decoded[$param_elements[0]][$param_elements[1]];
		} else if (count($param_elements) == 3) {
			return $decoded[$param_elements[0]][$param_elements[1]][$param_elements[2]];
		} else if (count($param_elements) == 4) {
			return $decoded[$param_elements[0]][$param_elements[1]][$param_elements[2]][$param_elements[3]];
		}

	}

	public static function writeJson($param, $value) {

		// Gets whole config file, overwrites json attribute $param with value $value

		$json_string = file_get_contents(app_path('Http/Controllers/config'));
		$decoded = json_decode($json_string, true);

		$decoded[$param] = $value;

		$encoded = json_encode($decoded);
		file_put_contents(app_path('Http/Controllers/config'), $encoded);

	}

}

