<!DOCTYPE html>
<html>
<head>
	
	<title>@yield('title')</title>

	<link href="https://fonts.googleapis.com/css?family=Karla&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Jost:wght@500&display=swap" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="{{ asset('css/style_main.css') }}">
	
	@if (session('theme') == 'dark')
		<link rel="stylesheet" type="text/css" href="{{ asset('css/style_dark.css') }}">
	@endif

	<script type="text/javascript" src="{{ asset('js/control-panel.js') }}"></script>

</head>
<body>

	<div id="header">

		<h3 id="header-title" class="header-element">
			/ Live event /
		</h3>

		<div id="header-text" class="header-element">

			Welcome, {{ auth()->user()->name }}

			<a class="header-button" href="{{ route('logout') }}"
	           onclick="event.preventDefault();
	                         document.getElementById('logout-form').submit();">
	            {{ __('Logout') }}
	        </a>

	         | <a href="/theme/switch">Switch theme</a>

	        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
	            @csrf
	        </form>

	        <br>

	    </div>

	</div>

	<div id="subheader">
		<a class="subheader-button" id="suheader-button-account" href="/controlpanel">My account</a>
		<a class="subheader-button" id="suheader-button-events" href="/controlpanel">My events</a>
		<a class="subheader-button" id="suheader-button-help" href="/controlpanel/help">Help</a>
	</div>

	<div id="content">
	
		@yield('content')

	</div>

</body>
</html>