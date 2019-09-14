@extends('layouts.BootStrapBody')
@section('title','Carga de Audio')

@section('MainContent')

<form action="{{ route('sendAudio') }}" method="POST" enctype="multipart/form-data">
    @csrf
  <div class="form-group">
    <input type="hidden" id="View" name="View" value="1">
    <label for="exampleFormControlFile1">Ingresar Audio</label>
    <input type="file" class="form-control-file" id="audio" name="audio">
  </div>

  <button type="submit"> Enviar </button>
</form>

@if ($message = Session::get('success'))
<div class="alert alert-success alert-block">
	<button type="button" class="close" data-dismiss="alert">×</button>	
        <strong>{{ $message }}</strong>
</div>
@endif  



@endsection