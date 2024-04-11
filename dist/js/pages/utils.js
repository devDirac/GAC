/* 
 * utils.js
 * @author FIGG - DIRAC
 * @description Archivo que contiene funciones de utilidad.
 */
$(document).ready(function () {
    //getRecentActivity();
});


function getCat(table) {
    console.log("Obteniendo catalogo de: " + table);
    $.ajax({
        type: "POST",
        url: '../controller/catController.php',
        data: {table: table, evento: 1},
        dataType: 'json',
        beforeSend: function () {
            console.log("Get cat.....");
        },
        success: function (response) {
            if (response.errorCode === 0) {
                $.each(response.data, function (index, value) {
                    ($("#idAreaS").val() === value.id) ? $("#areaUsr").append('<option value="' + value.id + '" selected="true">' + value.clave + " - " + value.nombre + '</option>') : $("#areaUsr").append('<option value="' + value.id + '">' + value.clave + " - " + value.nombre + '</option>');
                });
            } else {
                console.log(response);
            }
        },
        error: function (a, b, c) {
            console.log(a, b, c);
        }
    });
}

function getDocType(table) {
    console.log("Obteniendo catalogo de: " + table);
    $.ajax({
        type: "POST",
        url: '../controller/catController.php',
        data: {table: table, evento: 1},
        dataType: 'json',
        beforeSend: function () {
            console.log("Get cat.....");
        },
        success: function (response) {
            if (response.errorCode === 0) {
                $.each(response.data, function (index, value) {
                    $("#tipo_documento").append('<option value="' + value.id + '">' + value.clave + " - " + value.nombre + '</option>');
                });
            } else {
                console.log(response);
            }
        },
        error: function (a, b, c) {
            console.log(a, b, c);
        }
    });
}

function getAreasD(table) {
    console.log("Obteniendo catalogo de: " + table);
    $.ajax({
        type: "POST",
        url: '../controller/catController.php',
        data: {table: table, evento: 1},
        dataType: 'json',
        beforeSend: function () {
            console.log("Get projects.....");
        },
        success: function (response) {
            if (response.errorCode === 0) {
                $.each(response.data, function (index, value) {
                    $("#id_area").append('<option value="' + value.clave + '">' + value.clave + " - " + value.nombre + '</option>');
                });
            } else {
                console.log(response);
            }
        },
        error: function (a, b, c) {
            console.log(a, b, c);
        }
    });
}

function getAreasDB(table) {
    console.log("Obteniendo catalogo de: " + table);
    $.ajax({
        type: "POST",
        url: '../controller/catController.php',
        data: {table: table, evento: 1},
        dataType: 'json',
        beforeSend: function () {
            console.log("Get projects.....");
        },
        success: function (response) {
            if (response.errorCode === 0) {
                $.each(response.data, function (index, value) {
                    $("#id_area").append('<option value="' + value.id + '">' + value.clave + " - " + value.nombre + '</option>');
                });
            } else {
                console.log(response);
            }
        },
        error: function (a, b, c) {
            console.log(a, b, c);
        }
    });
}

function getProjectsD(table) {
    console.log("Obteniendo catalogo de: " + table);
    $.ajax({
        type: "POST",
        url: '../controller/catController.php',
        data: {table: table, evento: 1},
        dataType: 'json',
        beforeSend: function () {
            console.log("Get projects.....");
        },
        success: function (response) {
            if (response.errorCode === 0) {
                $.each(response.data, function (index, value) {
                    $("#id_proyecto").append('<option value="' + value.id + '">' + value.clave + " - " + value.nombre + '</option>');
                });

            } else {
                console.log(response);
            }
        },
        error: function (a, b, c) {
            console.log(a, b, c);
        }
    });
}

function getEscolaridad(table) {
    console.log("Obteniendo catalogo de: " + table);
    $.ajax({
        type: "POST",
        url: extSystem.urlController + 'catController.php',
        data: {table: table, evento: 1},
        dataType: 'json',
        beforeSend: function () {
//            console.log("Get cargos.....");
        },
        success: function (response) {
            console.log("Escolaridad: ", response);
            if (response.errorCode === 0) {
                $.each(response.data, function (index, value) {
                    $("#id_escolaridad").append('<option value="' + value.id + '">' + value.clave + " - " + value.nombre + '</option>');
                });

            } else {
                console.log(response);
            }
        },
        error: function (a, b, c) {
            console.log(a, b, c);
        }
    });
}

