<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>
		<link rel="icon" href="{{ asset('/public/img/twitter-icon.png') }}" type="image/png"/>
		<link rel="shortcut icon" href="{{ asset('/public/img/twitter-icon.png') }}" type="image/png"/>
		<!-- Scripts -->
		<script src="{{ asset('js/common.js') }}"></script>
		<script src="{{ asset('js/front.js') }}"></script>
		<script src="{{ asset('js/app.js') }}"></script>
		<script src="{{ asset('js/datatables.min.js') }}"></script>
		<script src="{{ asset('js/jquery.nicescroll.min.js') }}"></script>
		<script src="{{ asset('js/jquery.fancybox.min.js') }}"></script>
		<script src="{{ asset('js/scripts.js') }}"></script>
		<!-- Styles -->
		<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
		<link href="{{ asset('css/jquery.fancybox.min.css') }}" rel="stylesheet">
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('css/updates.css') }}" rel="stylesheet">
	</head>
	<body class="fancybox_form_body">
		    <div class="wrapper">
				<!-- Page Content  -->
				<div id="content">
					<!--Info Top---->
					<div class="inner-info">
						@include('layouts.flash-message')
						@yield('content')
					</div>
				</div>
			</div>
	</body>
</html>
