@extends('layouts.BootStrapBody')
@section('title','Asignar Ejercicio')

@section('MainContent')

<h4 class="titleInfo">
  Asignar Ejercicio
</h4>
<br>

<form action="{{ route('ejercicioPacienteGuardar') }}" method="POST" enctype="multipart/form-data">
    @csrf
  <div class="form-group row inputs">
    @if($pacientes != null)
    <div class="col-md-2 col-sm-2 col-lg-2">
        <label for="user">Paciente</label>
        <select name="user" id="user" class="form-control">
          @foreach ($pacientes as $paciente)
            <option value="{{ $paciente->id }}"> {{ $paciente->usuario }} </option>
          @endforeach
        </select>
        <input type="hidden" id="audio_preset_paciente" name="audio_preset_paciente" value="{{ $preset }}">  
      </div>
    @endif  

    <div class="col-md-2 col-sm-2 col-lg-2">
      <input type="hidden" name="View" value="1">
      <label for="ejercicio">Tipo de Ejercicio</label>
      <select name="ejercicio" id="audio_select_ejercicio" class="form-control">
        @foreach ($ejercicio as $ej)
          <option value="{{ $ej->id }}" desc="{{ $ej->descripcion }}"> {{ $ej->nombre }} </option>
        @endforeach
      </select>
    </div>
    <div class="col-md-2 col-sm-2 col-lg-2">
      <label for="es_levodopa">¿Es Levodopa?</label>
      <select id="es_levodopa" name="es_levodopa" class="form-control"><option value=0>NO</option><option value=1>SI</option></select>
    </div>
    <div class="col-md-2 col-sm-4 col-lg-2"  style="display: none;">
      <label for="modo_levodopa">ON/OFF</label>
      <select id="modo_levodopa" name="modo_levodopa" class="form-control"><option value="ON">ON</option><option value="OFF">OFF</option></select>
    </div>
  </div>
<br>
  <div class="form-group row">
    <h6 class="ejercicioInfo" id ="ejercicioInfo"> 
     Descripción del ejercicio:
    </h6>
    <span style="display:inline-block; width:25px;"></span>
    <h6 class="ejercicioDesc" id ="ejercicioDesc"> 
        {{ $ej->descripcion }}
    </h6>
  </div>
  <br>
  <div class="centerButton">
      <button type="submit"> Asignar </button>
  </div>
  
</form>
 

@if ($message = Session::get('success'))
        <!-- Modal -->
<div class="modal fade" id="audioModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Asignacion de Ejercicio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {{ $message }}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm closeButton" data-dismiss="modal">@lang('parkinsoft.closeButton')</button>
      </div>
    </div>
  </div>
</div>
@endif

@endsection

