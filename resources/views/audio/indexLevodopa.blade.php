@extends('layouts.BootStrapBody')
@section('title','Test de Levodopa')

@section('MainContent')

<h2 class="titleInfo">
  @lang('parkinsoft.levodopaTest')
</h2>

  @if($mode == 0)
  <form method="GET" action="{{ route('TestLevodopaFilter') }}">
    <div class="form-group">
        @if($pacientes != null)
          <div class="col-md-12 col-sm-12 col-lg-12">
              <strong>@lang('parkinsoft.patient'):</strong>
              <select name="user_id" class="form-control">
                @foreach ($pacientes as $paciente)
                  <option value="{{ $paciente->id }}"> {{ $paciente->usuario}} - {{$paciente->email}} </option>
                @endforeach
              </select>
          </div>
        @endif 
    </div>
    <div class="col-md-6 col-sm-6 col-lg-3">
          <button type="submit" class="btn btn-primary"> @lang('parkinsoft.filterFilters')</button>
    </div>
    
  </form>
  <form method="GET" action="{{ route('TestLevodopa') }}">
  <input type="hidden" value="" name="user_id">
  <div class="col-md-6 col-sm-6 col-lg-3">
    <button type="submit" class="btn btn-primary"> @lang('parkinsoft.clearFilters')</button>
    </div>
  </form>
  @endif

  @if($mode == 1)
  <form method="GET" action="{{ route('TestLevodopaFilter') }}">
    <div class="form-group">
      @if($pacientes != null)
      <div class="col-md-12 col-sm-12 col-lg-12">
          <strong>@lang('parkinsoft.patient'):</strong>
          <select name="user_id" class="form-control">
            @foreach ($pacientes as $paciente)
              @if($paciente->id == $preset['id'])
              <option value="{{ $paciente->id }}" selected> {{ $paciente->usuario }} - {{$paciente->email}}</option>
              @else
              <option value="{{ $paciente->id }}"> {{ $paciente->usuario }} - {{$paciente->email}}</option>
              @endif
            @endforeach
          </select>
      </div>
      @endif
      </div> 
      <div class="col-md-6 col-sm-6 col-lg-3">
          <button type="submit" class="btn btn-primary"> @lang('parkinsoft.filterFilters')</button>
    </div>
    
  </form>
  <form method="GET" action="{{ route('TestLevodopa') }}">
  <input type="hidden" value="" name="user_id">
  <div class="col-md-6 col-sm-6 col-lg-3">
    <button type="submit" class="btn btn-primary"> @lang('parkinsoft.clearFilters')</button>
    </div>
  </form>
  <div> 

    <table class="table table-bordered table-sm table-hover">
    <thead>
        <tr>
            <th>@lang('parkinsoft.user')</th>
            <th>@lang('parkinsoft.description')</th>
            <th>N° Ej. OFF</th>
            <th>N° Ej. OFF</th>
            <th>@lang('parkinsoft.createDate')</th>
            <th width="320px">@lang('parkinsoft.actions')</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($results as $row)
        @if($row->user_id == $preset['id'])
        <tr>
        @foreach ($pacientes as $paciente)
              @if($paciente->id == $row->user_id)
              <td>{{ $paciente->usuario }}</td>
              @endif
        @endforeach
            <td>{{ $row->ejercicio_descripcion }}</td>
            <td>{{ $row->pacienteejercicio_OFF_id  }}</td>
            <td>{{ $row->pacienteejercicio_ON_id}}</td>
            <td>{{ $row->fecha}}</td>
            <td>
            <button type="button" class="btn btn-primary" id="{{$row->pacienteejercicio_OFF_id}}"
                 data-toggle="modal" data-target="#levoModal" data-whatever="{{$row->user_id}},{{$row->pacienteejercicio_OFF_id}},{{$row->pacienteejercicio_ON_id}}">@lang('parkinsoft.process')</button>
            </td>
        </tr>
        @endif
        @endforeach
        </tbody>
    </table>

    <div class="modal fade" id="levoModal" tabindex="-1" role="dialog" aria-labelledby="levoModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title" id="levoModalLabel">@lang('parkinsoft.selectGraphic')</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <form method = "POST" id="levoForm" action="/audio/processAudio">
          <input type="hidden" id="useriD" name="user_id">
          <input type="hidden" id="levo1" name="pacienteEjercicio">
          <input type="hidden" id="levo2" name="CompareAudio1">
          <div class="form-group">
          @csrf
            <label><input type="checkbox" name="Energy"  value="1" checked> Energy</label><br>
            <label><input type="checkbox" name="eGemaps" value="1" checked> eGemaps</label><br>
            <label><input type="checkbox" name="Chroma"  value="1" checked> Chroma</label><br>
            <label><input type="checkbox" name="Audspec" value="1" checked> Audspec</label><br>
            <label><input type="checkbox" name="Prosody" value="1" checked> Prosody</label><br>  
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-sm closeButton" data-dismiss="modal">@lang('parkinsoft.closeButton')</button>
            <button type="submit" name="View" value="1" class="btn btn-primary" onclick="Levo.generateGraphicLevo();">Ver grafico</button>
            <button type="submit" name="output" value="pdf" class="btn btn-primary" onclick="Levo.downloadGraphicLevo();">Descargar como PDF</button>
          </div>   
        </form>
      </div>
    
    </div>
  </div>
</div>

@endif



@endsection