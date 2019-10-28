$( document ).ready(function() {


  $('#oneGraphicModal').modal('show');
  // Lista.addListener();
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

      //var pacienteEjercicio = $('#row').val();
      var pacienteEjercicio = element;

      //var obj = {id : pacienteEjercicio};


      $('#se1').select2(
        {
          language:'es',
          width:'100%',
          minimumInputLength: 0,
          placeholder: 'Seleccione audio',
          ajax: {
            url: '/AvailableAudio/' + pacienteEjercicio,
            data: function (params) {
              var query = {
                search: params.term,
                id: pacienteEjercicio,
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
        $('#se2').select2(
          {
            language:'es',
            width:'100%',
            minimumInputLength: 0,
            placeholder: 'Seleccione audio',
            ajax: {
              url: '/AvailableAudio/' + pacienteEjercicio,
              data: function (params) {
                var query = {
                  search: params.term,
                  id: pacienteEjercicio,
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

    // addListener: function(){
    //   $('#che1').change(function() {
    //     if($('#che1')[0].checked == true){
    //       Lista.fillSelector('1');
    //     }else{
    //       $('#compareDiv').html(
    //        '<div id="compareDiv">'
    //        +  '<label><input type="checkbox" name="Compare1" value="1" id="che1"> Comparar audio</label><br>'
    //        +  '<div id="selector1" style="display:none">'
    //        +    '<select id="se1" name="CompareAudio1">'
    //        +      '<option value=""></option>'
    //        +    '</select>'
    //        + '</div>'

    //        +' <div id="compareDiv2">'
    //        +  ' <label><input type="checkbox" name="Compare2" value="1" id="che2"> Comparar audio</label><br>'
    //        +  ' <div id="selector2" style="display:none">'
    //        +'     <select id="se2" name="CompareAudio2">'
    //        +'         <option value=""></option>'
    //        +'     </select>'
    //        +  ' </div>'
    //        +' </div>'
    //       +'</div>'
    //       )
          
    //       Lista.addListener();
    //       ;
    //     }
    //   });


    //   $('#che2').change(function() {
    //     if($('#che2')[0].checked == true){
    //       Lista.fillSelector('2');
    //     }else{
    //       $('#compareDiv2').html(
    //        +' <label><input type="checkbox" name="Compare2" value="1" id="che2"> Comparar audio</label><br>'
    //        +' <div id="selector2" style="display:none">'
    //        +'     <select id="se2" name="CompareAudio2">'
    //        +'         <option value=""></option>'
    //        +'     </select>'
    //        +' </div>'
    //       );
    //       Lista.addListener();
    //     }
       
    //   });
    // }

  }


  $('#levoModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) 
    var recipient = button.data('whatever').split(',');
    var useriD = recipient[0];
    var pacej = recipient[1];
    var comp = recipient[2];
    $('#useriD').val(useriD);
    $('#levo1').val(pacej);
    $('#levo2').val(comp);
})

var Levo = {
  generateGraphicLevo: function(){

    $('#levoForm').append('<input type="hidden" name="output" value="html">');
    
    $("#levoForm")
    .attr('action', '/audio/processAudio')
    .submit();
  },

  downloadGraphicLevo: function(){

    $("#graphicForm")
    .attr('action', '/audio/processAudio')
    .submit();
  },

}

