@extends('layouts.BootStrapBody')
@section('title','medico')
@section('MainContent')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Crear nuevo medico</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('medico.index') }}"> Atras</a>
        </div>
    </div>
</div>
  
 @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif 
   
<form action="{{ route('medico.store') }}" method="POST">
    @csrf
  
     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                    <div class="form-group">
                        <strong>Nombre:</strong>
                        <input type="text" name="nombre" class="form-control" placeholder="Nombre">
                    </div>
                </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Apellido:</strong>
                <input type="text" name="apellido" class="form-control" placeholder="Apellido">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Matricula:</strong>
                <input type="number" name="matricula" class="form-control" placeholder="Matricula">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Dni:</strong>
                <input type="number" name="dni" class="form-control" placeholder="Dni">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group{{ $errors->has('genero') ? ' has-error' : '' }}">
                <label for="genero" class="control-label">Género</label>
                               
                                    <select id="genero" type="text" class="custom-select" name="genero" required>
                                        <option selected></option>
                                        <option value="F">F</option>
                                        <option value="M">M</option>
                                    </select>
                                    @if ($errors->has('genero'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('genero') }}</strong>
                                        </span>
                                    @endif
                               
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group{{ $errors->has('nacimiento') ? ' has-error' : '' }}">
                                <label for="nacimiento" class="control-label">Nacimiento</label>
                           
                                    <input class="form-control" type="date" value="1990-01-01" id="nacimiento" name="nacimiento" required>
                                    @if ($errors->has('nacimiento'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('nacimiento') }}</strong>
                                        </span>
                                    @endif
                            
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="control-label">Direccion de email</label>

                            
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="control-label">Password</label>


                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
     
                        </div>
        </div>

        
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Crear</button>
        </div>
    </div>
   
</form>
@endsection