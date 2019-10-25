<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">

  <title> @yield('title') </title>
</head>
<body>
  <div id="app">
    @yield('BootStrapBody')
  </div>
  <script src="{{ asset('js/app.js') }}"></script>
  <script src="{{ asset('js/jquery-3.4.1.js') }}"></script>
  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('js/feather.min.js') }}"></script>
  <!-- <script src="{{ asset('js/Chart.min.js') }}"></script>
  <script src="{{ asset('js/dashboard.js') }}"></script> -->
  <script type="text/javascript" src="{{ asset('js/select2.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/i18n/es.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/listaDeEjercicios.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/exercise.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/audio.js') }}"></script>

</body>

</html>