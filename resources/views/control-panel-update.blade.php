@extends('layout-reg-user')

@section('title', 'LE - Control Panel')

@section('content')

	<h2 style="padding: 5px 0px 15px 0px;">
		{{ $name }}
	</h2>

	<div id="tab-selectors-panel">
		<a class="tab-selector" href="#">Edit Event</a>
		<a class="tab-selector" href="#">See Event Stats</a>
		<a class="tab-selector" href="#">Moderate Content</a>
	</div>

	<div id="separator"></div>

	<p>
		<form method="post" action="/controlpanel/{{ $event_id }}/name" id="form-update-name">
	 		{{ csrf_field() }}
	 		{{ method_field('PATCH') }}

	 		<label for="name"> Name: </label>
	 		<input type="text" id="name" name="newValue" placeholder=" {{ $name }} ">
	 		<input type="hidden" name="hidden" value="string">
	 		<button type="submit" name="update">Update</button>
	 	</form>
	</p>

	<p>
		Alias (URL to access for web-uploading to this event): <a href="/{{ $event_alias }}">livent.com/{{ $event_alias }}</a>
	</p>

	<p>
		<a href="/liveview/init/{{ $event_id }}" target="_blank">Go to LiveView</a>
	</p>

	<p>
		Event image:
	</p>

	<div class="avatar">
		
		<img id="avatar-img" src="{{ URL::to('/') }}/images/eventImages/{{ $title_image }}" height="100px" width="100px">

		<form enctype="multipart/form-data" method="post" action="/controlpanel/editevent/{event_id}/uploadImage">
	   		{{ csrf_field() }}
	   		<input class="input-file" name="image" id="image" type="file" onchange="this.form.submit()">
	   		<label for="image">Change</label>
	   		<input type="hidden" name="event_id" value="{{ $event_id }}">
		</form>

	</div>

	<p>
		Event length: Hours | Days
	</p>

	<p>
		<form method="post" action="/controlpanel/{{ $event_id }}/date" id="form-update-date">
	 		{{ csrf_field() }}
	 		{{ method_field('PATCH') }}

	 		<label for="date"> Date: </label>
	 		<input type="text" id="date" name="newValue" placeholder=" {{ $date }} ">
	 		<input type="hidden" name="hidden" value="string">
	 		<button type="submit" name="update">Update</button>
	 	</form>
	</p>
	
	<p>
		<form method="post" action="/controlpanel/{{ $event_id }}/time_start" id="form-update-time_start">
	 		{{ csrf_field() }}
	 		{{ method_field('PATCH') }}

	 		<label for="time_start"> Start: </label>
	 		<input type="text" id="time_start" name="newValue" placeholder=" {{ $time_start }} ">
	 		<input type="hidden" name="hidden" value="string">
	 		<button type="submit" name="update">Update</button>
	 	</form>
	</p>

	<p>
		<form method="post" action="/controlpanel/{{ $event_id }}/time_stop" id="form-update-time_start">
	 		{{ csrf_field() }}
	 		{{ method_field('PATCH') }}

	 		<label for="time_stop"> End: </label>
	 		<input type="text" id="time_stop" name="newValue" placeholder=" {{ $time_stop }} ">
	 		<input type="hidden" name="hidden" value="string">
	 		<button type="submit" name="update">Update</button>
	 	</form>
	</p>

	<p>
		Security: {{ $security }}
		<br>
		<a href="#">Go to moderator view</a>
	</p>

	<p>
		LiveView display mode: Single | Double | Triple | Grid | Mosaic
	</p>

	<p>
		Language: {{ $language }}
	</p>

	===========================================

	<p>
		<form method="post" action="/controlpanel/{{ $event_id }}/web_enabled" id="form-update-web_enabled">
	 		{{ csrf_field() }}
	 		{{ method_field('PATCH') }}

	 		<input type="hidden" name="hidden" value="boolean">

	 		<label for="Web enabled">Web enabled:</label>
			<input type="checkbox" class="switch_1" id="web_enabled" name="boolean" {{ $web_enabled == 'true' ? 'checked' : '' }} onchange="this.form.submit()">
	 	</form>
	</p>

	<p>
		<form method="post" action="/controlpanel/{{ $event_id }}/web_upload_images" id="form-update-web_upload_images">
	 		{{ csrf_field() }}
	 		{{ method_field('PATCH') }}

	 		<input type="hidden" name="hidden" value="boolean">

	 		<label for="Web enabled">Web image upload enabled:</label>
	 		<input type="checkbox" class="switch_1" id="web_upload_images" name="boolean" {{ $web_upload_images == 'true' ? 'checked' : '' }} onchange="this.form.submit()">
	 	</form>
	</p>

	<p>
		<form method="post" action="/controlpanel/{{ $event_id }}/web_upload_text" id="form-update-web_upload_text">
	 		{{ csrf_field() }}
	 		{{ method_field('PATCH') }}

	 		<input type="hidden" name="hidden" value="boolean">

	 		<label for="Web enabled">Web text upload enabled:</label>
	 		<input type="checkbox" class="switch_1" id="web_upload_text" name="boolean" {{ $web_upload_text == 'true' ? 'checked' : '' }} onchange="this.form.submit()">
	 	</form>
	</p>

	===========================================

	<p>
		<form method="post" action="/controlpanel/{{ $event_id }}/twitter_enabled" id="form-update-twitter_enabled">
	 		{{ csrf_field() }}
	 		{{ method_field('PATCH') }}

	 		<input type="hidden" name="hidden" value="boolean">

	 		<label for="Twitter enabled">Twitter enabled:</label>
			<input type="checkbox" class="switch_1" id="twitter_enabled" name="boolean" {{ $twitter_enabled == 'true' ? 'checked' : '' }} onchange="this.form.submit()">
	 	</form>
	</p>

	<p>
		<form method="post" action="/controlpanel/{{ $event_id }}/twitter_keyword" id="form-update-twitter_keyword">
	 		{{ csrf_field() }}
	 		{{ method_field('PATCH') }}

	 		<label for="name"> Twitter keyword: </label>
	 		<input type="text" id="twitter_keyword" name="newValue" placeholder="{{ $twitter_keyword }}">
	 		<input type="hidden" name="hidden" value="string">
	 		<button type="submit" name="update">Update</button>
	 	</form>
	</p>

	<p>
	 	<form method="post" action="/controlpanel/{{ $event_id }}/twitter_hashtags" id="form-update-twitter_hashtags">
	 		{{ csrf_field() }}
	 		{{ method_field('PATCH') }}

	 		<label for="name"> Twitter hashtags (separated by a space): </label>
	 		<input type="text" id="twitter_hashtags" name="newValue" placeholder="{{ $twitter_hashtags }}">
	 		<input type="hidden" name="hidden" value="string">
	 		<button type="submit" name="update">Update</button>
	 	</form>
	</p>

	<p>
	 	<form method="post" action="/controlpanel/{{ $event_id }}/twitter_frequency" id="form-update-twitter_frequency">
	 		{{ csrf_field() }}
	 		{{ method_field('PATCH') }}

	 		<label for="name"> Twitter frequency: </label>
	 		<input type="text" id="twitter_frequency" name="newValue" placeholder="{{ $twitter_frequency }}">
	 		<input type="hidden" name="hidden" value="string">
	 		<button type="submit" name="update">Update</button>
	 	</form>
	</p>

@endsection