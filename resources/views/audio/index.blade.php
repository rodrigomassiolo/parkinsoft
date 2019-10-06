@extends('layouts.BootStrapBody')
@section('title','Carga de Audio')

@section('MainContent')

<h4>Ingresar Audio</h4>
<br>
<form action="{{ route('sendAudio') }}" method="POST" enctype="multipart/form-data">
    @csrf
  <div class="form-group row">
    <div class="col-md-2">
      <input type="hidden" name="View" value="1">
      <select name="ejercicio">
        @foreach ($ejercicio as $ej)
          <option value="{{ $ej->id }}" > {{ $ej->descripcion }} </option>
        @endforeach
      </select>
    </div>
    <div class="col-md-6">
      <input type="file" class="form-control-file" id="audio" name="audio">
    </div>
  </div>

  <button type="submit"> Enviar </button>
</form>

<br><br>

<h6>Historico de audios subidos</h6>

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
            <td>{{ $row->created_at }}</td>
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
        Su audio ha sido cargado correctamente!
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
@endif

@endsection