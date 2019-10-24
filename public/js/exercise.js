$( document ).ready(function() {

    $('#exerciseMessageModal').modal('show');
    $('#adminMessageModal').modal('show');
    $('#userMessageModal').modal('show');
    $('#medicMessageModal').modal('show');
  
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
