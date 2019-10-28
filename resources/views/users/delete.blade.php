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

@if ($errors->any())
    <div class="alert alert-danger">
        @lang('parkinsoft.errorDescription').<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


    <div class="row">
        <form class="form-horizontal" method="GET" action="{{ route('/deleteUser') }}">
            <h6> @lang('parkinsoft.deleteAccountWarning') </h6>
            {{ csrf_field() }}

        <div class="form-group row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a class="btn btn-sm backButton" href="{{ route('welcome') }}">@lang('parkinsoft.backButton')</a>
            </div>            
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <button type="submit" class="btn btn-sm btn-danger">
                @lang('parkinsoft.deleteAccount')
                </button>
            </div>
        </form>
    </div>
@endsection
