<!DOCTYPE html>
<html>
<head>
	
	<title>@yield('title')</title>
	<link href="https://fonts.googleapis.com/css?family=Karla&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Jost:wght@500&display=swap" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="{{ asset('css/style_main.css') }}">
	
	@if (session('theme') == 'light')
		<link rel="stylesheet" type="text/css" href="{{ asset('css/style_light.css') }}">
	@else
		<link rel="stylesheet" type="text/css" href="{{ asset('css/style_dark.css') }}">
	@endif

</head>
<body>

	<div class="header">

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

	    </div>

	</div>

	<div class="subheader">
		<a class="subheader-button" href="/controlpanel">My account</a>
		<a class="subheader-button" href="/controlpanel">My events</a>
		<a class="subheader-button" href="/controlpanel/billing">Billing</a>
		<a class="subheader-button" href="controlpanel/help">Help</a>
	</div>
	
	@yield('content')

</body>
</html>