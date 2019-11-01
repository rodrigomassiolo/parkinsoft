$( document ).ready(function() {

});

$('#PatientModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var recipient = button.data('whatever')
    $('#rowValue').val(recipient)
    PatientActions.loadModal($('#rowValue').val());
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
        $("#formAnotador").attr('action', '/anotador/' + element);
        $("#anotadorButton").val(element);


    }

}
