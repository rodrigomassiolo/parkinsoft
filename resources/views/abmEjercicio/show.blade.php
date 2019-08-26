@extends('layouts.BootStrapBody')
@section('title','Ejercicio')
@section('MainContent')

    <div class="row">

        <div class="col-lg-12 margin-tb">

            <div class="pull-left">
                <h2>Ejercicio</h2>
            </div>

            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('abmEjercicio.index') }}"> Atras</a>
            </div>

        </div>

    </div>
 
    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Nombre: </strong>
                {{ $ejercicio->nombre }}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
            <strong>Descripción:</strong>   
                {{ $ejercicio->descripcion }}
            </div>
        </div>

    </div>

@endsection