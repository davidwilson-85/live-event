<p>Upload your image here</p>

<p>You are upploading for event_alias {{ $event_alias }} and event_id {{ $event_id }}</p>

<div class="">

	<form enctype="multipart/form-data" method="post" action="/upload_image">

   		{{ csrf_field() }}
   	
   		<input class="input-file" name="image" id="image" type="file" onchange="this.form.submit()">
   		<label for="image">Upload</label>
	
	</form>

</div>