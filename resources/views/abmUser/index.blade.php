@extends('layouts.BootStrapBody')
@section('title',trans("parkinsoft.abmUserLinkTitle"))

@section('MainContent')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-center titleInfo">
                <h2>@lang("parkinsoft.abmUserLinkTitle")</h2>
            </div>
            <div class="float-right">
                <a href="{{ route('abmUser.create') }}" class="btn btn-success" >
                <span data-feather="plus-circle"></span>@lang("parkinsoft.abmUserCreateNew")</a>
            </div>
        </div>
    </div>

    <p>
    <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#filterPanel" aria-expanded="false" aria-controls="collapseExample">
     @lang('parkinsoft.enableFilters')
    </button>
    </p>
        <div class="collapse show" id="filterPanel">
        <form action="{{ route('abmUser.index') }}" method="GET">
        @csrf
  
        <div class="row">
            <div class="col-xs-3 col-sm-3 col-md-3">
                <div class="form-group">
                    <strong> @lang('parkinsoft.email'): </strong>
                    <input type="text" name="email" class="form-control"
                      value= "{{Request::old('email')}}">
                </div>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3">
                <div class="form-group">
                    <strong> @lang('parkinsoft.user'):</strong>
                    <input type="text" name="usuario" class="form-control" 
                     value= "{{Request::old('usuario')}}">
                </div>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3">
                <div class="form-group">
                    <strong> @lang('parkinsoft.gender'):</strong>
                    <input type="text" name="genero" class="form-control" maxlength="1" 
                     value= "{{Request::old('genero')}}">
                </div>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3">
                <div class="form-group">
                    <strong>@lang('parkinsoft.nacDate'):</strong>
                    <input type="date" name="nacimiento" min="1900-01-01" max="2099-12-31" class="form-control" 
                    value= "{{Request::old('nacimiento')}}">
                </div>
            </div>
        </div>
        <div>
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6" style="margin-bottom: 1%;">
                        <button type="submit" class="btn btn-primary">@lang('parkinsoft.filterFilters')</button>
                </div>             
                </form>
                    
                <div class="col-xs-6 col-sm-6 col-md-6" style="margin-bottom: 1%;">
                    <form action="{{ route('abmUser.index') }}" method="GET">
                        @csrf
                        <button type="submit" class="btn btn-primary">@lang('parkinsoft.clearFilters')</button>
                    </form>
                </div>
               
            </div>
    </div>

    </div>
   
    <div style="display:none">
        <input type="hidden" id="UserDeleteRowHidden">
    </div>

    <table class="table table-bordered table-sm table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>@lang('parkinsoft.email')</th>
            <th>@lang('parkinsoft.user')</th>
            <th>@lang('parkinsoft.gender')</th>
            <th>@lang('parkinsoft.nacDate')</th>
            <th width="320px">@lang('parkinsoft.actions')</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($user as $row)
        <tr>
            <td>{{ $row->id }}</td>  
            <td>{{ $row->email }}</td>
            <td>{{ $row->usuario }}</td>
            <td>{{ $row->genero}}</td>
            <td>{{ $row->nacimiento}}</td>
            <td>
       
   
                    <a class="btn btn-info btn-sm" href="{{ route('abmUser.show',[$row->id]) }}"
                    data-toggle="tooltip">
                    <span data-feather="eye"></span>
                        @lang('parkinsoft.showButton')
                    </a>
    
                    <a class="btn btn-sm editButton" href="{{ route('abmUser.edit',$row->id) }}" 
                    data-toggle="tooltip">
                    <span data-feather="edit"></span>
                    @lang('parkinsoft.editButton')
                    </a>
                    <form action="{{ route('abmUser.destroy',$row->id) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="submit" style="display:none" id="deleteButton{{$row->id}}" ></button>

                        <button type="button" class="btn btn-danger btn-sm" data-whatever="{{$row->id}}"
                            data-toggle="modal"  data-target="#deleteUserModal" title="Eliminar">
                            <span data-feather="trash-2"></span>
                            @lang('parkinsoft.deleteButton')
                        </button>
                    </form>
                    <form action="{{ route('audio')}}" method="GET">
                        <input type="hidden" name="paciente_id" value="{{$row->id}}">

                        <button class="btn btn-info btn-sm" type="submit">@lang('parkinsoft.uploadAudio')</button>           
                    </form>
                    <form action="{{ route('ejercicioPacienteAsignar')}}" method="GET">
                            <input type="hidden" name="paciente_id" value="{{$row->id}}">
                            <button class="btn btn-info btn-sm" type="submit">@lang('parkinsoft.assingExercise')</button>           
                    </form>
                    <form action="{{ route('listaDeEjerciciosRealizados')}}" method="GET">
                        <input type="hidden" name="paciente_id" value="{{$row->id}}">
                        <button class="btn btn-info btn-sm" type="submit">@lang('parkinsoft.audioListLink')</button>           
                    </form>
                    <form action="{{ route('listaDeEjerciciosAsignados')}}" method="GET">
                        <input type="hidden" name="paciente_id" value="{{$row->id}}">
                        <button class="btn btn-info btn-sm" type="submit">@lang('parkinsoft.audioListLinkAssigned')</button>           
                    </form>
                    <form action="{{ route('operacion.index') }}" method="GET">
                        <input type="hidden" name="user_id" value="{{$row->id}}">
                        <button class="btn btn-info btn-sm" type="submit">@lang('parkinsoft.operacionLinkTitle')</button>           
                    </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
       {!! $user->render() !!}

       @if ($message = Session::get('success'))
        <!-- Modal -->
        <div class="modal fade" id="userMessageModal" tabindex="-1" role="dialog" aria-labelledby="userMessageModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userMessageModalLabel">@lang('parkinsoft.userModalTitle')</h5>
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


        <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteUserModalLabel">@lang('parkinsoft.deleteModalTitle')</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                        <div class="modal-body">
                            @lang('parkinsoft.userConfirmDelete')
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm cancelButton" data-dismiss="modal">@lang('parkinsoft.cancelButton')</button>
                        <button type="button" onclick="User.deleteUser();" class="btn btn-sm acceptButton">@lang('parkinsoft.acceptButton')</button>
                    </div>
                </div>
            </div>
        </div>

      
@endsection