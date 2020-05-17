<!DOCTYPE html>
<html>
<head>
	<title>@yield('title')</title>
	<link href="https://fonts.googleapis.com/css?family=Karla&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
</head>
<body>

	<div class="header">

		<h3>
			Live event
		</h3>

		<p class="header-text">

			Welcome, {{ auth()->user()->name }}.

			<a class="header-button" href="{{ route('logout') }}"
	           onclick="event.preventDefault();
	                         document.getElementById('logout-form').submit();">
	            {{ __('Logout') }}
	        </a>

	        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
	            @csrf
	        </form>

	    </p>

	</div>

	<div class="subheader">
		<a href="/controlpanel">Control panel</a> |
		<a href="/controlpanel/billing">Billing</a> |
		<a href="controlpanel/help">Help</a>
	</div>
	
	@yield('content')

</body>
</html>