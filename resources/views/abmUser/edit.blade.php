@extends('layouts.BootStrapBody')
@section('title','Paciente')
@section('MainContent')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-center titleInfo">
                <h2>@lang("parkinsoft.abmUserEditTitle")</h2>
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
  
    <form action="{{ route('abmUser.update',$user->id) }}" method="POST">
        @csrf
        @method('PUT')
   
         <div class="row">
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
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                <strong>@lang('parkinsoft.language'):</strong>
                        <input id="idioma" type="text" class="form-control" name="idioma" 
                        value="{{ old('idioma') }}" required autofocus>
                </div>
            </div>            
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>@lang('parkinsoft.medication'):</strong>
                        <input id="medicacion" type="text" class="form-control" name="medicacion" 
                        value="{{ old('medicacion') }}" required autofocus>
                </div>
            </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="password" class="control-label">@lang('parkinsoft.password')</label>
                        <input id="password" type="password" class="form-control" name="password">
                    </div>        
                    <div class="form-group">
                        <label for="password-confirm" class="control-label">@lang('parkinsoft.passwordConfirm')</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                    </div>
                </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit" class="btn editButton">@lang('parkinsoft.editButton')</button>
            </div>
        </div>
   
    </form>
@endsection