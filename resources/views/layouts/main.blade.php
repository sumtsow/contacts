<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name') }}</title>
		<!-- Scripts -->
		<script src="{{ asset('js/app.js') }}" defer></script>
		<script src="{{ asset('js/bootstrap.bundle.min.js') }}" defer></script>
		<!-- Styles -->
		<link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <body>
      <div id="app">
        @yield('nav')
        @yield('content')
        @yield('footer')
      </div>
    </body>
</html>
