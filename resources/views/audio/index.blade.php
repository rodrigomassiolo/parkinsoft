@extends('layouts.BootStrapBody')
@section('title','Carga de Audio')

@section('MainContent')

<h2 class="titleInfo">
  @lang('parkinsoft.uploadAudioTitle')
</h2>
<br>

<form action="{{ route('sendAudio') }}" method="POST" enctype="multipart/form-data">
    @csrf
  <div class="form-group row inputs">
    @if($pacientes != null)
    <div class="col-md-6 col-sm-6 col-lg-3">
        <strong>@lang('parkinsoft.patient'):</strong>
        <select name="user" id="user" class="form-control" required>
          <option selected disabled hidden style='display: none' value=''>@lang('parkinsoft.selectPatient')</option>
          @foreach ($pacientes as $paciente)
            <option value="{{ $paciente->id }}"> {{ $paciente->usuario }} </option>
          @endforeach
        </select>
      </div>
    @endif  
    <input type="hidden" id="audio_preset_paciente" value="{{ $preset }}">
    <div class="col-md-6 col-sm-6 col-lg-3">
      <input type="hidden" name="View" value="1">
      <strong>@lang('parkinsoft.exerciseType'):</strong>
      <select name="ejercicio" id="audio_select_ejercicio" class="form-control" required>
        <option selected disabled hidden style='display: none' value='' >@lang('parkinsoft.selectExerciseType')</option>
        @foreach ($ejercicio as $ej)
          <option value="{{ $ej->id }}" desc="{{ $ej->descripcion }}"> {{ $ej->nombre }} </option>
        @endforeach
      </select>
    </div>
    <div class="col-md-6 col-sm-6 col-lg-3">
      <strong>@lang('parkinsoft.isLevodopaLabel'):</strong>
      <select id="es_levodopa" name="es_levodopa" class="form-control"><option value=0>NO</option><option value=1>SI</option></select>
    </div>
    <div class="col-md-6 col-sm-6 col-lg-3"  style="display: none;">
        <strong>@lang('parkinsoft.onOff'):</strong>
      <select id="modo_levodopa" name="modo_levodopa" class="form-control"><option value="ON">ON</option><option value="OFF">OFF</option></select>
    </div>
  </div>  

  <div class="form-group row inputs">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <strong> @lang('parkinsoft.exerciseDescription'):</strong>
        <input type="text" disabled class="form-control" id ="ejercicioDesc" value="">
      </div>
  </div>

  <div class="form-group row inputs">
    <div class="col-md-6 col-sm-6 col-lg-6">
        <strong>@lang('parkinsoft.uploadAudioLabel'):</strong>
      <input type="file" class="form-control-file" id="audio" name="audio">
    </div>
    <div class="col-md-6 col-sm-6 col-lg-6">
        <strong>@lang('parkinsoft.audioQuality'):</strong>
        <select id="origen_audio" name="origen_audio" class="form-control">
            <option selected disabled hidden style='display: none' value='celular' required>@lang('parkinsoft.selectAudioQuality')</option>          
            <option value="celular">Celular</option>
            <option value="profesional">Profesional</option>
        </select>
    </div>
  </div>
  <div class="form-group row inputs">
      <div class="col-xs-12 col-sm-12 col-md-12">
          <strong>@lang('parkinsoft.medication'):</strong> 
          <input type="text" name="ultimaMedicacion" placeholder="Ingrese la última medicación tomada y la hora" class="form-control">
      </div>
  </div>

  <div class="centerButton row">
    <div class="col-lg-12" style="text-align:center">
      <button type="submit" class="btn btn-sm sendButton"> @lang('parkinsoft.sendButton') </button>
    </div>
  </div>
  
</form>


<br><br>
<h6 class="tableInfo"
  >Historial de audios subidos
</h6>

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
        @if(Auth::user()->rol->type == 0 || Auth::user()->rol->type == 1)
        <th width="320px">@lang('parkinsoft.actions')</th>
        @endif
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

       {!! $PacienteEjercicio->render() !!}



@if ($message = Session::get('success'))
        <!-- Modal -->
<div class="modal fade" id="audioModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Carga de audio</h5>
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

@endsection

