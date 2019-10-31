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
                <input type="hidden" id="paciente_id" name="paciente_id" value="{{ $paciente_id }}">
                <div class="col-md-3 col-sm-3 col-lg-3">
                        <strong>@lang('parkinsoft.patient'):</strong>
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
                                <strong>@lang('parkinsoft.exerciseType'):</strong>
                                <select name="ejercicio_id" id="ejercicio_id" class="form-control">
                                  <option value=""></option>
                                  @foreach ($ejercicio as $ej)
                                    <option value="{{ $ej->id }}" desc="{{ $ej->descripcion }}"> {{ $ej->nombre }} </option>
                                  @endforeach
                                </select>
                        </div>

            <div class="col-xs-3 col-sm-3 col-md-3">
                <div class="form-group">
                    <strong>@lang('parkinsoft.date'):</strong>
                    <input type="date" name="created_at" class="form-control" min="1900-01-01" max="2099-12-31"
                     value= "{{Request::old('created_at')}}">
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
                    <form action="{{ route('listaDeEjerciciosAsignados') }}" method="GET">
                    @csrf
                   
                        <button type="submit" class="btn btn-primary">@lang('parkinsoft.clearFilters')</button>
                        </form>
                    </div>
                
            </div>
    </div>

    </div>

    <table class="table table-bordered table-sm table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>@lang('parkinsoft.user')</th>
            <th>@lang('parkinsoft.exercise')</th>
            <th>@lang('parkinsoft.status')</th>
            <th>@lang('parkinsoft.isLevodopa')</th>
            <th>@lang('parkinsoft.onOff')</th>
            <th>@lang('parkinsoft.createDate')</th>
            <th width="320px">@lang('parkinsoft.actions')</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($PacienteEjercicio as $row)
        <tr>
            <td>{{ $row->id }}</td>  
            <td>{{ $row->user->usuario }}</td>
            <td>{{ $row->ejercicio->nombre }}</td>
            <td>{{ $row->status }}</td>
            @if($row->es_levodopa == 1 )
                <td>@lang('parkinsoft.yes')</td>
            @else
                <td>No</td>
            @endif
            @if($row->es_levodopa == 1)
                <td>{{ $row->modo_levodopa }}</td>
            @else
                <td>-</td>
            @endif
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