<h3>
	Live event - Control panel
</h3>

<p>
	<a href="/liveview/init/{{ $id }}" target="_blank">Go to LiveView</a>
</p>

Main settings ===========================================

<p>
	<form method="post" action="/controlpanel/{{ $id }}/name" id="form-update-name">
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
	Event image: Here show as in first Laravel project.
</p>

<p>
	Event length: Hours | Days
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

Content settings ===========================================

<p>
	<form method="post" action="/controlpanel/{{ $id }}/web_enabled" id="form-update-web_enabled">
 		{{ csrf_field() }}
 		{{ method_field('PATCH') }}

 		<input type="hidden" name="hidden" value="boolean">

 		<label for="Web enabled">Web enabled:</label>
		<input type="checkbox" id="web_enabled" name="boolean" {{ $web_enabled == 'true' ? 'checked' : '' }} onchange="this.form.submit()">
 	</form>
</p>

<p>
	<form method="post" action="/controlpanel/{{ $id }}/web_upload_images" id="form-update-web_upload_images">
 		{{ csrf_field() }}
 		{{ method_field('PATCH') }}

 		<input type="hidden" name="hidden" value="boolean">

 		<label for="Web enabled">Web image upload enabled:</label>
 		<input type="checkbox" id="web_upload_images" name="boolean" {{ $web_upload_images == 'true' ? 'checked' : '' }} onchange="this.form.submit()">
 	</form>
</p>

<p>
	<form method="post" action="/controlpanel/{{ $id }}/web_upload_text" id="form-update-web_upload_text">
 		{{ csrf_field() }}
 		{{ method_field('PATCH') }}

 		<input type="hidden" name="hidden" value="boolean">

 		<label for="Web enabled">Web text upload enabled:</label>
 		<input type="checkbox" id="web_upload_text" name="boolean" {{ $web_upload_text == 'true' ? 'checked' : '' }} onchange="this.form.submit()">
 	</form>
</p>

<p>
	<form method="post" action="/controlpanel/{{ $id }}/twitter_enabled" id="form-update-twitter_enabled">
 		{{ csrf_field() }}
 		{{ method_field('PATCH') }}

 		<input type="hidden" name="hidden" value="boolean">

 		<label for="Twitter enabled">Twitter enabled:</label>
		<input type="checkbox" id="twitter_enabled" name="boolean" {{ $twitter_enabled == 'true' ? 'checked' : '' }} onchange="this.form.submit()">
 	</form>
</p>

<p>
	<form method="post" action="/controlpanel/{{ $id }}/twitter_hashtags" id="form-update-twitter_hashtags">
 		{{ csrf_field() }}
 		{{ method_field('PATCH') }}

 		<label for="name"> Twitter hashtags (separated by a space): </label>
 		<input type="text" id="twitter_hashtags" name="newValue" placeholder="{{ $twitter_hashtags }}">
 		<input type="hidden" name="hidden" value="string">
 		<button type="submit" name="update">Update</button>
 	</form>
</p>