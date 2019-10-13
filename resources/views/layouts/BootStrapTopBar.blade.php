<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="home">Higia</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">

    @if (Auth::guest())
    <ul class="navbar-nav ml-auto">

      <li class="nav-item dropdown">

        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" 
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Idioma
        </a>

        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink"> 
          <a class="dropdown-item" href="{{ URL::to('en') }}">
              English
              <img class="img-fluid flag" style="width:20%" src="{{asset('/img/gb.svg')}}">
          </a>

          <a class="dropdown-item" href="{{ URL::to('es') }}">
              Español
              <img class="img-fluid flag" style="width:20%" src="{{asset('/img/es.svg')}}">
          </a>

        </div>
      </li>
      <li><a  class="nav-link" href="{{ route('infosite') }}">Info. del sitio</a></li>
      <li><a  class="nav-link" href="{{ route('infoproj') }}">Info. del projecto</a></li>
      <li><a  class="nav-link" href="{{ route('login') }}">Login</a></li>
      <li><a  class="nav-link" href="{{ route('register') }}">Registrar</a></li>
    </ul>
    @else
      <ul class="navbar-nav ml-auto">
        
      @yield('LeftBarCollapsed',View::make('layouts.LeftBarCollapsed'))

        <li class="nav-item dropdown">

          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" 
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Idioma
          </a>

          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink"> 
            <a class="dropdown-item" href="{{ URL::to('en') }}">
                English
                <img class="img-fluid flag" style="width:20%" src="{{asset('/img/gb.svg')}}">
            </a>

            <a class="dropdown-item" href="{{ URL::to('es') }}">
                Español
                <img class="img-fluid flag" style="width:20%" src="{{asset('/img/es.svg')}}">
            </a>

          </div>
        </li>

        <li><a  class="nav-link" href="{{ route('infosite') }}">Info. del sitio</a></li>
        <li><a  class="nav-link" href="{{ route('infoproj') }}">Info. del projecto</a></li>

        <li class="nav-item dropdown">  
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" 
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              {{ Auth::user()->usuario }}
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">

            <a class="dropdown-item" href="{{ route('user') }}">Datos</a>
            <a class="dropdown-item" href="{{ route('user/delete') }}">Eliminar</a>
            <a class="dropdown-item" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>


          </div>
        </li>
      </ul>
    @endif
    </div>
  </nav>


