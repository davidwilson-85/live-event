<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

// Use TwitterAPI wrapper (https://github.com/J7mbo/twitter-api-php)
use App\Http\Controllers\TwitterAPI\TwitterAPIExchange;

use App\Tweet;


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
    	// TO DO:
    	// - Change to search by hashtag
    	// - Change table fields text to varchar because insert queries are taking a long time...
    	// - 

		$settings = array(
		    'oauth_access_token' => "2769937384-CQIhnchVnKbE4LkE1ovxIf4ABFmxcbkIPELfduY",
		    'oauth_access_token_secret' => "WmvmmK1qFAK2dShvipvqZ5pNydNziMOoRfwTzRzangxiC",
		    'consumer_key' => "t8a3bkcnnQl8Pfb58yxOBe7XP",
		    'consumer_secret' => "pJbY2Bc5eaCHrV3z1ueCYEIvCivhJlgTpZ1oOmSAEc6SQdt7t4"
		);

		$url = 'https://api.twitter.com/1.1/search/tweets.json';
		$getfield = '?q=climate%change%20-filter:retweets&count=500&tweet_mode=extended';
		//$getfield = '?q=gaturro%20ganadores%20dedicatoria%20-filter:retweets&count=500&tweet_mode=extended';
		$requestMethod = 'GET';

		$twitter = new TwitterAPIExchange($settings);

		$api_response = json_decode($twitter->setGetfield($getfield)
		    ->buildOauth($url, $requestMethod)
		    ->performRequest());

		// I may need to loop through response pages using provided pagination links

		// I store the response in array format
		$api_response_array = array();

		foreach ($api_response as $element) {
			$api_response_array[] = $element;
		}

		// Reverse order of tweets in response data, so direction is older -> newer tweet
		$api_response_array[0] = array_reverse($api_response_array[0]);




		// Delete from response tweets that are already in the database

		// (database could be empty!!!!!!!!!!)

		$highest_tweet_id = 0;
		$highest_tweet_id = Tweet::orderBy('tweet_id','desc')->first()->tweet_id;
		//return $highest_tweet_id;











		// For testing:
		//return $api_response_array;


		// Create a new array, loop through Twitter response object
		// If tweet id_str > max id in db, add desired info of tweet to the array.

		$tweets_info = array();

		foreach ($api_response_array[0] as $tweet) {

			if ($tweet->id_str > $highest_tweet_id) {

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

		}

		//return $tweets_info;

		// Store new tweets in db

		foreach ($tweets_info as $tweet_info) {

			$tweet = new Tweet;
	    	$tweet->tweet_id = $tweet_info['tweet_id'];
	    	$tweet->user_name = $tweet_info['user_name'];
	    	$tweet->url_user_img = $tweet_info['user_profile_img'];
	    	$tweet->full_text = $tweet_info['full_text'];
	    	$tweet->img_urls = $tweet_info['img_urls'];
	        $tweet->save();
		}

		return $tweets_info;

		return view('twitter_view', ['tweets_info' => $tweets_info]);

    }

    public function compare() {

		//

    }
}
