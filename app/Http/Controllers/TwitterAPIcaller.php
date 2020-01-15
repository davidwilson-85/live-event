<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

// Use TwitterAPI wrapper (https://github.com/J7mbo/twitter-api-php)
use App\Http\Controllers\TwitterAPI\TwitterAPIExchange;

class TwitterAPIcaller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index() {

    	// Using TwitterAPIExchange library, get tweets from Twitter API.
    	// $getfield specifies search options
    	// I am using Free Twitter account, which has some limitations:
    	//   - Completeness is not assured
    	//   - Only tweets from the last 7-10 days are returned
    	// For now, I use count=500 and ignore pagination (it seems I get max 100 tweets...)
    	//
    	// TO DO: Change to search by hashtag

		$settings = array(
		    'oauth_access_token' => "2769937384-CQIhnchVnKbE4LkE1ovxIf4ABFmxcbkIPELfduY",
		    'oauth_access_token_secret' => "WmvmmK1qFAK2dShvipvqZ5pNydNziMOoRfwTzRzangxiC",
		    'consumer_key' => "t8a3bkcnnQl8Pfb58yxOBe7XP",
		    'consumer_secret' => "pJbY2Bc5eaCHrV3z1ueCYEIvCivhJlgTpZ1oOmSAEc6SQdt7t4"
		);

		$url = 'https://api.twitter.com/1.1/search/tweets.json';
		$getfield = '?q=climate%change%20-filter:retweets&count=500&tweet_mode=extended';
		$requestMethod = 'GET';

		$twitter = new TwitterAPIExchange($settings);

		$api_response = json_decode($twitter->setGetfield($getfield)
		    ->buildOauth($url, $requestMethod)
		    ->performRequest());

		// I may need to loop through response pages using provided pagination links


		$api_response_array = array();

		foreach ($api_response as $element) {
			$api_response_array[] = $element;
		}

		// For testing:
		//return $api_response_array;

		$tweets_info = array();

		foreach ($api_response_array[0] as $tweet) {

			if (isset($tweet->entities->media[0]->media_url)) {
				$imgs_links = $tweet->entities->media[0]->media_url;
			} else {
				$imgs_links = 'no_imgs';
			}

			$tweets_info[] = array(
				'tweet_id' => $tweet->id,
				'user_name' => $tweet->user->name,
				'user_profile_img' => $tweet->user->profile_image_url,
				'full_text' => $tweet->full_text,
				'imgs_links' => $imgs_links
			);

		}

		return view('twitter_view', ['tweets_info' => $tweets_info]);

    }
}
