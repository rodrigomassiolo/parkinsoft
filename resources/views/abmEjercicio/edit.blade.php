@extends('layouts.BootStrapBody')
@section('title','Abm Ejercicios')
@section('MainContent')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left titleInfo">
                <h2>@lang('parkinsoft.exerciseEdit')</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-sm backButton" href="{{ route('abmEjercicio.index') }}"> @lang('parkinsoft.backButton')</a>
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
  
    <form action="{{ route('abmEjercicio.update',$ejercicio->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
   
         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>@lang('parkinsoft.name'): </strong>
                    <input type="text" name="nombre" value="{{ $ejercicio->nombre }}"
                     class="form-control">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>@lang('parkinsoft.description'): </strong>
                    <input type="text" name="descripcion" value="{{ $ejercicio->descripcion }}"
                     class="form-control">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group{{ $errors->has('audio_example') ? ' has-error' : '' }}">
                    <strong>@lang('parkinsoft.exerciseAudio'): </strong>
                       <input type="file" class="form-control-file" id="audio_example" name="audio_example">
                    </div>
                </div>        
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit" class="btn btn-sm editButton">@lang('parkinsoft.editButton')</button>
            </div>
        </div>
   
    </form>
@endsection