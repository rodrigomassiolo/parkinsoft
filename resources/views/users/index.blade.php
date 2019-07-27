{{--@extends('layouts.app')
BootStrapBody
@section('content')--}}
@section('title','Modificar datos')
@extends('layouts.BootStrapBody')

@section('MainContent')
<div class="container">

    <div class="row">

        <div class="col-md-2"></div>

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Modificar datos</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('user/update') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('genero') ? ' has-error' : '' }}">
                            <label for="genero" class="col-md-4 control-label">Género</label>
                            <div class="col-md-6">
                                <select id="genero" type="text" class="custom-select" name="genero" required>
                                    <option selected>{{ Auth::user()->genero }}</option>
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

                        <div class="form-group{{ $errors->has('nacimiento') ? ' has-error' : '' }}">
                            <label for="nacimiento" class="col-md-4 control-label">Nacimiento</label>
                            <div class="col-md-6">
                                <input class="form-control" type="date" value={{ Auth::user()->nacimiento }} id="nacimiento" name="nacimiento" required>
                                @if ($errors->has('nacimiento'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nacimiento') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                       
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirmar Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <input id="email" type="hidden"
                             class="form-control" name="email" value={{ Auth::user()->email }}>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Modificar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-2"></div>

    </div>
</div>
@endsection
