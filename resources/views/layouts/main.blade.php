<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="user" content="{{ auth()->user()['name'] ?? '' }}">
        <title>{{ config('app.name') }}</title>
		<!-- Scripts -->
		<script src="{{ asset('js/app.js') }}" defer></script>
		<script src="{{ asset('js/bootstrap.bundle.min.js') }}" defer></script>
		<!-- Styles -->
		<link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <body>
      <div id="app" class="container">
        @yield('nav')
        @yield('content')
				<button type="button" class="btn btn-light border border-secondary position-fixed bottom-0 end-0 m-3" onclick="window.scrollTo({top: 0, behavior: 'smooth'});">&uArr;</button>
      </div>
    </body>
</html>
