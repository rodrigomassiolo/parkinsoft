$( document ).ready(function() {

    $('#exerciseMessageModal').modal('show');
  
  });

  $('#deleteExerciseModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) 
    var recipient = button.data('whatever') 
    $('#deleteRowHidden').val(recipient)
  })

  var Exercise = {
    deleteExercise: function(){
      var row = $('#deleteRowHidden').val();

      $("#deleteButton" + row).click();
    }
  }