@extends('layouts.BootStrapBody')
@section('title',trans('parkinsoft.audioListLinkAssigned'))

@section('MainContent')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>@lang('parkinsoft.audioListLinkAssigned')</h2>
            </div>

        </div>
    </div>

    <p>
    <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#filterPanel" aria-expanded="false" aria-controls="collapseExample">
     @lang('parkinsoft.enableFilters')
    </button>
    </p>
        <div class="collapse show" id="filterPanel">
        <form action="{{ route('listaDeEjerciciosAsignados') }}" method="GET">
        @csrf
  
        <div class="row">
                <div class="col-md-3 col-sm-3 col-lg-3">
                        <strong>Paciente:</strong>
                            <select name="user_id" id="user_id" class="form-control">
                                @if(count($pacientes)>1)
                                <option value=""></option>
                                @endif
                                  @foreach ($pacientes as $paciente)
                                    <option value="{{ $paciente->id }}"> {{ $paciente->usuario }} </option>
                                  @endforeach
                            </select>
                        </div>  
                        <div class="col-md-3 col-sm-3 col-lg-3">
                                <strong>Tipo de Ejercicio</strong>
                                <select name="ejercicio_id" id="ejercicio_id" class="form-control">
                                  <option value=""></option>
                                  @foreach ($ejercicio as $ej)
                                    <option value="{{ $ej->id }}" desc="{{ $ej->descripcion }}"> {{ $ej->nombre }} </option>
                                  @endforeach
                                </select>
                        </div>

            <div class="col-xs-3 col-sm-3 col-md-3">
                <div class="form-group">
                    <strong>Fecha:</strong>
                    <input type="date" name="created_at" class="form-control" 
                    placeholder="Fecha de subida" value= "{{Request::old('created_at')}}">
                </div>
            </div>
        </div>
        <div>
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6" style="margin-bottom: 1%;">
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>             
                </form>
                    <form action="{{ route('listaDeEjerciciosAsignados') }}" method="GET">
                    @csrf
                    <div class="col-xs-6 col-sm-6 col-md-6" style="margin-bottom: 1%;">
                        <button type="submit" class="btn btn-primary">Borrar filtros</button>
                    </div>
                </form>
            </div>
    </div>

    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered table-sm table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>Usuario</th>
            <th>Ejercicio</th>
            <th>Estado</th>
            <th>Fecha de Creación</th>
            <th width="320px">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($PacienteEjercicio as $row)
        <tr>
            <td>{{ $row->id }}</td>  
            <td>{{ $row->user->usuario }}</td>
            <td>{{ $row->ejercicio->nombre }}</td>
            <td>{{ $row->status }}</td>
            <td>{{ $row->created_at }}</td>
            <td>
                <form action="{{ route('realizarEjercicio')}}" method="GET">
                        <input type="hidden" name="pacienteEjercicio" value="{{$row->id}}">
                        <button class="btn btn-info btn-sm" type="submit">Realizar Ejercicio</button>           
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
  
       {{-- {!! $PacienteEjercicio->render() !!} --}}    
      
@endsection