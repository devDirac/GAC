$(document).ready(function () {

    $("#trajectoryForm").submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: extSystem.urlController + 'usuarioTrayectoriaController.php',
            data: $('#trajectoryForm').serializeArray(),
            dataType: 'json',
            beforeSend: function () {
                console.log("Add trajectory");
            },
            success: function (response) {
                if (response.errorCode === 0) {
                    showAlert(response.msg, "Redireccionando..", "success", "bounce");
                    //Redireccionamos al dashboard
                    setTimeout(function () {
                        $("#trajectoryForm")[0].reset();
                        $("#myModalTrajectory").modal("toggle");
                        getInfoTrajectoryUsr($("#id_usuario").val(), 1);
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

function getAllInfoUser(id_usuario) {
    $.post(extSystem.urlController + "usrController.php",
            {evento: 12, id_usuario: id_usuario},
            function (response) {
                if (response.errorCode === 0) {
                    console.log("Rsponse getAllInfoUser: ", response);
                    $("#no_control").html(response.data.no_control);
                    $("#nombre").html(response.data.nombre);
                    $("#apellidos").html(response.data.apellidos);
//                    $("#telefono").val(response.data.telefono);
                    $("#correo").html(response.data.correo);
                    $("#puesto").html(response.data.puesto);
                    $("#ubicacion").html(response.data.ubicacion);
                    $("#area").html(response.data.area);
                    $("#escolaridad").html(response.data.escolaridad);
                    if (parseInt(response.data.titulado) === 1) {
                        $("#titulado").html("Titulado");
                    } else {
                        $("#titulado").html("Sin registro");
                    }
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getAddressIdUsr(id_usuario) {
    console.log("getAddressIdUsr");
    $.post(extSystem.urlController + "addressController.php",
            {evento: 7, id: id_usuario},
            function (response) {
                console.log("Response: ", response);
                if (response.errorCode === 0) {
                    $("#calle").html(response.data[0].calle);
                    $("#numero").html(response.data[0].numero);
                    $("#nombre_contacto").html(response.data[0].nombre_contacto);
                    $("#telefono_contacto").html(response.data[0].tel_contacto);
//                    $("#tel_empresa").val(response.data[0].tel_empresa);
                    $("#celular").html(response.data[0].tel_celular);
                    $("#tipo_sangre").html(response.data[0].tipo_sangre);
                    $("#alergias").html(response.data[0].alergias);
//                    $("#foto").val(response.data[0].foto);
                    if (response.data[0].foto.length > 4) {
                        $("#fotoUsr").prop("src", response.data[0].foto);
                    }

                    getAddress(response.data[0].id_colonia);

                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getAddress(colony) {
    $.post(extSystem.urlController + "addressController.php",
            {evento: 6, colony: colony},
            function (response) {
                if (response.errorCode === 0) {
                    $("#ciudad").html(response.data[0].nombre_ciudad);
                    $("#colonia").html(response.data[0].nombre_colonia);
                    $("#ciudad").html(response.data[0].nombre_ciudad);
                    $("#estado").html(response.data[0].nombre_estado);

                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getUsrFiles(id_usuario) {
    $("#tabla_archivos_usuarios").dataTable().fnDestroy();
    $("#archivos_usuarios").html("");
    $.post(extSystem.urlController + "usrFileController.php",
            {evento: 2, id_usuario: id_usuario},
            function (response) {
                if (response.errorCode === 0) {
                    console.log("RESPONSE getUsrFiles: ", response);

                    var files = '';

                    $.each(response.data, function (index, value) {
                        files += '<tr>'
                                + '<td>' + value.nombre + '</td>'
                                + '<td>' + value.nombre_documento + '</td>'
                                + '<td>' + value.tamanio + '</td>'
                                + '<td>' + value.tipo + '</td>'
                                + '<td><a href="' + extSystem.urlController + value.path + value.nombre + '" target="_blank">' + value.nombre + '</a></td>'
                                + '<td><a href="javascript:eliminarArchivo(' + value.id + ',\'' + value.path + value.nombre + '\' )">Eliminar ' + value.nombre + '</a></td>'
                                + '</tr>';

                    });
                    $("#archivos_usuarios").append(files);
                    $("#tabla_archivos_usuarios").dataTable({
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

function eliminarArchivo(id, path) {
//    alert("eliminarArchivo : ", id, path);
    swal({
        title: '¿Estas seguro?',
        text: "¡Esta operación es irreversible!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Si, eliminar!',
        cancelButtonText: 'Cancelar'
    }).then(function () {
        $.post(extSystem.urlController + "usrFileController.php",
                {evento: 3, id_archivo: id, path: path},
                function (response) {
                    console.log("Response: ", response);
                    if (response.errorCode === 0) {
                        $("#tabla_archivos_usuarios").dataTable().fnDestroy();
                        $("#archivos_usuarios").html("");
                        setTimeout(function () {
                            getUsrFiles($("#id_usuario").val());
                        }, 1500);
                        showAlert(response.msg, "Archivo eliminado exitosamente", "success", "bounce");
                    } else {
                        showAlert("¡Error!", response.msg, "error", "swing");
                    }
                }, 'json');
    });
}


function getAllInfoUserOI(id_usuario) {
    console.log("getAllInfoUserOI");
//    alert("HEY");
    $.post(extSystem.urlController + "usrController.php",
            {evento: 14, id_usuario: id_usuario},
            function (response) {
                console.log("Response: ", response);
                if (response.errorCode === 0) {
                    $("#nombre").html(response.data[0].nombre);
                    $("#no_control").html(response.data[0].no_control);
                    $("#apellidos").html(response.data[0].apellidos);
                    $("#celular").html(response.data[0].tel_celular);
                    $("#correo").html(response.data[0].correo);
                    $("#puesto").html(response.data[0].puesto);
                    $("#ubicacion").html(response.data[0].proyecto);
                    $("#direccion_area").html(response.data[0].direccion);
                    $("#area").html(response.data[0].area);
                    $("#escolaridad").html(response.data[0].escolaridad);

                    switch (parseInt(response.data[0].titulado)) {
                        case 0:
                            $("#titulado").html("Sin estudios");
                            break;
                        case 1:
                            $("#titulado").html("Titulado");
                            break;
                        case 2:
                            $("#titulado").html("Pasante");
                            break;
                        case 3:
                            $("#titulado").html("Sin estudios");
                            break;
                        default:
                            $("#titulado").html("Sin estudios");
                            break;
                    }



                    $("#estado").html(response.data[0].estado);
                    $("#ciudad").html(response.data[0].ciudad);
                    $("#colonia").html(response.data[0].nombre_colonia);
                    $("#calle").html(response.data[0].calle);
                    $("#cp").html(response.data[0].valor);

                    $("#numero").html(response.data[0].numero);
                    $("#nombre_contacto").html(response.data[0].nombre_contacto);

                    $("#telefono_contacto").html(response.data[0].tel_contacto);
                    $("#tipo_sangre").html(response.data[0].tipo_sangre);
                    $("#alergias").html(response.data[0].alergias);

                    $("#foto").val(response.data[0].foto);
                    $("#fotoUsr").prop("src", response.data[0].foto);

                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getInfoTrajectoryUsr(id_usuario, opcion) {
    $("#table_trajectory").dataTable().fnDestroy();
    $("#user_trajectory").html("");
    $.post(extSystem.urlController + "usuarioTrayectoriaController.php",
            {evento: 1, id_usuario: id_usuario, opcion: opcion},
            function (response) {
                if (response.errorCode === 0) {
                    var trajUsr = '';
                    $.each(response.data, function (index, value) {
                        $("#no_control").html(value.no_control);
                        $("#nombre").html(value.nombre);
                        $("#apellidos").html(value.apellidos);
                        $("#id_usuario").val(value.id_usuario);
                        $("#correo").val(value.correo);

                        trajUsr += '<tr>'
                                + '<td>' + value.nombre + '</td>'
                                + '<td>' + value.apellidos + '</td>'
                                + '<td>' + value.cargo + '</td>'
                                + '<td>' + value.proyecto + '</td>'
                                + '<td>' + format2(parseFloat(value.sueldo), '$') + '</td>'
                                + '<td>' + value.fecha_inicio + '</td>'
                                + '<td>' + value.fecha_fin + '</td>'
                                + '<td>' + value.fecha_captura + '</td>'
                                + '<td><button type="submit" class="btn btn-primary btn-flat" data-toggle="tooltip" title="Editar trayectoria" onclick="openModalTrajectory(2,' + value.id + ');"><li class="fa fa-pencil text-orange"></li></button></td>'

                                + '</tr>';
                    });
                    $("#user_trajectory").append(trajUsr);
                    $("#table_trajectory").dataTable({
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

function format2(n, currency) {
    return currency + " " + n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
}

function openModalTrajectory(opcion, id) {
    $("#myModalTrajectory").modal("toggle");
    getProfile();
    getCargos('cat_perfil_dirac');
    getProjectsD('proyectos_sgi');
    $("#id_usuario").val($("#idUsuario").val());
    if (opcion === 1) {
        $("#trajectoryForm")[0].reset();
        $("#opcion").val(1);
    } else {
        getTrajectoryById(id, opcion);
    }
}

function getTrajectoryById(id, opcion) {
    $.post(extSystem.urlController + "usuarioTrayectoriaController.php",
            {evento: 1, id: id, opcion: opcion},
            function (response) {
                if (response.errorCode === 0) {
                    $("#id").val(response.data[0].id);
                    $("#id_cargo").val(response.data[0].id_cargo);
                    $("#id_proyecto").val(response.data[0].id_proyecto);
                    $("#sueldo").val(response.data[0].sueldo);
                    $("#fecha_ingreso").val(response.data[0].fecha_inicio);
                    $("#opcion").val(2);

                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

