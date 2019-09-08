<div class="sidebar-sticky">
  <ul class="nav flex-column">
    <!-- <li class="nav-item">
      <a class="nav-link active" href="../dash">
        <span data-feather="layout"></span>
        Dashboard <span class="sr-only">(current)</span>
      </a>
    </li> -->
    <li class="nav-item">
      <a class="nav-link" href="../tickets">
        <span data-feather="file"></span>
        Tickets
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="../contact">
        <span data-feather="users"></span>
        Contactanos
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="../sendemail">
        <span data-feather="mail"></span>
        Enviar Mail
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="../audio">
        <span data-feather="music"></span>
        Cargar Audio
      </a>
    </li>
    <!-- <h5>Deberia ser medico para ver esto</h5> -->
    <li class="nav-item">
      <a class="nav-link" href="../TestLevodopa">
        <span data-feather="activity"></span> 
        Test de Levodopa
      </a>
    </li>  
    <li class="nav-item">
      <a class="nav-link" href="../audio/graphic">  
        <span data-feather="activity"></span> 
        Visualizar graficos
      </a>
    </li>  
    <!-- <h5>Deberia ser admin para ver esto</h5> -->
    @if (Auth::user()->rol->type == 0) 
    <li class="nav-item">
      <a class="nav-link" href="../medico">
        <span data-feather="activity"></span>
        ABM Medicos
      </a>
    </li>  
     @endif 
     @if (Auth::user()->rol->type == 0) 
    <li class="nav-item">
      <a class="nav-link" href="../abmUser">
        <span data-feather="heart"></span>
        ABM Usuarios
      </a>
    </li>
     @endif 
     @if (Auth::user()->rol->type == 0) 
    <li class="nav-item">
      <a class="nav-link" href="../abmAdmin">
        <span data-feather="activity"></span>
        ABM Administradores
      </a>
    </li>
     @endif  
     @if (Auth::user()->rol->type == 0) 
    <li class="nav-item">
      <a class="nav-link" href="../abmEjercicio">
        <span data-feather="activity"></span>
        ABM Ejercicios
      </a>
    </li>
     @endif  
  </ul>

</div>