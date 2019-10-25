@extends('layouts.BootStrapBody')
@section('title','Operacion')
@section('MainContent')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                @lang('parkinsoft.operacionEdit')
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('operacion.index') }}"> @lang('parkinsoft.backButton')</a>
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
  
    <form action="{{ route('operacion.update',$operacion->id) }}" method="POST">
        @csrf
        @method('PUT')
   
         <div class="row">
             <input type="hidden" value="{{$operacion->user_id}}" name="user_id">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>@lang('parkinsoft.description')</strong>
                    <input type="text" name="descripcion" value="{{ $operacion->descripcion }}"
                     class="form-control" placeholder="Descripción">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>@lang('parkinsoft.date')</strong>
                    <input type="date" name="fecha" value="{{ $operacion->fecha }}" 
                    class="form-control" placeholder="Fecha">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit" class="btn btn-primary">@lang('parkinsoft.editButton')</button>
            </div>
        </div>
   
    </form>
@endsection