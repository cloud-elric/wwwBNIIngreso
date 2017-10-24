function agregarPreviewImage(element, jqelement) {
    var file = element.files[0];

    if (!file) {

        return false;
    }

    var imagefile = file.type;

    var filename = jqelement.val();

    if (filename.substring(3, 11) == 'fakepath') {
        filename = filename.substring(12);
    }// remove c:\fake at beginning from localhost chrome
    // var url = base+'usrUsuarios/guardarFotosCompetencia';

    var match = ["image/jpeg", "image/jpg", 'image/png'];

    if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {

        swal("Espera", "Archivo no aceptado por el sistema", "warning");

        return false;
    }

    if (element.files && element.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            var token = jqelement.data('token');
            $('#photo2').attr('src', e.target.result);

            //$('#modal-sustain-art-' + token+' .sustain-art-cont-images-dialog-img').css(
            //        'background-image', 'url(' + e.target.result + ')');


        }

        reader.readAsDataURL(element.files[0]);
    }
}

function ocultarBotonesCancelarConfirmar(){
    $(".container-btn-actions").hide();
    $("#photo").hide();
    $("#v").show();
}

function mostrarBotonesCancelarConfirmar(){
    $(".container-btn-actions").show();
    $("#photo").show();
    $("#v").hide();
}

function ocultarBotonTomarFoto(){
    $("#take").hide();
}

function mostrarBotonTomarFoto(){
    $("#take").show();
}

var timesButton = 0;
$(document).ready(function () {

    $("#input-subir-imagen").on("change", function () {
        agregarPreviewImage(this, $(this));
    });

    $("#btn-cancel").on("click", function(e){
        e.preventDefault();
        
        ocultarBotonesCancelarConfirmar();
        mostrarBotonTomarFoto();

    });

    $(".js-registrar-entrada").on("click", function(e){
        e.preventDefault();
        var token = $(this).data("token");
        var url = baseUrl+"site/agregar-entrada";
        var formEntrada = $("#form-agregar-registro");
        var data = formEntrada.serialize()+ "&token=" + token;
        var l = Ladda.create(this);
        $.ajax({
            url: url,
            type: "POST",
            data:data,
            success:function(resp){

                if(resp.status=="success"){
                    $('#myModal').modal('hide');
                    swal("OK", "Tu registro se ha completado", "success");
                }else{
                    swal("Error", "Se ha producido un problema al guardar", "warning");
                }
                
            }, 
            complete:function(){
                l.stop();
            }
        });
    });

    $(".js-close-modal").on("click", function(e){
        e.preventDefault();
        $('#myModal').modal('hide');
    });

    $("#btn-guardar").on("click", function () {
        var canvas = document.getElementById('canvas');
        var dataURL = canvas.toDataURL();

        var l = Ladda.create(this);

        if (timesButton < 1) {
            swal("Espera", "Debes tomarte una foto", "warning");
            l.stop();
            return false;
        }

        $.ajax({
            type: "POST",
            url: baseUrl+"site/identificando-miembro",
            data: {
                imgBase64: dataURL,
            },

            success: function (resp) {
                console.log(resp);

                if (resp.usuario && resp.usuario.txt_token) {

                    $('#myModal').modal('show');
                    $("#nombre-usuario").text(resp.usuario.txt_username+" "+resp.usuario.txt_apellido_paterno);
                    $("#imagen-encontrada").attr("src", baseUrl+"imagenes/" + resp.usuario.txt_token + ".png");

                    $(".js-registrar-entrada").data("token", resp.usuario.txt_token);
                        

                } else {
                    swal({
                        title: "Persona no identificada",
                        text: "No se encontro una persona aproximada a la imagen",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonText: 'Soy un miembro nuevo',
                        cancelButtonText: "Cancelar",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    
                    }).then((confirm) => {
                        if (confirm) {
                           // window.location = baseUrl+"site/agregar-miembros";
                        } else {
                          //swal("Your imaginary file is safe!");
                        }
                      });
                    //swal("Sin datos", "No se encontro una persona aproximada", "warning");
                }

                timesButton = 0;

                ocultarBotonesCancelarConfirmar();
                mostrarBotonTomarFoto();

                
                l.stop();

            }, error: function () {
                swal("Lo sentimos", "Ocurrio un suceso inesperado.", "warning");
                l.stop();
            }
        });
    });

});


; (function () {
    function userMedia() {
        return navigator.getUserMedia = navigator.getUserMedia ||
            navigator.webkitGetUserMedia ||
            navigator.mozGetUserMedia ||
            navigator.msGetUserMedia || null;

    }


    // Now we can use it
    if (userMedia()) {
        var videoPlaying = false;
        var constraints = {
            video: true,
            audio: false
        };
        var video = document.getElementById('v');

        var media = navigator.getUserMedia(constraints, function (stream) {

            // URL Object is different in WebKit
            var url = window.URL || window.webkitURL;

            // create the url and set the source of the video element
            video.src = url ? url.createObjectURL(stream) : stream;

            // Start the video
            video.play();
            videoPlaying = true;
        }, function (error) {
            console.log("ERROR");
            console.log(error);
        });


        // Listen for user click on the "take a photo" button
        document.getElementById('take').addEventListener('click', function () {



            if (videoPlaying) {
                var canvas = document.getElementById('canvas');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                canvas.getContext('2d').drawImage(video, 0, 0);
                var data = canvas.toDataURL('image/png');
                document.getElementById('photo').setAttribute('src', data);

                ocultarBotonTomarFoto();
                mostrarBotonesCancelarConfirmar();
                

                timesButton++;
            }
        }, false);



    } else {
        console.log("KO");
    }
})();