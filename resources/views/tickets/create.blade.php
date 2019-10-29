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
                    <legend>@lang('parkinsoft.ticketNewPageTitle')</legend>
                    <div class="form-group">
                        <label for="title" class="col-lg-2 control-label">@lang('parkinsoft.ticketNewTitle')</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="title" name="title">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="content" class="col-lg-2 control-label">@lang('parkinsoft.ticketNewContent')</label>
                        <div class="col-lg-10">
                            <textarea class="form-control" rows="3" id="content" name="content"></textarea>
                            <span class="help-block">@lang('parkinsoft.ticketNewHelp')</span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            
                            <button type="submit" value="1" name="response" class="btn btn-primary">Enviar</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <!-- Modal -->
        <div class="modal fade" id="ticketModalMSG" tabindex="-1" role="dialog" aria-labelledby="ticketModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ticketModalLabel">@lang('parkinsoft.ticketNewPageTitle')</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                  
                        <div class="modal-body">
                            {{ $message }}
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm closeButton" data-dismiss="modal">@lang('parkinsoft.closeButton')</button>
                    </div>
                </div>
            </div>
        </div>
        @endif



@endsection