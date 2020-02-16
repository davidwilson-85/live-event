

<p>
	{{ $selected_tweet->id }}
</p>

<p>
	{{ $selected_tweet->user_name }}
</p>

<p>
	{{ $selected_tweet->full_text }}
</p>

<p>
	{{ $selected_tweet->nbr_views }}
</p>

<p>
	<img src="{{ $selected_tweet->img_urls[0] }}" width="1000px">
</p>