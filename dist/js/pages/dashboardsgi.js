/* 
 * dashboardsgi.js
 * @author FIGG - DIRAC
 * @description Archivo que contiene las funciones necesarias para realizar login SGI.
 */
$(document).ready(function () {

    $("#loginForm").submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: '../controller/usrController.php',
            data: $('#loginForm').serializeArray(),
            dataType: 'json',
            beforeSend: function () {
                console.log("Login...");
            },
            success: function (response) {
                if (response.errorCode === 0) {
                    console.log(response);
//                    $("#msg").html('<div class="col-md-8 col-md-offset-3"><div class="alert alert-dismissable alert-success"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong><i class="fa fa-success"> </i></strong>' + response.msg + '</div></div>');
                    if ($("#remember").prop("checked")) {
                        console.log("Remember me!");
                        //Si esta checkeado box de recordar usuario creamos las cookies
                        localStorage.setItem("usrSGI", $("#usuario").val());
                        localStorage.setItem("passSGI", $("#contrasenia").val());
                        localStorage.setItem("remSGI", 1);
                    } else {
                        console.log("No Remember me!");
                        localStorage.setItem("usrSGI", "");
                        localStorage.setItem("passSGI", "");
                        localStorage.setItem("remSGI", 0);
                    }
                    showAlert(response.msg, "Redireccionando..", "success", "bounce");
                    //Redireccionamos al dashboard
                    setTimeout(function () {
                        window.location.href = "dashboard.php";
                    }, 2500);

                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            },
            error: function (a, b, c) {
                console.log(a, b, c);
            }
        });
    });

    $("#updateUsrForm").submit(function (event) {
        event.preventDefault();
//        alert("Actualizar Usuario");
        if ($("#contrasenia").val() === $("#contrasenia2").val()) {
            $.ajax({
                type: "POST",
                url: '../controller/usrController.php',
                data: $('#updateUsrForm').serializeArray(),
                dataType: 'json',
                beforeSend: function () {
                    console.log("Update User...");
                },
                success: function (response) {
                    if (response.errorCode === 0) {
                        console.log(response);
//                        $("#msg").html('<div class="col-md-12 col-md-offset-0"><div class="alert alert-dismissable alert-success"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong><i class="fa fa-success"> </i></strong>' + response.msg + '</div></div>');
                        showAlert(response.msg, "Usuario actualizado.", "success", "bounce");
                        //Redireccionamos al dashboard
                        setTimeout(function () {
                            $("#msg").html('');
                            window.location.href = "dashboard.php";
                        }, 2500);
                    } else {
                        showAlert("¡Error!", response.msg, "error", "swing");
                    }
                },
                error: function (a, b, c) {
                    console.log(a, b, c);
                }
            });
        } else {
            $("#msg").html('<div class="col-md-12 col-md-offset-0"><div class="alert alert-dismissable alert-danger"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong><i class="fa fa-danger"> </i></strong>Las contraseñas no coinciden</div></div>');
            setTimeout(function () {
                $("#msg").html('');
            }, 2500);
        }

    });
});

