
@foreach ($tweets_info as $tweet_info)

	<p>
		<img src="{{ $tweet_info['user_profile_img'] }}">
		{{ $tweet_info['tweet_id'] }}, {{ $tweet_info['user_name'] }}
		<br>
		{{ $tweet_info['full_text'] }}
		<br>

		@if ($tweet_info['img_urls'] != 'no_imgs')
			@foreach ($tweet_info['img_urls'] as $img_url)
				<img src="{{ $img_url }}" width="300">
			@endforeach
		@endif
	</p>

@endforeach