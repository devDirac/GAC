$(document).ready(function () {
    $("#assign_usr").submit(function (event) {
        event.preventDefault();
        var valida = validarPorcentajes();
        if (valida) {
            $("#msg").html('<div class="text-center"><i class="fa fa-spinner fa-spin" style="font-size:48px; color: aqua"></i><br /><b class="text-center">Procesando informaci&oacute;n...<b></div>');
//            $("#msg2").html('<i class="fa fa-spinner fa-spin" style="font-size:48px; color: aqua"></i>');
            $.post("../controller/transferController.php",
                    $("#assign_usr").serializeArray(),
                    function (response) {
                        if (response.errorCode === 0) {
                            showAlert(response.msg, "La transferencia ha sido procesada.", "success", "bounce");
                            setTimeout(function () {
                                window.location.href = "dashboard.php";
                            }, 1500);
                        } else {
                            showAlert("¡Error!", response.msg, "error", "swing");
                        }
                        $("#msg").html('');
                        $("#msg2").html('');
                    }, 'json');

        } else {
            $("#msg").html('<b class="text-center text-danger">Los porcentajes de utilizaci&oacute;n de los proyectos deben sumar 100.<b>');
        }
    });

    $("#update_assigns").submit(function (event) {
        event.preventDefault();
        var valida = validarPorcentajesEdit();
        if (valida) {
            $("#msg").html('<div class="text-center"><i class="fa fa-spinner fa-spin" style="font-size:48px; color: aqua"></i><br /><b class="text-center">Procesando informaci&oacute;n...<b></div>');
            $.post("../controller/transferController.php",
                    $("#update_assigns").serializeArray(),
                    function (response) {
                        if (response.errorCode === 0) {
                            showAlert(response.msg, "Las transferencias han sido actualizadas.", "success", "bounce");
                            setTimeout(function () {
                                window.location.href = "dashboard.php";
                            }, 1500);
                        } else {
                            showAlert("¡Error!", response.msg, "error", "swing");
                        }
                        $("#msg").html('');
                        $("#msg2").html('');
                    }, 'json');

        } else {
            $("#msg").html('<b class="text-center text-danger">Los porcentajes de utilizaci&oacute;n de los proyectos deben sumar 100.<b>');
        }
    });

});

