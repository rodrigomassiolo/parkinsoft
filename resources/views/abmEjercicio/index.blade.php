@extends('layouts.BootStrapBody')
@section('title','Abm Ejercicios')

@section('MainContent')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>@lang('parkinsoft.abmExerciseLink')</h2>
            </div>
            <div class="float-right">
                <a href="{{ route('abmEjercicio.create') }}" class="btn btn-success" >
                <span data-feather="plus-circle"></span>Crear nuevo Ejercicio</a>
            </div>
        </div>
    </div>

    <p>
    <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#filterPanel" aria-expanded="false" aria-controls="collapseExample">
     @lang('parkinsoft.enableFilters')
    </button>
    </p>
        <div class="collapse show" id="filterPanel">
        <form action="{{ route('abmEjercicio.index') }}" method="GET">
        @csrf
  
        <div class="row">
            <div class="col-xs-3 col-sm-3 col-md-3">
                <div class="form-group">
                    <strong>Nombre: </strong>
                    <input type="text" name="nombre" class="form-control"
                     placeholder="Nombre a filtrar" value= "{{Request::old('nombre')}}">
                </div>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3">
                <div class="form-group">
                    <strong>Descripcion:</strong>
                    <input type="text" name="descripcion" class="form-control" 
                    placeholder="Descripcion a filtrar" value= "{{Request::old('descripcion')}}">
                </div>
            </div>
        </div>
        <div>
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6" style="margin-bottom: 1%;">
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>             
                </form>
                    <form action="{{ route('abmEjercicio.index') }}" method="GET">
                    @csrf
                    <div class="col-xs-6 col-sm-6 col-md-6" style="margin-bottom: 1%;">
                        <button type="submit" class="btn btn-primary">Borrar filtros</button>
                    </div>
                </form>
            </div>
    </div>

    </div>
    
    <!-- @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif -->

    <div style="display:none">
        <input type="hidden" id="ExerciseDeleteRowHidden">
    </div>


    <table class="table table-bordered table-sm table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>Nombre</th>
            <th>Descripcion</th>
            <th width="320px">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($ejercicio as $row)
        <tr>
            <td>{{ $row->id }}</td>  
            <td>{{ $row->nombre }}</td>
            <td>{{ $row->descripcion }}</td>
            <td>
                <form action="{{ route('abmEjercicio.destroy',$row->id) }}" method="POST">
                @if ($row->audio_example_path)
                        <a class="btn btn-success btn-sm" href="{{ route('donwloadAudioExample',[$row->id]) }}" data-toggle="tooltip" title="Descargar Audio de Ejemplo">
                        <span data-feather="download"></span>
                        Ejemplo
                        </a>
                @endif
                <a class="btn btn-info btn-sm" href="{{ route('abmEjercicio.show',[$row->id]) }}"
                    data-toggle="tooltip" title="Mostrar">
                    <span data-feather="eye"></span>
                        Mostrar
                </a>
    
                <a class="btn btn-primary btn-sm" href="{{ route('abmEjercicio.edit',$row->id) }}" 
                    data-toggle="tooltip" title="Editar">
                    <span data-feather="edit"></span>
                    Editar
                </a>

                    @csrf
                    @method('DELETE')
      
                    <button type="submit" style="display:none" id="deleteButton{{$row->id}}" ></button>

                    <button type="button" class="btn btn-danger btn-sm" data-whatever="{{$row->id}}"
                    data-toggle="modal"  data-target="#deleteExerciseModal" title="Eliminar">
                    <span data-feather="trash-2"></span>
                        Eliminar
                    </button>
                </form>
                
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
  
       {!! $ejercicio->render() !!}
      
       @if ($message = Session::get('success'))
        <!-- Modal -->
        <div class="modal fade" id="exerciseMessageModal" tabindex="-1" role="dialog" aria-labelledby="exerciseMessageModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exerciseMessageModalLabel">@lang('parkinsoft.exerciseModalTitle')</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                  
                        <div class="modal-body">
                            {{ $message }}
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('parkinsoft.closeButton')</button>
                    </div>
                </div>
            </div>
        </div>
        @endif


        <div class="modal fade" id="deleteExerciseModal" tabindex="-1" role="dialog" aria-labelledby="deleteExerciseModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteExerciseModalLabel">@lang('parkinsoft.deleteModalTitle')</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                        <div class="modal-body">
                            @lang('parkinsoft.exerciseConfirmDelete')
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('parkinsoft.cancelButton')</button>
                        <button type="button" onclick="Exercise.deleteExercise();" class="btn btn-secondary">@lang('parkinsoft.acceptButton')</button>
                    </div>
                </div>
            </div>
        </div>





@endsection