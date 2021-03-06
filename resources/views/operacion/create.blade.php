@extends('layouts.BootStrapBody')
@section('title','Operacion')
@section('MainContent')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left titleInfo">
            <h2>@lang('parkinsoft.operacionCreateNew')</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-sm backButton" href="{{ route('operacion.index') }}">@lang('parkinsoft.backButton')</a>
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
   
<form action="{{ route('operacion.store') }}" method="POST">
    @csrf
  
     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
                <strong>@lang('parkinsoft.user')</strong>
                <select id="Operacion_user_id" name="user_id"></select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
            <strong>@lang('parkinsoft.description')</strong>   
              <input class="form-control" type="text" id="descripcion" name="descripcion" required>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
            <strong>@lang('parkinsoft.date')</strong>   
              <input class="form-control" type="date" id="fecha" name="fecha" required min="1900-01-01" max="2099-12-31">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-sm createButton">@lang('parkinsoft.createButton')</button>
        </div>

    </div>
   
</form>
@endsection