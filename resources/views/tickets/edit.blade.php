@extends('layouts.BootStrapBody')
@section('title', 'Editar')

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
                    <legend>Editar ticket</legend>
                    <div class="form-group">
                        <label for="title" class="col-lg-2 control-label">Título</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="title" name="title" value="{!! $ticket->title !!}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="content" class="col-lg-2 control-label">Contenido</label>
                        <div class="col-lg-10">
                            <textarea class="form-control" rows="3" id="content" name="content">{!! $ticket->content !!}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>
                        
                        @if($ticket->status == 1)
                            <input type='hidden' name='foobar' value=0/>
                            <input type="checkbox" name="status" checked value=1> ¿Cerrar este ticket?
                        @else
                            <input type='hidden' name='foobar' value=0 />
                            <input type="checkbox" name="status" value=1> ¿Cerrar este ticket?
                        @endif
                        </label>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                        <a class="btn btn-danger" href="{!! action('TicketsController@show', $ticket->slug) !!}"> @lang('parkinsoft.cancelButton')</a>
                         
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
@endsection