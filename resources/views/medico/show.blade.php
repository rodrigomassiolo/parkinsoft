@extends('layouts.BootStrapBody')
@section('title','Medico')
@section('MainContent')
    <div class="row">
        <div class="col-lg-12 margin-tb">
        <div class="pull-left titleInfo">
                <h2>@lang('parkinsoft.medicShowTitle')</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('medico.index') }}">  @lang('parkinsoft.backButton')</a>
            </div>
        </div>
    </div>
   
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>@lang('parkinsoft.name'):</strong>
                {{ $medico->nombre }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>@lang('parkinsoft.surname'):</strong>
                {{ $medico->apellido }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>@lang('parkinsoft.matricula'):</strong>
                {{ $medico->matricula }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>@lang('parkinsoft.dni'):</strong>
                {{ $medico->dni }}
            </div>
        </div>
    </div>
@endsection