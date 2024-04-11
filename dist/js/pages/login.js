/* 
 * login.js
 * @author FIGG - DIRAC
 * @description Archivo que contiene las funciones necesarias para realizar login SGI.
 */
$(document).ready(function () {
    $("#loginForm").submit(function (event) {
        event.preventDefault();
        var usuario = $("#usuario").val();
        var contrasenia = $("#contrasenia").val();
        if ((usuario == "luis.vargas") && (contrasenia == "Dirac2017")) {
            showAlert("¡Operaci&oacute;n Exitosa!", "Redireccionando..", "success", "bounce");
            //Redireccionamos al dashboard
            setTimeout(function () {
                window.location.href = "get_paysheet.php";
            }, 2500);
        } else {
            showAlert("¡Error!", "Error al iniciar sesi&oacute;n", "error", "swing");
        }



//        $.ajax({
//            type: "POST",
//            url: '../controller/usrController.php',
//            data: $('#loginForm').serializeArray(),
//            dataType: 'json',
//            beforeSend: function () {
//                console.log("Login...");
//            },
//            success: function (response) {
//                if (response.errorCode === 0) {
//                    console.log(response);
////                    $("#msg").html('<div class="col-md-8 col-md-offset-3"><div class="alert alert-dismissable alert-success"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong><i class="fa fa-success"> </i></strong>' + response.msg + '</div></div>');
//                    if ($("#remember").prop("checked")) {
//                        console.log("Remember me!");
//                        //Si esta checkeado box de recordar usuario creamos las cookies
//                        localStorage.setItem("usrSGI", $("#usuario").val());
//                        localStorage.setItem("passSGI", $("#contrasenia").val());
//                        localStorage.setItem("remSGI", 1);
//                    } else {
//                        console.log("No Remember me!");
//                        localStorage.setItem("usrSGI", "");
//                        localStorage.setItem("passSGI", "");
//                        localStorage.setItem("remSGI", 0);
//                    }
//                    showAlert(response.msg, "Redireccionando..", "success", "bounce");
//                    //Redireccionamos al dashboard
//                    setTimeout(function () {
//                        window.location.href = "dashboard.php";
//                    }, 2500);
//
//                } else {
//                    showAlert("¡Error!", response.msg, "error", "swing");
//                }
//            },
//            error: function (a, b, c) {
//                console.log(a, b, c);
//            }
//        });
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

$("#registerUsrForm").submit(function (event) {
    event.preventDefault();
//    alert("Registrar Usuario");
    console.log($('#registerUsrForm').serializeArray());
    if ($("#contrasenia").val() === $("#contrasenia2").val()) {
        if (parseInt($("#errors").val()) === 0) {
            $.ajax({
                type: "POST",
                url: extSystem.urlController + "usrController.php",
                data: $('#registerUsrForm').serializeArray(),
                dataType: 'json',
                beforeSend: function () {
                    console.log("Register User...");
                },
                success: function (response) {
                    if (response.errorCode === 0) {
                        console.log(response);
                        console.log(response.data.id_usuario);
                        $("#id_usuario").val(response.data.id_usuario);
//                    $("#msg").html('<div class="col-md-12 col-md-offset-0"><div class="alert alert-dismissable alert-success"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong><i class="fa fa-success"> </i></strong>' + response.msg + '</div></div>');
                        //Redireccionamos al login y guardamos datos en localStorage
//                    localStorage.setItem("usrSGI", $("#usuario").val());
//                    localStorage.setItem("passSGI", $("#contrasenia").val());
//                    localStorage.setItem("remSGI", 1);
                        showAlert(response.msg, "", "success", "bounce");
                        setTimeout(function () {
//                        $("#msg").html('');
                            window.location.href = "all_users.php";
                        }, 1500);
                    } else {
                        showAlert("¡Error!", response.msg, "error", "swing");
                    }
                },
                error: function (a, b, c) {
                    console.log(a, b, c);
                }
            });
        } else {
            showAlert("¡Error!", "Favor de verificar datos de usuario y correo", "error", "swing");
        }
    } else {
        showAlert("¡Error!", "Las contraseñas no coinciden", "error", "swing");
//        $("#msg").html('<div class="col-md-12 col-md-offset-0"><div class="alert alert-dismissable alert-danger"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong><i class="fa fa-danger"> </i></strong>Las contraseñas no coinciden</div></div>');
//        setTimeout(function () {
//            $("#msg").html('');
//        }, 2500);
    }

});

//function  readSession() {
//    $("#usuario").val(localStorage.getItem("usrSGI"));
//    $("#contrasenia").val(localStorage.getItem("passSGI"));
//    $("#remember").prop("checked", true);
//}

function cerrarSesion(evento) {
    event.preventDefault();
//    alert("CerrarSesion: " + evento);
    $.ajax({
        type: "POST",
        url: extSystem.urlController + 'usrController.php',
        data: {evento: evento},
        dataType: 'json',
        beforeSend: function () {
            console.log("Cerrar Sesión...");
        },
        success: function (response) {
            if (response.errorCode === 0) {
                console.log(response);
                window.location.href = "../../wpage/login.php";
            } else {
                showAlert("¡Error!", response.msg, "error", "swing");
            }
        },
        error: function (a, b, c) {
            console.log(a, b, c);
        }
    });
}

function uploadImage() {
//    alert("UploadImage");
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
        },
        success: function (response) {
            if (response.errorCode === 0) {
                $("#imagen").val(response.path + response.nombre);
                $("#imageUsr").prop("src", $("#imagen").val());
            } else {
                showAlert("¡Error!", response.msg, "error", "swing");
            }
        },
        error: function (a, b, c) {
            console.log(a, b, c);
        }
    });
}
function uploadImg() {
//    alert("UploadImage2");
    var formData = new FormData($('#uploadForm2')[0]);
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
        },
        success: function (response) {
            if (response.errorCode === 0) {
                console.log("FOTOOOOOOOOO:", response.path + response.nombre);
                $("#foto").val(response.path + response.nombre);
                $("#fotoUsr").prop("src", $("#foto").val());
            } else {
                showAlert("¡Error!", response.msg, "error", "swing");
            }
        },
        error: function (a, b, c) {
            console.log(a, b, c);
        }
    });
}

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

function validarUsuario() {
    if ($("#usuario").val().length > 5) {
        $.post(extSystem.urlController + "usrController.php",
                {evento: 18, usuario: $("#usuario").val()},
                function (response) {
                    if (response.errorCode === 0) {
                        $("#msgUsr").html('<p class="text-green"><b>' + response.msg + '</b><p>');
                        $("#errors").val(0);
                    } else {
                        $("#msgUsr").html('<p class="text-red"><b>El usuario ya existe o es incorrecto, favor de seleccionar otro.</b><p>');
                        $("#errors").val(1);
                    }
                }, 'json');
    }
}

function validarCorreo() {
    if ($("#correo").val().length > 5) {
        $.post(extSystem.urlController + "usrController.php",
                {evento: 19, correo: $("#correo").val()},
                function (response) {
                    if (response.errorCode === 0) {
                        $("#msgMail").html('<p class="text-green"><b>' + response.msg + '</b><p>');
                        $("#errors").val(0);
                    } else {
                        $("#msgMail").html('<p class="text-red"><b>El correo ya existe o es incorrecto, favor de seleccionar otro.</b><p>');
                        $("#errors").val(1);
                    }
                }, 'json');
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

