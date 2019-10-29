@extends('layouts.BootStrapBody')
@section('title','Operacion')

@section('MainContent')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left titleInfo">
                <h2>@lang('parkinsoft.operacionLinkTitle')</h2>
            </div>
            <div class="float-right">
                <a class="btn btn-success btn-sm" href="{{ route('operacion.create') }}"> @lang('parkinsoft.operacionCreateNew')</a>
            </div>
        </div>
    </div>

    <p>
    <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#filterPanel" aria-expanded="false" aria-controls="collapseExample">
     @lang('parkinsoft.enableFilters') 
    </button>
    </p>
        <div class="collapse show" id="filterPanel">
        <form action="{{ route('operacion.index') }}" method="GET">
        @csrf
  
        
        <div class="row">
            <div class="col-md-3 col-sm-3 col-lg-3">
                <div class="form-group">
                    <strong>@lang('parkinsoft.user')</strong>
                    <select name="user_id" id="user_id" class="form-control">
                        @foreach ($pacientes as $paciente)
                        <option value="{{ $paciente->id }}"> {{ $paciente->usuario }} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            {{-- <div class="col-xs-3 col-sm-3 col-md-3">
                <div class="form-group">
                    <strong>@lang('parkinsoft.user')</strong>
                    <input type="text" name="usuario" class="form-control" 
                    value= "{{Request::old('usuario')}}">
                </div>
            </div>
        </div> --}}
        <div>
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6" style="margin-bottom: 1%;">
                        <button type="submit" class="btn btn-primary">@lang('parkinsoft.filterFilters')</button>
                </div>             
        </form>
        <div class="col-xs-6 col-sm-6 col-md-6" style="margin-bottom: 1%;">
            <form action="{{ route('operacion.index') }}" method="GET">
                @csrf
                <button type="submit" class="btn btn-primary">@lang('parkinsoft.clearFilters')</button>
            </form>
        </div>
            </div>
    </div>

    </div>
   
    <div style="display:none">
        <input type="hidden" id="OperacionDeleteRowHidden">
    </div>

    <table class="table table-bordered table-sm table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>@lang('parkinsoft.user')</th>
            <th>@lang('parkinsoft.date')</th>
            <th>@lang('parkinsoft.description')</th>
            <th width="280px">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($operacion as $row)
        <tr>
            <td>{{ $row->id }}</td>  
            <td>{{ $row->user->usuario }}</td>
            <td>{{ $row->fecha }}</td>
            <td>{{ $row->descripcion}}</td>
            <td>
                <form action="{{ route('operacion.destroy',$row->id) }}" method="POST">
   
                    <a class="btn btn-info btn-sm" href="{{ route('operacion.show',[$row->id]) }}">
                    <span data-feather="trash"></span>
                        @lang('parkinsoft.showButton')
                    </a>
    
                    <a class="btn btn-sm editButton" href="{{ route('operacion.edit',$row->id) }}">
                        <span class=""></span> @lang('parkinsoft.editButton')</a>
   
                    @csrf
                    @method('DELETE')
      
                    <button type="submit" style="display:none" id="deleteButton{{$row->id}}" ></button>

                    <button type="button" class="btn btn-danger btn-sm" data-whatever="{{$row->id}}"
                        data-toggle="modal"  data-target="#deleteOperacionModal" title="Eliminar">
                        <span data-feather="trash-2"></span>
                        @lang('parkinsoft.deleteButton')
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
  
       {!! $operacion->render() !!}
      
       @if ($message = Session::get('success'))
        <!-- Modal -->
        <div class="modal fade" id="operacionMessageModal" tabindex="-1" role="dialog" aria-labelledby="operacionMessageModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="operacionMessageModalLabel">@lang('parkinsoft.operacionModalTitle')</h5>
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


        <div class="modal fade" id="deleteOperacionModal" tabindex="-1" role="dialog" aria-labelledby="deleteOperacionModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteOperacionModalLabel">@lang('parkinsoft.deleteModalTitle')</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                        <div class="modal-body">
                            @lang('parkinsoft.operacionConfirmDelete')
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm cancelButton" data-dismiss="modal">@lang('parkinsoft.cancelButton')</button>
                        <button type="button" onclick="Operacion.deleteOperacion();" class="btn btn-sm acceptButton">@lang('parkinsoft.acceptButton')</button>
                    </div>
                </div>
            </div>
        </div>



@endsection