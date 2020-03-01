<!DOCTYPE html>
<html>
<head>
	<title>LiveView</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
	<script type="text/javascript" src="{{ asset('js/javascript.js') }}"></script>
</head>

<body>






Ajax start

<div id="ajax-test">

</div>

Ajax end






<div id="selected_id">
	id:
</div>

<div id="img">
	<img id="selected_img" src="" width="700px">
</div>



{{--


<p>
	type: {{ $selected_element->type}}
</p>

<p>
	id: {{ $selected_element->id }}
</p>

<p>
	user_name: {{ $selected_element->user_name }}
</p>

<p>
	full text: {{ $selected_element->full_text }}
</p>

<p>
	nbr views: {{ $selected_element->nbr_views }}
</p>

@if ($selected_element->type == 'tweet')

	<p>
		<img src="{{ $selected_element->imgs[0] }}" width="1000px">
	</p>

@endif

@if ($selected_element->type == 'web_upload')

	<p>
		<img src="uploadedImages/{{ $selected_element->imgs[0] }}" width="1000px">
	</p>

@endif

--}}

</body>
</html>