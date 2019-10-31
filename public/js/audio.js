
$( document ).ready(function() {
/*******Audio Index ****/
    $('#audio_select_ejercicio').on('change',function(e){
        // $('#ejercicioDesc').html(e.target[e.target.value].attributes[1].value);
        $('#audio_select_ejercicio').children().each(
            function(){
                if($(this)[0].selected == true){
                    // $('#ejercicioDesc').html( $(this)[0].attributes[1].value);
                    $('#ejercicioDesc').val( $(this)[0].attributes[1].value);
                }
            }
        )
        $("#btnExample").attr("href","http://"+window.location.hostname+'/ejercicio/download_example/'+$("#audio_select_ejercicio").val());

      });
    var preset = $("#audio_preset_paciente").val();
    if(preset >= 0){
    $("#user").val(preset); 
    $("#user").prop('disabled', true);
    }  
/***********************/
    $('#audioModal').modal('show');

    var $window = $(window);

    function checkWidth() {
        var windowsize = $window.width();
        if (windowsize < 992) {
            $("#leftBar").addClass("leftBarHide");
            $("#leftBar").removeClass("leftBarShow");
            $("#main").removeClass("col-md-9");
            $("#actions").addClass("showAction");
            $("#actions").removeClass("hideAction");
             
        }else{
            $("#leftBar").addClass("leftBarShow");
            $("#leftBar").removeClass("leftBarHide");
            $("#main").addClass("col-md-9");
            $("#actions").addClass("hideAction");
            $("#actions").removeClass("showAction");
        }
    }
    checkWidth();
  
    $(window).resize(checkWidth);

});

// var Contact = {

//     cancel: function(){
//         $.ajax({
//             url: "/welcome",
//           type: 'GET',
//           success: function(data){}
        
//         })
//     }

// }