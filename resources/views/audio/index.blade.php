@extends('layouts.BootStrapBody')
@section('title','Carga de Audio')

@section('MainContent')

<form action="{{ route('sendAudio') }}" method="POST" enctype="multipart/form-data">
    @csrf
  <div class="form-group">
    <label for="exampleFormControlFile1">Ingresar Audio</label>
    <input type="file" class="form-control-file" id="audio" name="audio">
  </div>

  <button type="submit"> Enviar </button>
</form>


@endsection