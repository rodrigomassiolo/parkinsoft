@extends('layouts.BootStrapBody')
@section('title','Abm Ejercicio')
@section('MainContent')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Crear nuevo ejercicio</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('abmEjercicio.index') }}"> Atras</a>
        </div>
    </div>
</div>
   
@if ($errors->any())
    <div class="alert alert-danger">
    @lang('parkinsoft.errorDescription').<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
   
<form action="{{ route('abmEjercicio.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
  
     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                <!-- <label for="nombre" class="col-md-4 control-label">Nombre</label> -->
                <strong>Nombre: </strong>
                                <input id="nombre" type="text" class="form-control" name="nombre" 
                                value="{{ old('nombre') }}" required autofocus>

                                @if ($errors->has('nombre'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nombre') }}</strong>
                                    </span>
                                @endif
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group{{ $errors->has('descripcion') ? ' has-error' : '' }}">
                            <!-- <label for="descripcion" class="col-md-4 control-label">Descripcion: </label> -->
                            <strong>Descripcion: </strong>
                                <input id="descripcion" type="text" class="form-control" name="descripcion" 
                                value="{{ old('descripcion') }}" required autofocus>

                                @if ($errors->has('descripcion'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('descripcion') }}</strong>
                                    </span>
                                @endif
                      
                </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group{{ $errors->has('audio_example') ? ' has-error' : '' }}">
               <strong>Audio de Ejemplo: </strong>
               <input type="file" class="form-control-file" id="audio_example" name="audio_example">
            </div>
        </div>        

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Crear</button>
        </div>

    </div>
   
</form>
@endsection