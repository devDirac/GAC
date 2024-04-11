/* 
 * clima_organizacional.js
 * @author FIGG - DIRAC
 * @description Archivo que contiene las funciones necesarias para realizar login SGI.
 */
$(document).ready(function () {

    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-yellow, input[type="radio"].flat-yellow').iCheck({
        checkboxClass: 'icheckbox_flat-yellow',
        radioClass: 'iradio_flat-yellow'
    });
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-red',
        radioClass: 'iradio_flat-red'
    });
    $('input[type="checkbox"].flat-green, input[type="radio"].flat-green').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green'
    });
    $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    });
    $('input[type="checkbox"].flat-orange, input[type="radio"].flat-orange').iCheck({
        checkboxClass: 'icheckbox_flat-orange',
        radioClass: 'iradio_flat-orange'
    });


    //Desactivamos todos los TABS
    $("#at2").removeAttr("data-toggle");
    $("#at3").removeAttr("data-toggle");
    $("#at4").removeAttr("data-toggle");
    $("#at5").removeAttr("data-toggle");
    $("#at6").removeAttr("data-toggle");
    $("#at7").removeAttr("data-toggle");


    $("#part1Form").submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: '../controller/climaOrganizacionalController.php',
            data: $('#part1Form').serializeArray(),
            dataType: 'json',
            beforeSend: function () {
                console.log("Enviando respuestas ambiente de trabajo...");
            },
            success: function (response) {
                if (response.errorCode === 0) {
                    console.log(response);
                    $("#part1").removeClass("active");
                    $("#part2").attr("class", "tab-pane fade in active");
                    $("#t2").tab('show');
                    $("#at2").attr("data-toggle", "tab");
                    $("#at1").removeAttr("data-toggle");
                    $("#t1").attr("class", "disabled");
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            },
            error: function (a, b, c) {
                console.log(a, b, c);
            }
        });
    });

    $("#part1-1Form").submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: '../controller/climaOrganizacionalController.php',
            data: $('#part1-1Form').serializeArray(),
            dataType: 'json',
            beforeSend: function () {
                console.log("Enviando respuestas ambiente de trabajo...");
            },
            success: function (response) {
                if (response.errorCode === 0) {
                    console.log(response);
                    $("#part2").removeClass("active");
                    $("#part3").attr("class", "tab-pane fade in active");
                    $("#t3").tab('show');
                    $("#at3").attr("data-toggle", "tab");
                    $("#at2").removeAttr("data-toggle");
                    $("#t2").attr("class", "disabled");
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            },
            error: function (a, b, c) {
                console.log(a, b, c);
            }
        });
    });

    $("#part1-2Form").submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: '../controller/climaOrganizacionalController.php',
            data: $('#part1-2Form').serializeArray(),
            dataType: 'json',
            beforeSend: function () {
                console.log("Enviando respuestas ambiente de trabajo...");
            },
            success: function (response) {
                if (response.errorCode === 0) {
                    console.log(response);
                    $("#part3").removeClass("active");
                    $("#part4").attr("class", "tab-pane fade in active");
                    $("#t4").tab('show');
                    $("#at4").attr("data-toggle", "tab");
                    $("#at3").removeAttr("data-toggle");
                    $("#t3").attr("class", "disabled");
//                    showAlert(response.msg, "Respuestas enviadas correctamente", "success", "bounce");
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            },
            error: function (a, b, c) {
                console.log(a, b, c);
            }
        });
    });

    $("#part1-3Form").submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: '../controller/climaOrganizacionalController.php',
            data: $('#part1-3Form').serializeArray(),
            dataType: 'json',
            beforeSend: function () {
                console.log("Enviando respuestas ambiente de trabajo...");
            },
            success: function (response) {
                if (response.errorCode === 0) {
                    console.log(response);
                    $("#part4").removeClass("active");
                    $("#part5").attr("class", "tab-pane fade in active");
                    $("#t5").tab('show');
                    $("#at5").attr("data-toggle", "tab");
                    $("#at4").removeAttr("data-toggle");
                    $("#t4").attr("class", "disabled");

                    //Se oculta parte 1
                    $("#parteNo1").hide("slow");

                    showAlert(response.msg, "Respuestas enviadas correctamente", "success", "bounce");
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            },
            error: function (a, b, c) {
                console.log(a, b, c);
            }
        });
    });

    $("#parte2Form").submit(function (event) {
        event.preventDefault();
        var cont = 0;
        $.each($('#parte2Form').serializeArray(), function (index, value) {
            if (value.value !== "") {
                cont++;
            }
        });
        console.log(cont);

        if (cont === 6) {
            $.ajax({
                type: "POST",
                url: '../controller/climaOrganizacionalController.php',
                data: $('#parte2Form').serializeArray(),
                dataType: 'json',
                beforeSend: function () {
                    console.log("Enviando respuestas clima organizacional parte 2");
                },
                success: function (response) {
                    if (response.errorCode === 0) {
                        $("#part5").removeClass("active");
                        $("#part6").attr("class", "tab-pane fade in active");
                        $("#t6").tab('show');
                        $("#at6").attr("data-toggle", "tab");
                        $("#at5").removeAttr("data-toggle");
                        $("#t5").attr("class", "disabled");
                        
                        
                        $("#at7").attr("data-toggle", "tab");
                        $("#t7").removeClass("disabled");
                        showAlert(response.msg, "Respuestas enviadas correctamente", "success", "bounce");
                    } else {
                        showAlert("¡Error!", response.msg, "error", "swing");
                    }
                },
                error: function (a, b, c) {
                    console.log(a, b, c);
                }
            });
        } else {
            showAlert("¡Error!", "Favor de marcar 5 categorías", "error", "swing");
            return false;
        }
    });

    $("#sugerenciasForm").submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: '../controller/climaOrganizacionalController.php',
            data: $('#sugerenciasForm').serializeArray(),
            dataType: 'json',
            beforeSend: function () {
                console.log("Enviando respuestas clima organizacional parte 2");
            },
            success: function (response) {
                if (response.errorCode === 0) {
                    console.log(response);
                    $("#part6").removeClass("active");
                    $("#part7").attr("class", "tab-pane fade in active");
                    $("#t7").tab('show');
                    $("#at7").attr("data-toggle", "tab");
                    $("#at6").removeAttr("data-toggle");
                    $("#t6").attr("class", "disabled");
                    showAlert(response.msg, "Respuestas enviadas correctamente", "success", "bounce");
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            },
            error: function (a, b, c) {
                console.log(a, b, c);
            }
        });
    });


    $("#anexoForm").submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: '../controller/climaOrganizacionalController.php',
            data: $('#anexoForm').serializeArray(),
            dataType: 'json',
            beforeSend: function () {
                console.log("Enviando respuestas clima organizacional parte 2");
            },
            success: function (response) {
                if (response.errorCode === 0) {
                    console.log(response);
//                    $("#part6").removeClass("active");
//                    $("#part7").attr("class", "tab-pane fade in active");
//                    $("#t7").tab('show');
//                    $("#at7").attr("data-toggle", "tab");
//                    $("#at6").removeAttr("data-toggle");
//                    $("#t6").attr("class", "disabled");
                    showAlert(response.msg, "¡Gracias por tu apoyo!", "success", "bounce");
                    setTimeout(function () {
                        $(location).attr('href', 'http://www.arjion.com');
                    }, 2000);
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            },
            error: function (a, b, c) {
                console.log(a, b, c);
            }
        });
    });


