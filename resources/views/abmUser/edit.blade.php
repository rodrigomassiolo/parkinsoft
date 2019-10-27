@extends('layouts.BootStrapBody')
@section('title','usuario')
@section('MainContent')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Editar usuario</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('abmUser.index') }}"> Atras</a>
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
                                <label for="genero" class="control-label">Género</label>
                            
                                    <select id="genero" type="text" class="custom-select" name="genero" required>
                                        <option selected>{{ $user->genero }}</option>
                                        <option value="F">F</option>
                                        <option value="M">M</option>
                                    </select>
                                    @if ($errors->has('genero'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('genero') }}</strong>
                                        </span>
                                    @endif
                            
                </div>
            </diV>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Fecha de Nacimiento:</strong>
                    <input type="date" name="nacimiento" value="{{ $user->nacimiento }}" 
                    class="form-control" placeholder="Fecha de nacimiento a editar">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Idioma:</strong>
                            <input id="idioma" type="text" class="form-control" name="idioma" 
                            value="{{ old('idioma') }}" required autofocus>
                    </div>
                </div>            
                <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Medicacion:</strong>
                                <input id="medicacion" type="text" class="form-control" name="medicacion" 
                                value="{{ old('medicacion') }}" required autofocus>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="password" class="control-label">Password</label>
                            <input id="password" type="password" class="form-control" name="password">
                        </div>        
                        <div class="form-group">
                            <label for="password-confirm" class="control-label">Confirmar Password</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                        </div>
                    </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit" class="btn btn-primary">Editar</button>
            </div>
        </div>
   
    </form>
@endsection