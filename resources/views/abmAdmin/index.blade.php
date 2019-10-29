@extends('layouts.BootStrapBody')
@section('title','Admin')

@section('MainContent')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left titleInfo">
                <h2>@lang('parkinsoft.abmAdminLinkTitle')</h2>
            </div>
            <div class="float-right">
                <a class="btn btn-success btn-sm" href="{{ route('abmAdmin.create') }}"> @lang('parkinsoft.adminCreateNew')</a>
            </div>
        </div>
    </div>

    <p>
    <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#filterPanel" aria-expanded="false" aria-controls="collapseExample">
        @lang('parkinsoft.enableFilters') 
    </button>
    </p>
        <div class="collapse show" id="filterPanel">
        <form action="{{ route('abmAdmin.index') }}" method="GET">
        @csrf
  
        <div class="row">
            <div class="col-xs-3 col-sm-3 col-md-3">
                <div class="form-group">
                    <strong>@lang('parkinsoft.email'):</strong>
                    <input type="text" name="email" class="form-control"
                        value= "{{Request::old('email')}}">
                </div>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3">
                <div class="form-group">
                    <strong>@lang('parkinsoft.user'):</strong>
                    <input type="text" name="usuario" class="form-control" 
                     value= "{{Request::old('usuario')}}">
                </div>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3">
                <div class="form-group">
                    <strong>@lang('parkinsoft.gender'):</strong>
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
                        <button type="submit" class="btn btn-primary">
                            @lang('parkinsoft.filterFilters')
                        </button>
                </div>             
        </form>
                <div class="col-xs-6 col-sm-6 col-md-6" style="margin-bottom: 1%;">
                    <form action="{{ route('abmAdmin.index') }}" method="GET">
                        @csrf
                        <button type="submit" class="btn btn-primary">@lang('parkinsoft.clearFilters')</button>
                    </form>
                </div>
            </div>
    </div>

    </div>
   
    <div style="display:none">
        <input type="hidden" id="AdminDeleteRowHidden">
    </div>

    <table class="table table-bordered table-sm table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>@lang('parkinsoft.email')</th>
            <th>@lang('parkinsoft.user')</th>
            <th>@lang('parkinsoft.gender')</th>
            <th>@lang('parkinsoft.nacDate')</th>
            <th width="280px">@lang('parkinsoft.actions')</th>
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
                
   
                    <a class="btn btn-info btn-sm"  href="{{ route('abmAdmin.show',[$row->id]) }}">
                    <span data-feather="trash"></span>
                        @lang('parkinsoft.showButton')
                    </a>
    
                    <a class="btn btn-sm editButton" href="{{ route('abmAdmin.edit',$row->id) }}">
                        <span class=""></span>
                        @lang('parkinsoft.editButton')
                    </a>
   

                <form action="{{ route('abmAdmin.destroy',$row->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
      
                    <button type="submit" style="display:none" id="deleteButton{{$row->id}}" ></button>

                    <button type="button" class="btn btn-danger btn-sm" data-whatever="{{$row->id}}"
                        data-toggle="modal"  data-target="#deleteAdminModal">
                        <span data-feather="trash-2"></span>
                        @lang('parkinsoft.deleteButton')
                    </button>

                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
  
       {!! $user->render() !!}
      
       @if ($message = Session::get('success'))
        <!-- Modal -->
        <div class="modal fade" id="adminMessageModal" tabindex="-1" role="dialog" aria-labelledby="adminMessageModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="adminMessageModalLabel">@lang('parkinsoft.adminModalTitle')</h5>
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


        <div class="modal fade" id="deleteAdminModal" tabindex="-1" role="dialog" aria-labelledby="deleteAdminModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteAdminModalLabel">@lang('parkinsoft.deleteModalTitle')</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                        <div class="modal-body">
                            @lang('parkinsoft.adminConfirmDelete')
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm cancelButton" data-dismiss="modal">@lang('parkinsoft.cancelButton')</button>
                        <button type="button" class="btn btn-sm acceptButton" onclick="Admin.deleteAdmin();">@lang('parkinsoft.acceptButton')</button>
                    </div>
                </div>
            </div>
        </div>



@endsection