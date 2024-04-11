/* 
 * users.js
 * @author FIGG - DIRAC
 * @description Archivo que contiene funciones de utilidad.
 */
$(document).ready(function () {
    $("#updateUsrSGI").submit(function (event) {
        event.preventDefault();
        if ($("#contrasenia").val() === $("#contrasenia2").val()) {
            $.post(extSystem.urlController + "usrController.php",
                    $("#updateUsrSGI").serializeArray(),
                    function (response) {
                        if (response.errorCode === 0) {
                            showAlert(response.msg, "Usuario actualizado", "success", "bounce");
//                            setTimeout(function () {
//                                window.location.href = "all_users.php";
//                            }, 1500);
                        } else {
                            showAlert("¡Error!", response.msg, "error", "swing");
                        }
                    }, 'json');
        } else {
            $("#msg").html('<div class="col-md-12 col-md-offset-0"><div class="alert alert-dismissable alert-danger"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong><i class="fa fa-danger"> </i></strong>Las contraseñas no coinciden</div></div>');
            setTimeout(function () {
                $("#msg").html('');
            }, 2500);
        }
    });

});

function getUsers() {
    $.post(extSystem.urlController + "usrController.php",
            {evento: 7},
            function (response) {
                if (response.errorCode === 0) {
                    var requests = "";
                    $.each(response.data, function (index, value) {
                        requests += '<tr>'
                                + '<td>' + value.id_usuario + '</td>'
                                + '<td>' + value.nombre + '</td>'
                                + '<td>' + value.apellidos + '</td>'
                                + '<td>' + value.usuario + '</td>'
                                + '<td>' + value.correo + '</td>'
                                + '<td>' + value.nombre_perfil + '</td>';
                        if (parseInt(value.estatus) === 1) {
                            requests += '<td>Activo</td>';
                        } else {
                            requests += '<td>Inactivo</td>';
                        }
                        requests += '<td>'
                                + '<form name="newProjectForm" id="newProjectForm" method="POST" action="edit_usr_sgi.php">'
                                + '<input type="hidden" name="id_usuario" value="' + value.id_usuario + '" />'
                                + '<button type="submit" class="btn btn-primary btn-flat"><li class="fa fa-pencil"></li></button>'
                                + '</form></td>';
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

function getInfoUsrProfile(id_usuario) {
    console.log("getInfoUsrProfile");
    $.post(extSystem.urlController + "usrController.php",
            {evento: 8, id_usuario: id_usuario},
            function (response) {
                console.log("Response: ", response);
                if (response.errorCode === 0) {
                    console.log("el 8: " + response);
                    $("#nameUsr").html(response.data[0].nombre);

                    $("#usuario").val(response.data[0].usuario);
//                    $("#contrasenia").val(response.data[0].contrasenia);
                    $("#correo").val(response.data[0].correo);
                    $("#areaUsr").val(response.data[0].id_area);
                    $("#perfilUsr").val(response.data[0].id_perfil);
                    $("#estatusUsr").val(response.data[0].estatus);
                    $("#id_perfil_usuario").val(response.data[0].id);
                    $("#nivel").val(response.data[0].nivel);
                    $("#id_cargo").val(response.data[0].id_cargo);
                    $("#telefono").val(response.data[0].telefono);
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getAddressByIdUsr(id_usuario) {
    console.log("getAddressByIdUsr");
    $.post(extSystem.urlController + "addressController.php",
            {evento: 7, id: id_usuario},
            function (response) {
                console.log("Response: ", response);
                if (response.errorCode === 0) {
//                    console.log(response);
//                    $("#id_direccion").html(response.data[0].id_direccion);
//                    $("#id_usuario").val(response.data[0].id_usuario);
                    $("#idColonia").val(response.data[0].id_colonia);
//                    $("#colonias").val(response.data[0].colonias);
                    $("#calle").val(response.data[0].calle);
                    $("#numero").val(response.data[0].numero);
                    $("#nombre_contacto").val(response.data[0].nombre_contacto);
                    $("#tel_contacto").val(response.data[0].tel_contacto);
                    $("#tel_empresa").val(response.data[0].tel_empresa);
                    $("#celular").val(response.data[0].tel_celular);
                    $("#tipo_sangre").val(response.data[0].tipo_sangre);
                    $("#alergias").val(response.data[0].alergias);
                    $("#foto").val(response.data[0].foto);
                    $("#fotoUsr").prop("src", response.data[0].foto);

                    $("#id_escolaridad").val(response.data[0].id_escolaridad);

                    if (parseInt(response.data[0].titulado) === 0) {
                        $('#titulado').iCheck('uncheck');
                    }
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getAllInfoUsers() {
    $.post(extSystem.urlController + "usrController.php",
            {evento: 11},
            function (response) {
                if (response.errorCode === 0) {
                    var requests = "";
                    $.each(response.data, function (index, value) {
                        requests += '<tr>'
                                + '<td>' + value.id_usuario + '</td>'
                                + '<td><a href="usr_info.php?id_usuario=' + value.id_usuario + '" class="sweet-figg-title">' + value.no_control + '</a></td>';
                        if (parseInt(value.estatus) === 1) {
                            if (parseInt(value.eliminado) === 0) {
                                requests += '<td class="text-red"><b>' + value.nombre + '</b></td>';
                            } else {
                                requests += '<td><a href="user_trajectory.php?id_usuario=' + value.id_usuario + '" class="text-yellow"><b>' + value.nombre + '</b></a></td>';
                            }
                        } else {
                            requests += '<td class="text-red"><b>' + value.nombre + '</b></td>';
                        }
                        requests += '<td>' + value.apellidos + '</td>'
                                + '<td>' + value.usuario + '</td>'
                                + '<td>' + value.genero + '</td>'
                                + '<td>' + value.correo + '</td>'
                                + '<td>' + value.puesto + '</td>'
                                + '<td>' + value.nombre_area + '</td>'
                                + '<td>' + value.ubicacion + '</td>'
                                + '<td>' + value.escolaridad + '</td>';

                        if (parseInt(value.titulado) === 1) {
                            requests += '<td>Titulado</td>';
                        } else {
                            requests += '<td>Sin registro</td>';

                        }
                        requests += '<td>' + value.telefono + '</td>'
                                + '<td>' + value.nivel + '</td>'
                                + '<td>' + value.fecha_ingreso + '</td>';

                        if (parseInt(value.id_empresa) === 1) {
                            requests += '<td>DIRAC</td>';
                        } else if (parseInt(value.id_empresa) === 2) {
                            requests += '<td>DIELEM</td>';
                        } else if (parseInt(value.id_empresa) === 3) {
                            requests += '<td>LAB. DIRAC</td>';
                        }else{
                            requests += '<td>DISENO</td>';
                        }

                        requests += '<td>' + value.fecha_nacimiento + '</td>'
                                + '<td>' + value.curp + '</td>'
                                + '<td>' + value.rfc + '</td>'
                                + '<td>' + value.direccion + '</td>'
                                + '<td>' + value.calle + '</td>'
                                + '<td>' + value.numero + '</td>'
                                + '<td>' + value.nombre_colonia + '</td>'
                                + '<td>' + value.ciudad + '</td>'
                                + '<td>' + value.estado + '</td>';
                        requests += '<td>'
                                + '<form name="newProjectForm" id="newProjectForm" method="POST" action="edit_usr_sgi.php">'
                                + '<input type="hidden" name="id_usuario" value="' + value.id_usuario + '" />'
                                + '<button type="submit" class="btn btn-primary btn-flat" data-toggle="tooltip" title="Editar usuario"><li class="fa fa-pencil text-orange"></li></button>'
                                + '</form>'
                                + '<form name="addUsr" id="addUsr" method="POST" action="register.php">'
                                + '<button type="submit" class="btn btn-primary btn-flat" data-toggle="tooltip" title="Agregar usuario"><li class="fa fa-plus-square-o text-success"></li></button>'
                                + '</form>';

                        if (parseInt(value.estatus) === 0) {
                            requests += '<button type="submit" class="btn btn-primary btn-flat" onclick="desactivarUsr(' + value.id_usuario + ',' + value.estatus + ')" data-toggle="tooltip" title="Bloquear/Desbloquear usuario"><li class="fa  fa-check text-success"></li></button>';
                        } else {
                            requests += '<button type="submit" class="btn btn-primary btn-flat" onclick="desactivarUsr(' + value.id_usuario + ',' + value.estatus + ')" data-toggle="tooltip" title="Bloquear/Desbloquear usuario"><li class="fa fa-ban text-danger"></li></button>';
                        }


                        requests += '<button type="submit" class="btn btn-primary btn-flat" onclick="eliminarUsr(' + value.id_usuario + ',' + value.eliminado + ')" data-toggle="tooltip" title="Eliminar usuario"><li class="fa fa-times text-danger"></li></button>'
                                + '</td>'
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

function getAllInfoUsersD() {
    $.post(extSystem.urlController + "usrController.php",
            {evento: 21},
            function (response) {
                if (response.errorCode === 0) {
                    var requests = "";
                    $.each(response.data, function (index, value) {
                        requests += '<tr>'
                                + '<td>' + value.id_usuario + '</td>'
                                + '<td><a href="usr_info.php?id_usuario=' + value.id_usuario + '" class="sweet-figg-title">' + value.no_control + '</a></td>';
                        if (parseInt(value.eliminado) === 0) {
                            requests += '<td class="text-red"><b>' + value.nombre + '</b></td>';
                        } else {
                            requests += '<td><a href="user_trajectory.php?id_usuario=' + value.id_usuario + '" class="text-yellow"><b>' + value.nombre + '</b></a></td>';
                        }
                        requests += '<td>' + value.apellidos + '</td>'
                                + '<td>' + value.usuario + '</td>'
                                + '<td>' + value.genero + '</td>'
                                + '<td>' + value.correo + '</td>'
                                + '<td>' + value.puesto + '</td>'
                                + '<td>' + value.nombre_area + '</td>'
                                + '<td>' + value.ubicacion + '</td>'
                                + '<td>' + value.escolaridad + '</td>';

                        if (parseInt(value.titulado) === 1) {
                            requests += '<td>Titulado</td>';
                        } else {
                            requests += '<td>Sin registro</td>';

                        }
                        requests += '<td>' + value.telefono + '</td>'
                                + '<td>' + value.nivel + '</td>'
                                + '<td>' + value.fecha_ingreso + '</td>'
                                + '<td>' + value.fecha_nacimiento + '</td>'
                                + '<td>' + value.curp + '</td>'
                                + '<td>' + value.rfc + '</td>'
                                + '<td>' + value.direccion + '</td>'
                                + '<td>' + value.calle + '</td>'
                                + '<td>' + value.numero + '</td>'
                                + '<td>' + value.nombre_colonia + '</td>'
                                + '<td>' + value.ciudad + '</td>'
                                + '<td>' + value.estado + '</td>';
                        requests += '<td>'
                                + '<form name="newProjectForm" id="newProjectForm" method="POST" action="edit_usr_sgi.php">'
                                + '<input type="hidden" name="id_usuario" value="' + value.id_usuario + '" />'
                                + '<button type="submit" class="btn btn-primary btn-flat" data-toggle="tooltip" title="Editar usuario"><li class="fa fa-pencil text-orange"></li></button>'
                                + '</form>'
                                + '<form name="addUsr" id="addUsr" method="POST" action="register.php">'
                                + '<button type="submit" class="btn btn-primary btn-flat" data-toggle="tooltip" title="Agregar usuario"><li class="fa fa-plus-square-o text-success"></li></button>'
                                + '</form>';

                        if (parseInt(value.estatus) === 0) {
                            requests += '<button type="submit" class="btn btn-primary btn-flat" onclick="desactivarUsr(' + value.id_usuario + ',' + value.estatus + ')" data-toggle="tooltip" title="Bloquear/Desbloquear usuario"><li class="fa  fa-check text-success"></li></button>';
                        } else {
                            requests += '<button type="submit" class="btn btn-primary btn-flat" onclick="desactivarUsr(' + value.id_usuario + ',' + value.estatus + ')" data-toggle="tooltip" title="Bloquear/Desbloquear usuario"><li class="fa fa-ban text-danger"></li></button>';
                        }


                        requests += '<button type="submit" class="btn btn-primary btn-flat" onclick="eliminarUsr(' + value.id_usuario + ',' + value.eliminado + ')" data-toggle="tooltip" title="Eliminar usuario"><li class="fa fa-times text-danger"></li></button>'
                                + '</td>'
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

function desactivarUsr(id_usuario, valor) {
    if (parseInt(valor) === 1) {
        valor = 0;
    } else {
        valor = 1;
    }
    $.post(extSystem.urlController + "usrController.php",
            {evento: 13, id_usuario: id_usuario, referencia: 'status = ?, eliminado = ? ', valor: valor},
            function (response) {
                console.log("Response: ", response);
                if (response.errorCode === 0) {
                    showAlert(response.msg, "Usuario actualizado", "success", "bounce");
                    enviarNotificacion(id_usuario, valor);
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function eliminarUsr(id_usuario, valor) {
    if (parseInt(valor) === 1) {
        valor = 0;
    } else {
        valor = 1;
    }
    $.post(extSystem.urlController + "usrController.php",
            {evento: 13, id_usuario: id_usuario, referencia: 'status = ?, eliminado = ? ', valor: valor},
            function (response) {
                console.log("Response: ", response);
                if (response.errorCode === 0) {
                    showAlert(response.msg, "Usuario actualizado", "success", "bounce");
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}


function getAllInfoUserGFH(id_usuario) {
    console.log("getAllInfoUser");
//    alert("HEY");
    $.post(extSystem.urlController + "usrController.php",
            {evento: 14, id_usuario: id_usuario},
            function (response) {
                console.log("Response: ", response);
                if (response.errorCode === 0) {
                    $("#usuario").val(response.data[0].usuario);
                    $("#areaUsr").val(response.data[0].id_direccion);

                    getUserByDirection(response.data[0].id_direccion);

                    $("#area_direccion").val(response.data[0].id_area);
                    $("#id_cargo").val(response.data[0].id_perfil);
                    $("#id_escolaridad").val(response.data[0].id_escolaridad);
                    $("#id_empresa").val(response.data[0].id_empresa);
                    setTimeout(function () {
                        $("#jefe_inmediato").val(response.data[0].jefe_inmediato);
                    }, 1500);


                    switch (parseInt(response.data[0].titulado)) {
                        case 0:
                            $("#trunco").iCheck('check');
                            break;
                        case 1:
                            $("#titulado").iCheck('check');
                            break;
                        case 2:
                            $("#pasante").iCheck('check');
                            break;
                        case 3:
                            $("#trunco").iCheck('check');
                            break;
                        default:
                            $("#trunco").iCheck('check');
                            break;
                    }
                    $("#perfilUsr").val(response.data[0].id_perfil_sgi);
                    $("#nivel").val(response.data[0].nivel);
                    $("#estatus").val(response.data[0].status);
                    $("#telefono").val(response.data[0].telefono);
                    $("#celular").val(response.data[0].tel_celular);

                    $("#tel_empresa").val(response.data[0].tel_empresa);
                    $("#nombre").val(response.data[0].nombre);
                    $("#apellidos").val(response.data[0].apellidos);

//                    $("#genero").val(response.data[0].genero);
                    $("#genero option:contains('" + response.data[0].genero + "')").attr("selected", true);

                    $("#correo").val(response.data[0].correo);

                    $("#estados").val(response.data[0].id_estado);
                    $("#cp").val(response.data[0].valor);
                    $("#id_cp").val(response.data[0].id_cp);

                    $("#calle").val(response.data[0].calle);
                    $("#numero").val(response.data[0].numero);
                    $("#nombre_contacto").val(response.data[0].nombre_contacto);
                    $("#tel_contacto").val(response.data[0].tel_contacto);
                    $("#alergias").val(response.data[0].alergias);
                    $("#tipo_sangre").val(response.data[0].tipo_sangre);

                    $("#foto").val(response.data[0].foto);
                    $("#lat").val(response.data[0].lat);
                    $("#lon").val(response.data[0].lon);
                    $("#id_perfil_usuario").val(response.data[0].id_perfil);
                    $("#id_colonia").val(response.data[0].id_colonia);

                    $("#foto").val(response.data[0].foto);
                    $("#fotoUsr").prop("src", response.data[0].foto);

                    $("#no_control").val(response.data[0].no_control);
                    $("#id_proyecto").val(response.data[0].id_proyecto);
                    $("#fecha_ingreso").val(response.data[0].fecha_ingreso);
                    $("#fecha_nacimiento").val(response.data[0].fecha_nacimiento);
                    $("#rfc").val(response.data[0].rfc);
                    $("#curp").val(response.data[0].curp);

                    $("#estatusUsr").val(response.data[0].status);

                    getCitiesByState(response.data[0].id_estado);
                    getColsByCity(response.data[0].id_ciudad);

                    setTimeout(function () {
                        $("#ciudades").val(response.data[0].id_ciudad);
                        $("#colonias").val(response.data[0].id_colonia);
                    }, 2500);
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function enviarNotificacion(id_usuario, valor) {

    if (valor === 0) {
        $.post(extSystem.urlController + "alertsController.php",
                {evento: 1, id_usuario: id_usuario, referencia: 'in'},
                function (response) {
                    console.log("Response: ", response);
                    if (response.errorCode === 0) {
//                    showAlert(response.msg, "Usuario actualizado", "success", "bounce");                    
//                    setTimeout(function () {
//                        location.reload();
//                    }, 1000);
                    } else {
                        showAlert("¡Error!", response.msg, "error", "swing");
                    }
                }, 'json');
    } else {
        console.log("No notifico nada..");
    }


}