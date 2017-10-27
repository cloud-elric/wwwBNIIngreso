$(document).ready(function(){
    $('#inlineDatepicker').datepicker();
    $("#inlineDatepicker").on("changeDate", function(event) {
      $("#inputHiddenInline").val(
        $("#inlineDatepicker").datepicker('getFormattedDate')
      );
    });
});