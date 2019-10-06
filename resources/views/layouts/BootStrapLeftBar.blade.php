<div class="sidebar-sticky">
  <ul class="nav flex-column">

    <li class="nav-item">
      <a class="nav-link" href="{{ route('tickets') }}">
        <span data-feather="file"></span>
        @lang('parkinsoft.ticketsLink')
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('contact') }}">
        <span data-feather="users"></span>
        @lang('parkinsoft.contactLink')
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('audio') }}">
        <span data-feather="music"></span>
        @lang('parkinsoft.uploadAudio')
      </a>
    </li>
    <!-- <h5>Deberia ser medico para ver esto</h5> -->
    <li class="nav-item">
      <a class="nav-link" href="{{ route('TestLevodopa') }}">
        <span data-feather="activity"></span> 
        @lang('parkinsoft.levodopaTest')
      </a>
    </li>  
    <!-- <h5>Deberia ser admin para ver esto</h5> -->
    @if (Auth::user()->rol->type == 0) 
    <li class="nav-item">
      <a class="nav-link" href="{{ route('medico.index') }}">
        <span data-feather="activity"></span>
        ABM Medicos
      </a>
    </li>  
     @endif 
     @if (Auth::user()->rol->type == 0) 
    <li class="nav-item">
      <a class="nav-link" href="{{ route('abmUser.index') }}">
        <span data-feather="heart"></span>
        ABM Usuarios
      </a>
    </li>
     @endif 
     @if (Auth::user()->rol->type == 0) 
    <li class="nav-item">
      <a class="nav-link" href="{{ route('abmAdmin.index') }}">
        <span data-feather="activity"></span>
        ABM Administradores
      </a>
    </li>
     @endif  
     @if (Auth::user()->rol->type == 0) 
    <li class="nav-item">
      <a class="nav-link" href="{{ route('abmEjercicio.index') }}">
        <span data-feather="activity"></span>
        ABM Ejercicios
      </a>
    </li>
     @endif  
     @if (Auth::user()->rol->type == 0) 
    <li class="nav-item">
      <a class="nav-link" href="{{ route('listaDeEjercicios') }}">
        <span data-feather="activity"></span>
        Lista de Audios
      </a>
    </li>
     @endif  
     <li class="nav-item">
      <a class="nav-link" href="{{ route('listaDeEjercicios') }}">
        <span data-feather="activity"></span>
        Lista de Audios
      </a>
    </li>
     <form action="{{ route('donwloadApk') }}" method="GET">
      @csrf
        <a class="nav-link" href="{{ route('donwloadApk') }}" data-toggle="tooltip" title="Mostrar">
          <span data-feather="eye"></span>
              Descargar App
        </a>
      </form>
  </ul>

</div>