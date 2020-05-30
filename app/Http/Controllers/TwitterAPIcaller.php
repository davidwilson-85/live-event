<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

// Use TwitterAPI wrapper (https://github.com/J7mbo/twitter-api-php)
use App\Http\Controllers\TwitterAPI\TwitterAPIExchange;

use App\Event;
use App\Tweet;

use DateTime;
use DateTimeZone;


class TwitterAPIcaller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function checkEventsScheduling() {

    	/*
    	short_event:
		D == date
		T >= start_time
		T <= end_time

		long_event:
		D >= start_date
		D <= end_date
		T >= start_time
		T <= end_time

		set Twitter command freq at 1 min

		1 min	always
		5 min	00,05,10,15,20,25,30,35,40,45,50,55     t / 5 = whole number
		10 min	00,10,20,30,40,50                       t / 10 = whole number
		...
		60 min	00        								t / 60 = whole number

		checkDate()->checkTime()->checkFfreq()
		*/


		// 1. Get current envents from db and their scheduling info

		$current_events = \DB::table('events')->select('id')->get();
		

		// 2. Obtain current day, time, etc

		$currentDateTime = new DateTime('', new DateTimeZone('Europe/Berlin'));
	    $currentDateTimeFormatted = $currentDateTime->format('Y-m-d H:i:s');
		$currentDate = substr($currentDateTimeFormatted, 0, 10);
		$currentTime = substr($currentDateTimeFormatted, 11, 5);
		$currentMinutes = substr($currentDateTimeFormatted, 14, 2);

		/////////////////////////////////////////////////////////////////////////////////
		//
		// VERY IMPORTANT: At some point I will need to deal with different time zones...
		//
		/////////////////////////////////////////////////////////////////////////////////


		// 3. For each event, get scheduling info from config file. Next, determine if it is due, and run method call()

		foreach ($current_events as $event) {

			if (ConfigLiveevent::readConfig($event->id, 'twitter_enabled') == 'true') {

				$event->type = ConfigLiveevent::readConfig($event->id, 'type');
				$event->date = ConfigLiveevent::readConfig($event->id, 'date');
				$event->date_interval = ConfigLiveevent::readConfig($event->id, 'date_interval');
				$event->time_start = ConfigLiveevent::readConfig($event->id, 'time_start');
				$event->time_stop = ConfigLiveevent::readConfig($event->id, 'time_stop');
				$event->twitter_frequency = ConfigLiveevent::readConfig($event->id, 'twitter_frequency');
				$event->keyword = ConfigLiveevent::readConfig($event->id, 'twitter_keyword');

				if ($event->type == 'hours') {

					//list( $event->dayMatch, $event->timeMatch, $event->freqMatch ) = array( False, False, False );
					
					// Some say equenctial testing is the fastest way (loop is left if a condition is false)
					if (is_int( $currentMinutes / $event->twitter_frequency )) {
							
						if ($event->date == $currentDate) {

							if (strtotime($event->time_start) <= strtotime($currentTime) AND strtotime($event->time_stop) >= strtotime($currentTime)) {
							
								$this->callTwitter($event->id, $event->keyword);
							
							}
						}
					}

				}

			}

		}

		//return $current_events;

