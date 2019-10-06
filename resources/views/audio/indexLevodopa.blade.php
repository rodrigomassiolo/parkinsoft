@extends('layouts.BootStrapBody')
@section('title','Carga de Audio')

@section('MainContent')

<form action="{{ route('sendAudio') }}" method="POST" enctype="multipart/form-data">
    @csrf
  <div class="form-group">
    @foreach($ejercicio as $ej)
      @if($ej->nombre == 'levodopa1')
        <input type="hidden" name="ejercicio" value="{{ $ej->id }}">
      @endif
    @endforeach
    <label for="exampleFormControlFile1">@lang('parkinsoft.levodopaFirstAudioText')</label>
    <input type="file" class="form-control-file" id="audio" name="audio">
  </div>

  <button type="submit" name="Levodopa" value="1"> @lang('parkinsoft.levodopaFirstAudioButton') </button>
</form>

<form action="{{ route('sendAudio') }}" method="POST" enctype="multipart/form-data">
    @csrf
  <div class="form-group">
  @foreach($ejercicio as $ej)
      @if($ej->nombre == 'levodopa2')
        <input type="hidden" name="ejercicio" value="{{ $ej->id }}">
      @endif
    @endforeach
    <label for="exampleFormControlFile1">@lang('parkinsoft.levodopaSecondAudioText')</label>
    <input type="file" class="form-control-file" id="audio" name="audio">
  </div>
  
  <button type="submit" name="Levodopa" value="1"> @lang('parkinsoft.levodopaSecondAudioButton') </button>
</form>



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
        !Su audio ha sido cargado correctamente!
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
@endif




@endsection