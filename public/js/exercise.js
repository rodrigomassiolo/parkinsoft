$( document ).ready(function() {

    $('#exerciseMessageModal').modal('show');
    $('#adminMessageModal').modal('show');
    $('#userMessageModal').modal('show');
    $('#medicMessageModal').modal('show');
    $('#operacionMessageModal').modal('show');
    $('#BDMessageModal').modal('show');
    $('#myDataModal').modal('show');

    $('#ticketModalMSG').modal('show');
  
  
    $('#Operacion_user_id').select2(
        {
          language:'es',
          width:'100%',
          minimumInputLength: 2,
          ajax: {
            url: '/GetUser',
            data: function (params) {
              var query = {
                search: params.term,
                type: 'public'
              }
              return query;
            },
            processResults: function (data) {
              return {
                results: data.items
              };
            }
          }
        });

  });

  $('#deleteExerciseModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) 
    var recipient = button.data('whatever') 
    $('#ExerciseDeleteRowHidden').val(recipient)
  })

  var Exercise = {
    deleteExercise: function(){
      var row = $('#ExerciseDeleteRowHidden').val();

      $("#deleteButton" + row).click();
    }
  }

  $('#deleteAdminModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) 
    var recipient = button.data('whatever') 
    $('#AdminDeleteRowHidden').val(recipient)
  })

  var Admin = {
    deleteAdmin: function(){
      var row = $('#AdminDeleteRowHidden').val();

      $("#deleteButton" + row).click();
    }
  }

  $('#deleteUserModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) 
    var recipient = button.data('whatever') 
    $('#UserDeleteRowHidden').val(recipient)
  })

  var User = {
    deleteUser: function(){
      var row = $('#UserDeleteRowHidden').val();

      $("#deleteButton" + row).click();
    }
  }

  $('#deleteMedicModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) 
    var recipient = button.data('whatever') 
    $('#MedicDeleteRowHidden').val(recipient)
  })

  var Medic = {
    deleteMedic: function(){
      var row = $('#MedicDeleteRowHidden').val();

      $("#deleteButton" + row).click();
    }
  }

  $('#deleteOperacionModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) 
    var recipient = button.data('whatever') 
    $('#OperacionDeleteRowHidden').val(recipient)
  })

  var Operacion = {
    deleteOperacion: function(){
      var row = $('#OperacionDeleteRowHidden').val();

      $("#deleteButton" + row).click();
    }
  }


  var BD = {
    deleteColumnIndex: function(table,col,index,){

      var del = table.split(',');

      $.ajax({
        type:'POST',
        url:'/BaseDeDatos/deleteIndex',
        headers: {
          'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
        },
        data:{nombre_index:del[2], tabla: del[0],View:1},
        success:function(data){
          $('.modal').modal('hide');
          $('#okModalLabel').modal('show');
        }
     });
    },
    showColumns: function(element){

      $('#tableRowHidden').val(element);

      $.ajax({
        type:'GET',
        url:'/BaseDeDatos/showColumnsFromTable',
        data:{tabla:element, View:1},
        success:function(data){

          var table = $("#columnTableBody");
          
          table.html('');

          table.append(data);

          BD.getIndex(element);
        }
     });
    },

    getIndex: function(element){

      $.ajax({
        type:'GET',
        url:'/BaseDeDatos/showIndexesFromTable',
        data:{tabla:element, View:1},
        success:function(data){

          var table = $("#columnTableBody");

          for(i=0;i < data.length; i++){

            $("#columnTable").find('tr').find('td').each(function(){
              if($(this)[0].innerText == data[i].nombre_columna){

                var deleteRow = {tabla : element , nombre_columna: data[i].nombre_columna, nombre_index : data[i].nombre_index}
                var row = $(this).parent();
                row[0].innerHTML = '';
                row[0].innerHTML = '<td>' + data[i].nombre_columna + '</td>'
                              + '<td>' + data[i].nombre_index + '</td>'
                              + '<td><button type="button" onclick="BD.deleteColumnIndex(\''+deleteRow.tabla+','+deleteRow.nombre_columna+','+deleteRow.nombre_index+'\');">Eliminar Indice</button></td>';
              }
            })
          }
        }
     });
    },

    createIndex: function(){
     $('.modal').modal('hide');

     $("#indexModal").modal('show');
     $("#getColumn").select2(
      {
        language:'es',
        width:'100%',
        minimumInputLength: 0,
        ajax: {
          url: '/BaseDeDatos/getColumnSelect',
          data: function (params) {
            var query = {
              search: params.term,
              tabla: $('#tableRowHidden').val(),
              type: 'public'
            }
            return query;
          },
          processResults: function (data) {
            return {
              results: data.items
            };
          }
        }
      });
    },

    CreateIndexPut: function(){

      $.ajax({
        type:'POST',
        url:'/BaseDeDatos/setIndex',
        data:{tabla:$('#tableRowHidden').val(), View:1,columna: $('#getColumn :selected').text(),nombre_index: $('#newnombre_index').val()},
        headers: {
          'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
          },
        success:function(data){
          $('.modal').modal('hide');
          $("#createM").modal('show');
        }
     });
    }
  }
