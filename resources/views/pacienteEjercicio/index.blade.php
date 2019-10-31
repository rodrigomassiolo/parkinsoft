@extends('layouts.BootStrapBody')
@section('title',trans('parkinsoft.audioListLink'))

@section('MainContent')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left titleInfo">
                <h2>@lang('parkinsoft.audioListLink')</h2>
            </div>

        </div>
    </div>

    <p>
    <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#filterPanel" aria-expanded="false" aria-controls="collapseExample">
     @lang('parkinsoft.enableFilters')
    </button>
    </p>
        <div class="collapse show" id="filterPanel">
        <form action="{{ route('listaDeEjerciciosRealizados') }}" method="GET">
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
        </div>
        <div class="row">
            <div class="col-xs-3 col-sm-3 col-md-3">
                <div class="form-group">
                    <strong>@lang('parkinsoft.dateFrom'):</strong>
                    <input type="date" name="created_atFrom" class="form-control" min="1900-01-01" max="2099-12-31"
                     value= "{{Request::old('created_atFrom')}}">
                </div>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3">
                <div class="form-group">
                    <strong>@lang('parkinsoft.dateTo'):</strong>
                    <input type="date" name="created_atTo" class="form-control" min="1900-01-01" max="2099-12-31"
                     value= "{{Request::old('created_atTo')}}">
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
                        <form action="{{ route('listaDeEjerciciosRealizados') }}" method="GET">
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
            @if(Auth::user()->rol->type == 0 || Auth::user()->rol->type == 1)
            <td>
                <button type="button" class="btn btn-primary" id="{{$row->id}}"
                 data-toggle="modal" data-target="#exampleModal" onclick="Lista.fillSelector({{$row->id}});" data-whatever="{{$row->id}}">@lang('parkinsoft.process')</button>
            </td>
            @endif
        </tr>
        @endforeach
        </tbody>
    </table>
  
       {{-- {!! $PacienteEjercicio->render() !!} --}}

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title" id="exampleModalLabel">@lang('parkinsoft.selectGraphic')</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="row" name="row">
        <form method = "POST" id="graphicForm">
          <div class="form-group">
          @csrf
            <label><input type="checkbox" name="Energy"  value="1" checked> Energy</label><br>
            <label><input type="checkbox" name="eGemaps" value="1" checked> eGemaps</label><br>
            <label><input type="checkbox" name="Chroma"  value="1" checked> Chroma</label><br>
            <label><input type="checkbox" name="Audspec" value="1" checked> Audspec</label><br>
            <label><input type="checkbox" name="Prosody" value="1" checked> Prosody</label><br>  
    

            <div id="CompareDiv">
                <div class="row">
                    <div class="col-10 offset-2-md">
                        <strong>@lang('parkinsoft.compareAudioFirst'):</strong>
                        <select id="se1" name="CompareAudio1"></select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-10 offset-2-md">
                        <strong>@lang('parkinsoft.compareAudioSecond'):</strong>
                        <select id="se2" name="CompareAudio2"></select>
                    </div>
                </div>
            </div>

            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-sm closeButton" data-dismiss="modal">@lang('parkinsoft.closeButton')</button>
            <button type="submit" name="View" value="1" class="btn btn-sm btn-primary" onClick="Lista.generateGraphic();">@lang('parkinsoft.showHtmlGraphicButton')</button>
            <button type="submit" name="output" value="pdf" class="btn btn-sm btn-primary" onClick="Lista.downloadGraphic();">@lang('parkinsoft.downloadPdfGraphicButton')</button>
          </div>   
        </form>
      </div>
    
    </div>
  </div>
</div>

@if ($message = Session::get('success'))
        <!-- Modal -->
        <div class="modal fade" id="oneGraphicModal" tabindex="-1" role="dialog" aria-labelledby="adminMessageModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="adminMessageModalLabel">@lang('parkinsoft.selectGraphic')</h5>
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
      
@endsection