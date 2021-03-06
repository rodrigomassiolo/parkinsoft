@extends('layouts.BootStrapBody')
@section('title','Base de Datos')

@section('MainContent')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>@lang('parkinsoft.BDLinkTitle')</h2>
            </div>
        </div>
    </div>
   
    <div style="display:none">
        <input type="hidden" id="tableRowHidden">
    </div>

    @csrf

    <table class="table table-bordered table-sm table-hover">
    <thead>
        <tr>
            <th>@lang('parkinsoft.nameTable')</th>
            <th width="280px">@lang('parkinsoft.actions')</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tablas as $row)
        @if($row != "Tables_in_parkinsoft")
        <tr>
            <td>{{ $row}}</td>
            <td>
                <button type="button" class="btn btn-danger btn-sm" data-whatever="{{ $row}}"
                    data-toggle="modal"  data-target="#columnBDModal" 
                    onclick="BD.showColumns('{!! $row !!}');" 
                >
                    @lang('parkinsoft.BDShowColumnsButton')
                </button>
            </td>
        </tr>
        @endif
        @endforeach
        </tbody>
    </table>
      
       @if ($message = Session::get('success'))
        <!-- Modal -->
        <div class="modal fade" id="BDMessageModal" tabindex="-1" role="dialog" aria-labelledby="BDMessageModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="BDMessageModalLabel">@lang('parkinsoft.BDModalTitle')</h5>
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


        <div class="modal fade" id="deleteBDModal" tabindex="-1" role="dialog" aria-labelledby="deleteBDModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteBDModalLabel">@lang('parkinsoft.deleteModalTitle')</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                        <div class="modal-body">
                            @lang('parkinsoft.BDConfirmDelete')
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('parkinsoft.cancelButton')</button>
                        <button type="button" onclick="BD.deleteBD();" class="btn acceptButton">@lang('parkinsoft.acceptButton')</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="columnBDModal" tabindex="-1" role="dialog" aria-labelledby="columnBDModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="min-width:50%;">
                <div class="modal-content modal-lg">
                    <div class="modal-header">
                        <h5 class="modal-title" id="columnBDModalLabel">@lang('parkinsoft.BDColumnModalTitle')</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                        <div class="modal-body" style="min-height:200px;" id="columnModalBody">
                        
                        <table class="table table-bordered table-sm table-hover" id="columnTable">
                            <thead>
                                <tr>
                                    <td>
                                    @lang('parkinsoft.BDColumnName')
                                    </td>
                                    <td>
                                    @lang('parkinsoft.BDIndexName')
                                    </td>
                                    <td>
                                    @lang('parkinsoft.actions')
                                    </td>
                                </tr>
                            </thead>
                            <tbody id="columnTableBody"> 
                            </tbody>
                        </table>

                        
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn backButton" data-dismiss="modal">@lang('parkinsoft.backButton')</button>
                        <button type="button" onclick="BD.createIndex();" class="btn btn-secondary" data-dismiss="modal">@lang('parkinsoft.BDCreateNewButton')</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="indexModal" tabindex="-1" role="dialog" aria-labelledby="deleteBDModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteBDModalLabel">@lang('parkinsoft.deleteModalTitle')</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                        <div class="modal-body">
                            <label>@lang('parkinsoft.BDColumnName')</label>
                            <select id="getColumn"></select>
                            <br><br>
                            <label>@lang('parkinsoft.BDIndexName')</label>
                            <input type="text" name="nombre_index" id="newnombre_index">
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('parkinsoft.cancelButton')</button>
                        <button type="button" onclick="BD.CreateIndexPut();" class="btn acceptButton">@lang('parkinsoft.acceptButton')</button>
                    </div>
                </div>
            </div>
        </div>

     <!-- Message -->
     <div class="modal fade" id="createM" tabindex="-1" role="dialog" aria-labelledby="createML">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createML">@lang('parkinsoft.BDModalTitle')</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                  
                        <div class="modal-body" id="createMBody">
                            @lang('parkinsoft.BDCreateIndexMessage')          
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn closeButton" data-dismiss="modal">@lang('parkinsoft.closeButton')</button>
                    </div>
                </div>
            </div>
        </div>




@endsection