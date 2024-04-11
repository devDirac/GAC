/* 
 * requests_sgi.js
 * @author FIGG - DIRAC
 * @description Archivo que contiene las funciones necesarias para realizar login SGI.
 */
$(document).ready(function () {
    $("#mailsForm").submit(function (event) {
        event.preventDefault();
        $("#editor1").val(CKEDITOR.instances.editor1.getData());
        $("#loading").toggle();
        $.post("../../../sgi-dirac/utils/enviar_correo.php",
                $("#mailsForm").serializeArray(),
                function (response) {
                    if (response.errorCode === 0) {
                        $("#loading").toggle(); 
                        showAlert(response.msg, "Correo enviado", "success", "bounce");
                    } else {
                        showAlert("¡Error!", response.msg, "error", "swing");
                    }
                }, 'json');

    });
});
