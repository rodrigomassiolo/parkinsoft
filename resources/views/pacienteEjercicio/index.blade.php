@extends('layouts.BootStrapBody')
@section('title','Lista de Audios')

@section('MainContent')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Lista de Audios</h2>
            </div>

        </div>
    </div>

    <p>
    <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#filterPanel" aria-expanded="false" aria-controls="collapseExample">
    Habilitar filtros
    </button>
    </p>
        <div class="collapse show" id="filterPanel">
        <form action="{{ route('listaDeEjercicios') }}" method="GET">
        @csrf
  
        <div class="row">
            <div class="col-xs-3 col-sm-3 col-md-3">
                <div class="form-group">
                    <strong>Usuario: </strong>
                    <input type="text" name="usuario" class="form-control"
                     placeholder="Usuario a filtrar" value= "{{Request::old('user_id')}}">
                </div>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3">
                <div class="form-group">
                    <strong>Tipo de ejercicio:</strong>
                    <input type="text" name="tipoDeEjercicio" class="form-control" 
                    placeholder="Tipo de ejercicio a filtrar" value= "{{Request::old('tipoDeEjercicio')}}">
                </div>
            </div>

            <div class="col-xs-3 col-sm-3 col-md-3">
                <div class="form-group">
                    <strong>Tipo de ejercicio:</strong>
                    <input type="date" name="created_at" class="form-control" 
                    placeholder="Fecha de subida" value= "{{Request::old('created_at')}}">
                </div>
            </div>
        </div>
        <div>
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6" style="margin-bottom: 1%;">
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>             
                </form>
                    <form action="{{ route('listaDeEjercicios') }}" method="GET">
                    @csrf
                    <div class="col-xs-6 col-sm-6 col-md-6" style="margin-bottom: 1%;">
                        <button type="submit" class="btn btn-primary">Borrar filtros</button>
                    </div>
                </form>
            </div>
    </div>

    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered table-sm table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>Usuario</th>
            <th>Ejercicio</th>
            <th>Fecha de Creación</th>
            <th width="320px">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($PacienteEjercicio as $row)
        <tr>
            <td>{{ $row->id }}</td>  
            <td>{{ $row->user->usuario }}</td>
            <td>{{ $row->ejercicio->nombre }}</td>
            <td>{{ $row->created_at }}</td>
            <td>
                <button type="button" class="btn btn-primary" id="{{$row->id}}"
                 data-toggle="modal" data-target="#exampleModal" data-whatever="{{$row->id}}">Mostrar acciones</button>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
  
       {!! $PacienteEjercicio->render() !!}


       <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title" id="exampleModalLabel">Seleccionar tipo de grafico</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="row" name="row">
        <form method = "POST" id="graphicForm">
          <div class="form-group">
          @csrf
            <label><input type="checkbox" name="Energy" value="1"> Energy</label><br>

           
            <label><input type="checkbox" name="eGemaps" value="1"> eGemaps</label><br>

            
            <label><input type="checkbox" name="Chroma" value="1"> Chroma</label><br>

            
            <label><input type="checkbox" name="Audspec" value="1"> Audspec</label><br>
            
           
            <label><input type="checkbox" name="Prosody" value="1"> Prosody</label><br>    
    
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="submit" name="View" value="1" class="btn btn-primary" onClick="Lista.generateGraphic();">Ver grafico</button>
            <button type="submit" name="output" value="pdf" class="btn btn-primary" onClick="Lista.downloadGraphic();">Descargar como PDF</button>
          </div>   
        </form>
      </div>
    
    </div>
  </div>
</div>
    
      
@endsection