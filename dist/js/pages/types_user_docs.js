/* 
 * areas.js
 * @author FIGG - DIRAC
 * @description Archivo que contiene funciones de utilidad.
 */
$(document).ready(function () {
//
    $("#typesUsrDocsForm").submit(function (event) {       
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: '../controller/catController.php',
            data: $("#typesUsrDocsForm").serializeArray(),
            dataType: 'json',
            beforeSend: function () {
                console.log("Replace typesUsrDocsForm....");
            },
            success: function (response) {
                if (response.errorCode === 0) {
                    showAlert(response.msg, "Informaci&oacute;n actualizada correctamente", "success", "bounce");
                    setTimeout(function(){
                        location.href = 'types_user_docs.php';
                    },1000);
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

function getTypeDocs(table) {
    $("#types_usr_docs").dataTable().fnDestroy();
    $("#dirac_tipos_documentos_usr").html("");
    console.log("Obteniendo catalogo de: " + table);
    $.ajax({
        type: "POST",
        url: '../controller/catController.php',
        data: {table: table, evento: 1},
        dataType: 'json',
        beforeSend: function () {
            console.log("getTypeDocs.....");
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
                        requests += '<td>Activo</td>';
                    } else {
                        requests + '<td>Inactivo</td>';
                    }
                    requests += '<td>'
                            + '<form name="newTypeUsrDocForm" id="newTypeUsrDocForm" method="POST" action="new_type_usr_doc.php">'
                            + '<input type="hidden" name="id" value="' + value.id + '" />'
                            + '<button type="submit" class="btn btn-primary btn-flat"><li class="fa fa-pencil"></li></button>'
                            + '</form>'
                            + '<button data-toggle="tooltip" title="Eliminar" class="btn btn-primary btn-flat" onClick="deleteRC(\'cat_archivos_usuarios\', ' + value.id + ')"><li class="fa fa-minus-circle text-danger"></li></button></td>';
                });
                $("#dirac_tipos_documentos_usr").append(requests);
                $("#types_usr_docs").dataTable({
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
                console.log(response);
            }
        },
        error: function (a, b, c) {
            console.log(a, b, c);
        }
    });
}

function getTypeuUsrDoc(id, table) {
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