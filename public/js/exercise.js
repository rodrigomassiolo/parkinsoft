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
    // deleteColumnIndex: function(){
    //   var row = $('#BDDeleteRowHidden').val();
    //   $("#deleteButton" + row).click();
    // }
    showColumns: function(element){

      $.ajax({
        type:'GET',
        url:'/BaseDeDatos/showColumnsFromTable',
        data:{tabla:element},
        success:function(data){
          for(i=0; i <= data.length; i++){
            var column = data[i];

            var table = $("#columnTable");
            var row = table.insertRow();
            var col1 = row.insertCell(0);
            var col2 = row.insertCell(1);
            col1.innerHTML = column;
            col2.html = '<button type="button" onclick="BD.addIndex('+ column +')">Agregar indice</button>' 
          }
           
        }
     });


    }
  }
