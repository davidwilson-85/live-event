<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

use App\Tweet;

use DateTime;

class ContentJockeyController extends Controller
{
    // This class deals with content that has to be deliverred to frontend Live View

	public function weightedLive() {

		// Determine if need to return starred or regular content

		// TO DO LATER

		// Query last X elements in DB and. Maybe X should be a tunable parameter because in case of low inflow of tweets/images, it will exclude anything older and could result in too much repetition of latest X tweets/images

		$latestElements = Tweet::where('img_urls', '!=', 'no_imgs')->orderBy('id', 'desc')->take(50)->get();


		// https://stackoverflow.com/questions/365191/how-to-get-time-difference-in-minutes-in-php
		//$currentTime = new DateTime();
		//$currentTimeFormatted = $currentTime->format('Y-m-d H:i:s');
		//$uploadTime = DateTime::createFromFormat('Y-m-d H:i:s', '2020-02-10 21:00:00');


		$currentTime = new DateTime();
		$currentTimeFormatted = $currentTime->format('Y-m-d H:i:s');

		//$interval = ( strtotime($currentTimeFormatted) - strtotime('2020-01-29 21:00:00') ) / 60;


		if (count($latestElements) == 0) {

			return 'No tweets/images in DB. Before each event, manager should upload several iamges to prime the system';

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
				//$nScore = [ age(minutes) + numViews * ageMax  * rand(-0.01 - +0.01);
				$element->nScore = $element->age + $max_age * $element->nbr_views + mt_rand(-10000, 10000) * 0.0000001; 

			}


			// Find ID of element with lowest N score

			$nScores = array();

			foreach ($latestElements as $element) {
				$nScores[$element->id] = $element->nScore;
			}

			$element_min_nScore = array_keys($nScores, min($nScores));


			// Update nbr_views of selected element

			$selected_tweet = Tweet::find($element_min_nScore[0]);
			$selected_tweet->nbr_views += 1;
			$selected_tweet->save();
			

			// Return to view

			// Convert string with img urls to array
			$img_urls = explode(",", $selected_tweet->img_urls);
			array_pop($img_urls);
			$selected_tweet->img_urls = $img_urls;

			//return array($selected_tweet, $latestElements);
			//return $selected_tweet;

			return view('weighted-live', ['selected_tweet' => $selected_tweet]);

		}

	}

}