function getTiposArchivosUsr(table) {
    console.log("Obteniendo catalogo de: " + table);
    $.ajax({
        type: "POST",
        url: extSystem.urlController + 'catController.php',
        data: {table: table, evento: 1},
        dataType: 'json',
        beforeSend: function () {
//            console.log("Get cargos.....");
        },
        success: function (response) {
            console.log("T/Archivos: ", response);
            if (response.errorCode === 0) {
                $.each(response.data, function (index, value) {
                    $("#id_tipo_documento").append('<option value="' + value.id + '">' + value.nombre + '</option>');
                });

            } else {
                console.log(response);
            }
        },
        error: function (a, b, c) {
            console.log(a, b, c);
        }
    });
}

function showAlert(title, text, type, animation) {
    console.log(title + " - " + text + " - " + type + " - " + animation);
    swal({
        title: '<p class="sweet-figg-title">' + title + '</p>',
        type: type,
        html: '<p class="sweet-figg-text">' + text + '</p>',
        timer: 2500,
        animation: false,
        customClass: 'animated ' + animation
    }).catch(swal.noop);


}

function getRecentActivity() {
    $.post("../controller/usrController.php",
            {evento: 6},
            function (response) {
                var items = "";
                if (response.errorCode === 0) {
//                    console.log("Response", response.data);
                    $.each(response.data, function (index, value) {
                        items += '<li>'
                                + '<a href="javascript::;">';
                        switch (parseInt(value.id_evento)) {
                            case 1:
                                items += '<i class="menu-icon fa fa-sign-in bg-green"></i>';
                                break;
                            case 2:
                                items += '<i class="menu-icon fa fa-sign-out bg-red"></i>';
                                break;
                            case 3:
                                items += '<i class="menu-icon fa fa-info bg-blue"></i>';
                                break;
                            case 4:
                                items += '<i class="menu-icon fa fa-key bg-yellow"></i>';
                                break;
                            case 5:
                                items += '<i class="menu-icon fa fa-folder-open-o bg-fuchsia"></i>';
                                break;
                            default:
                                items += '<i class="menu-icon fa fa-circle-o bg-aqua"></i>';
                                break;
                        }
                        items += '<div class="menu-info">'
                                + '<h4 class="control-sidebar-subheading">' + value.nombre + '</h4>'
                                + '<p>' + value.fecha + ' ' + value.hora + '</p>'
                                + '</div>'
                                + '</a>'
                                + '</li>';
                    });
//                    console.log("ITEMS", items);
                    $("#recentActivity").html(items);
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');

    if (isMobile()) {
        $("#solicitudesSGI").hide();
    }
}

function getParameterByName(name, url) {
    if (!url) {
        url = window.location.href;
    }
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
    if (!results)
        return null;
    if (!results[2])
        return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

$("#q").keyup(function () {
    event.preventDefault();
    $("#tableSearch").dataTable.ext.errMode = 'none';
    $("#tableSearch").dataTable().fnDestroy();
    if ($("#q").val().length >= 1) {
        $("#filesFound").html("");
        $.post("../controller/fileSGIController.php",
                {evento: 1, word: $("#q").val()},
                function (response) {
                    if (response.errorCode === 0) {
                        var filesFound = '';
                        $.each(response.data, function (index, value) {
                            var url = encodeURI($("#systemPath").val() + value.path.substring(3) + value.nombre);
//                            console.log(url);
                            filesFound += '<tr>'
                                    + '<td>' + value.id + '</td>'
                                    + '<td>' + value.clave + '</td>'
                                    + '<td>' + value.nombre + '</td>'
                                    + '<td>' + value.descripcion + '</td>'
                                    + '<td><a href="' + url + '" target="_blank" onclick="saveAction(' + value.id + ', 0);"><i class="fa fa-cloud-download"></i></a></td>'
                                    + '</tr>';
                        });
                        $("#divTableSearch").fadeIn(1000);
                        $("#filesFound").append(filesFound);
//                        console.log(response);
                        $("#tableSearch").dataTable({
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
    } else {
        $("#filesFound").html("");
        $("#divTableSearch").fadeOut(1000);
    }
});

function saveActionS(id, action) {
    $.post("../controller/fileUsrController.php",
            {evento: 1, id_archivo: id, action: action},
            function (response) {
                if (response.errorCode === 0) {
                    console.log(response);
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getProfile() {
    $.ajax({
        type: "POST",
        url: '../controller/catController.php',
        data: {evento: 4, table: ""},
        dataType: 'json',
        beforeSend: function () {
            console.log("Get projects.....");
        },
        success: function (response) {
            if (response.errorCode === 0) {
                $.each(response.data, function (index, value) {

                    if (parseInt(value.id_perfil_sgi) == 5) {
                        $("#perfilUsr").append('<option value="' + value.id_perfil_sgi + '" selected="true">' + value.nombre + '</option>');
                    } else {
                        $("#perfilUsr").append('<option value="' + value.id_perfil_sgi + '">' + value.nombre + '</option>');
                    }
                });


            } else {
                console.log(response);
            }
        },
        error: function (a, b, c) {
            console.log(a, b, c);
        }
    });
}

function getUsrsList() {
    console.log("Obteniendo catalogo de usuarios");
    $.ajax({
        type: "POST",
        url: '../../../sgi-dirac/controller/usrController.php',
        data: {evento: 7},
        dataType: 'json',
        beforeSend: function () {
            console.log("Get Users.....");
        },
        success: function (response) {
            if (response.errorCode === 0) {
                $.each(response.data, function (index, value) {
                    $("#usuarios").append('<option value="' + value.id_usuario + '">' + value.usuario + " - " + value.nombre + '</option>');
                });

            } else {
                console.log(response);
            }
        },
        error: function (a, b, c) {
            console.log(a, b, c);
        }
    });
}


function isMobile() {
    var userAgent = navigator.userAgent.toLowerCase();
    var device = /android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(userAgent);

//    if (device) {
//        showAlert("¡Error!", "device", "error", "swing");
//    } else {
//        showAlert("¡Error!", "ordenador", "success", "swing");
//    }
    return device;
}




function getPuestos(table) {
    console.log("Obteniendo catalogo de: " + table);
    $.ajax({
        type: "POST",
        url: '../controller/catController.php',
        data: {table: table, evento: 1},
        dataType: 'json',
        beforeSend: function () {
            console.log("Get Puestos.....");
        },
        success: function (response) {
            if (response.errorCode === 0) {
                $.each(response.data, function (index, value) {
                    $("#id_puesto").append('<option value="' + value.id + '">' + value.clave + " - " + value.nombre + '</option>');
                });
            } else {
                console.log(response);
            }
        },
        error: function (a, b, c) {
            console.log(a, b, c);
        }
    });
}

function getCargos(table) {
    console.log("Obteniendo catalogo de: " + table);
    $.ajax({
        type: "POST",
        url: extSystem.urlController + 'catController.php',
        data: {table: table, evento: 1},
        dataType: 'json',
        beforeSend: function () {
            console.log("Get cargos.....");
        },
        success: function (response) {
            if (response.errorCode === 0) {
                $.each(response.data, function (index, value) {
                    $("#id_cargo").append('<option value="' + value.id + '">' + value.clave + " - " + value.nombre + '</option>');
                });

            } else {
                console.log(response);
            }
        },
        error: function (a, b, c) {
            console.log(a, b, c);
        }
    });
}

function getProyectos(table) {
    console.log("Obteniendo catalogo de: " + table);
    $.ajax({
        type: "POST",
        url: '../controller/catController.php',
        data: {table: table, evento: 1},
        dataType: 'json',
        beforeSend: function () {
            console.log("Get cargos.....");
        },
        success: function (response) {
            if (response.errorCode === 0) {
                $.each(response.data, function (index, value) {
                    $("#id_proyecto").append('<option value="' + value.id + '">' + value.clave + " - " + value.nombre + '</option>');
                });

            } else {
                console.log(response);
            }
        },
        error: function (a, b, c) {
            console.log(a, b, c);
        }
    });
}


function getStatesByCountry(country) {
    $.post(extSystem.urlController + "addressController.php",
            {evento: 1, country: country},
            function (response) {
                if (response.errorCode === 0) {
                    var states = '';
                    $.each(response.data, function (index, value) {
                        states += '<option value="' + value.id_estado + '">' + value.nombre_estado + '</option>';
                    });
                    $("#estados").append(states);
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getCitiesByState(state) {
    $.post(extSystem.urlController + "addressController.php",
            {evento: 2, state: state},
            function (response) {
                if (response.errorCode === 0) {
                    $("#ciudades").html('<option value="">Seleccione ciudad</option>');
                    var cities = '';
                    $.each(response.data, function (index, value) {
                        cities += '<option value="' + value.id_ciudad + '">' + value.nombre_ciudad + '</option>';
                    });
                    $("#ciudades").append(cities);
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getColsByCity(city) {
    $.post(extSystem.urlController + "addressController.php",
            {evento: 3, city: city},
            function (response) {
                if (response.errorCode === 0) {
                    $("#colonias").html('<option value="">Seleccione colonia</option>');
                    var colonies = '';
                    $.each(response.data, function (index, value) {
                        colonies += '<option value="' + value.id_colonia + '">' + value.nombre_colonia + '</option>';
                    });
                    $("#colonias").append(colonies);
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getZCByColony(colony) {
    console.log("Colonia: ", colony);
    $.post(extSystem.urlController + "addressController.php",
            {evento: 4, colony: colony},
            function (response) {
                console.log(response.data);
                if (response.errorCode === 0) {
                    console.log(response.data[0].valor);
                    $("#cp").val(response.data[0].valor);
                    $("#id_cp").val(response.data[0].id_cp);
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getAllInfoAddressByZC(zp) {

    if (zp.length === 5) {
        $.post(extSystem.urlController + "addressController.php",
                {evento: 5, zp: zp},
                function (response) {
                    console.log(response.data);
                    if (response.errorCode === 0) {

                    } else {
                        showAlert("¡Error!", response.msg, "error", "swing");
                    }
                }, 'json');
    } else {
        console.log("Faltan numero para CP.");
    }


}

function getAllLocation(colony) {
    $.post(extSystem.urlController + "addressController.php",
            {evento: 6, colony: colony},
            function (response) {
                console.log("ALLLOCATION", response.data);
                if (response.errorCode === 0) {
                    $("#estados").val(response.data[0].id_estado);

                    getCitiesByState(response.data[0].id_estado);
                    getColsByCity(response.data[0].id_ciudad);

                    setTimeout(function () {
                        console.log(response.data[0].id_colonia);
                        $("#ciudades").val(response.data[0].id_ciudad);
                        getZCByColony(response.data[0].id_colonia);
                        setTimeout(function () {
                            $("#colonias").val(response.data[0].id_colonia);
                        }, 1500);

                    }, 1500);

                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getAreasDirecciones() {
    console.log("Obteniendo catalogo de: ");
    $("#area_direccion").html("");
    $.ajax({
        type: "POST",
        url: extSystem.urlController + 'catAreaDireccionController.php',
        data: {evento: 4},
        dataType: 'json',
        beforeSend: function () {
            console.log("Get areas direcciones.....");
        },
        success: function (response) {
            if (response.errorCode === 0) {
                var options = "";
                $.each(response.data, function (index, value) {
                    options += '<option value="' + value.id + '">' + value.nombre + '</option>';
                });
                $("#area_direccion").append(options);
            } else {
                console.log(response);
            }
        },
        error: function (a, b, c) {
            console.log(a, b, c);
        }
    });
}

function deleteRC(table, id) {
    $.post("../controller/catController.php",
            {evento: 5, table: table, id: id},
            function (response) {
                if (response.errorCode === 0) {
                    setTimeout(function () {
                        showAlert(response.msg, "Informaci&oacute;n actualizada correctamente", "success", "bounce");
                        switch (table) {
                            case 'cat_escolaridad':
                                getCareers("cat_escolaridad");
                                break;
                            case 'cat_archivos_usuarios':
                                getTypeDocs("cat_archivos_usuarios");
                                break;
                            case 'cat_perfil_dirac':
                                getPuestos("cat_perfil_dirac");
                                break;
                            case 'cat_areas':
                                getAreas("cat_areas");
                                break;
                            default:
                                getAreasDirecciones();
                                break;
                        }
                    }, 1500);
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getUserByDirection(id_direccion) {
    $.ajax({
        type: "POST",
        url: extSystem.urlController + 'usrController.php',
        data: {evento: 20, id_direccion: id_direccion},
        dataType: 'json',
        beforeSend: function () {
            console.log("Get usrs by area.....");
            $("#jefe_inmediato").html("");
        },
        success: function (response) {
            if (response.errorCode === 0) {
                $("#jefe_inmediato").append('<option value="2">Mario Luis Salazar Lazcano</option>');
                $.each(response.data, function (index, value) {
                    $("#jefe_inmediato").append('<option value="' + value.id_usuario + '">' + value.nombre + ' ' + value.apellidos + '</option>');
                });
            } else {
                console.log(response);
            }
        },
        error: function (a, b, c) {
            console.log(a, b, c);
        }
    });
}




