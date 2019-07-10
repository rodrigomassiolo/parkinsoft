<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="home">Higia</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">

    @if (Auth::guest())
    <ul class="navbar-nav ml-auto">
      <li><a  class="nav-link" href="{{ route('login') }}">Login</a></li>
      <li><a  class="nav-link" href="{{ route('register') }}">Register</a></li>
    </ul>
    @else
      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              {{ Auth::user()->usuario }}
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">

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


