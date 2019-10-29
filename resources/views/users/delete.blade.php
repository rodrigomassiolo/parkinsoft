{{--@extends('layouts.app')
BootStrapBody
@section('content')--}}
@section('title','Eliminar cuenta')
@extends('layouts.BootStrapBody')

@section('MainContent')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left titleInfo">
            <h2>@lang('parkinsoft.deleteAccount')</h2>
        </div>
    </div>
</div>

    <div class="row">
        <form class="form-horizontal" method="GET" action="{{ route('/deleteUser') }}">
            <h6> @lang('parkinsoft.deleteAccountWarning') </h6>
            {{ csrf_field() }}

        <div class="form-group row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a class="btn btn-sm backButton" href="{{ route('welcome') }}">@lang('parkinsoft.backButton')</a>
            </div>            
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <button type="button" data-toggle="modal"  data-target="#deleteAccount" class="btn btn-sm btn-danger">
                    @lang('parkinsoft.deleteAccount')
                </button>
        </div>


        <div class="modal fade" id="deleteAccount" tabindex="-1" role="dialog" aria-labelledby="deleteAccountLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteAccountLabel">@lang('parkinsoft.deleteModalTitle')</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                        <div class="modal-body">
                            @lang('parkinsoft.accountConfirmDelete')
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm cancelButton" data-dismiss="modal">@lang('parkinsoft.cancelButton')</button>
                        <button type="submit" class="btn btn-sm acceptButton">@lang('parkinsoft.acceptButton')</button>
                    </div>
                </div>
            </div>
        </div>


        </form>
    </div>
@endsection
