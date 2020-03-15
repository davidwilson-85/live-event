<h3>
	Live event - Control panel
</h3>

<p>
	@if (count($user_events) == 0)

		You have no events yet	

	@else

		@foreach ($user_events as $event)

			{{ $event->event_alias }} -- 
			Go to LiveView -- 
			<a href="/controlpanel/{{ $event->id }}">Edit</a> -- 
			Delete
			<br>

		@endforeach

	@endif
</p>

<p>

	Create new event:

	<form method="post" action="/controlpanel/newevent">

		{{ csrf_field() }}

		Name of the event:<br>
		<input name="name" type="text" placeholder="Film summit"><br>
		Shortened name (URL-compatible alias):<br>
		<input name="event-alias" type="text" placeholder="fisum"><br>

		Type of event:<br>
		<select name="event-type" form="">
			<option value="1">Short event</option>
			<option value="2">Long-term event</option>
		</select>
		<br><br>

		<button type="submit" name="store">Create</button>

	</form>

</p>