function getInfoUsrs() {
    $.post("../controller/transferController.php",
            {evento: 1, query: 'id_direccion = ' + $("#area_direccion").val() + " AND nivel != 'A' "},
            function (response) {
                if (response.errorCode === 0) {
                    var requests = "";
                    $.each(response.data, function (index, value) {
                        requests += '<tr>'
                                + '<td>' + value.id_usuario + '</td>'
                                + '<td>' + value.no_control + '</td>'
                                + '<td class="text-orange"><b>' + value.nombre + '</b></td>'
                                + '<td>' + value.apellidos + '</td>'
                                + '<td>' + value.usuario + '</td>'
                                + '<td>' + value.genero + '</td>'
                                + '<td>' + value.correo + '</td>'
                                + '<td>' + value.puesto + '</td>'
                                + '<td>' + value.direccion + '</td>'
                                + '<td>' + value.proyecto + '</td>'
                                + '<td>' + value.escolaridad + '</td>';

                        if (parseInt(value.titulado) === 1) {
                            requests += '<td>Titulado</td>';
                        } else {
                            requests += '<td>Sin registro</td>';

                        }
                        requests += '<td>' + value.fecha_ingreso + '</td>';
                        requests += '<td>'
                                + '<form name="asignar_trayectoria" id="asignar_trayectoria" method="POST" action="assign_usr_project.php">'
                                + '<input type="hidden" name="id_usuario" value="' + value.id_usuario + '" />'
                                + '<button type="submit" class="btn btn-flat" data-toggle="tooltip" title="Transferencia de recurso"><li class="fa fa-plus-circle text-orange"></li></button>'
                                + '</form>'
                                + '<form name="ver_trayectoria" id="ver_trayectoria" method="POST" action="view_trajectory.php">'
                                + '<input type="hidden" name="id_usuario" value="' + value.id_usuario + '" />'
                                + '<button type="submit" class="btn btn-flat" data-toggle="tooltip" title="Ver transferencias de recurso"><li class="fa fa-eye text-success"></li></button>'
                                + '</form>'
                                + '<form name="editar_trayectoria" id="editar_trayectoria" method="POST" action="edit_trajectory.php">'
                                + '<input type="hidden" name="id_usuario" value="' + value.id_usuario + '" />'
                                + '<button type="submit" class="btn btn-flat" data-toggle="tooltip" title="Editar transferencias de recurso"><li class="fa fa-pencil text-warning"></li></button>'
                                + '</form>';
                        +'</td>'
                                + '</tr>';
                    });
                    $("#dirac_users").append(requests);
                    $("#users").dataTable({
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

function getInfoUsrById(id_usuario) {
    $.post("../controller/transferController.php",
            {evento: 1, query: 'id_usuario = ' + id_usuario},
            function (response) {
                if (response.errorCode === 0) {
                    console.log(response);
                    $("#id_puesto").val(response.data[0].id_perfil);
                    $("#id_proyecto").val(response.data[0].id_proyecto);
                    $("#id_proyecto_anterior").val(response.data[0].id_proyecto);
                    $("#id_direccion").val(response.data[0].id_direccion);
                    $("#id_area").val(response.data[0].id_direccion);
                    $("#nombre_usuario").html(response.data[0].nombre + " " + response.data[0].apellidos);
                    $("#sueldo").val(response.data[0].last_salary);
                    $("#compensaciones").val(response.data[0].compensaciones);
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getUsrTransfers(id_usuario) {
    $("#asiggns_user").html('');
    $.post("../controller/transferController.php",
            {evento: 3, query: 'A.id_usuario = ' + id_usuario},
            function (response) {
                if (response.errorCode === 0) {
                    console.log(response);
                    if (response.data.length > 0) {
                        var transfers = '<div class="form-group">';
                        transfers += ' <table class="table dt-responsive nowrap table-responsive text-center"><tr><td>Proyecto</td><td>% utilizaci&oacute;n</td><td>Eliminar asignaci&oacute;n</td></tr>'
                        $.each(response.data, function (index, value) {
                            transfers += '<tr>';
                            transfers += '<td><input type="hidden" name="id_asignacion[]" value="' + value.id + '" /><input type="hidden" name="fecha_inicioP[]" value="' + value.fecha_inicio + '" /><input type="hidden" name="fecha_finP[]" value="' + value.fecha_fin + '" />' + value.proyecto + '</td>';
                            transfers += '<td><input type="number" name="utilizacionP[]" id="utilizacion" step="1" min="0" max="100" value="' + value.utilizacion + '" class="form-control" required="true" /></td>';
                            transfers += '<td><a href="#" onclick="deleteAssign(' + value.id + ', ' + value.id_usuario + ' );"><i class="fa fa-ban text-danger"></i></a></td>';
                            transfers += '</tr>';
                        });
                        transfers += '<tr><td id="proyecto_nuevo">Proyecto Nuevo</td><td><input type="number" name="utilizacion" id="utilizacionN" step="1" min="1" max="100" value="0" class="form-control" required="true" /></td></tr>';
                        transfers += '</table></div>';
                        $("#asiggns_user").html(transfers);
                    } else {
                        $("#asiggns_user").html('<p class="text-orange text-center">El usuario no cuenta con registros de transferencia.</p>')
                    }
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getMyTransfers(q) {
    $.post("../controller/transferController.php",
            {evento: 3, query: q},
            function (response) {
                if (response.errorCode === 0) {
                    var requests = "";
                    $.each(response.data, function (index, value) {
                        requests += '<tr>'
                                + '<td>' + value.id + '</td>'
                                + '<td class="text-orange"><b>' + value.nombre_empleado + '</b></td>'
                                + '<td>' + value.cargo + '</td>'
                                + '<td>' + value.proyecto_anterior + '</td>'
                                + '<td>' + value.proyecto + '</td>'
                                + '<td>' + accounting.formatMoney(parseFloat(value.sueldo) * 2) + '</td>'
                                + '<td>' + accounting.formatMoney(value.viaticos) + '</td>'
                                + '<td>' + accounting.formatMoney(value.compensaciones) + '</td>'
                                + '<td>' + value.utilizacion + '</td>'
                                + '<td>' + value.fecha_inicio + '</td>'
                                + '<td>' + value.fecha_fin + '</td>'
                                + '<td>' + value.nota + '</td>';

                        switch (parseInt(value.estatus)) {
                            case 0:
                                requests += '<td class="text-orange"><b>En autorizaci&oacute;n (DG)</b></td>';
                                break;
                            case 1:
                                requests += '<td class="text-success"><b>Autorizado</b></td>';
                                break;
                            case 2:
                                requests += '<td class="text-danger"><b>Rechazado</b></td>';
                                break;

                            default:
                                requests += '<td>Error al recuperar status</td>';
                                break;
                        }
                        if (value.nota_dg === null) {
                            requests += '<td></td>'
                        } else {
                            requests += '<td>' + value.nota_dg + '</td>'
                        }

                        requests += '<td>'
                                + '<form name="ver_trayectoria" id="ver_trayectoria" method="POST" action="view_trajectory.php">'
                                + '<input type="hidden" name="id_usuario" value="' + value.id_usuario + '" />'
                                + '<button type="submit" class="btn btn-flat" data-toggle="tooltip" title="Ver transferencias de recurso"><li class="fa fa-eye text-success"></li></button>'
                                + '</form>'
                                + '<form name="editar_trayectoria" id="editar_trayectoria" method="POST" action="edit_trajectory.php">'
                                + '<input type="hidden" name="id_usuario" value="' + value.id_usuario + '" />'
                                + '<button type="submit" class="btn btn-flat" data-toggle="tooltip" title="Editar transferencias de recurso"><li class="fa fa-pencil text-warning"></li></button>'
                                + '</form>';
                        requests += '</tr>';
                    });
                    $("#dirac_transfers").append(requests);
                    $("#transfers").dataTable({
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

function getTrajectory() {
    $.post("../controller/transferController.php",
            {evento: 3, query: 'A.id_usuario = ' + $("#id_usuario").val()},
            function (response) {
                if (response.errorCode === 0) {
                    var requests = "";
                    $.each(response.data, function (index, value) {
                        requests += '<tr>'
                                + '<td>' + value.id + '</td>'
                                + '<td class="text-orange"><b>' + value.nombre_empleado + '</b></td>'
                                + '<td>' + value.cargo + '</td>'
                                + '<td>' + value.proyecto_anterior + '</td>'
                                + '<td>' + value.proyecto + '</td>'
                                + '<td>' + accounting.formatMoney(parseFloat(value.sueldo) * 2) + '</td>'
                                + '<td>' + accounting.formatMoney(value.viaticos) + '</td>'
                                + '<td>' + accounting.formatMoney(value.compensaciones) + '</td>'
                                + '<td>' + value.utilizacion + '</td>'
                                + '<td>' + value.fecha_inicio + '</td>'
                                + '<td>' + value.fecha_fin + '</td>'
                                + '<td>' + value.nota + '</td>';

                        switch (parseInt(value.estatus)) {
                            case 0:
                                requests += '<td class="text-orange"><b>En autorizaci&oacute;n (DG)</b></td>';
                                break;
                            case 1:
                                requests += '<td class="text-success"><b>Autorizado</b></td>';
                                break;
                            case 2:
                                requests += '<td class="text-danger"><b>Rechazado</b></td>';
                                break;

                            default:
                                requests += '<td>Error al recuperar status</td>';
                                break;
                        }
                        if (value.nota_dg === null) {
                            requests += '<td></td>'
                        } else {
                            requests += '<td>' + value.nota_dg + '</td>'
                        }
                        requests += '</tr>';
                    });
                    $("#dirac_transfers").append(requests);
                    $("#transfers").dataTable({
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

function getTrajectoryEdit() {
    $.post("../controller/transferController.php",
            {evento: 3, query: 'A.id_usuario = ' + $("#id_usuario").val()},
            function (response) {
                if (response.errorCode === 0) {
                    var requests = "";
                    $.each(response.data, function (index, value) {
                        $("#nombre_usuario").html(value.nombre_empleado);
                        requests += '<tr>'
                                + '<td><input type="hidden" name="id_assign[]" value="' + value.id + '" />' + value.id + '</td>'
                                + '<td class="text-orange"><b>' + value.proyecto + '</b><input type="hidden" name="id_proyecto[]" value="'+value.id_proyecto+'" /></td>'
                                + '<td>' + value.cargo + '</td>'
                                + '<td><input type="text" name="utilizacionP[]" value="' + value.utilizacion + '" class="form-control" /></td>'
                                + '<td><input type="date" name="fechaInicioP[]" value="' + value.fecha_inicio + '" class="form-control" /></td>'
                                + '<td><input type="date" name="fechaFinP[]" value="' + value.fecha_fin + '" class="form-control" /></td>'
                                + '<td><a href="#" onclick="deleteAssignEdit(' + value.id + ', ' + value.id_usuario + ' );"><i class="fa fa-ban text-danger"></i></a></td>';
                        +'</tr>';
                    });
                    $("#dirac_transfers").append(requests);
                    $("#transfers").dataTable({
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

function getMyTransfersDG() {
    $.post("../controller/transferController.php",
            {evento: 3, query: 'A.estatus = 0'},
            function (response) {
                if (response.errorCode === 0) {
                    var requests = "";
                    $.each(response.data, function (index, value) {
                        var motivo = "";
                        requests += '<tr>'
                                + '<td>' + value.id + '</td>'
                                + '<td class="text-orange"><b>' + value.nombre_empleado + '</b></td>'
                                + '<td>' + value.cargo + '</td>'
                                + '<td>' + value.proyecto_anterior + '</td>'
                                + '<td>' + value.proyecto + '</td>'
                                + '<td>' + value.direccion_anterior + '</td>'
                                + '<td>' + value.direccion + '</td>'
                                + '<td>' + accounting.formatMoney(parseFloat(value.sueldo) * 2) + '</td>'
                                + '<td>' + accounting.formatMoney(value.viaticos) + '</td>'
                                + '<td>' + accounting.formatMoney(value.compensaciones) + '</td>'
                                + '<td>' + value.utilizacion + '</td>'
                                + '<td>' + value.fecha_inicio + '</td>'
                                + '<td>' + value.fecha_fin + '</td>'
                                + '<td>' + value.nota + '</td>';

                        if (parseFloat(value.last_salary) !== parseFloat(value.sueldo)) {
                            motivo += '<b class="text-orange">Sueldo</b><br />';
                        }
                        if (parseFloat(value.compensaciones) > 0) {
                            motivo += '<b class="text-orange">Compensaciones</b><br />';
                        }
                        if (parseFloat(value.viaticos) > 0) {
                            motivo += '<b class="text-orange">Viaticos</b><br />';
                        }
                        requests += '<td>' + motivo + '</td>';
                        requests += '<td><button type="button" class="btn btn-primary btn-flat" onclick="checkAssign(' + value.id + ');" >Autorizar</button></td>'
                                + '</tr>';
                    });
                    $("#dirac_transfers").append(requests);
                    $("#transfers").dataTable({
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

function checkAssign(id) {
    $("#myModal").modal("show");
    $("#id_assign").val(id);
}

function authAssign(valor) {
    $("#msg").html('<div class="text-center"><i class="fa fa-spinner fa-spin" style="font-size:48px; color: aqua"></i><br /><b class="text-center">Procesando informaci&oacute;n...<b></div>');
    $.post("../controller/transferController.php",
            {evento: 4, id: $("#id_assign").val(), valor: valor, nota_dg: $("#nota_dg").val()},
            function (response) {
                if (response.errorCode === 0) {
                    showAlert(response.msg, "Solicitud actualizada exitosamente", "success", "bounce");
                    setTimeout(function () {
                        window.location.href = "my_pending_transfers.php";
                    }, 1500);
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
                $("#msg").html('');
            }, 'json');
}

function selectTT(opcion) {
    $("#opcion").val(opcion);
    $("#opts_assign").show('slow');
    if (parseInt(opcion) === 1) {
        $("#div_project").show('slow');
        $("#div_area").hide('slow');
    } else {
        $("#div_area").show('slow');
        $("#div_project").hide('slow');
    }
}

function validarPorcentajes() {
    var suma = 0;

    $.each($("input[name='utilizacionP[]']"), function (index, value) {
        console.log(value.value);
        suma += parseFloat(value.value);
    });
    suma += parseFloat($("#utilizacionN").val());
    console.log(suma);
    if (suma !== 100) {
        return false;
    } else {
        return true;
    }
}

function validarPorcentajesEdit() {
    var suma = 0;
    $.each($("input[name='utilizacionP[]']"), function (index, value) {
//        console.log(value.value);
        suma += parseFloat(value.value);
    });

    if (suma !== 100) {
        return false;
    } else {
        return true;
    }
}

function deleteAssign(id, id_usuario) {
    $.post("../controller/transferController.php",
            {evento: 5, id: id},
            function (response) {
                if (response.errorCode === 0) {
                    showAlert(response.msg, "Asignaci&oacute;n eliminada exitosamente", "success", "bounce");
                    setTimeout(function () {
                        getUsrTransfers(id_usuario);
                    }, 1500);
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
                $("#msg").html('');
            }, 'json');
}

function deleteAssignEdit(id, id_usuario) {
    $.post("../controller/transferController.php",
            {evento: 5, id: id},
            function (response) {
                if (response.errorCode === 0) {
                    showAlert(response.msg, "Asignaci&oacute;n eliminada exitosamente", "success", "bounce");
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
                $("#msg").html('');
            }, 'json');
}
function getParameterByName(param) {
    var url = window.location.href;
    var urlObj = new URL(url);
    var parameter = urlObj.searchParams.get(param);
    return parameter;
}

function checkPercentage(campo) {
    console.log(campo);
}

function writeProject(){
    $("#proyecto_nuevo").html($("#id_proyecto option:selected" ).text());
}