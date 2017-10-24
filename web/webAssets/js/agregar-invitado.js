var form = $('#form-agregar-invitado');
$(document).ready(function(){


    form.on('afterValidate', function (e, messages, errorAttributes) {
        if(errorAttributes.length > 0){
            var button = document.getElementById('btn-guardar-invitado');
            var l = Ladda.create(button);
            l.stop();
            return false;
        }
        
    });

    $('#form-agregar-invitado').on('beforeSubmit', function(e) {
       
        var button = document.getElementById('btn-guardar-invitado');
        var l = Ladda.create(button);
    
        if (form.find('.has-error').length) {
            
            l.stop();
            return false;
        }
    
        var formData = form.serialize();
        $.ajax({
            url: baseUrl+"site/guardar-invitado",
            type: "POST",
            data: formData,
            success: function (data) {
               if(data.status=="success"){
                   swal("Ok", "Invitado guardado correctamente", "success");
                   form[0].reset();
                   form.data('yiiActiveForm').validated = false;
               }else{
                   swal("warning", data.mensaje, "warning");
               }


            },
            error: function () {
               
            },
            complete: function(){
                l.stop();
            }
        });
    }).on('submit', function(e){
        e.preventDefault();
    });
});