$( document ).ready(function() {

    $('#exerciseMessageModal').modal('show');
    $('#adminMessageModal').modal('show');
    $('#userMessageModal').modal('show');
    $('#medicMessageModal').modal('show');
    $('#operacionMessageModal').modal('show');
    $('#BDMessageModal').modal('show');
  
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
    deleteColumnIndex: function(deleteRow){
      $.ajax({
        type:'POST',
        url:'/BaseDeDatos/deleteIndex',
        data:{nombre_index:deleteRow.nombre_index, tabla: deleteRow.tabla,View:1},
        success:function(data){
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
                              + '<td><button type="button" onclick="BD.deleteColumnIndex('+ deleteRow +');">Eliminar Indice</button></td>';
              }
            })
          }
          

        }
     });
    },

    createIndex: function(){
     $("#getColumn").select2(
      {
        language:'es',
        width:'100%',
        minimumInputLength: 2,
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
        success:function(data){
          alert('creado');
        }
     });
    }
  }
