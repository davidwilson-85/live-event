@extends('layout-reg-user')

@section('title', 'LE - Edit Event')

@section('content')

	<div>
		@if (count($user_events) == 0)

			You have no events yet	

		@else

			<p class="section-title">These are your events:</p>

			<table id="table-events">
				<tr>
					<th>
						Name
					</td>
					<th>
						Status
					</td>
					<th>
						Operations
					</td>
				</tr>

				@foreach ($user_events as $event)

					<tr>
						<td>
							/{{ $event->short_name }}
						</td>
						<td>
							Live Now!
						</td>
						<td>
							<a href="/controlpanel/editevent/{{ $event->id }}">Edit</a> 
							<a href="/controlpanel/deleteevent/{{ $event->id }}">Delete</a> 
							<a href="/controlpanel/stats/{{ $event->id }}">Stats</a>
						</td>
					</tr>

				@endforeach

			</table>

		@endif
	</div>

	<div>

		<p class="section-title">Create new event:</p>

		<form method="post" action="/controlpanel/newevent">

			{{ csrf_field() }}

			<div class="newEvent-element">
				<div class="newEvent-label">
					Name of the event:
				</div>
				<div class="newEvent-input">
					<input class="text-input" name="name" type="text" placeholder="Film summit">
				</div>
			</div>
			<div class="newEvent-element">
				<div class="newEvent-label">
					Shortened name (URL-compatible alias):
				</div> 
				<div class="newEvent-input">
					<input class="text-input" name="event-alias" type="text" placeholder="fisum">
				</div>
			</div>
			<div class="newEvent-element">
				<div class="newEvent-label">
					Type of event:
				</div>
				<div class="newEvent-input">
					<select class="dropdown-list" name="event-type" form="">
						<option value="1">Short event</option>
						<option value="2">Long-term event</option>
					</select>
				</div>
			</div>

			<div id="checkBoxStringency">
				<input type="checkbox" class="switch_1" id="stringency">
			</div>

			<button class="form-button" type="submit" name="store">Create</button>

		</form>

	</div>

@endsection