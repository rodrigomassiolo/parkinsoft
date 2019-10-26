@extends('layouts.BootStrapBody')
@section('title','Abm Admin')

@section('MainContent')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>@lang('parkinsoft.abmAdminLink')</h2>
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
                    <strong>Email: </strong>
                    <input type="text" name="email" class="form-control"
                     placeholder="Email a filtrar" value= "{{Request::old('email')}}">
                </div>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3">
                <div class="form-group">
                    <strong>Usuario:</strong>
                    <input type="text" name="usuario" class="form-control" 
                    placeholder="Usuario a filtrar" value= "{{Request::old('usuario')}}">
                </div>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3">
                <div class="form-group">
                    <strong>Sexo:</strong>
                    <input type="text" name="sexo" class="form-control" maxlength="1" 
                    placeholder="Sexo a filtrar" value= "{{Request::old('sexo')}}">
                </div>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3">
                <div class="form-group">
                    <strong>Fecha de Nacimiento:</strong>
                    <input type="date" name="fechaDeNac" class="form-control" 
                    placeholder="Fecha de nacimiento a filtrar" value= "{{Request::old('FechaDeNac')}}">
                </div>
            </div>
        </div>
        <div>
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6" style="margin-bottom: 1%;">
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>             
                </form>
                    <form action="{{ route('abmAdmin.index') }}" method="GET">
                    @csrf
                    <div class="col-xs-6 col-sm-6 col-md-6" style="margin-bottom: 1%;">
                        <button type="submit" class="btn btn-primary">Borrar filtros</button>
                    </div>
                </form>
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
            <th>Email</th>
            <th>Usuario</th>
            <th>Genero</th>
            <th>Fecha de Nacimiento</th>
            <th width="280px">Acciones</th>
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
                <form action="{{ route('abmAdmin.destroy',$row->id) }}" method="POST">
   
                    <a class="btn btn-info btn-sm" href="{{ route('abmAdmin.show',[$row->id]) }}">
                    <span data-feather="trash"></span>
                        Mostrar
                    </a>
    
                    <a class="btn btn-primary btn-sm" href="{{ route('abmAdmin.edit',$row->id) }}"><span class=""></span>Editar</a>
   
                    @csrf
                    @method('DELETE')
      
                    <button type="submit" style="display:none" id="deleteButton{{$row->id}}" ></button>

                    <button type="button" class="btn btn-danger btn-sm" data-whatever="{{$row->id}}"
                        data-toggle="modal"  data-target="#deleteAdminModal" title="Eliminar">
                        <span data-feather="trash-2"></span>
                        Eliminar
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('parkinsoft.closeButton')</button>
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('parkinsoft.cancelButton')</button>
                        <button type="button" onclick="Admin.deleteAdmin();" class="btn btn-secondary">@lang('parkinsoft.acceptButton')</button>
                    </div>
                </div>
            </div>
        </div>



@endsection