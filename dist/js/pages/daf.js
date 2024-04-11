/* 
 * daf.js
 * @author FIGG - DIRAC
 * @description Archivo que contiene funciones JS para modulo DAF.
 */
$(document).ready(function () {
    $("#paramsForm").submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: '../controller/dafController.php',
            data: $("#paramsForm").serializeArray(),
            dataType: 'json',
            beforeSend: function () {
                console.log("Replace mail....");
            },
            success: function (response) {
                if (response.errorCode === 0) {
                    showAlert(response.msg, "Informaci&oacute;n actualizada correctamente", "success", "bounce");
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            },
            error: function (a, b, c) {
                console.log(a, b, c);
            }
        });
    });
    $("#paramsForm2").submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: '../controller/dafController.php',
            data: $("#paramsForm2").serializeArray(),
            dataType: 'json',
            beforeSend: function () {
                console.log("Replace mail....");
            },
            success: function (response) {
                if (response.errorCode === 0) {
                    showAlert(response.msg, "Informaci&oacute;n actualizada correctamente", "success", "bounce");
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            },
            error: function (a, b, c) {
                console.log(a, b, c);
            }
        });
    });

    $("#add_output").submit(function (event) {
        event.preventDefault();
        $("#send_output").prop("disabled", true);
        var formData = new FormData($('#add_output')[0]);
        $.ajax({
            type: "POST",
            url: '../controller/dafController.php',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {
                console.log("Insertando solicitud");
                $("#msg").html('<div class="text-center"><i class="fa fa-spinner fa-spin" style="font-size:48px; color: #F49625"></i><br /><b class="text-center">Procesando informaci&oacute;n...<b></div>');
            },
            success: function (response) {
                if (response.errorCode === 0) {
                    showAlert(response.msg, "Informaci&oacute;n enviada correctamente", "success", "bounce");
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            },
            error: function (a, b, c) {
                console.log(a, b, c);
                showAlert("¡Error!", "Tu sesi&oacute;n ha caducado.", "error", "swing");
                setTimeout(function () {
                    window.location.href = "dashboard.php";
                }, 2500);
            }
        });
    });

    $("#authOutput").submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: '../controller/dafController.php',
            data: $("#authOutput").serializeArray(),
            dataType: 'json',
            beforeSend: function () {
                $("#msg").html('<div class="text-center"><i class="fa fa-spinner fa-spin" style="font-size:48px; color: #F49625"></i><br /><b class="text-center">Procesando informaci&oacute;n...<b></div>');
                $("#authBtn").prop("disabled", "true");
            },
            success: function (response) {
                if (response.errorCode === 0) {
                    showAlert(response.msg, "Informaci&oacute;n procesada correctamente", "success", "bounce");
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            },
            error: function (a, b, c) {
                console.log(a, b, c);
            }
        });
    });
    $("#editRequester").submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: '../controller/dafController.php',
            data: $("#editRequester").serializeArray(),
            dataType: 'json',
            beforeSend: function () {
                $("#msg").html('<div class="text-center"><i class="fa fa-spinner fa-spin" style="font-size:48px; color: #F49625"></i><br /><b class="text-center">Procesando informaci&oacute;n...<b></div>');
                $("#authBtn").prop("disabled", "true");
            },
            success: function (response) {
                if (response.errorCode === 0) {
                    showAlert(response.msg, "Informaci&oacute;n procesada correctamente", "success", "bounce");
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            },
            error: function (a, b, c) {
                console.log(a, b, c);
            }
        });
    });
});