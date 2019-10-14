
$( document ).ready(function() {
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