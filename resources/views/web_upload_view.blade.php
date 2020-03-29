<p>Upload your image here</p>

<p>You are upploading for event: {{ $event_alias }}</p>
<p>The event id is: {{ $event_id }}</p>

<div class="">

	<form enctype="multipart/form-data" method="post" action="/upload_image">

   		{{ csrf_field() }}
   	
   		<input class="input-file" name="image" id="image" type="file" onchange="this.form.submit()">
   		<label for="image">Upload</label>

   		<input type="hidden" name="event_id" value="{{ $event_id }}">
	
	</form>

	<form method="post" action="/upload_text">

   		{{ csrf_field() }}
   		<input type="hidden" name="event_id" value="{{ $event_id }}">
   	
   		<label for="text">Send text to LiveView</label>
   		<br>
   		<textarea rows="6" cols="70" name="text_contents" id="text"></textarea>
   		<br>
		<button type="submit" name="update">Send!</button>
	</form>

</div>