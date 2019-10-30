@extends('layouts.BootStrapBody')
@section('title','Historial')

@section('MainContent')

@if(Auth::user()->rol->type == 2)
<h2 class="titleInfo">
    Historial de audios subidos
</h2>
<br>

    @if($PacienteEjercicio->count() > 0)
    <table class="table table-bordered table-sm table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Ejercicio</th>
                <th>Fecha de Creación</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($PacienteEjercicio as $row)
            <tr>
                <td>{{ $row->id }}</td>  
                <td>{{ $row->ejercicio->descripcion }}</td>
                <td>{{ $row->created_at }} </td> 
        
            </tr>
            @endforeach
            </tbody>
        </table>
    @else
        @lang('parkinsoft.noHistorialToShow')
    @endif

@endif

@endsection