@extends('layouts.BootStrap')
@section('BootStrapBody')
  @yield('BootStrapTopBar',View::make('layouts.BootStrapTopBar'))
  <div class="container-fluid" style="margin-top: 0px;">
    <div class="row">
      @if (Auth::guest())
          <main role="main" class="col-md-12 ml-sm-auto col-lg-12">
            @yield('MainContent')
          </main>
      @else
          <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            @yield('BootStrapLeftBar',View::make('layouts.BootStrapLeftBar'))
          </nav>
          <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            @yield('MainContent')
          </main>
      @endif
    </div>
  </div>
@endsection