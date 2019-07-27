{{--@extends('layouts.app')
BootStrapBody
@section('content')--}}
@section('title','Modificar datos')
@extends('layouts.BootStrapBody')

@section('MainContent')
<div class="container">

    <div class="row">

        <!-- <div class="col-md-2"></div> -->

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Eliminar cuenta</div>
                <div class="panel-body">

                <div style="margin-top:5%">

                <h6> ¿Realmente desea eliminar su cuenta? Esta acción no puede ser revertida </h6>
                    <form class="form-horizontal" method="POST" action="{{ route('deleteUser') }}">
                        {{ csrf_field() }}

<!-- 
                        <div class="form-group">
                            <input id="email" type="hidden"
                             class="form-control" name="email" value={{ Auth::user()->email }}>
                        </div> -->


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Eliminar usuario
                                </button>
                            </div>
                        </div>
                    </form>

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
        
        <div class="col-md-2"></div>

    </div>
</div>
@endsection
