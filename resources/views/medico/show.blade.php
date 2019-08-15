@extends('layouts.BootStrapBody')
@section('title','medico')
@section('MainContent')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Medico</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('medico.index') }}"> Atras</a>
            </div>
        </div>
    </div>
   
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Nombre:</strong>
                {{ $medico->nombre }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Apellido:</strong>
                {{ $medico->apellido }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Matricula:</strong>
                {{ $medico->matricula }}
            </div>
        </div>
    </div>
@endsection