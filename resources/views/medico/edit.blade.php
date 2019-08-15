@extends('layouts.BootStrapBody')
@section('title','medico')
@section('MainContent')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Editar medico</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('medico.index') }}"> Atras</a>
            </div>
        </div>
    </div>
   
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
  
    <form action="{{ route('medico.update',$medico->id) }}" method="POST">
        @csrf
        @method('PUT')
   
         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Nombre:</strong>
                    <input type="text" name="nombre" value="{{ $medico->nombre }}" class="form-control" placeholder="Nombre a editar">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Apellido:</strong>
                    <input type="text" name="apellido" value="{{ $medico->apellido }}" class="form-control" placeholder="Apellido a editar">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Matricula:</strong>
                    <input type="number" name="matricula" value="{{ $medico->matricula }}" class="form-control" placeholder="Matricula a editar">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit" class="btn btn-primary">Editar</button>
            </div>
        </div>
   
    </form>
@endsection