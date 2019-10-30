<li id="actions" class="nav-item dropdown hideAction">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" 
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        @lang('parkinsoft.accionDropdown')
    </a>
    
    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink"> 
    @if (Auth::user()->rol->type == 0) 
        <a class="dropdown-item" href="{{ route('tickets') }}">
            @lang('parkinsoft.ticketsLink')
        </a>
    @endif
        <a class="dropdown-item" href="{{ route('contact') }}">
            @lang('parkinsoft.contactLink')
        </a>

        <a class="dropdown-item" href="{{ route('audio') }}">
            @lang('parkinsoft.uploadAudio')
        </a>

        @if (Auth::user()->rol->type == 0 || Auth::user()->rol->type == 1 ) 
        <a class="dropdown-item" href="{{ route('TestLevodopa') }}">
            @lang('parkinsoft.levodopaTest')
        </a>
        @endif

        @if (Auth::user()->rol->type == 0) 
        <a class="dropdown-item" href="{{ route('medico.index') }}">
            @lang('parkinsoft.abmMedicLink')
        </a>
        @endif

        @if (Auth::user()->rol->type == 0 || Auth::user()->rol->type == 1) 
        <a class="dropdown-item" href="{{ route('abmUser.index') }}">
            @lang('parkinsoft.abmUserLink')
        </a>
        @endif

        @if (Auth::user()->rol->type == 0) 
        <a class="dropdown-item" href="{{ route('abmAdmin.index') }}">
            @lang('parkinsoft.abmAdminLink')
        </a>
        @endif

        @if (Auth::user()->rol->type == 0 || Auth::user()->rol->type == 1 ) 
        <a class="dropdown-item" href="{{ route('operacion.index') }}">
            @lang('parkinsoft.operacionLink')
        </a>
        @endif  
        @if (Auth::user()->rol->type == 0) 
        <a class="dropdown-item" href="{{ route('BaseDeDatos') }}">
            @lang('parkinsoft.BDLink')
        </a>
        @endif    

        @if (Auth::user()->rol->type == 0 || Auth::user()->rol->type == 1) 
            <a class="dropdown-item" href="{{ route('abmEjercicio.index') }}">
                @lang('parkinsoft.abmExerciseLink')
            </a>
        @endif

        <a class="dropdown-item" href="{{ route('listaDeEjerciciosRealizados') }}">
            @lang('parkinsoft.audioListLink')
        </a>
        <a class="dropdown-item" href="{{ route('listaDeEjerciciosAsignados') }}">
            @lang('parkinsoft.audioListLinkAssigned')
        </a>

        <form action="{{ route('donwloadApk') }}" method="GET">
            @csrf
            <a class="dropdown-item" href="{{ route('donwloadApk') }}" data-toggle="tooltip">
                @lang('parkinsoft.downloadAppLink')
            </a>
        </form>
    </div>

</li>
