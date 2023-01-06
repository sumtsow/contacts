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
      </div>
    </body>
</html>
