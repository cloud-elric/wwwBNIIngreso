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

$('#form-agregar-miembro').on('beforeSubmit', function(e) {
    var form = $(this);
    var button = document.getElementById('btn-guardar-miembro');
    var l = Ladda.create(button);

    if (form.find('.has-error').length || timesButton < 1) {
        swal("Espera", "Debes tomarte una foto", "warning");
        l.stop();
        return false;
    }

    var formData = form.serialize();
    $.ajax({
        url: baseUrl+"site/guardar-miembro",
        type: "POST",
        data: formData,
        success: function (data) {
            ocultarBotonesCancelarConfirmar();
            mostrarBotonTomarFoto();
        },
        error: function () {
           
        }
    });
}).on('submit', function(e){
    e.preventDefault();
});

$(document).ready(function () {

    $("#input-subir-imagen").on("change", function () {
        agregarPreviewImage(this, $(this));
    });

    $("#btn-cancel").on("click", function(e){
        e.preventDefault();
        timesButton--;
        
        ocultarBotonesCancelarConfirmar();
        mostrarBotonTomarFoto();

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

                if (resp.txt_token) {

                    $('#myModal').modal('show');
                    $("#nombre-usuario").text(resp.txt_nombre_completo);
                    $("#imagen-encontrada").attr("src", "imagenes/" + resp.txt_token + ".png");

                } else {
                    swal("Sin datos", "No se encontro una persona aproximada", "warning");
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

                $("#entusuarios-image").val(canvas.toDataURL());

                ocultarBotonTomarFoto();
                mostrarBotonesCancelarConfirmar();
                

                timesButton++;
            }
        }, false);



    } else {
        console.log("KO");
    }
})();