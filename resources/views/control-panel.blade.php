@extends('layout-reg-user')

@section('title', 'LE - Edit Event')

@section('content')

	<p>
		@if (count($user_events) == 0)

			You have no events yet	

		@else

			<table id="table-events">
				<tr>
					<th>
						Name
					</td>
					<th>
						Status
					</td>
					<th>
						Edit
					</td>
				</tr>
				<tr>
					<td>
						climate
					</td>
					<td>
						Upcomming
					</td>
					<td>
						Edit
					</td>
				</tr>
				<tr>
					<td>
						mercadona
					</td>
					<td>
						Live now!
					</td>
					<td>
						Edit
					</td>
				</tr>
				<tr>
					<td>
						wparty
					</td>
					<td>
						Closed
					</td>
					<td>
						Edit
					</td>
				</tr>
			</table>

			@foreach ($user_events as $event)

				{{ $event->short_name }} --  
				<a href="/controlpanel/editevent/{{ $event->id }}">Edit</a> -- 
				<a href="/controlpanel/deleteevent/{{ $event->id }}">Delete</a> --
				<a href="/controlpanel/stats/{{ $event->id }}">Stats</a>
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

@endsection