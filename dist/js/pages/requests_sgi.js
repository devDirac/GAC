/* 
 * requests_sgi.js
 * @author FIGG - DIRAC
 * @description Archivo que contiene las funciones necesarias para realizar login SGI.
 */
$(document).ready(function () {
    $("#newRequestForm").submit(function (event) {
        event.preventDefault();
        var formData = new FormData($('#newRequestForm')[0]);
        $.ajax({
            type: "POST",
            url: '../controller/slcController.php',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {
                console.log("Insertando solicitud");
            },
            success: function (response) {
                if (response.errorCode === 0) {
                    showAlert(response.msg, "Solicitud generada", "success", "bounce");
                    setTimeout(function () {
                        window.location.href = "my_requests.php";
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

});

function getMyRequests() {
    $.post("../controller/slcController.php",
            {evento: 2},
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
                                + '<td>' + value.descripcion_estatus + '</td>';
//                        switch (parseInt(value.id_estatus_solicitud)) {
//                            case 1:
//                                requests += '<td>Creada</td>'
//                                        + '</tr>';
//                                break;
//                            case 2:
//                                requests += '<td>Revisi&oacute;n Local</td>'
//                                        + '</tr>';
//                                break;
//                            case 3:
//                                requests += '<td>Revisi&oacute;n Corporativa</td>'
//                                        + '</tr>';
//                                break;
//                            case 4:
//                                requests += '<td>Aprobado</td>'
//                                        + '</tr>';
//                                break;
//
//                            default:
//                                requests += '<td>Cancelado</td>'
//                                        + '</tr>';
//
//                                break;
//                        }

                    });
                    $("#my_requests").append(requests);
                    $("#requests").dataTable({
                        "bPaginate": true,
                        "bLengthChange": false,
//                        "bFilter": false,
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
                            }
                        }
                    });
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}


function getMyRequestsToReview() {
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
                                + '<td>'+value.nombre_estatus+'</td>'
                                + '<td><form name="authDoc" id="docProps" action="auth_document.php" method="POST">'
                                + '<input type="hidden" name="evento" value="4" />'
                                + '<input type="hidden" name="id_solicitud" value="' + value.id_solicitud + '" />'
                                + '<button type="submit" class="btn btn-primary btn-flat"><li class="fa fa-pencil"></li></button>'
                                + '</form></td>'
                                + '</tr>';
                        ;
//                        switch (parseInt(value.id_estatus_solicitud)) {
//                            case 1:
//                                requests += '<td>Nueva</td>'
//                                        + '<td><form name="authDoc" id="docProps" action="auth_document.php" method="POST">'
//                                        + '<input type="hidden" name="evento" value="4" />'
//                                        + '<input type="hidden" name="id_solicitud" value="' + value.id_solicitud + '" />'
//                                        + '<button type="submit" class="btn btn-primary btn-flat"><li class="fa fa-pencil"></li></button>'
//                                        + '</form></td>'
//                                        + '</tr>';
//                                break;
//                            case 2:
//                                requests += '<td>Revisi&oacute;n Local</td>'
//                                        + '<td><form name="authDoc" id="docProps" action="auth_document.php" method="POST">'
//                                        + '<input type="hidden" name="evento" value="4" />'
//                                        + '<input type="hidden" name="id_solicitud" value="' + value.id_solicitud + '" />'
//                                        + '<button type="submit" class="btn btn-primary btn-flat"><li class="fa fa-pencil"></li></button>'
//                                        + '</form></td>'
//                                        + '</tr>';
//                                break;
//                            case 3:
//                                requests += '<td>Revisi&oacute;n Corporativa</td>'
//                                        + '<td><form name="authDoc" id="docProps" action="auth_document.php" method="POST">'
//                                        + '<input type="hidden" name="evento" value="4" />'
//                                        + '<input type="hidden" name="id_solicitud" value="' + value.id_solicitud + '" />'
//                                        + '<button type="submit" class="btn btn-primary btn-flat"><li class="fa fa-pencil"></li></button>'
//                                        + '</form></td>'
//                                        + '</tr>';
//                                break;
//                            case 4:
//                                requests += '<td>Aprobado</td>'
//                                        + '<td><form name="authDoc" id="docProps" action="auth_document.php" method="POST">'
//                                        + '<input type="hidden" name="evento" value="4" />'
//                                        + '<input type="hidden" name="id_solicitud" value="' + value.id_solicitud + '" />'
//                                        + '<button type="submit" class="btn btn-primary btn-flat"><li class="fa fa-pencil"></li></button>'
//                                        + '</form></td>'
//                                        + '</tr>';
//                                break;
//
//                            default:
//                                requests += '<td>Cancelado</td>'
//                                        + '<td><form name="authDoc" id="docProps" action="auth_document.php" method="POST">'
//                                        + '<input type="hidden" name="evento" value="4" />'
//                                        + '<input type="hidden" name="id_solicitud" value="' + value.id_solicitud + '" />'
//                                        + '<button type="submit" class="btn btn-primary btn-flat"><li class="fa fa-pencil"></li></button>'
//                                        + '</form></td>'
//                                        + '</tr>';
//                                break;
//                        }

                    });
                    $("#my_requests").append(requests);
                    $("#requestsToReview").dataTable({
                        "bPaginate": true,
                        "bLengthChange": false,
//                        "bFilter": false,
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
                            }
                        }
                    });
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getMyRequestsAreaToReview() {
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
                                + '<td>'+value.nombre_estatus+'</td>'
                                + '<td><form name="authDoc" id="docProps" action="auth_document.php" method="POST">'
                                + '<input type="hidden" name="evento" value="4" />'
                                + '<input type="hidden" name="id_solicitud" value="' + value.id_solicitud + '" />'
                                + '<button type="submit" class="btn btn-primary btn-flat"><li class="fa fa-pencil"></li></button>'
                                + '</form></td>'
                                + '</tr>';
                    });
                    $("#my_requests").append(requests);
                    $("#requestsToReview").dataTable({
                        "bPaginate": true,
                        "bLengthChange": false,
//                        "bFilter": false,
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
                            }
                        }
                    });
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

//function docProperties(idSolicitud) {
//    $.post("../controller/usrController.php",
//            {evento: 6, id_solicitud: idSolicitud},
//            function (response) {
//                var items = "";
//                if (response.errorCode === 0) {
//                    console.log("Response", response.data);
//
//                } else {
//                    showAlert("¡Error!", response.msg, "error", "swing");
//                }
//            }, 'json');
//}
