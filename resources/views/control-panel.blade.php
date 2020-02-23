<h3>
	Live event - Control panel
</h3>

<p>
	<form method="post" action="/controlpanel/name" id="form-update-name">
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
	<form method="post" action="/controlpanel/web_enabled" id="form-update-web_enabled">
 		{{ csrf_field() }}
 		{{ method_field('PATCH') }}

 		<input type="hidden" name="hidden" value="boolean">
 		<label for="Web enabled"> Web enabled: </label>

 		@if ($web_enabled == 'true')
 			<input type="checkbox" id="web_enabled" name="web_enabled" checked onchange="this.form.submit()">
 		@elseif ($web_enabled == 'false')
 			<input type="checkbox" id="web_enabled" name="web_enabled" onchange="this.form.submit()">
 		@endif

 		
 	</form>
</p>

<p>
	Web image upload enabled: {{ $web_uploadImages }}
</p>

<p>
	Web text upload enabled: {{ $web_uploadText }}
</p>