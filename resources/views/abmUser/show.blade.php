@extends('layouts.BootStrapBody')
@section('title','user')
@section('MainContent')
    <div class="row">
        <div class="col-lg-12 margin-tb">
        <div class="pull-left titleInfo">
                <h2>@lang('parkinsoft.abmUserShowTitle')</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('abmUser.index') }}"> @lang('parkinsoft.backButton')</a>
            </div>
        </div>
    </div>
 
    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>@lang('parkinsoft.gender'):</strong>
                {{ $user->genero }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
            <strong>@lang('parkinsoft.nacDate'):</strong>   
            {{ $user->nacimiento }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>@lang('parkinsoft.email'):</strong>
                {{ $user->email }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>@lang('parkinsoft.user'):</strong>
                {{ $user->usuario }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>@lang('parkinsoft.createDate'):</strong>
                {{ $user->created_at }}
            </div>
        </div>
    </div>
@endsection