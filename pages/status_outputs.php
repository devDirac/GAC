<?php
require_once '../snippets/header.php';
require_once '../model/DAF.php';

$daf = DAF::DAFSngltn();
?>
<body class="bg-simple-textured sidebar-mini">
    <div class="wrapper">    
        <?php
        require_once '../snippets/header_bar.php';
        require_once '../snippets/sidebar.php';
        ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1 class="text-aqua">
                    Estatus de salidas de equipo y material
                    <small></small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Administraci&oacute;n</li>
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="box box-warning">
                        <div class="box-header">
                            <div class="row">
                                <!--<form name="search_records" id="search_records">-->
                                <div class="col-lg-12">
                                    <div class="col-lg-4 form-group">
                                        Fecha inicio
                                        <input class="form-control" name="fecha_inicio" id="fecha_inicio" type="date" value="" />
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        Fecha fin
                                        <input class="form-control" name="fecha_fin" id="fecha_fin" type="date" value="" />
                                    </div>
                                    <div class="col-lg-4 form-group">  
                                        &nbsp;
                                        <button name="enviar" id="enviar" value="Buscar" onclick="search_outs_stat();" class="btn btn-block btn-primary" >Buscar</button>
                                    </div>
                                </div>
                                <!--</form>-->
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <table id="projects" class="table table-bordered dt-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Persona asignada</th>
                                        <th>Solicitante</th>
                                        <th>Descripci&oacute;n</th>
                                        <th>Destino</th>
                                        <th>Fecha</th>
                                        <th>Fecha s&aacute;lida</th>
                                        <th>Fecha regreso</th>
                                        <th>Fecha recepci&oacute;n</th>
                                        <th>Destinatario</th>
                                        <!--<th>Vigencia</th>-->
                                        <!--<th>Documento</th>-->
                                        <!--<th>Comentarios</th>-->
                                        <th>Estatus</th>
                                    </tr>
                                </thead>
                                <tbody id="dirac_outputs">
                                    
                                    
                                </tbody>
                            </table>
                            <input type="hidden"
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                    <!-- /.row (nested) -->
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <?php require_once '../snippets/search.php'; ?>

                    </div>
                </div>
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->  

        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <form name="paramsForm" id="paramsForm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Cambiar correo de autorizador</h4>
                        </div>
                        <div class="modal-body">
                            <label>Correo: </label>
                            <input type="email" name="valor" id="valor" class="form-control" required="true">

                            <input type="hidden" name="evento" id="evento" value="2" />

                        </div>
                        <div class="modal-footer">
                            <input type="submit" name="enviar" id="enviar" value="Actualizar" class="btn btn-info" />
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>

        <!-- Modal -->
        <div id="myModalAuth" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <form name="authOutput" id="authOutput">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title text-aqua" id="title"></h4>
                        </div>
                        <div class="modal-body">
                            <label>Comentarios: </label>
                            <textarea name="comentario" id="comentario" rows="5" class="form-control"></textarea>
                            <input type="hidden" name="evento" id="evento" value="3" />
                            <input type="hidden" name="estatus" id="estatus" value="" />
                            <input type="hidden" name="id" id="id" value="" />

                        </div>
                        <div class="modal-footer">
                            <input type="submit" name="authBtn" id="authBtn" value="Actualizar" class="btn btn-info" />
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                    <div id="msg"></div>
                </form>

            </div>
        </div>

        <?php
        require_once '../snippets/sidebar2.php';
        require_once '../snippets/footer.php';
        require_once '../utils/datatables.php';
        ?>
    </div><!-- ./wrapper -->    
    <script type="text/javascript" src="<?php echo SYSTEM_PATH ?>dist/js/pages/properties.js"></script>
    <script type="text/javascript" src="<?php echo SYSTEM_PATH ?>dist/js/pages/login.js"></script>    
    <script type="text/javascript" src="<?php echo SYSTEM_PATH ?>dist/js/pages/utils.js"></script>
    <script type="text/javascript" src="<?php echo SYSTEM_PATH ?>dist/js/pages/daf.js"></script>
    <script type="text/javascript">
                                            $("#projects").dataTable({
                                                "dom": 'Bfrtip',
//             "order": [[ 0, 'asc' ], [ 1, 'asc' ]]
                                                "order": [5, 'desc'],
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
                                            function openModalAuth(estatus, id) {
                                                $('#myModalAuth').modal('toggle');
                                                $("#authOutput input[name='estatus']").val(estatus);
                                                $("#authOutput input[name='id']").val(id);
                                                if (parseInt(estatus) === 3) {
                                                    $("#title").html("Autorizar s&aacute;lida");
                                                    $("#authBtn").removeClass();
                                                    $("#authBtn").addClass("btn btn-success");
                                                    $("#authBtn").val("Autorizar");
                                                } else {
                                                    $("#title").html("Rechazar s&aacute;lida");
                                                    $("#authBtn").removeClass();
                                                    $("#authBtn").addClass("btn btn-danger");
                                                    $("#authBtn").val("Rechazar");
                                                }

                                            }

                                            function search_outs_stat() {
                                                $("#projects").dataTable().fnDestroy();
                                                $("#dirac_outputs").html("");
                                                var q = "1=1";
                                                $.post("../controller/dafController.php",
                                                        {evento: 13, fecha_inicio: $("#fecha_inicio").val(), fecha_fin: $("#fecha_fin").val()},
                                                function (response) {
                                                    if (response.errorCode === 0) {
                                                        console.log(response.data);
                                                        var records = '';
                                                        $.each(response.data, function (index, value) {
                                                            records += '<tr>';
                                                            records += '<td>' + value.id + '</td>';
                                                            var solicitante = "";
                                                            if (parseInt(value.id_solicitante) === 0) {
                                                                solicitante = value.otro_usuario;
                                                            } else {
                                                                solicitante = value.solicitante;
                                                            }
//                                                                    records += '<td>' + value.solicitante + '</td>';
                                                            records += '<td>' + solicitante + '</td>';
                                                            records += '<td>' + value.nombre + '</td>';
                                                            records += '<td>' + value.descripcion + '</td>';
                                                            records += '<td>' + value.destino + '</td>';
                                                            records += '<td>' + value.fecha_salida + '</td>';
                                                            records += '<td>' + value.hora_salida + '</td>';
                                                            records += '<td>' + value.hora_regreso + '</td>';
                                                            records += '<td>' + value.hora_recepcion + '</td>';
                                                            records += '<td>' + value.destinatario + '</td>';
//                                                                    records += '<td>' + value.vigencia + ' d&iacute;as</td>';
//                                                                    records += '<td><a href="../documentos_salida/' + value.archivo + '" target="_blank">' + value.archivo + '</a></td>';
//                                                                    records += '<td>' + value.hora_salida + '</td>';
//                                                                    records += '<td>' + value.persona_salida_nombre + '</td>';
//                                                                    records += '<td>' + value.comentarios + '</td>';
                                                            var estatus = "El equipo ha salido";
                                                            if (value.hora_regreso === "NULL") {
                                                                estatus += "/ El equipo aún no regresa.";
                                                            } else {
                                                                estatus += "/ El equipo ya ha regresado.";
                                                            }

                                                            if (value.hora_salida === "NULL") {
                                                                estatus += "El equipo nunca salió.";
                                                            }

                                                            if (parseInt(value.vigencia) === 100) {
                                                                estatus += "El equipo tiene vigencia indeterminada.";
                                                            }


                                                            records += '<td>' + estatus + '</td>';
                                                            records += '</tr>';
                                                        });
                                                        $("#dirac_outputs").append(records);
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
                                                        $("#msg").html("Ha ocurrido un error, por favor intente m&aacute;s tarde.");
                                                    }
                                                }, 'json');
                                            }
    </script>
</body>
