$( document ).ready(function() {

  Lista.addListener();
  $("#modo_levodopa").parent().hide();
  $("#modo_levodopa").val(null);

  $("#es_levodopa").on('change',function(e){if(e.target.value == 1){
    $("#modo_levodopa").val('ON');
    $("#modo_levodopa").parent().show();
  }else{
    $("#modo_levodopa").val(null);
    $("#modo_levodopa").parent().hide();
  }
});
});


$('#exampleModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) 
    var recipient = button.data('whatever') 
    $('#row').val(recipient)
  })

  var Lista = {

    generateGraphic: function(){

      var pacienteEjercicio = $('#row').val();
      
      $('#graphicForm').append('<input type="hidden" value="'+ pacienteEjercicio +'" name="pacienteEjercicio">');

      $('#graphicForm').append('<input type="hidden" name="output" value="html">');
      
      $("#graphicForm")
      // .attr('action', '/listaDeEjercicios/show/' + $('#row').val())
      .attr('action', '/audio/processAudio')
      .submit();
    },

    downloadGraphic: function(){

      var pacienteEjercicio = $('#row').val();

      $('#graphicForm').append('<input type="hidden" value="'+ pacienteEjercicio +'" name="pacienteEjercicio">');

      $("#graphicForm")
      .attr('action', '/audio/processAudio')
      .submit();
    },

    fillSelector: function(element){

      var pacienteEjercicio = $('#row').val();

      var obj = {id : pacienteEjercicio};

      $.ajax({
          url: "/AvailableAudio/" + pacienteEjercicio,
        type: 'GET',
        // data: {id : pacienteEjercicio},
        success: function(data){
          $('#se' + element).html(data.html);
          $('#selector' + element).show();
      }
      })
    },

    addListener: function(){
      $('#che1').change(function() {
        if($('#che1')[0].checked == true){
          Lista.fillSelector('1');
        }else{
          $('#compareDiv').html(
           '<div id="compareDiv">'
           +  '<label><input type="checkbox" name="Compare1" value="1" id="che1"> Comparar audio</label><br>'
           +  '<div id="selector1" style="display:none">'
           +    '<select id="se1" name="CompareAudio1">'
           +      '<option value=""></option>'
           +    '</select>'
           + '</div>'

           +' <div id="compareDiv2">'
           +  ' <label><input type="checkbox" name="Compare2" value="1" id="che2"> Comparar audio</label><br>'
           +  ' <div id="selector2" style="display:none">'
           +'     <select id="se2" name="CompareAudio2">'
           +'         <option value=""></option>'
           +'     </select>'
           +  ' </div>'
           +' </div>'
          +'</div>'
          )
          
          Lista.addListener();
          ;
        }
      });


      $('#che2').change(function() {
        if($('#che2')[0].checked == true){
          Lista.fillSelector('2');
        }else{
          $('#compareDiv2').html(
           +' <label><input type="checkbox" name="Compare2" value="1" id="che2"> Comparar audio</label><br>'
           +' <div id="selector2" style="display:none">'
           +'     <select id="se2" name="CompareAudio2">'
           +'         <option value=""></option>'
           +'     </select>'
           +' </div>'
          );
          Lista.addListener();
        }
       
      });
    }

  }