$("#registerUsrForm").submit(function () {
    event.preventDefault();
//    alert("Registrar Usuario");
    console.log($('#registerUsrForm').serializeArray());
    if ($("#contrasenia").val() === $("#contrasenia2").val()) {
        $.ajax({
            type: "POST",
            url: '../controller/usrController.php',
            data: $('#registerUsrForm').serializeArray(),
            dataType: 'json',
            beforeSend: function () {
                console.log("Register User...");
            },
            success: function (response) {
                if (response.errorCode === 0) {
                    console.log(response);
//                    $("#msg").html('<div class="col-md-12 col-md-offset-0"><div class="alert alert-dismissable alert-success"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong><i class="fa fa-success"> </i></strong>' + response.msg + '</div></div>');
                    //Redireccionamos al login y guardamos datos en localStorage
                    localStorage.setItem("usrSGI", $("#usuario").val());
                    localStorage.setItem("passSGI", $("#contrasenia").val());
                    localStorage.setItem("remSGI", 1);
                    showAlert(response.msg, "", "success", "bounce");
                    setTimeout(function () {
//                        $("#msg").html('');
                        window.location.href = "login.php";
                    }, 2500);
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            },
            error: function (a, b, c) {
                console.log(a, b, c);
            }
        });
    } else {
        $("#msg").html('<div class="col-md-12 col-md-offset-0"><div class="alert alert-dismissable alert-danger"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong><i class="fa fa-danger"> </i></strong>Las contraseñas no coinciden</div></div>');
        setTimeout(function () {
            $("#msg").html('');
        }, 2500);
    }

});


function getDDocs() {
    $.post("../controller/fileSGIController.php",
            {evento: 2},
            function (response) {
                if (response.errorCode === 0) {
//                    console.log(response);
                    $("#downDocsNum").html(response.numElems);
                    var ddocs = '';
                    $.each(response.data, function (index, value) {
                        ddocs += '<tr>'
                                + '<td>' + value.id + '</td>'
                                + '<td>' + value.fecha + '</td>'
                                + '<td>' + value.clave + '</td>'
                                + '<td>' + value.nombre + '</td>'
                                + '<td>' + value.descripcion + '</td>'
                                + '<td>Publicado</td>'
                                + '</tr>';
                    });
                    $("#bodyDDOCS").append(ddocs);
                    $("#tableDDOCS").dataTable({
                        "dom": 'Bfrtip',
                        "buttons": [
                            'colvis', 'csv', 'excel', 'pdf', 'print'
//                            'excel', 'pdf', 'print'
                        ],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": true,
                        "bInfo": true,
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sProcessing": "Procesando...",
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sZeroRecords": "No se encontraron resultados",
                            "sEmptyTable": "Ningún dato disponible en esta tabla",
                            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sSearch": "Buscar:",
                            "sUrl": "",
                            "sInfoThousands": ",",
                            "sLoadingRecords": "Cargando...",
                            "sButtonText": "Imprimir",
                            "oPaginate": {
                                "sFirst": "Primero",
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "buttons": {
                                "print": "Imprimir",
                                "colvis": "Columnas mostradas"
                            }
                        }
                    });
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getCDocs() {
    $.post("../controller/fileSGIController.php",
            {evento: 3},
            function (response) {
                if (response.errorCode === 0) {
                    $("#conDocsNum").html(response.numElems);
                    var ddocs = '';
                    $.each(response.data, function (index, value) {
                        ddocs += '<tr>'
                                + '<td>' + value.id + '</td>'
                                + '<td>' + value.fecha + '</td>'
                                + '<td>' + value.clave + '</td>'
                                + '<td>' + value.nombre + '</td>'
                                + '<td>' + value.descripcion + '</td>'
                                + '<td>Publicado</td>'
                                + '</tr>';
                    });
                    $("#bodyCDOCS").append(ddocs);
                    $("#tableCDOCS").dataTable({
                        "dom": 'Bfrtip',
                        "buttons": [
                            'colvis', 'csv', 'excel', 'pdf', 'print'
//                            'excel', 'pdf', 'print'
                        ],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": true,
                        "bInfo": true,
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sProcessing": "Procesando...",
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sZeroRecords": "No se encontraron resultados",
                            "sEmptyTable": "Ningún dato disponible en esta tabla",
                            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sSearch": "Buscar:",
                            "sUrl": "",
                            "sInfoThousands": ",",
                            "sLoadingRecords": "Cargando...",
                            "sButtonText": "Imprimir",
                            "oPaginate": {
                                "sFirst": "Primero",
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "buttons": {
                                "print": "Imprimir",
                                "colvis": "Columnas mostradas"
                            }
                        }
                    });
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getRCrtd() {
    $.post("../controller/slcController.php",
            {evento: 2},
            function (response) {
                if (response.errorCode === 0) {
                    console.log(response.numElems);
                    $("#reqCNum").html(response.numElems);
                    var reqCrtd = '';
                    $.each(response.data, function (index, value) {
                        reqCrtd += '<tr>'
                                + '<td>' + value.id_solicitud + '</td>'
                                + '<td>' + value.titulo + '</td>'
                                + '<td>' + value.nombre_archivo + '</td>'
                                + '<td>' + value.tipo_documento_nombre + '</td>'
                                + '<td>' + value.descripcion + '</td>'
                                + '<td>' + value.descripcion_estatus + '</td>'
                                + '</tr>';
                    });
                    $("#bodyreq").append(reqCrtd);
                    $("#tableReqCrtd").dataTable({
                        "dom": 'Bfrtip',
                        "buttons": [
                            'colvis', 'csv', 'excel', 'pdf', 'print'
//                            'excel', 'pdf', 'print'
                        ],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": true,
                        "bInfo": true,
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sProcessing": "Procesando...",
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sZeroRecords": "No se encontraron resultados",
                            "sEmptyTable": "Ningún dato disponible en esta tabla",
                            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sSearch": "Buscar:",
                            "sUrl": "",
                            "sInfoThousands": ",",
                            "sLoadingRecords": "Cargando...",
                            "sButtonText": "Imprimir",
                            "oPaginate": {
                                "sFirst": "Primero",
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "buttons": {
                                "print": "Imprimir",
                                "colvis": "Columnas mostradas"
                            }
                        }
                    });
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getDocHP() {
    $.post("../controller/slcController.php",
            {evento: 12},
            function (response) {
                if (response.errorCode === 0) {
                    console.log(response.numElems);
                    $("#fileProc").html(response.numElems);
                    var reqCrtd = '';
                    $.each(response.data, function (index, value) {
                        reqCrtd += '<tr>'
                                + '<td>' + value.id_solicitud + '</td>'
                                + '<td>' + value.titulo + '</td>'
                                + '<td>' + value.nombre + '</td>'
                                + '<td>' + value.fecha + '</td>'
                                + '<td>' + value.descripcion + '</td>'
                                + '<td>' + value.nombre_estatus + '</td>'
                                + '</tr>';
                    });
                    $("#bodyreqAP").append(reqCrtd);
                    $("#tableReqAP").dataTable({
                        "dom": 'Bfrtip',
                        "buttons": [
                            'colvis', 'csv', 'excel', 'pdf', 'print'
//                            'excel', 'pdf', 'print'
                        ],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": true,
                        "bInfo": true,
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sProcessing": "Procesando...",
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sZeroRecords": "No se encontraron resultados",
                            "sEmptyTable": "Ningún dato disponible en esta tabla",
                            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sSearch": "Buscar:",
                            "sUrl": "",
                            "sInfoThousands": ",",
                            "sLoadingRecords": "Cargando...",
                            "sButtonText": "Imprimir",
                            "oPaginate": {
                                "sFirst": "Primero",
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "buttons": {
                                "print": "Imprimir",
                                "colvis": "Columnas mostradas"
                            }
                        }
                    });
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getDocAuthP() {
    $.post("../controller/slcController.php",
            {evento: 13},
            function (response) {
                if (response.errorCode === 0) {
                    console.log(response.numElems);
                    $("#pendADoc").html(response.numElems);
                    var reqCrtd = '';
                    $.each(response.data, function (index, value) {
                        reqCrtd += '<tr>'
                                + '<td>' + value.id_solicitud + '</td>'
                                + '<td>' + value.titulo + '</td>'
                                + '<td>' + value.nombre + '</td>'
                                + '<td>' + value.fecha + '</td>'
                                + '<td>' + value.descripcion + '</td>'
                                + '<td>' + value.nombre_estatus + '</td>'
                                + '</tr>';
                    });
                    $("#bodyreqPA").append(reqCrtd);
                    $("#tableReqPA").dataTable({
                        "dom": 'Bfrtip',
                        "buttons": [
                            'colvis', 'csv', 'excel', 'pdf', 'print'
//                            'excel', 'pdf', 'print'
                        ],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": true,
                        "bInfo": true,
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sProcessing": "Procesando...",
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sZeroRecords": "No se encontraron resultados",
                            "sEmptyTable": "Ningún dato disponible en esta tabla",
                            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sSearch": "Buscar:",
                            "sUrl": "",
                            "sInfoThousands": ",",
                            "sLoadingRecords": "Cargando...",
                            "sButtonText": "Imprimir",
                            "oPaginate": {
                                "sFirst": "Primero",
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "buttons": {
                                "print": "Imprimir",
                                "colvis": "Columnas mostradas"
                            }
                        }
                    });
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getDocRevP() {
    $.post("../controller/slcController.php",
            {evento: 14},
            function (response) {
                if (response.errorCode === 0) {
                    console.log(response.numElems);
                    $("#pendDocs").html(response.numElems);
                    var reqCrtd = '';
                    $.each(response.data, function (index, value) {
                        reqCrtd += '<tr>'
                                + '<td>' + value.id_solicitud + '</td>'
                                + '<td>' + value.titulo + '</td>'
                                + '<td>' + value.nombre + '</td>'
                                + '<td>' + value.fecha + '</td>'
                                + '<td>' + value.descripcion + '</td>'
                                + '<td>' + value.nombre_estatus + '</td>'
                                + '</tr>';
                    });
                    $("#bodyreqPR").append(reqCrtd);
                    $("#tableReqPR").dataTable({
                        "dom": 'Bfrtip',
                        "buttons": [
                            'colvis', 'csv', 'excel', 'pdf', 'print'
//                            'excel', 'pdf', 'print'
                        ],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": true,
                        "bInfo": true,
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sProcessing": "Procesando...",
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sZeroRecords": "No se encontraron resultados",
                            "sEmptyTable": "Ningún dato disponible en esta tabla",
                            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sSearch": "Buscar:",
                            "sUrl": "",
                            "sInfoThousands": ",",
                            "sLoadingRecords": "Cargando...",
                            "sButtonText": "Imprimir",
                            "oPaginate": {
                                "sFirst": "Primero",
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "buttons": {
                                "print": "Imprimir",
                                "colvis": "Columnas mostradas"
                            }
                        }
                    });
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function requestDA() {
    $.post("../controller/slcController.php",
            {evento: 15},
            function (response) {
                console.log(response.data);
                if (response.errorCode === 0) {
                    var requests = "";
                    $.each(response.data, function (index, value) {
                        requests += '<tr>'
                                + '<td>' + value.id_solicitud + '</td>'
                                + '<td>' + value.titulo + '</td>'
                                + '<td>' + value.nombre_archivo + '</td>'
                                + '<td>' + value.fecha + '</td>'
                                + '<td>' + value.nombre + '</td>'
                                + '<td>' + value.tipo_documento_nombre + '</td>'
                                + '<td>' + value.nombre_estatus + '</td>'
                                + '<td><form name="authDoc" id="docProps" action="auth_document.php" method="POST">'
                                + '<input type="hidden" name="evento" value="4" />'
                                + '<input type="hidden" name="id_solicitud" value="' + value.id_solicitud + '" />'
                                + '<button type="submit" class="btn btn-primary btn-flat"><li class="fa fa-pencil"></li></button>'
                                + '</form></td>'
                                + '</tr>';
                    });
                    $("#bodyMRP").append(requests);
                    $("#tableReqMRP").dataTable({
                        "dom": 'Bfrtip',
                        "buttons": [
                            'colvis', 'csv', 'excel', 'pdf', 'print'
//                            'excel', 'pdf', 'print'
                        ],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": true,
                        "bInfo": true,
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sProcessing": "Procesando...",
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sZeroRecords": "No se encontraron resultados",
                            "sEmptyTable": "Ningún dato disponible en esta tabla",
                            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sSearch": "Buscar:",
                            "sUrl": "",
                            "sInfoThousands": ",",
                            "sLoadingRecords": "Cargando...",
                            "sButtonText": "Imprimir",
                            "oPaginate": {
                                "sFirst": "Primero",
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "buttons": {
                                "print": "Imprimir",
                                "colvis": "Columnas mostradas"
                            }
                        }
                    });
                    $("#myReqPen").html(response.numElems);
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function requestRL() {
    $.post("../controller/slcController.php",
            {evento: 3},
            function (response) {
                console.log(response.data);
                if (response.errorCode === 0) {
                    var requests = "";
                    $.each(response.data, function (index, value) {
                        requests += '<tr>'
                                + '<td>' + value.id_solicitud + '</td>'
                                + '<td>' + value.titulo + '</td>'
                                + '<td>' + value.nombre_archivo + '</td>'
                                + '<td>' + value.fecha + '</td>'
                                + '<td>' + value.nombre + '</td>'
                                + '<td>' + value.tipo_documento_nombre + '</td>'
                                + '<td>' + value.nombre_estatus + '</td>'
                                + '<td><form name="authDoc" id="docProps" action="auth_document.php" method="POST">'
                                + '<input type="hidden" name="evento" value="4" />'
                                + '<input type="hidden" name="id_solicitud" value="' + value.id_solicitud + '" />'
                                + '<button type="submit" class="btn btn-primary btn-flat"><li class="fa fa-pencil"></li></button>'
                                + '</form></td>'
                                + '</tr>';
                        ;
                    });
                    $("#bodyMRP").append(requests);
                    $("#tableReqMRP").dataTable({
                        "dom": 'Bfrtip',
                        "buttons": [
                            'colvis', 'csv', 'excel', 'pdf', 'print'
//                            'excel', 'pdf', 'print'
                        ],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": true,
                        "bInfo": true,
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sProcessing": "Procesando...",
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sZeroRecords": "No se encontraron resultados",
                            "sEmptyTable": "Ningún dato disponible en esta tabla",
                            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sSearch": "Buscar:",
                            "sUrl": "",
                            "sInfoThousands": ",",
                            "sLoadingRecords": "Cargando...",
                            "sButtonText": "Imprimir",
                            "oPaginate": {
                                "sFirst": "Primero",
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "buttons": {
                                "print": "Imprimir",
                                "colvis": "Columnas mostradas"
                            }
                        }
                    });
                    $("#myReqPen").html(response.numElems);
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function requestRC() {
    $.post("../controller/slcController.php",
            {evento: 15},
            function (response) {
                console.log(response.data);
                if (response.errorCode === 0) {
                    var requests = "";
                    $.each(response.data, function (index, value) {
                        requests += '<tr>'
                                + '<td>' + value.id_solicitud + '</td>'
                                + '<td>' + value.titulo + '</td>'
                                + '<td>' + value.nombre_archivo + '</td>'
                                + '<td>' + value.fecha + '</td>'
                                + '<td>' + value.nombre + '</td>'
                                + '<td>' + value.tipo_documento_nombre + '</td>'
                                + '<td>' + value.nombre_estatus + '</td>'
                                + '<td><form name="authDoc" id="docProps" action="auth_document.php" method="POST">'
                                + '<input type="hidden" name="evento" value="4" />'
                                + '<input type="hidden" name="id_solicitud" value="' + value.id_solicitud + '" />'
                                + '<button type="submit" class="btn btn-primary btn-flat"><li class="fa fa-pencil"></li></button>'
                                + '</form></td>'
                                + '</tr>';
                    });
                    $("#bodyMRP").append(requests);
                    $("#tableReqPA").dataTable({
                        "dom": 'Bfrtip',
                        "buttons": [
                            'colvis', 'csv', 'excel', 'pdf', 'print'
//                            'excel', 'pdf', 'print'
                        ],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": true,
                        "bInfo": true,
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sProcessing": "Procesando...",
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sZeroRecords": "No se encontraron resultados",
                            "sEmptyTable": "Ningún dato disponible en esta tabla",
                            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sSearch": "Buscar:",
                            "sUrl": "",
                            "sInfoThousands": ",",
                            "sLoadingRecords": "Cargando...",
                            "sButtonText": "Imprimir",
                            "oPaginate": {
                                "sFirst": "Primero",
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "buttons": {
                                "print": "Imprimir",
                                "colvis": "Columnas mostradas"
                            }
                        }
                    });
                    $("#myReqPen").html(response.numElems);
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function requestDG() {
    $.post("../controller/slcController.php",
            {evento: 15},
            function (response) {
                console.log(response.data);
                if (response.errorCode === 0) {
                    var requests = "";
                    $.each(response.data, function (index, value) {
                        requests += '<tr>'
                                + '<td>' + value.id_solicitud + '</td>'
                                + '<td>' + value.titulo + '</td>'
                                + '<td>' + value.nombre_archivo + '</td>'
                                + '<td>' + value.fecha + '</td>'
                                + '<td>' + value.nombre + '</td>'
                                + '<td>' + value.tipo_documento_nombre + '</td>'
                                + '<td>' + value.nombre_estatus + '</td>'
                                + '<td><form name="authDoc" id="docProps" action="auth_document.php" method="POST">'
                                + '<input type="hidden" name="evento" value="4" />'
                                + '<input type="hidden" name="id_solicitud" value="' + value.id_solicitud + '" />'
                                + '<button type="submit" class="btn btn-primary btn-flat"><li class="fa fa-pencil"></li></button>'
                                + '</form></td>'
                                + '</tr>';
                    });
                    $("#bodyMRP").append(requests);
                    $("#tableReqPA").dataTable({
                        "dom": 'Bfrtip',
                        "buttons": [
                            'colvis', 'csv', 'excel', 'pdf', 'print'
//                            'excel', 'pdf', 'print'
                        ],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": true,
                        "bInfo": true,
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sProcessing": "Procesando...",
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sZeroRecords": "No se encontraron resultados",
                            "sEmptyTable": "Ningún dato disponible en esta tabla",
                            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sSearch": "Buscar:",
                            "sUrl": "",
                            "sInfoThousands": ",",
                            "sLoadingRecords": "Cargando...",
                            "sButtonText": "Imprimir",
                            "oPaginate": {
                                "sFirst": "Primero",
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "buttons": {
                                "print": "Imprimir",
                                "colvis": "Columnas mostradas"
                            }
                        }
                    });
                    $("#myReqPen").html(response.numElems);
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

$("#fd").click(function () {
    $("#fileDwnl").toggle(1000);
});

$("#fc").click(function () {
    $("#fileCnsl").toggle(1000);
});

$("#sc").click(function () {
    $("#reqCrtd").toggle(1000);
});


$("#ap").click(function () {
    $("#reqAP").toggle(1000);
});
$("#pr").click(function () {
    $("#reqPR").toggle(1000);
});

$("#pa").click(function () {
    $("#reqPA").toggle(1000);
});

$("#mrp").click(function () {
    $("#myRP").toggle(1000);
});

