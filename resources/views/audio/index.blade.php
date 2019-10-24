@extends('layouts.BootStrapBody')
@section('title','Carga de Audio')

@section('MainContent')

<h4 class="titleInfo">
  Ingresar Audio
</h4>
<br>

<form action="{{ route('sendAudio') }}" method="POST" enctype="multipart/form-data">
    @csrf
  <div class="form-group row inputs">
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
    <div class="col-md-6 col-sm-6 col-lg-6">
      <label for="audio">Cargue un Audio</label>
      <input type="file" class="form-control-file" id="audio" name="audio">
    </div>
  </div>
  <div class="col-xs-12 col-sm-12 col-md-12">
      <div class="form-group"><div class="form-group">
        <strong>Medicacion</strong> 
        <input type="text" name="ultimaMedicacion" placeholder="Ingrese la última medicación tomada y la hora" class="form-control">
      </div>
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
      <button type="submit"> Enviar </button>
  </div>
  
</form>

<br><br>
<h6 class="tableInfo"
  >Historial de audios subidos
</h6>

<table class="table table-bordered table-sm table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>Ejercicio</th>
            <th>Fecha de Creación</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($PacienteEjercicio as $row)
        <tr>
            <td>{{ $row->id }}</td>  
            <td>{{ $row->ejercicio->descripcion }}</td>
            <td>{{ $row->created_at }} </td> 
      
        </tr>
        @endforeach
        </tbody>
    </table>

       {!! $PacienteEjercicio->render() !!}



@if ($message = Session::get('success'))
        <!-- Modal -->
<div class="modal fade" id="audioModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Carga de audio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {{ $message }}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
@endif

@endsection

