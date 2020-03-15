<h3>
	Live event - Control panel
</h3>

<p>
	Alias (URL to acces for web-uploading to this event): {{ $event_alias }}
</p>

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
	Security: {{ $security }}
</p>

<p>
	Language: {{ $language }}
</p>

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
	Web text upload enabled: {{ $web_upload_text }}
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