//    $("#updateUsrForm").submit(function (event) {
//        event.preventDefault();
////        alert("Actualizar Usuario");
//        if ($("#contrasenia").val() === $("#contrasenia2").val()) {
//            $.ajax({
//                type: "POST",
//                url: '../controller/usrController.php',
//                data: $('#updateUsrForm').serializeArray(),
//                dataType: 'json',
//                beforeSend: function () {
//                    console.log("Update User...");
//                },
//                success: function (response) {
//                    if (response.errorCode === 0) {
//                        console.log(response);
////                        $("#msg").html('<div class="col-md-12 col-md-offset-0"><div class="alert alert-dismissable alert-success"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong><i class="fa fa-success"> </i></strong>' + response.msg + '</div></div>');
//                        showAlert(response.msg, "Usuario actualizado.", "success", "bounce");
//                        //Redireccionamos al dashboard
//                        setTimeout(function () {
//                            $("#msg").html('');
//                            window.location.href = "dashboard.php";
//                        }, 2500);
//                    } else {
//                        showAlert("¡Error!", response.msg, "error", "swing");
//                    }
//                },
//                error: function (a, b, c) {
//                    console.log(a, b, c);
//                }
//            });
//        } else {
//            $("#msg").html('<div class="col-md-12 col-md-offset-0"><div class="alert alert-dismissable alert-danger"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong><i class="fa fa-danger"> </i></strong>Las contraseñas no coinciden</div></div>');
//            setTimeout(function () {
//                $("#msg").html('');
//            }, 2500);
//        }
//
//    });
});

