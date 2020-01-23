<p>Upload your image here</p>

<div class="">

	<form enctype="multipart/form-data" method="post" action="/upload_image">

   		{{ csrf_field() }}
   	
   		<input class="input-file" name="image" id="image" type="file" onchange="this.form.submit()">
   		<label for="image">Upload</label>
	
	</form>

</div>