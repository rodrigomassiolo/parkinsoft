@extends('layouts.BootStrapBody')
@section('title','Medico')

@section('MainContent')


    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-center">
                <h2>ABM Medico</h2>
            </div>
            <div class="float-right">
                <a href="{{ route('medico.create') }}" class="btn btn-success">
                <span data-feather="plus-circle"></span> Crear nuevo medico</a>
            </div>
        </div>
    </div>

    
    <p>
    <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#filterPanel" aria-expanded="false" aria-controls="collapseExample">
    Habilitar filtros
    </button>
    </p>
        <div class="collapse show" id="filterPanel">
        <form action="{{ route('medico.index') }}" method="GET">
        @csrf
  
        <div class="row">
            <div class="col-xs-3 col-sm-3 col-md-3">
                <div class="form-group">
                    <strong>Nombre: </strong>
                    <input type="text" name="nombre" class="form-control"
                     placeholder="Nombre a filtrar" value= "{{Request::old('nombre')}}">
                </div>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3">
                <div class="form-group">
                    <strong>Apellido:</strong>
                    <input type="text" name="apellido" class="form-control" 
                    placeholder="Apellido a filtrar" value= "{{Request::old('apellido')}}">
                </div>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3">
                <div class="form-group">
                    <strong>Matricula:</strong>
                    <input type="number" name="matricula" class="form-control" 
                    placeholder="Matricula a filtrar" value= "{{Request::old('matricula')}}">
                </div>
            </div>
        </div>
        <div>
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6" style="margin-bottom: 1%;">
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>             
                </form>
                    <form action="{{ route('medico.index') }}" method="GET">
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
        <!-- <script>
        alert("{{ $message }}");
    </script> -->
    @endif
   
    <table class="table table-bordered table-sm table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Matricula</th>
            <th>Fecha de Creación</th>
            <th width="320px">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($medico as $row)
        <tr>
            <td>{{ ++$i }}</td>  
            <td>{{ $row->nombre }}</td>
            <td>{{ $row->apellido }}</td>
            <td>{{ $row->matricula  }}</td>
            <td>{{ $row->created_at}}</td>
            <td>
                <form action="{{ route('medico.destroy',$row->id) }}" method="POST">
   
                    <a class="btn btn-info btn-sm" href="{{ route('medico.show',$row->id) }}"
                    data-toggle="tooltip" title="Mostrar">
                    <span data-feather="eye"></span>
                    Mostrar
                    </a>
    
                    <a class="btn btn-primary btn-sm" href="{{ route('medico.edit',$row->id) }}" 
                    data-toggle="tooltip" title="Editar">
                    <span data-feather="edit"></span>
                    Editar
                    </a>
   
                    @csrf
                    @method('DELETE')
      
                    <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" title="eliminar">
                    <span data-feather="trash-2"></span>
                    Eliminar</button>
                </form>


            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
  
       {!! $medico->render() !!}
      
@endsection