//$("#registerUsrForm").submit(function () {
//    event.preventDefault();
////    alert("Registrar Usuario");
//    console.log($('#registerUsrForm').serializeArray());
//    if ($("#contrasenia").val() === $("#contrasenia2").val()) {
//        $.ajax({
//            type: "POST",
//            url: '../controller/usrController.php',
//            data: $('#registerUsrForm').serializeArray(),
//            dataType: 'json',
//            beforeSend: function () {
//                console.log("Register User...");
//            },
//            success: function (response) {
//                if (response.errorCode === 0) {
//                    console.log(response);
////                    $("#msg").html('<div class="col-md-12 col-md-offset-0"><div class="alert alert-dismissable alert-success"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong><i class="fa fa-success"> </i></strong>' + response.msg + '</div></div>');
//                    //Redireccionamos al login y guardamos datos en localStorage
////                    localStorage.setItem("usrSGI", $("#usuario").val());
////                    localStorage.setItem("passSGI", $("#contrasenia").val());
////                    localStorage.setItem("remSGI", 1);
//                    showAlert(response.msg, "", "success", "bounce");
////                    setTimeout(function () {
//////                        $("#msg").html('');
////                        window.location.href = "login.php";
////                    }, 2500);
//                } else {
//                    showAlert("¡Error!", response.msg, "error", "swing");
//                }
//            },
//            error: function (a, b, c) {
//                console.log(a, b, c);
//            }
//        });
//    } else {
//        $("#msg").html('<div class="col-md-12 col-md-offset-0"><div class="alert alert-dismissable alert-danger"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong><i class="fa fa-danger"> </i></strong>Las contraseñas no coinciden</div></div>');
//        setTimeout(function () {
//            $("#msg").html('');
//        }, 2500);
//    }
//
//});

//function  readSession() {
//    $("#usuario").val(localStorage.getItem("usrSGI"));
//    $("#contrasenia").val(localStorage.getItem("passSGI"));
//    $("#remember").prop("checked", true);
//}

//function cerrarSesion(evento) {
//    event.preventDefault();
////    alert("CerrarSesion: " + evento);
//    $.ajax({
//        type: "POST",
//        url: '../controller/usrController.php',
//        data: {evento: evento},
//        dataType: 'json',
//        beforeSend: function () {
//            console.log("Cerrar Sesión...");
//        },
//        success: function (response) {
//            if (response.errorCode === 0) {
//                console.log(response);
//                window.location.href = "login.php";
//            } else {
//                showAlert("¡Error!", response.msg, "error", "swing");
//            }
//        },
//        error: function (a, b, c) {
//            console.log(a, b, c);
//        }
//    });
//}

function uploadFile() {
    var formData = new FormData($('#uploadForm')[0]);
//    formData.append('act', 'save');
    $.ajax({

        type: "POST",
        url: "../utils/up.php",
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json',
        beforeSend: function () {
            console.log("Cargar imagen...");
            $("#btnSaveRecords").prop("disabled", true);
        },
        success: function (response) {
            if (response.errorCode === 0) {
                //alert(response.path + response.nombre);
                $("#archivo").val(response.path + response.nombre);
                $("#nombre_archivo").val(response.nombre);
//                $("#imageUsr").prop("src", $("#imagen").val());
                $("#btnSaveRecords").prop("disabled", false);
            } else {
                showAlert("¡Error!", response.msg, "error", "swing");
            }
        },
        error: function (a, b, c) {
            console.log(a, b, c);
        }
    });
}

function saveRecords() {
    $("#btnSaveRecords").prop("disabled", true);
    if ($("#archivo").val() !== "") {
        $.ajax({
            type: "POST",
            url: '../controller/index.php',
            data: {evento: 2, archivo: $("#archivo").val(), nombre: $("#nombre_archivo").val()},
            dataType: 'json',
            beforeSend: function () {
                console.log("Cargando registros");
                $("#gifCargando").toggle();
            },
            success: function (response) {
                $("#gifCargando").toggle();
                console.log("Ya terminé..");
                if (response.errorCode === 0) {
                    showAlert("¡Operaci&oacute;n Exitosa!", "Registros cargados", "success", "bounce");
                    $("#btnGenerateMatrix").toggle();
                } else {
                    showAlert("¡Error!", "Error al cargar registros a la BD", "error", "swing");
                }
            },
            error: function (a, b, c) {
                console.log("Error......");
                $("#gifCargando").toggle();
                console.log(a, b, c);
            }
        });
    } else {
        showAlert("¡Error!", "Favor de seleccionar un archivo", "error", "swing");
    }

}

