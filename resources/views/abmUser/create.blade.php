@extends('layouts.BootStrapBody')
@section('title',trans("parkinsoft.abmUserLink"))
@section('MainContent')

<div class="row">
    <div class="col-lg-12 margin-tb">
    <div class="pull-center titleInfo">
                <h2>@lang("parkinsoft.abmUserCreateNew")</h2>
        </div>
        <div class="pull-right">
        <a class="btn btn-sm backButton" href="{{ route('abmUser.index') }}"> @lang("parkinsoft.backButton")</a>
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
   
<form action="{{ route('abmUser.store') }}" method="POST">
    @csrf
  
     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                <strong>@lang('parkinsoft.name'):</strong>
                    <input id="nombre" type="text" class="form-control" name="nombre" 
                    value="{{ old('nombre') }}" required autofocus>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group{{ $errors->has('apellido') ? ' has-error' : '' }}">
                <strong>@lang('parkinsoft.surname'):</strong>
                        <input id="apellido" type="text" class="form-control" name="apellido" 
                        value="{{ old('apellido') }}" required autofocus>
                </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group{{ $errors->has('dni') ? ' has-error' : '' }}">
                <strong>@lang('parkinsoft.dni'):</strong>
                    <input id="dni" pattern=".{6,}" title="Debe ingresar como minimo 6 caracteres" 
                     class="form-control" name="dni" value="{{ old('dni') }}" required autofocus>
                </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
            <strong>@lang('parkinsoft.gender'):</strong>
                <select id="genero" type="text" class="custom-select" name="genero" required>
                    <option value="F">F</option>
                    <option value="M">M</option>
                </select>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
            <strong>@lang('parkinsoft.nacDate'):</strong>
              <input class="form-control" type="date" id="nacimiento" name="nacimiento" required>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group{{ $errors->has('idioma') ? ' has-error' : '' }}">
                <strong>@lang('parkinsoft.language'):</strong>
                <input id="idioma" type="text" class="form-control" name="idioma" 
                        value="{{ old('idioma') }}" required autofocus>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group{{ $errors->has('medicacion') ? ' has-error' : '' }}">
                <strong>@lang('parkinsoft.medication'):</strong>
                <input id="medicacion" type="text" class="form-control" name="medicacion" 
                            value="{{ old('medicacion') }}" required autofocus>
            </div>
        </div>
    
       <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>@lang('parkinsoft.email'):</strong>
                <input type="text" name="email" class="form-control">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <strong>@lang('parkinsoft.password'):</strong>
                <input id="password" type="password" class="form-control" name="password" required>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-sm createButton">@lang('parkinsoft.createButton')</button>
        </div>

    </div>
   
</form>
@endsection