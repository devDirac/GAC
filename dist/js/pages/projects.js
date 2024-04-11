/* 
 * projects.js
 * @author FIGG - DIRAC
 * @description Archivo que contiene funciones de utilidad.
 */
$(document).ready(function () {
//
    getActiveProjectsSB("proyectos_sgi", "estatus = 1");

    $("#projectForm").submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: '../controller/catController.php',
            data: $("#projectForm").serializeArray(),
            dataType: 'json',
            beforeSend: function () {
                console.log("Replace project....");
            },
            success: function (response) {
                if (response.errorCode === 0) {
                    showAlert(response.msg, "Informaci&oacute;n actualizada correctamente", "success", "bounce");
                    setTimeout(function () {
                        window.location.href = 'projects.php';
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

function getProjects(table) {
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
                console.log(response);
                var requests = "";
                $.each(response.data, function (index, value) {
                    requests += '<tr>'
                            + '<td>' + value.id + '</td>'
                            + '<td>' + value.clave + '</td>'
                            + '<td>' + value.nombre + '</td>'
                            + '<td>' + value.descripcion + '</td>';
                    if (parseInt(value.estatus) === 1) {
                        requests += '<td class="text-success"><b>Activo<b></td>';
                    } else {
                        requests += '<td class="text-danger"><b>Inactivo<b></td>';
                    }
                    requests += '<td>'
                            + '<form name="newProjectForm" id="newProjectForm" method="POST" action="new_project.php" data-toggle="tooltip" title="Editar proyecto">'
                            + '<input type="hidden" name="id" value="' + value.id + '" />'
                            + '<button type="submit" class="btn btn-primary btn-flat"><li class="fa fa-pencil"></li></button>'
                            + '</form>'
                            + '<a href="#" class="btn btn-primary btn-flat"><li class="fa fa-folder-open" data-toggle="tooltip" title="Crear carpeta de proyecto" onclick="createFolder(' + value.id + ',\'' + value.clave + '\');"></li></a></td>';
                });
                $("#dirac_projects").append(requests);
                $("#projects").dataTable({
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
                console.log(response);
            }
        },
        error: function (a, b, c) {
            console.log(a, b, c);
        }
    });
}

function getProject(id, table) {
    $.post("../controller/catController.php",
            {id: id, table: table, evento: 3},
            function (response) {
                if (response.errorCode === 0) {
                    $("#clave").val(response.data.clave);
                    $("#nombre").val(response.data.nombre);
                    $("#descripcion").val(response.data.descripcion);
                    $("#estatus").val(response.data.estatus);

                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function createFolder(id, clave) {
    $.post("../controller/pmController.php",
            {id: id, clave: clave, evento: 1},
            function (response) {
                if (response.errorCode === 0) {
                    showAlert(response.msg, "Carpeta creada exitosamente.", "success", "bounce");
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getActiveProjectsSB(table, query) {
    $.ajax({
        type: "POST",
        url: '../controller/catController.php',
        data: {table: table, query: query, evento: 1},
        dataType: 'json',
        beforeSend: function () {
            console.log("Get projects.....");
        },
        success: function (response) {
            if (response.errorCode === 0) {
                console.log(response);
                var requests = "";
                $.each(response.data, function (index, value) {
                    requests += '<li><a href="http://arjion.com/finder/index.html?carpeta=proyectos/' + value.clave + '" target="_blank" data-toggle="tooltip" title="'+value.nombre+'"><i class="fa fa-circle-o"></i>'+value.nombre+'</a></li>';
                });
                $("#projectFolders").html(requests);
            } else {
                console.log(response);
            }
        },
        error: function (a, b, c) {
            console.log(a, b, c);
        }
    });
}