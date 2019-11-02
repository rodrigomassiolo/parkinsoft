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
                    <legend>@lang('parkinsoft.editTicketLegend')</legend>
                    <div class="form-group">
                        <label for="title" class="col-lg-2 control-label">@lang('parkinsoft.title')</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="title" name="title" disabled value="{!! $ticket->title !!}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="content" class="col-lg-2 control-label">@lang('parkinsoft.description')</label>
                        <div class="col-lg-10">
                            <textarea class="form-control" rows="3" id="" name="" disabled>{!! $ticket->content !!}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="content" class="col-lg-2 control-label">@lang('parkinsoft.response')</label>
                        <div class="col-lg-10">
                            <textarea class="form-control" rows="3" id="content" name="content"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>

                        @if($ticket->status == 1)
                            <input type='hidden' name='foobar' value=0/>
                            @lang('parkinsoft.closeTicket') <input type="checkbox" name="status" checked value=1>
                        @else
                            <input type='hidden' name='foobar' value=0 />
                            @lang('parkinsoft.closeTicket') <input type="checkbox" name="status" value=1>
                        @endif
                        </label>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                        <a class="btn btn-sm cancelButton" href="{!! action('TicketsController@show', $ticket->slug) !!}"> @lang('parkinsoft.cancelButton')</a>

                            <button type="submit" class="btn btn-sm editButton">@lang('parkinsoft.actualizar')</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
@endsection
