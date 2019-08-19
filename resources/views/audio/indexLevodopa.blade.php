@extends('layouts.BootStrapBody')
@section('title','Carga de Audio')

@section('MainContent')

<form action="{{ route('sendAudioLevodopa') }}" method="POST" enctype="multipart/form-data">
    @csrf
  <div class="form-group">
    <label for="exampleFormControlFile1">Ingresar Audio sin medicación</label>
    <input type="file" class="form-control-file" id="audio1" name="audio1">
  </div>
  <div class="form-group">
    <label for="exampleFormControlFile1">Ingresar Audio con medicación</label>
    <input type="file" class="form-control-file" id="audio2" name="audio2">
  </div>

  <button type="submit"> Enviar </button>
</form>


@endsection