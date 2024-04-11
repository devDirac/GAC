/* 
 * admin_surveys.js
 * @author FIGG - DIRAC
 * @description Archivo que contiene funciones de utilidad.
 */
$(document).ready(function () {
    $("#updateStatus").submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: '../controller/catEncuestaController.php',
            data: $("#updateStatus").serializeArray(),
            dataType: 'json',
            beforeSend: function () {
                console.log("Update Status encuestas....");
            },
            success: function (response) {
                if (response.errorCode === 0) {
                    showAlert(response.msg, "Informaci&oacute;n actualizada correctamente", "success", "bounce");
                    setTimeout(function () {
                        location.reload();
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

function getEncuestas() {
    console.log("Obteniendo catalogo de encuestas");
    $.ajax({
        type: "POST",
        url: '../controller/catEncuestaController.php',
        data: {evento: 1},
        dataType: 'json',
        beforeSend: function () {
            console.log("Obteniendo encuestas.....");
        },
        success: function (response) {
            if (response.errorCode === 0) {
                var requests = "";
                $.each(response.data, function (index, value) {
                    requests += '<tr>'
                            + '<td>' + value.id + '</td>'
                            + '<td>' + value.clave + '</td>'
                            + '<td>' + value.nombre + '</td>'
                            + '<td>' + value.descripcion + '</td>';
                    if (parseInt(value.estatus) === 1) {
                        requests += '<td class="text-green">Activo</td>';
                    } else {
                        requests += '<td class="text-red">Inactivo</td>';
                    }
                    requests += '<td>'+value.path+'</td>';
                    requests += '<td class="text-center">'
                            + '<form name="updateStatus' + value.id + '" id="updateStatus' + value.id + '" >'
                            + '<input type="hidden" name="id" value="' + value.id + '" />'
                            + '<input type="hidden" name="estatus" value="' + value.estatus + '" />'
                            + '<input type="hidden" name="evento" id="evento" value="2" />'
                            + '<button type="button" class="btn btn-primary btn-flat" onClick="updateStatus(' + value.id + ')"><li class="fa fa-pencil"></li></button>'
                            + '</form></td>';
                });
                $("#dirac_encuestas").append(requests);
                $("#encuestas").dataTable({
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

function getArea(id, table) {
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

function updateStatus(idForm) {
//    alert("updateStatus: " + idForm);
//    console.log($("#updateStatus" + idForm + "").serializeArray());
    $.ajax({
        type: "POST",
        url: '../controller/catEncuestaController.php',
        data: $("#updateStatus" + idForm + "").serializeArray(),
        dataType: 'json',
        beforeSend: function () {
            console.log("Update Status encuestas....");
        },
        success: function (response) {
            if (response.errorCode === 0) {
                showAlert(response.msg, "Informaci&oacute;n actualizada correctamente", "success", "bounce");
                setTimeout(function () {
                    location.reload();
                }, 1500);
            } else {
                showAlert("¡Error!", response.msg, "error", "swing");
            }
        },
        error: function (a, b, c) {
            console.log(a, b, c);
        }
    });

}