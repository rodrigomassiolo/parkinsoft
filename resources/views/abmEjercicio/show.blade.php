@extends('layouts.BootStrapBody')
@section('title','Ejercicio')
@section('MainContent')

    <div class="row">

        <div class="col-lg-12 margin-tb">

            <div class="pull-left titleInfo">
                <h2>@lang('parkinsoft.abmExerciseLink')</h2>
            </div>

            <div class="pull-right">
                <a class="btn btn-sm backButton" href="{{ route('abmEjercicio.index') }}"> @lang('parkinsoft.backButton')</a>
            </div>

        </div>

    </div>
 
    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>@lang('parkinsoft.name'): </strong>
                {{ $ejercicio->nombre }}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
            <strong>@lang('parkinsoft.description'):</strong>   
                {{ $ejercicio->descripcion }}
            </div>
        </div>

        @if ($ejercicio->audio_example_path)
        <div class="col-xs-12 col-sm-12 col-md-12">
            <a class="btn btn-success btn-sm" href="{{ route('donwloadAudioExample',[$ejercicio->id]) }}" 
                        data-toggle="tooltip">
                        <span data-feather="download"></span>
                            @lang('parkinsoft.exerciseDownloadExample')
            </a>
        </div>
        @endif

    </div>

@endsection