function generateMatrix() {
    $("#btnGenerateMatrix").prop("disabled", true);
    $.ajax({
        type: "POST",
        url: '../controller/index3.php',
        data: {evento: 2, archivo: $("#archivo").val()},
        dataType: 'json',
        beforeSend: function () {
            console.log("Cargando registros");
            $("#gifCargando").toggle();
        },
        success: function (response) {
            $("#gifCargando").toggle();
            if (response.errorCode === 0) {
                showAlert("¡Operaci&oacute;n Exitosa!", "Registros cargados", "success", "bounce");
                $("#btnDownloadMatrix").toggle();
                $("#url").val(response.data);
            } else {
                showAlert("¡Error!", "Error al cargar registros a la BD", "error", "swing");
            }
        },
        error: function (a, b, c) {
            console.log("Error......");
            $("#gifCargando").toggle();
            console.log(a, b, c);
        }
    });

}

function downloadFile() {
    /*$("#btnSaveRecords").prop("disabled",false);
     $("#btnGenerateMatrix").prop("disabled",false);
     $("#btnGenerateMatrix").toggle();
     $("#btnDownloadMatrix").toggle();*/
    var url = $("#url").val();
    window.open(url);
    location.reload();

}

function noRepeatNumber(campo) {
    console.log(campo);

    var existe = false;
    var cont = 0;

    if (campo.value >= 6) {
        showAlert("¡Error!", "El n&uacute;mero seleccionado es incorrecto", "error", "swing");
        $("#" + campo.id + "").val("");
    } else {
        $.each($('#parte2Form').serializeArray(), function (index, value) {
            if (value.name !== campo.name) {
                if (value.value === campo.value) {
                    console.log(value.value + " - " + campo.value);
                    showAlert("¡Error!", "Ya seleccionaste ese n&uacute;mero", "error", "swing");
                    existe = true;
//                campo.foucus();
                    $("#" + campo.id + "").focus();
                }
                if (value.value !== "") {
                    cont++;
                }
            }
        });
        console.log("Contador: " + cont);
        if (!existe && cont === 5) {
            $('#parte2Form input').attr('readonly', 'readonly');
        } else {
//        showAlert("¡Error!", "Ya seleccionaste ese n&uacute;mero", "error", "swing");
        }
    }
}

//function recoverPass() {
//    swal({
//        title: '<p class="sweet-figg-title">Recuperar contraseña</p>',
//        html: '<p class="sweet-figg-text">Introduce tu correo</p>',
//        input: 'email',
//        inputClass: 'sweet-figg-text',
//        showCancelButton: true,
//        confirmButtonText: 'Enviar',
//        cancelButtonText: 'Cancelar',
//        showLoaderOnConfirm: true,
//        preConfirm: function (email) {
//            return new Promise(function (resolve, reject) {
//                $.post("../controller/usrController.php",
//                        {evento: 5, correo: email},
//                        function (response) {
//                            if (response.errorCode === 0) {
//                                showAlert(response.msg, "Se ha enviado su nueva contraseña a: " + email, "success", "bounce");
//                            } else {
//                                showAlert("¡Error!", response.msg, "error", "swing");
//                            }
//                        }, 'json');
////                setTimeout(function () {    
////                    if (email === 'taken@example.com') {
////                        reject('This email is already taken.')
////                    } else {
////                        resolve();
////                    }
////                }, 2000);
//            });
//        },
//        allowOutsideClick: false
//    });
////            .then(function (email) {
////        swal({
////            type: 'success',
////            title: '¡Operacion Exitosa!',
////            html: 'Se ha enviado su nueva contraseña a: ' + email
////        });
////    },
////            function (email) {
////                swal({
////                    type: 'error',
////                    title: '¡Error!',
////                    html: 'Ha ocurrido un error al enviar correo' + email + ' intente más tarde.'
////                });
////            });
//}

