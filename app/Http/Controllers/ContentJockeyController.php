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

		// Query last X elements in DB and

		$latestElements = Tweet::orderBy('id', 'desc')->take(50)->get();


		// https://stackoverflow.com/questions/365191/how-to-get-time-difference-in-minutes-in-php


		$time = DateTime::createFromFormat('Y-m-d H:i:s', '2020-01-31 21:00:00');

		$currentTime = new DateTime();

		$currentTimeFormatted = $currentTime->format('Y-m-d H:i:s');


		$interval = ( strtotime($currentTimeFormatted) - strtotime('2020-01-29 21:00:00') ) / 60;

		return $interval;

		$interval = $currentTime->diff($time);

		$intervalInMins = 
			$interval->y * 999 +
			$interval->y * 999 +
			$interval->y * 999 +
			$interval->y * 999 +
			$interval->y * 999;

		
		return $interval;
		

		foreach ($latestElements as $element) {

			//return $element->created_at;

			return DateTime::createFromFormat('Y-m-d H:i:s', $element->created_at)->format('H:i:s');

		}

		//return DateTime::createFromFormat('Y-m-d H:i:s', '2020-01-30 22:05:01')->format('Y H:i:s');

		return $latestElements;

		// Calculate score for each element

		//$score = [ age(minutes) + numViews * (ageMax - ageMin) ] * rand(-0.1 - +0.1);

		// Select element with lowest score, update views info in DB

		// Return selected element
	}
    

    //


}
