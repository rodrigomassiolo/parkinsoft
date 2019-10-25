@extends('layouts.BootStrapBody')
@section('title','Operación')
@section('MainContent')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
               <h2> @lang('parkinsoft.operacionShowTitle')</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('operacion.index') }}"> @lang('parkinsoft.backButton')</a>
            </div>
        </div>
    </div>
 
    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>@lang('parkinsoft.user')</strong>
                {{ $operacion->user->usuario }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>@lang('parkinsoft.date')</strong>   
                {{ $operacion->fecha }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>@lang('parkinsoft.description')</strong>
                {{ $operacion->descripcion }}
            </div>
        </div>
    </div>
@endsection