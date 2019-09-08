<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="stylesheet" href="/css/bootstrap.css">
  <title> @yield('title') </title>
</head>
<body>
  <div id="app">
    @yield('BootStrapBody')
  </div>
  <script src="{{ asset('js/app.js') }}"></script>
  <script src="{{ asset('js/jquery-slim.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('js/feather.min.js') }}"></script>
  <script src="{{ asset('js/Chart.min.js') }}"></script>
  <script src="{{ asset('js/dashboard.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/listaDeEjercicios.js') }}"></script>

</body>

</html>