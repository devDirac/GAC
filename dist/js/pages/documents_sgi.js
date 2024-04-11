/* 
 * users.js
 * @author FIGG - DIRAC
 * @description Archivo que contiene funciones de utilidad.
 */
$(document).ready(function () {
    $("#updateDocSGI").submit(function (event) {
        event.preventDefault();
        $.post("../controller/fileSGIController.php",
                $("#updateDocSGI").serializeArray(),
                function (response) {
                    console.log(response);
                    if (response.errorCode === 0) {
                        showAlert(response.msg, "Documento actualizado", "success", "bounce");
                        setTimeout(function () {
                            window.location.href = "sgi_documents.php";
                        }, 2500);

                    } else {
                        showAlert("¡Error!", response.msg, "error", "swing");
                    }
                }, 'json');
    });

});

function getDocumentsSGI() {
    $.post("../controller/fileSGIController.php",
            {evento: 4},
            function (response) {
                if (response.errorCode === 0) {
                    var requests = "";
                    $.each(response.data, function (index, value) {
                        requests += '<tr>'
                                + '<td>' + value.id + '</td>'
                                + '<td>' + value.clave + '</td>'
                                + '<td>' + value.nombre + '</td>'
                                + '<td>' + value.descripcion + '</td>';
                        if (parseInt(value.estatus) === 1) {
                            requests += '<td>Publicado</td>';
                        } else {
                            requests + '<td>No publicado</td>';
                        }
                        requests += '<td>'
                                + '<form name="editDocSGI" id="editDocSGI" method="POST" action="edit_doc_sgi.php">'
                                + '<input type="hidden" name="id_archivo" value="' + value.id + '" />'
                                + '<button type="submit" class="btn btn-primary btn-flat"><li class="fa fa-pencil"></li></button>'
                                + '</form></td>';
                    });
                    $("#dirac_documents").append(requests);
                    $("#sgi_documents").dataTable({
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
                            "buttons":{
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

function getInfoDoc(id_archivo) {
    $.post("../controller/fileSGIController.php",
            {evento: 5, id_archivo: id_archivo},
            function (response) {
                if (response.errorCode === 0) {

                    $("#nombre").val(response.data[0].nombre);
                    $("#clave").val(response.data[0].clave);
                    $("#descripcion").val(response.data[0].descripcion);

                    $("#estatusDoc").val(response.data[0].publicado);
                    $("#tipo_documento").val(response.data[0].tipo_documento);
                    $("#id_proyecto").val(response.data[0].id_proyecto);
                    $("#areaUsr").val(response.data[0].id_area);


                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}