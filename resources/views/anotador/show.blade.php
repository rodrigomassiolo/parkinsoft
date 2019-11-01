@extends('layouts.BootStrapBody')
@section('title', 'Contact')

@section('MainContent')

<div class="container col-md-8 col-md-offset-2">
        <div class="well well bs-component">
            <div class="content">
                <h2 class="header">{!! $anotador->title !!}</h2>
            </div>
            <div class="clearfix"></div>
        </div>
            <form action="{{ route('abmUser.index')}}" method="GET">
                <button class="btn btn-danger btn-sm" type="submit">@lang('parkinsoft.anotadorgoBack')</button>           
            </form>

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


            <hr>

              <div class="well well bs-component">
        <form class="form-horizontal" method="post" action="/anotar">

            @foreach($errors->all() as $error)
                <p class="alert alert-danger">{{ $error }}</p>
            @endforeach

            @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            <input type="hidden" name="anotador_id" value="{!! $anotador->id !!}">

            <fieldset>
                <legend>@lang('parkinsoft.anotadorInsertComment')</legend>
                <div class="form-group">
                    <div class="col-lg-12">
                        <textarea class="form-control" rows="3" id="content" name="content"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        <!-- <button type="reset" class="btn btn-default">Cancelar</button> -->
                        <button type="submit" class="btn btn-primary">@lang('parkinsoft.anotadorResponse')</button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>

@endsection