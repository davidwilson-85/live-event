<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

// Use TwitterAPI wrapper (https://github.com/J7mbo/twitter-api-php)
use App\Http\Controllers\TwitterAPI\TwitterAPIExchange;

use App\Tweet;

class CallTwitterAPI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'twitterapi:call';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Call the Twitter API to get info of desired tweets';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tweet = new Tweet;
        $tweet->tweet_id = 0000;
        $tweet->user_name = 'cron test';
        $tweet->url_user_img = 'cron test';
        $tweet->full_text = 'cron test';
        $tweet->img_urls = 'cron test';
        $tweet->save();
    }
}
