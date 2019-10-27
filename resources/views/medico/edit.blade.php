@extends('layouts.BootStrapBody')
@section('title','medico')
@section('MainContent')
    <div class="row">
        <div class="col-lg-12 margin-tb">
        <div class="pull-left titleInfo">
                <h2>@lang('parkinsoft.abmMedicEditTitle')</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('medico.index') }}">  @lang('parkinsoft.backButton')</a>
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
  
    <form action="{{ route('medico.update',$medico->id) }}" method="POST">
        @csrf
        @method('PUT')
   
         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>@lang('parkinsoft.name'): </strong>
                    <input type="text" name="nombre" value="{{ $medico->nombre }}" class="form-control">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                <strong>@lang('parkinsoft.surname'): </strong>
                    <input type="text" name="apellido" value="{{ $medico->apellido }}" class="form-control">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                <strong>@lang('parkinsoft.matricula'): </strong>
                    <input type="number" name="matricula" value="{{ $medico->matricula }}" class="form-control">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>@lang('parkinsoft.dni'):</strong> 
                    <input id="dni" pattern=".{6,}" title="Debe ingresar como minimo 6 caracteres" 
                     class="form-control" name="dni" value="{{ $medico->dni }}"  required autofocus>
                </div>
            </div>
        </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit" class="btn btn-primary">@lang('parkinsoft.editButton')</button>
            </div>
        </div>
   
    </form>
@endsection