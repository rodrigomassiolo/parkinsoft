{{--@extends('layouts.app')
BootStrapBody
@section('content')--}}
@extends('layouts.BootStrapBody')

@section('MainContent')
<div class="container" style="background-image:{{asset('/img/higialogo.jpg')}}">
    <div>
        <div>
           
            <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} ">
                    <label for="email" class="col-md-4 control-label">@lang('parkinsoft.emailDireccion')</label>

                    <div class="col-md-8">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} ">
                    <label for="password" class="col-md-4 control-label">@lang('parkinsoft.password')</label>

                    <div class="col-md-8">
                        <input id="password" type="password" class="form-control" name="password" required>

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group ">
                    <div class="col-md-12" style="text-align: end;">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Recordarme
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-12" >
                        <button type="submit" class="btn btn-primary">
                            Login
                        </button>

                        <a class="btn btn-link" href="{{ route('emailReset') }}">
                            @lang('parkinsoft.forgetPassword')
                        </a>
                    </div>
                </div>
                <!-- <div class="form-group ">
                            <div class="col-md-12 control">
                                <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                                    @lang('parkinsoft.noAccount') 
                                <a href="{{ route('register') }}">
                                @lang('parkinsoft.registerHere') 
                                </a>
                    </div>
                </div> -->
                </div>    
            </form>
             
        </div>
        
    </div>
</div>
@endsection