		// This should be completed in less than a minute (not a problem I guess)

    }


    public function callTwitter($event_id, $keyword) {
    	
    	//
    	// TO DO:
    	// - Change to search by hashtag
    	// - Change table fields text to varchar because insert queries are taking a long time...
    	// - 
    	// 


		// *******************************************************************
		// Perform Twitter Search API call

    	// Get highest (most recent) tweet_id_str from the database to call API asking only for higher ids
		
		$nbrTweets = Tweet::where('event_id', $event_id)->count();
		
		if ($nbrTweets == 0) {
			$highestTweetIDinDB = 0;
		} else {
			$highestTweetIDinDB = Tweet::where('event_id', $event_id)->orderBy('tweet_id','desc')->first()->tweet_id;
		}


		// Using TwitterAPIExchange library, get tweets from Twitter API.
    	// $getfield specifies search options
    	// I am using Free Twitter account, which has some limitations:
    	//   - Completeness is not assured
    	//   - Only tweets from the last 7-10 days are returned
    	// For now, I use count=500 and ignore pagination (it seems I get max 100 tweets...)

		// From Twitter API docs: "since_id" = Returns results with an ID greater than (that is, more recent than) the specified ID. There are limits to the number of Tweets which can be accessed through the API. If the limit of Tweets has occured since the since_id, the since_id will be forced to the oldest ID available.

		$settings = array();

		$url = 'https://api.twitter.com/1.1/search/tweets.json';
		$getfield = '?q='. $keyword .'%20-filter:retweets&count=500&tweet_mode=extended&since_id='. $highestTweetIDinDB;
		$requestMethod = 'GET';

		$twitter = new TwitterAPIExchange($settings);

		$api_response = json_decode($twitter->setGetfield($getfield)
		    ->buildOauth($url, $requestMethod)
		    ->performRequest());

		// I may need to loop through response pages using provided pagination links


		// *******************************************************************
		// Process API response

		// I store the response in array format
		$api_response_array = array();

		foreach ($api_response as $element) {
			$api_response_array[] = $element;
		}

		// Reverse order of tweets in response data, so direction is older -> newer tweet
		$api_response_array[0] = array_reverse($api_response_array[0]);

		// For testing:
		//return $api_response_array;


		// Create a new array, loop through Twitter response object
		// If tweet id_str > max id in db, add desired info of tweet to the array.

		$tweets_info = array(
			'oauth_access_token' => "2769937384-CQIhnchVnKbE4LkE1ovxIf4ABFmxcbkIPELfduY",
		    'oauth_access_token_secret' => "WmvmmK1qFAK2dShvipvqZ5pNydNziMOoRfwTzRzangxiC",
		    'consumer_key' => "t8a3bkcnnQl8Pfb58yxOBe7XP",
		    'consumer_secret' => "pJbY2Bc5eaCHrV3z1ueCYEIvCivhJlgTpZ1oOmSAEc6SQdt7t4"
		);

		foreach ($api_response_array[0] as $tweet) {

			// Check if tweet has images
			if (isset($tweet->extended_entities)) {
				$img_urls = '';
				foreach ($tweet->extended_entities->media as $media) {
					$img_urls .= $media->media_url .',';
				}
			} else {
				$img_urls = 'no_imgs';
			}

			$tweets_info[] = array(
				'tweet_id' => $tweet->id_str,
				'user_name' => $tweet->user->name,
				'user_profile_img' => $tweet->user->profile_image_url,
				'full_text' => $tweet->full_text,
				'img_urls' => $img_urls
			);

		}

		//return $tweets_info;


		// *******************************************************************
		// Store new tweets in db

		foreach ($tweets_info as $tweet_info) {

			$tweet = new Tweet;
			$tweet->event_id = $event_id;
	    	$tweet->tweet_id = $tweet_info['tweet_id'];
	    	$tweet->user_name = $tweet_info['user_name'];
	    	$tweet->url_user_img = $tweet_info['user_profile_img'];
	    	$tweet->full_text = $tweet_info['full_text'];
	    	$tweet->img_urls = $tweet_info['img_urls'];
	    	$tweet->nbr_views = 0;
	        $tweet->save();
		}

		// For testing
		return $tweets_info;
		//return view('twitter_view', ['tweets_info' => $tweets_info]);

    }

    /*
    // This is the old function called directly from the Scheduler
    public function index() {
    	
    	//
    	// TO DO:
    	// - Change to search by hashtag
    	// - Change table fields text to varchar because insert queries are taking a long time...
    	// - 
    	// 


		// *******************************************************************
		// Perform Twitter Search API call

    	// Get highest (most recent) tweet_id_str from the database to call API asking only for higher ids
		
		$nbrTweets = Tweet::count();
		
		if ($nbrTweets == 0) {
			$highestTweetIDinDB = 0;
		} else {
			$highestTweetIDinDB = Tweet::orderBy('tweet_id','desc')->first()->tweet_id;
		}


		// Using TwitterAPIExchange library, get tweets from Twitter API.
    	// $getfield specifies search options
    	// I am using Free Twitter account, which has some limitations:
    	//   - Completeness is not assured
    	//   - Only tweets from the last 7-10 days are returned
    	// For now, I use count=500 and ignore pagination (it seems I get max 100 tweets...)

		// From Twitter API docs: "since_id" = Returns results with an ID greater than (that is, more recent than) the specified ID. There are limits to the number of Tweets which can be accessed through the API. If the limit of Tweets has occured since the since_id, the since_id will be forced to the oldest ID available.

		$settings = array(
		    'oauth_access_token' => "2769937384-CQIhnchVnKbE4LkE1ovxIf4ABFmxcbkIPELfduY",
		    'oauth_access_token_secret' => "WmvmmK1qFAK2dShvipvqZ5pNydNziMOoRfwTzRzangxiC",
		    'consumer_key' => "t8a3bkcnnQl8Pfb58yxOBe7XP",
		    'consumer_secret' => "pJbY2Bc5eaCHrV3z1ueCYEIvCivhJlgTpZ1oOmSAEc6SQdt7t4"
		);

		$url = 'https://api.twitter.com/1.1/search/tweets.json';
		$getfield = '?q=climate%change%20-filter:retweets&count=500&tweet_mode=extended&since_id='. $highestTweetIDinDB;
		$requestMethod = 'GET';

		$twitter = new TwitterAPIExchange($settings);

		$api_response = json_decode($twitter->setGetfield($getfield)
		    ->buildOauth($url, $requestMethod)
		    ->performRequest());

		// I may need to loop through response pages using provided pagination links


		// *******************************************************************
		// Process API response

		// I store the response in array format
		$api_response_array = array();

		foreach ($api_response as $element) {
			$api_response_array[] = $element;
		}

		// Reverse order of tweets in response data, so direction is older -> newer tweet
		$api_response_array[0] = array_reverse($api_response_array[0]);

		// For testing:
		//return $api_response_array;


		// Create a new array, loop through Twitter response object
		// If tweet id_str > max id in db, add desired info of tweet to the array.

		$tweets_info = array();

		foreach ($api_response_array[0] as $tweet) {

			// Check if tweet has images
			if (isset($tweet->extended_entities)) {
				$img_urls = '';
				foreach ($tweet->extended_entities->media as $media) {
					$img_urls .= $media->media_url .',';
				}
			} else {
				$img_urls = 'no_imgs';
			}

			$tweets_info[] = array(
				'tweet_id' => $tweet->id_str,
				'user_name' => $tweet->user->name,
				'user_profile_img' => $tweet->user->profile_image_url,
				'full_text' => $tweet->full_text,
				'img_urls' => $img_urls
			);

		}

		//return $tweets_info;


		// *******************************************************************
		// Store new tweets in db

		foreach ($tweets_info as $tweet_info) {

			$tweet = new Tweet;
	    	$tweet->tweet_id = $tweet_info['tweet_id'];
	    	$tweet->user_name = $tweet_info['user_name'];
	    	$tweet->url_user_img = $tweet_info['user_profile_img'];
	    	$tweet->full_text = $tweet_info['full_text'];
	    	$tweet->img_urls = $tweet_info['img_urls'];
	    	$tweet->nbr_views = 0;
	        $tweet->save();
		}

		// For testing
		//return $tweets_info;

		// For testing
		//return view('twitter_view', ['tweets_info' => $tweets_info]);

    }
    */
    
}
