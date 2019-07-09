@extends('layouts.BootStrapBody')
@section('title','medicamento')

@section('MainContent')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>ABM Medicamentos</h2>
            </div>
            <div class="float-right">
                <a class="btn btn-success btn-sm" href="{{ route('medicamento.create') }}"> Crear Medicamento</a>
            </div>
        </div>
    </div>

    <p>
    <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#filterPanel" aria-expanded="false" aria-controls="collapseExample">
    Habilitar filtros
    </button>
    </p>
        <div class="collapse" id="filterPanel">
        <form action="{{ route('medicamento.index') }}" method="GET">
        @csrf
  
        <div class="row">
            <div class="col-xs-3 col-sm-3 col-md-3">
                <div class="form-group">
                    <strong>Nombre:</strong>
                    <input type="text" name="nombre" class="form-control" placeholder="Nombre a filtrar">
                </div>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3">
                <div class="form-group">
                    <strong>Numero:</strong>
                    <input type="text" name="numero" class="form-control" placeholder="Numero a filtrar">
                </div>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3">
                <div class="form-group">
                    <strong>Letra:</strong>
                    <input type="text" name="Letra" class="form-control" placeholder="Letra a filtrar">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center" style="margin-bottom: 1%;">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </div>
   
</form>
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
            <th>Name</th>
            <th>Numero</th>
            <th>Letra</th>
            <th>Fecha de Creación</th>
            <th width="280px">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($medicamento as $row)
        <tr>
            <td>{{ ++$i }}</td>  
            <td>{{ $row->nombre }}</td>
            <td>{{ $row->numero }}</td>
            <td>{{ $row->Letra  }}</td>
            <td>{{ $row->created_at}}</td>
            <td>
                <form action="{{ route('medicamento.destroy',$row->id) }}" method="POST">
   
                    <a class="btn btn-info btn-sm" href="{{ route('medicamento.show',$row->id) }}">
                    <span class="oi oi-trash"></span>
                        Mostrar
                    </a>
    
                    <a class="btn btn-primary btn-sm" href="{{ route('medicamento.edit',$row->id) }}"><span class="glyphicon glyphicon-trash"></span>Editar</a>
   
                    @csrf
                    @method('DELETE')
      
                    <button type="submit" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span>Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
  
       {!! $medicamento->render() !!}
      
@endsection