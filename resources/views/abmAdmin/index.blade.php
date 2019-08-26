@extends('layouts.BootStrapBody')
@section('title','Abm Admin')

@section('MainContent')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>ABM Admin</h2>
            </div>
            <div class="float-right">
                <a class="btn btn-success btn-sm" href="{{ route('abmAdmin.create') }}"> Crear usuario</a>
            </div>
        </div>
    </div>

    <p>
    <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#filterPanel" aria-expanded="false" aria-controls="collapseExample">
    Habilitar filtros
    </button>
    </p>
        <div class="collapse show" id="filterPanel">
        <form action="{{ route('abmAdmin.index') }}" method="GET">
        @csrf
  
        <div class="row">
            <div class="col-xs-3 col-sm-3 col-md-3">
                <div class="form-group">
                    <strong>Email: </strong>
                    <input type="text" name="email" class="form-control"
                     placeholder="Email a filtrar" value= "{{Request::old('email')}}">
                </div>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3">
                <div class="form-group">
                    <strong>Usuario:</strong>
                    <input type="text" name="usuario" class="form-control" 
                    placeholder="Usuario a filtrar" value= "{{Request::old('usuario')}}">
                </div>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3">
                <div class="form-group">
                    <strong>Sexo:</strong>
                    <input type="text" name="sexo" class="form-control" maxlength="1" 
                    placeholder="Sexo a filtrar" value= "{{Request::old('sexo')}}">
                </div>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3">
                <div class="form-group">
                    <strong>Fecha de Nacimiento:</strong>
                    <input type="date" name="fechaDeNac" class="form-control" 
                    placeholder="Fecha de nacimiento a filtrar" value= "{{Request::old('FechaDeNac')}}">
                </div>
            </div>
        </div>
        <div>
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6" style="margin-bottom: 1%;">
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>             
                </form>
                    <form action="{{ route('abmAdmin.index') }}" method="GET">
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
            <th>Email</th>
            <th>Usuario</th>
            <th>Genero</th>
            <th>Fecha de Nacimiento</th>
            <th width="280px">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($user as $row)
        <tr>
            <td>{{ $row->id }}</td>  
            <td>{{ $row->email }}</td>
            <td>{{ $row->usuario }}</td>
            <td>{{ $row->genero}}</td>
            <td>{{ $row->nacimiento}}</td>
            <td>
                <form action="{{ route('abmAdmin.destroy',$row->id) }}" method="POST">
   
                    <a class="btn btn-info btn-sm" href="{{ route('abmAdmin.show',[$row->id]) }}">
                    <span data-feather="trash"></span>
                        Mostrar
                    </a>
    
                    <a class="btn btn-primary btn-sm" href="{{ route('abmAdmin.edit',$row->id) }}"><span class=""></span>Editar</a>
   
                    @csrf
                    @method('DELETE')
      
                    <button type="submit" class="btn btn-danger btn-sm"><span class=""></span>Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
  
       {!! $user->render() !!}
      
@endsection