/* 
 * utils.js
 * @author FIGG - DIRAC
 * @description Archivo que contiene funciones de utilidad.
 */
$(document).ready(function () {
    $("#authForm").submit(function (event) {
        event.preventDefault();
        $("#authButton").attr("disabled", true);
        var formData = new FormData($('#authForm')[0]);
        $.ajax({
            type: "POST",
            url: '../controller/binController.php',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {
                console.log("Actualizando solicitud");
            },
            success: function (response) {
                if (response.errorCode === 0) {
                    showAlert(response.msg, "Solicitud actualizada", "success", "bounce");
                    //Redireccionamos
                    setTimeout(function () {
                        window.location.href = "requests_to_review.php";
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
                    showAlert(response.msg, "Solicitud actualizada", "success", "bounce");
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
function getAreaByRequest() {
    console.log("Obteniendo estructura de areas para navegación de archivos");
    $.ajax({
        type: "POST",
        url: '../controller/slcController.php',
        data: {evento: 5},
        dataType: 'json',
        beforeSend: function () {
            console.log("Get areas navigation");
        },
        success: function (response) {
            if (response.errorCode === 0) {
                var areas = '';
                $.each(response.data, function (index, value) {
                    areas += '<div class="row">'
                            + '<div class="col-lg-12">'
//                            + '<img src="../dist/img/png_32/Folder.png" width="16" height="16" />&nbsp;&nbsp;<a href="#" onClick="getProjByArea(\'' + value.id_area + '\')">' + value.clave + ' - ' + value.nombre + '</a><br />'
                            + '<img src="../dist/img/png_32/Folder.png" width="16" height="16" />&nbsp;&nbsp;<a href="#" onClick="getTypeDocsByArea(\'' + value.id_area + '\')">' + value.clave + ' - ' + value.nombre + '</a><br />'
                            + '<div id="area' + value.id_area + '" class="col-lg-offset-.5 col-lg-12" style="display:none"></div>'
                            + '</div>'
                            + '</div>';
                });
                $("#areas").append(areas);
            } else {
                console.log(response);
            }
        },
        error: function (a, b, c) {
            console.log(a, b, c);
        }
    });
}

function getProjByArea(area) {
    console.log("Obteniendo estructura de proyectos para navegación de archivos");
    $("#area" + area + "").html("");
    $.ajax({
        type: "POST",
        url: '../controller/slcController.php',
        data: {evento: 6, area: area},
        dataType: 'json',
        beforeSend: function () {
            console.log("Get projects navigation");
        },
        success: function (response) {
            if (response.errorCode === 0) {
                console.log(response);
                var projects = '';
                $.each(response.data, function (index, value) {
                    projects += '<div class="row">'
                            + '<div class="col-lg-12">'
                            + '<img src="../dist/img/png_32/Folder.png" width="16" height="16" />&nbsp;&nbsp;<a href="#" onClick="getDocProjArea(\'' + value.id_area + '\', \'' + value.id_proyecto + '\')">' + value.clave + ' - ' + value.nombre + '</a><br />'
                            + '<div id="project' + value.id_proyecto +area+ '" class="col-lg-offset-.5 col-lg-12" style="display:none"></div>'
                            + '</div>'
                            + '</div>';
                });
                $("#area" + area + "").append(projects);
                $("#area" + area + "").toggle(1000);
            } else {
                console.log(response);
            }
        },
        error: function (a, b, c) {
            console.log(a, b, c);
        }
    });
}

function getTypeDocsByArea(area) {
    console.log("Obteniendo estructura de proyectos para navegación de archivos");
    $("#area" + area + "").html("");
    $.ajax({
        type: "POST",
        url: '../controller/slcController.php',
        data: {evento: 16, area: area},
        dataType: 'json',
        beforeSend: function () {
            console.log("Get projects navigation");
        },
        success: function (response) {
            if (response.errorCode === 0) {
                console.log(response);
                var projects = '';
                $.each(response.data, function (index, value) {
                    projects += '<div class="row">'
                            + '<div class="col-lg-12">'
//                            + '<img src="../dist/img/png_32/Folder.png" width="16" height="16" />&nbsp;&nbsp;<a href="#" onClick="getDocProjArea(\'' + value.id_area + '\', \'' + value.id_proyecto + '\')">' + value.clave + ' - ' + value.nombre + '</a><br />'
                            + '<img src="../dist/img/png_32/Folder.png" width="16" height="16" />&nbsp;&nbsp;<a href="#" onClick="getProjByDoc(\'' + value.id_area + '\', \'' + value.tipo_documento + '\')">' + value.clave + ' - ' + value.nombre + '</a><br />'
                            + '<div id="typeDocs' + value.tipo_documento +area+ '" class="col-lg-offset-.5 col-lg-12" style="display:none"></div>'
                            + '</div>'
                            + '</div>';
                });
                $("#area" + area + "").append(projects);
                $("#area" + area + "").toggle(1000);
            } else {
                console.log(response);
            }
        },
        error: function (a, b, c) {
            console.log(a, b, c);
        }
    });
}

function getDocProjArea(area, proyecto) {
    console.log("Obteniendo estructura para navegación de archivos");
    $("#project" + proyecto +area+ "").html("");
    $.ajax({
        type: "POST",
        url: '../controller/slcController.php',
        data: {evento: 7, area: area, proyecto: proyecto},
        dataType: 'json',
        beforeSend: function () {
            console.log("Get type documents navigation");
        },
        success: function (response) {
            if (response.errorCode === 0) {
                console.log(response);
                var docType = '';
                $.each(response.data, function (index, value) {
                    docType += '<div class="row">'
                            + '<div class="col-lg-12">'
                            + '<img src="../dist/img/png_32/Folder.png" width="16" height="16" />&nbsp;&nbsp;<a href="#" onClick="getDocs(\'' + value.id_area + '\', \'' + value.id_proyecto + '\', \'' + value.tipo_documento + '\')">' + value.clave + ' - ' + value.nombre + '</a><br />'
                            + '<div id="doctype' + value.tipo_documento +area+ '" class="col-lg-offset-.5 col-lg-12" style="display:none"></div>'
                            + '</div>'
                            + '</div>';
                });
                $("#project" + proyecto +area+ "").append(docType);
                $("#project" + proyecto +area+ "").toggle(1000);
            } else {
                console.log(response);
            }
        },
        error: function (a, b, c) {
            console.log(a, b, c);
        }
    });
}

function getProjByDoc(area, documento) {
    console.log("Obteniendo estructura para navegación de archivos");
    $("#typeDocs" + documento +area+ "").html("");
    $.ajax({
        type: "POST",
        url: '../controller/slcController.php',
        data: {evento: 17, area: area, tipo_doc: documento},
        dataType: 'json',
        beforeSend: function () {
            console.log("Get type documents navigation");
        },
        success: function (response) {
            if (response.errorCode === 0) {
                console.log(response);
                var docType = '';
                $.each(response.data, function (index, value) {
                    docType += '<div class="row">'
                            + '<div class="col-lg-12">'
//                            + '<img src="../dist/img/png_32/Folder.png" width="16" height="16" />&nbsp;&nbsp;<a href="#" onClick="getDocs(\'' + value.id_area + '\', \'' + value.id_proyecto + '\', \'' + value.tipo_documento + '\')">' + value.clave + ' - ' + value.nombre + '</a><br />'
                            + '<img src="../dist/img/png_32/Folder.png" width="16" height="16" />&nbsp;&nbsp;<a href="#" onClick="getDocs(\'' + value.id_area + '\', \'' + value.id_proyecto + '\', \'' + value.tipo_documento + '\')">' + value.clave + ' - ' + value.nombre + '</a><br />'
                            + '<div id="doctype' + value.id_proyecto +area+ documento +'" class="col-lg-offset-.5 col-lg-12" style="display:none"></div>'
                            + '</div>'
                            + '</div>';
                });
                $("#typeDocs" + documento +area+ "").append(docType);
                $("#typeDocs" + documento +area+ "").toggle(1000);
            } else {
                console.log(response);
            }
        },
        error: function (a, b, c) {
            console.log(a, b, c);
        }
    });
}

function getDocs(area, proyecto, documento) {
    console.log("Obteniendo estructura para navegación de archivos");
    $("#doctype" + proyecto +area+documento+ "").html("");
    $.ajax({
        type: "POST",
        url: '../controller/slcController.php',
        data: {evento: 8, area: area, proyecto: proyecto, documento: documento},
        dataType: 'json',
        beforeSend: function () {
            console.log("Getdocuments navigation");
        },
        success: function (response) {
            if (response.errorCode === 0) {
                console.log(response);
                var docs = '';
                $.each(response.data, function (index, value) {
                    console.log("Id Solicitud - ", value.id_solicitud);
                    docs += '<form name="docViewForm" id="docViewForm' + value.id_solicitud + '" method="POST" action="document_view.php">'
                            + '<img src="../dist/img/png_32/Diploma.png" width="16" height="16" />&nbsp;&nbsp;'
                            + '<input type="hidden" name="id_solicitud" value="' + value.id_solicitud + '" />'
                            + '<a href="#" onclick="document.getElementById(\'docViewForm' + value.id_solicitud + '\').submit()">' + value.clave + " " + value.nombre + '</a>'
                            + '</form>';
                });
                $("#doctype" + proyecto +area+ documento+ "").append(docs);
                $("#doctype" + proyecto +area+ documento+ "").toggle(1000);
            } else {
                console.log(response);
            }
        },
        error: function (a, b, c) {
            console.log(a, b, c);
        }
    });
}

function docProperties(idSolicitud) {
    $.post("../controller/slcController.php",
            {evento: 9, id_solicitud: idSolicitud},
            function (response) {
                if (response.errorCode === 0) {
                    var theadProps = '';
                    theadProps += '<tr>'
                            + '<th id="thClaveDoc">' + response.data[0].clave + '</th>'
                            + '<th></th>'
                            + '<th></th>'
                            + '</tr>';

                    $("#theadProps").append(theadProps);
                    var tbodyProps = '';
                    tbodyProps += '<tr>'
                            + '<td>Nombre</td>'
                            + '<td></td>'
                            + '<td>' + response.data[0].nombre_archivo + '</td>'
                            + '</tr>'
                            + '<tr>'
                            + '<td>&Aacute;rea</td>'
                            + '<td></td>'
                            + '<td>' + response.data[0].nombre_area + '</td>'
                            + '</tr>'
                            + '<tr>'
                            + '<td>Proyecto</td>'
                            + '<td></td>'
                            + '<td>' + response.data[0].nom_proyecto + '</td>'
                            + '</tr>'
                            + '<tr>'
                            + '<td>Tipo</td>'
                            + '<td></td>'
                            + '<td>' + response.data[0].nom_tipo_documento + '</td>'
                            + '</tr>'
                            + '<tr>'
                            + '<td>Descripci&oacute;n</td>'
                            + '<td></td>'
                            + '<td>' + response.data[0].descripcion + '</td>'
                            + '</tr>';

                    $("#propsDoc").append(tbodyProps);
                    /************ Solicitud de cambio ************/
                    $("#documento_base").val(response.data[0].id_archivo);
                    $("#documento_base_nombre").val(response.data[0].nombre_archivo);
                    $("#id_area").val(response.data[0].id_area);
                    $("#tipo_documento").val(response.data[0].tipo_documento);
//                    $("#titulo").val(response.data[0].titulo);
                    $("#id_proyecto").val(response.data[0].id_proyecto);
//                    $("#descripcion").val(response.data[0].descripcion);
                    var url = encodeURI($("#systemPath").val() + response.data[0].path.substring(3) + response.data[0].nombre_archivo);

                    console.log(response.data[0].path.substring(3));
                    console.log(response.data[0].path);
                    $("#downloadDoc").html('<a href="' + url + '" target="_blank" onclick="saveAction(' + response.data[0].id_archivo + ', 0);">' + response.data[0].nombre_archivo + '</a>');

                    if (parseInt(response.process) === 1) {
                        $("#hasProcess").html("<li class='fa fa-warning'></li> (Este documento se encuentra en proceso de cambio.)");
                    }
                    //Mandamas a llamar a control de cambios del archivo
                    //getCtrlC(response.data[0].id_archivo);
                    getBinnacleLog(response.data[0].id_archivo);
                    //Guardamos la accion (consulta)
                    saveAction(response.data[0].id_archivo, 1);
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function docPropertiesAuth(idSolicitud) {
    $.post("../controller/slcController.php",
            {evento: 10, id_solicitud: idSolicitud},
            function (response) {
                if (response.errorCode === 0) {
                    var url = encodeURI($("#systemPath").val() + response.data[0].path.substring(3) + response.data[0].nombre_archivo);
                    var authHead = '';
                    authHead += '<tr>'
                            + '<th>Archivo</th>'
                            + '<th></th>'
                            + '<th><a href="' + url + '" target="_blank"><b>' + response.data[0].nombre_archivo + ' <i class="fa fa-cloud-download"></i></b></a></th>'
                            + '</tr>';

                    $("#authHead").append(authHead);
                    var authBodyProps = '';
                    authBodyProps += '<tr>'
                            + '<td>T&iacute;tulo</td>'
                            + '<td></td>'
                            + '<td>' + response.data[0].titulo + '</td>'
                            + '</tr>'
                            + '<tr>'
                            + '<td>&Aacute;rea</td>'
                            + '<td></td>'
                            + '<td>' + response.data[0].nombre_area + '</td>'
                            + '</tr>'
                            + '<tr>'
                            + '<td>Proyecto</td>'
                            + '<td></td>'
                            + '<td>' + response.data[0].nom_proyecto + '</td>'
                            + '</tr>'
                            + '<tr>'
                            + '<td>Tipo</td>'
                            + '<td></td>'
                            + '<td>' + response.data[0].nom_tipo_documento + '</td>'
                            + '</tr>'
                            + '<tr>'
                            + '<td>Documento base</td>'
                            + '<td></td>'
                            + '<td>' + response.data[0].nom_doc_base + '</td>'
                            + '</tr>';

                    $("#authPropsDoc").append(authBodyProps);
                    $("#estatus_solicitud").val(response.data[0].id_estatus_solicitud);
                    $("#documento_base").val(response.data[0].documento_base);
                    $("#documento_base_nombre").val(response.data[0].nombre_archivo);

//                    $("#r1").val(response.data[0].id_estatus_solicitud);
                    $("#id_archivo").val(response.data[0].id_archivo);
//                    $("#id_solicitud").val(response.data[0].id_solicitud);

                    //Mandamas a llamar bitacora de archivo
                    getBinnacleLog(response.data[0].id_archivo);
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}


function getCtrlC(id) {
    $.post("../controller/ctrlCController.php",
            {evento: 1, id_archivo: id},
            function (response) {
                var ctrlC = '';
                if (response.errorCode === 0) {
                    console.log(response);
                    $.each(response.data, function (index, value) {
                        ctrlC += '<tr>'
                                + '<td>' + value.version + '.' + value.revision + '</td>'
                                + '<td>' + value.fecha + '</td>'
                                + '<td>' + value.nom_editor + '</td>'
                                + '<td>' + value.nom_revisor + '</td>'
                                + '<td>' + value.nom_revisor2 + '</td>'
                                + '<td>' + value.nom_aprobador + '</td>'
                                + '<td>' + value.descripcion_cambio + '</td>'
                                + '</tr>';
                    });
                    $("#ctrlCDoc").append(ctrlC);
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getBinnacleLog(id) {
    $.post("../controller/binController.php",
            {evento: 1, id_archivo: id},
            function (response) {
                var binnFile = '';
                if (response.errorCode === 0) {
                    console.log(response);
                    $.each(response.data, function (index, value) {
                        binnFile += '<tr>'
                                + '<td>' + value.nom_usuario + '</td>'
                                + '<td>' + value.nombre_estatus + '</td>'
                                + '<td>' + value.descripcion + '</td>'
                                + '<td>' + value.fecha + '</td>'
                                + '</tr>';
                    });
                    $("#bitAuthDoc").append(binnFile);
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function saveAction(id, action) {
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

function compareName(archivo) {
    var nombre = $("#file-input").val();
    nombre = nombre.substring(12);
    console.log("Archivo: " + nombre);
    console.log($("#documento_base_nombre").val());
    if($("#documento_base_nombre").val() !== nombre){
        showAlert("¡Error!", "Favor de seleccionar archivo con el mismo nombre", "error", "swing");
    }
    
    return false;


}

