@extends('layouts.BootStrapBody')
@section('title', 'Contact')

@section('MainContent')
    <div class="container col-md-8 col-md-offset-2">
        <div class="well well bs-component">
            <form class="form-horizontal" method="post">
                @foreach ($errors->all() as $error)
                    <p class="alert alert-danger">{{ $error }}</p>
                @endforeach  
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <fieldset>
                    <legend>Enviar un nuevo ticket</legend>
                    <div class="form-group">
                        <label for="title" class="col-lg-2 control-label">Título</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="title" placeholder="Título" name="title">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="content" class="col-lg-2 control-label">Contenido</label>
                        <div class="col-lg-10">
                            <textarea class="form-control" rows="3" id="content" name="content"></textarea>
                            <span class="help-block">Envia un ticket para dudas y consultas.</span>
                        </div>
                    </div>
                    <!-- deberia estar al revez -->
                    @if (Auth::user()) 
                    <label for="email" class="col-lg-2 control-label">Email</label>
                        <div class="col-lg-10">
                            <input required type="text" class="form-control" id="email" placeholder="Ingrese email" name="email">
                        </div>
                    @endif 
                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <!-- <button type="button" onclick="Contact.cancel();" value="0" name="response" class="btn btn-default">Cancelar</button> -->
                            <button type="submit" value="1" name="response" class="btn btn-primary">Enviar</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
@endsection