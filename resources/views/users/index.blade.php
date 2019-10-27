{{--@extends('layouts.app')
BootStrapBody
@section('content')--}}
@section('title','Modificar datos')
@extends('layouts.BootStrapBody')

@section('MainContent')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left titleInfo">
            <h2>@lang('parkinsoft.modifyData')</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('welcome') }}">@lang('parkinsoft.backButton')</a>
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
    <form method="POST" action="{{ route('user/update') }}">
                {{ csrf_field() }}

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group{{ $errors->has('genero') ? ' has-error' : '' }}">
                    <strong>@lang('parkinsoft.gender'):</strong>
                        <select id="genero" type="text" class="custom-select" name="genero" required>
                        @if(Auth::user()->genero == "M")
                            <option selected>{{ Auth::user()->genero }}</option>
                            <option value="F">F</option>
                        @else
                            <option selected>{{ Auth::user()->genero }}</option>
                            <option value="M">M</option>
                        @endif
                        </select>                 
                    </div>
                </diV>


                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>@lang('parkinsoft.nacDate'):</strong>
                        <input class="form-control" type="date" value="{{ Auth::user()->nacimiento }}" id="nacimiento" name="nacimiento" required>
                    </div>
                </div>
                       
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>@lang('parkinsoft.password'):</strong>
                        <input id="password" type="password" class="form-control" name="password" required>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>@lang('parkinsoft.passwordConfirm'):</strong>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                    </div>
                </div>

                <div class="form-group">
                    <input id="email" type="hidden"
                        class="form-control" name="email" value={{ Auth::user()->email }}>
                </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
            <button type="submit" class="btn btn-primary">@lang('parkinsoft.editButton')</button>
    </div>
</form>
</div>

        @if ($message = Session::get('success'))
        <!-- Modal -->
        <div class="modal fade" id="myDataModal" tabindex="-1" role="dialog" aria-labelledby="myDataModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myDataModalLabel">@lang('parkinsoft.modifyModalTitle')</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                  
                        <div class="modal-body">
                            {{ $message }}
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('parkinsoft.closeButton')</button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        </div>
</div>


@endsection
