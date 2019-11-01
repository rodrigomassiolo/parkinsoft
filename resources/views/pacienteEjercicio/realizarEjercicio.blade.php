@extends('layouts.BootStrapBody')
@section('title','Realizar Ejercicio')

@section('MainContent')

<h4 class="titleInfo">
  Realizar Ejercicio
</h4>
<br>

<form action="{{ route('sendAudio') }}" method="POST" enctype="multipart/form-data">
    @csrf
  <div class="form-group row inputs">
    @if($pacientes != null)
    <div class="col-md-3 col-sm-3 col-lg-3">
        <label for="user">Paciente</label>
        <select name="user" id="user" class="form-control">
            <option value="{{ $pacientes->id }}"> {{ $pacientes->usuario }} </option>
        </select>
      </div>
    @endif  
    <div class="col-md-3 col-sm-3 col-lg-3">
      <input type="hidden" name="Realizado" value="1">
      <input type="hidden" name="paciente_ejercicio" value="{{$pacienteEjercicio_id}}">
      <label for="ejercicio">Tipo de Ejercicio</label>
      <select name="ejercicio" id="audio_select_ejercicio" class="form-control">
        <option value="{{ $ejercicio->id }}" desc="{{ $ejercicio->descripcion }}"> {{ $ejercicio->nombre }} </option>
      </select>
    </div>
  </div>
  <div class="form-group row">
      <h6 class="ejercicioInfo" id ="ejercicioInfo"> 
       Descripción del ejercicio:
      </h6>
      <span style="display:inline-block; width:25px;"></span>
      <h6 class="ejercicioDesc" id ="ejercicioDesc"> 
          {{ $ejercicio->descripcion }}
      </h6>
    </div>
  <div class="form-group row inputs">
    <div class="col-md-6 col-sm-6 col-lg-6">
      <label for="audio">Cargue un Audio</label>
      <input type="file" class="form-control-file" id="audio" name="audio">
    </div>
    <div class="col-md-2 col-sm-2 col-lg-2">
      <strong>@lang('parkinsoft.exerciseAudio'):</strong>
      <a class="btn btn-success btn-sm" id="btnExample" href=""
          data-toggle="tooltip" title="Descargar Audio de Ejemplo"> 
          <span data-feather="download"></span>
          @lang('parkinsoft.exerciseDownload')
      </a>
    </div>
    <div class="col-md-4 col-sm-4 col-lg-4">
        <label for="origen_audio">Calidad del audio</label>
        <select id="origen_audio" name="origen_audio" class="form-control"><option value="celular">Celular</option><option value="profesional">Profesional</option></select>
    </div>
  </div>
  <div class="form-group row inputs">
      <div class="col-md-6 col-sm-6 col-lg-6">
      <div class="form-group"><div class="form-group">
        <strong>Medicacion</strong> 
        <input type="text" name="ultimaMedicacion" placeholder="Ingrese la última medicación tomada y la hora" class="form-control">
      </div>
    </div>
  </div>
  </div>
<br>
  <div class="centerButton">
      <button type="submit"> Enviar </button>
  </div>
  
</form>

@if ($message = Session::get('success'))
        <!-- Modal -->
<div class="modal fade" id="audioModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Realizar Ejercicio</h5>
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

