
@foreach ($tweets_info as $tweet_info)

	<p>
		<img src="{{ $tweet_info['user_profile_img'] }}">
		{{ $tweet_info['tweet_id'] }}, {{ $tweet_info['user_name'] }}
		<br>
		{{ $tweet_info['full_text'] }}
		<br>
	</p>

@endforeach