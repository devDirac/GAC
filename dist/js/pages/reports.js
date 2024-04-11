/* 
 * requests_sgi.js
 * @author FIGG - DIRAC
 * @description Archivo que contiene las funciones necesarias para realizar login SGI.
 */
$(document).ready(function () {
    $("#dataSearch").submit(function (event) {
        event.preventDefault();
        $("#data_search").dataTable().fnDestroy();
        $("#body_data_search").html("");
//        $("#data_search").destroy();
        getDataSearch();
        return false;
    });
});


function getDataSearch() {
    console.log("DATA SEARCH");
    $.post("../controller/fileSGIController.php",
            $("#dataSearch").serializeArray(),
            function (response) {
                console.log(response.data);
                if (response.errorCode === 0) {
                    var dataSearch = "";
                    $.each(response.data, function (index, value) {
                        dataSearch += '<tr>'
                                + '<td>' + value.id + '</td>'
                                + '<td>' + value.nombre + '</td>'
                                + '<td>' + value.titulo + '</td>'
                                + '<td>' + value.fecha + '</td>'
                                + '<td>' + value.accion + '</td>'
                                + '<td>' + value.usuario + '</td>'
                                + '<td>' + value.nombre_area + '</td>'
                                + '<td>' + value.nombre_proyecto + '</td>'
                                + '<td>' + value.nombre_documento + '</td>'
                                + '<td>' + value.nombre_estatus + '</td>'
                                + '</tr>';
                    });
                    $("#body_data_search").append(dataSearch);
                    $("#data_search").dataTable({
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