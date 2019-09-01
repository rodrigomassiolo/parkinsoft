@extends('layouts.BootStrapBody')
@section('title','Abm Ejercicios')
@section('MainContent')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Editar Ejercicios</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('abmEjercicio.index') }}"> Atras</a>
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
  
    <form action="{{ route('abmEjercicio.update',$ejercicio->id) }}" method="POST">
        @csrf
        @method('PUT')
   
         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Nombre: </strong>
                    <input type="text" name="nombre" value="{{ $ejercicio->nombre }}"
                     class="form-control" placeholder="Nombre a editar">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Descripción: </strong>
                    <input type="text" name="descripcion" value="{{ $ejercicio->descripcion }}"
                     class="form-control" placeholder="Descripcion a editar">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit" class="btn btn-primary">Editar</button>
            </div>
        </div>
   
    </form>
@endsection