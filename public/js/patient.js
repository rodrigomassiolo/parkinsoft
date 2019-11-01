$( document ).ready(function() {

});

$('#PatientModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var recipient = button.data('whatever')
    $('#rowValue').val(recipient)
})


var PatientActions = {

    loadModal: function(element){

        $("#showButton").attr("href","http://"+window.location.hostname+'/abmUser/'+$("#rowValue").val());
        $("#editButton").attr("href","http://"+window.location.hostname+'/abmUser/'+$("#rowValue").val()+'/edit');

        $("#audioButton").val(element);
        $("#assignButton").val(element);
        $("#realizeButton").val(element);
        $("#assignedButton").val(element);
        $("#surgeryButton").val(element);
        $("#anotadorButton").val(element);


    }

}
