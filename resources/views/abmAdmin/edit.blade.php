@extends('layouts.BootStrapBody')
@section('title','abmAdmin')
@section('MainContent')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Editar abmAdmin</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('abmAdmin.index') }}"> Atras</a>
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
  
    <form action="{{ route('abmAdmin.update',$user->id) }}" method="POST">
        @csrf
        @method('PUT')
   
         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Nombre Codificado:</strong>
                    <input type="text" name="nombre" value="{{ $user->nombreCodificado }}"
                     class="form-control" placeholder="Nombre codificado a editar">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Nacionalidad:</strong>
                    <input type="text" name="nacionalidad" value="{{ $user->nacionalidad }}"
                     class="form-control" placeholder="Nacionalidad a editar">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Sexo:</strong>
                    <input type="text" name="sexo" maxlength="1" 
                    @if ($user->sexo == 'M') value="Masculino"
                    @else value="Femenino"
                    @endif
                     class="form-control" placeholder="Sexo a editar">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Fecha de Nacimiento:</strong>
                    <input type="date" name="fechaDeNac" value="{{ $user->fechaDeNac }}" 
                    class="form-control" placeholder="Fecha de nacimiento a editar">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit" class="btn btn-primary">Editar</button>
            </div>
        </div>
   
    </form>
@endsection