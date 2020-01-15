
		



@foreach ($tweets_info as $tweet_info)

	<p>
		<img src="{{ $tweet_info['user_profile_img'] }}">
		{{ $tweet_info['tweet_id'] }}, {{ $tweet_info['user_name'] }}
		<br>
		{{ $tweet_info['full_text'] }}
		<br>

		@if ($tweet_info['imgs_links'] != 'no_imgs')
			<img src="{{ $tweet_info['imgs_links'] }}" width="300">
		@endif
	</p>

@endforeach