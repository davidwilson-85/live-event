@extends('layout-reg-user')

@section('title', 'LE - Control Panel')

@section('content')

	<h3>
		{{ $name }}
	</h3>

	<p class="control-panel-tab-selector" style="background-color: yellow">
		<a href="/liveview/init/{{ $event_id }}" target="_blank">Go to Live View</a> |
		<a href="/{{ $event_alias }}">Go to Upload Page</a> |
		<a href="#">See event stats</a> |
		<a href="#">Moderator page</a>
	</p>

	

@endsection