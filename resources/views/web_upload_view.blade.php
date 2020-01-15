Upload your image here

<div class="avatar">
	
	<img id="avatar-img" src="images/">

	<form enctype="multipart/form-data" method="post" action="/areapersonal/imagen">
   	{{ csrf_field() }}
   	<input class="input-file" name="imagen" id="imagen" type="file" onchange="this.form.submit()">
   	<label for="imagen">Cambiar</label>
	</form>

</div>