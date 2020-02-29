<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

use App\Tweet;
Use App\UploadedImage;

use DateTime;

class ContentJockeyController extends Controller
{
    // This class deals with content that has to be deliverred to frontend Live View

	public function weightedLive() {

		// Determine if need to return starred or regular content

		// TO DO LATER

		// Query last X elements in DB and. Maybe X should be a tunable parameter because in case of low inflow of tweets/images, it will exclude anything older and could result in too much repetition of latest X tweets/images

		// Initialize $latestElements var and append different types of elements according to configuration of the app

		$latestTweets = collect();
		$latestWebUploads = collect();
		$latestElements = array();

		if (ConfigLiveevent::readConfig('twitter_enabled') == 'true') {

			$latestTweets = Tweet::where('img_urls', '!=', 'no_imgs')->orderBy('id', 'desc')->take(25)->get();

			$latestTweets->each(function ($item, $key) {
				$item->type = 'tweet';
			});

		}

		if (ConfigLiveevent::readConfig('web_enabled') == 'true') {

			$latestWebUploads = UploadedImage::orderBy('id', 'desc')->take(25)->get();

			$latestWebUploads->each(function ($item, $key) {
				$item->type = 'web_upload';
			});

		}

		$latestElements = $latestTweets->concat($latestWebUploads);

		// Calculate nScore of each element 

		// https://stackoverflow.com/questions/365191/how-to-get-time-difference-in-minutes-in-php
		//$currentTime = new DateTime();
		//$currentTimeFormatted = $currentTime->format('Y-m-d H:i:s');
		//$uploadTime = DateTime::createFromFormat('Y-m-d H:i:s', '2020-02-10 21:00:00');


		$currentTime = new DateTime();
		$currentTimeFormatted = $currentTime->format('Y-m-d H:i:s');

		//$interval = ( strtotime($currentTimeFormatted) - strtotime('2020-01-29 21:00:00') ) / 60;


		if (count($latestElements) == 0) {

			return 'No tweets/images in DB. Before each event, manager should upload several images to prime the system';

		} else {

			// Define array to store all ages
			$ages = array();

			foreach ($latestElements as $element) {

				// add age in minutes to array
				$element->age = ( strtotime($currentTimeFormatted) - strtotime($element->created_at) ) / 60;

				$ages[] = $element->age;

			}

			$max_age = max($ages);

			foreach ($latestElements as $element) {

				// add N score to array
				// nScore = [ age(minutes) + numViews * ageMax  * rand(-0.01 - +0.01);
				$element->nScore = $element->age + $max_age * $element->nbr_views + mt_rand(-10000, 10000) * 0.0000001; 

			}

			// Select and return element with lowest nScore

			$min_nScore = $latestElements->min('nScore');
			$selected_element = $latestElements->where('nScore', $min_nScore)->first();

			// I split code depending on type of selected element

			if ($selected_element->type == 'tweet') {

				// Update nbr_views of selected element

				$updated_element = Tweet::find($selected_element->id);
				$updated_element->nbr_views += 1;
				$updated_element->save();
				
				// Return to view

				// Convert string with img urls to array
				$img_urls = explode(",", $selected_element->img_urls);
				array_pop($img_urls);
				$selected_element->imgs = $img_urls;

				return view('weighted-live', ['selected_element' => $selected_element]);

			}

			if ($selected_element->type == 'web_upload') {

				// Update nbr_views of selected element

				$updated_element = UploadedImage::find($selected_element->id);
				$updated_element->nbr_views += 1;
				$updated_element->save();
				
				// Return to view

				// Convert string with img names to array
				$img_names = explode(",", $selected_element->file_name);
				$selected_element->imgs = $img_names;

				return view('weighted-live', ['selected_element' => $selected_element]);

			}

		}

	}

	public function ajax() {

		$resp = array(
			'info1' => 'first message',
			'info2' => 'second message'
		);

		$msg = "This is a simple messagee.";
		
		return $resp;

	}

}
