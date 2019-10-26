@extends('layouts.BootStrapBody')
@section('title','Admin')
@section('MainContent')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left titleInfo">
                <h2>@lang('parkinsoft.adminEdit')</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('abmAdmin.index') }}"> @lang('parkinsoft.backButton')</a>
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
  
    <form action="{{ route('abmAdmin.update',$user->id) }}" method="POST">
        @csrf
        @method('PUT')
   
         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>@lang('parkinsoft.user'):</strong>
                    <input type="text" name="usuario" value="{{ $user->usuario }}"
                     class="form-control">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group{{ $errors->has('genero') ? ' has-error' : '' }}">
                    <strong>@lang('parkinsoft.gender'):</strong>
                        <select id="genero" type="text" class="custom-select" name="genero" required>
                            @if($user->genero == "M")
                                <option selected>{{ $user->genero }}</option>
                                <option value="F">F</option>
                            @else
                                <option selected>{{ $user->genero }}</option>
                                <option value="M">M</option>
                            @endif
                        </select>                 
                </div>
            </diV>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>@lang('parkinsoft.nacDate'):</strong>
                    <input type="date" name="nacimiento" value="{{ $user->nacimiento }}" 
                    class="form-control">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit" class="btn btn-primary">@lang('parkinsoft.editButton')</button>
            </div>
        </div>
    </form>
@endsection