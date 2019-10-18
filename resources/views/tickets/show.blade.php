@extends('layouts.BootStrapBody')
@section('title', 'Contact')

@section('MainContent')

<div class="container col-md-8 col-md-offset-2">
        <div class="well well bs-component">
            <div class="content">
                <h2 class="header">{!! $ticket->title !!}</h2>
                <p> <strong>Status:</strong>: {!! $ticket->status ? 'Pendiente' : 'Respondido' !!}</p>
                <p> 
                <strong>Consulta:</strong> {!! $ticket->content !!} 
                </p>
            </div>
            <a href="{!! action('TicketsController@edit', $ticket->slug) !!}" class="btn btn-info float-left">Edit</a>

           <form method="post" action="{!! action('TicketsController@destroy', $ticket->slug) !!}" class="float-left">
               <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                  <div>
                    <button type="submit" class="btn btn-danger">Borrar</button>
                  </div>
            </form>

            <div class="clearfix"></div>
        </div>

             <!-- @foreach($comments as $comment)
                <div class="well well bs-component">
                  <div class="content">
                     {!! $comment->content !!}
                  </div>
                </div>
             @endforeach -->
<hr>

            <table class="table table-bordered table-sm table-hover">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Comentario</th>
                        <th>Fecha de Creación</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($comments as $comment)
                    <tr>
                        <td>{{ $comment->user_id }}</td>  
                        <td>{{ $comment->content }}</td>
                        <td>{{ $comment->created_at }} </td> 
                    </tr>
                    @endforeach
                </tbody>
            </table>




              <div class="well well bs-component">
        <form class="form-horizontal" method="post" action="/comment">

            @foreach($errors->all() as $error)
                <p class="alert alert-danger">{{ $error }}</p>
            @endforeach

            @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            <input type="hidden" name="post_id" value="{!! $ticket->id !!}">

            <fieldset>
                <legend>Contestar</legend>
                <div class="form-group">
                    <div class="col-lg-12">
                        <textarea class="form-control" rows="3" id="content" name="content"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        <button type="reset" class="btn btn-default">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Publicar</button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>

@endsection