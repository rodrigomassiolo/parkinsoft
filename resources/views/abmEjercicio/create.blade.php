@extends('layouts.BootStrapBody')
@section('title','Abm Ejercicio')
@section('MainContent')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left titleInfo">
            <h2>@lang('parkinsoft.exerciseCreateNew')</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('abmEjercicio.index') }}"> @lang('parkinsoft.backButton')</a>
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
                <strong>@lang('parkinsoft.name'): </strong>
                                <input id="nombre" type="text" class="form-control" name="nombre" 
                                value="{{ old('nombre') }}" required autofocus>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group{{ $errors->has('descripcion') ? ' has-error' : '' }}">
                            <strong>@lang('parkinsoft.description'): </strong>
                                <input id="descripcion" type="text" class="form-control" name="descripcion" 
                                value="{{ old('descripcion') }}" required autofocus>
                </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group{{ $errors->has('audio_example') ? ' has-error' : '' }}">
               <strong>@lang('parkinsoft.exerciseAudio'): </strong>
               <input type="file" class="form-control-file" id="audio_example" name="audio_example">
            </div>
        </div>        

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">@lang('parkinsoft.createButton')</button>
        </div>

    </div>
   
</form>
@endsection