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
                    Solicitudes pendientes de proveedores
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
                            <!--<h3 class="box-title">&Aacute;reas disponibles. </h3>-->
                            <?php
                            $auth = $daf->getParams("direccion = 'DAF' AND parametro = 'correo';");
                            $auth2 = $daf->getParams("direccion = 'DAF' AND parametro = 'copia';");
                            ?>
                            <!--                            <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="col-lg-offset-3 col-lg-6 text-center">
                                                                    <p>
                                                                        Correo autorizador de salidas: 
                                                                        <b class="sweet-figg-title"><?php echo $auth["data"]->valor; ?></b>                                            
                                                                    </p>
                                                                </div>      
                                                                <div class="col-lg-offset-5 col-lg-3 text-center">                                        
                                                                    <a href="#" class="btn btn-warning btn-flat btn-block center-block" data-toggle="modal" data-target="#myModal">Cambiar correo</a>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="col-lg-offset-3 col-lg-6 text-center">
                                                                    <p>
                                                                        Correo autorizador 2 de salidas: 
                                                                        <b class="sweet-figg-title"><?php echo $auth2["data"]->valor; ?></b>                                            
                                                                    </p>
                                                                </div>      
                                                                <div class="col-lg-offset-5 col-lg-3 text-center">                                        
                                                                    <a href="#" class="btn btn-warning btn-block center-block" data-toggle="modal" data-target="#myModal2">Cambiar autorizador 2</a>
                                                                </div>
                                                            </div>
                                                        </div>                            -->
                            <hr />
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <table id="projects" class="table table-bordered dt-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Solicitante</th>
                                        <th>Fecha ingreso</th>
                                        <th>Proveedor</th>
                                        <th>Empresa</th>
                                        <th>Comentarios</th>
                                        <th>Personal de apoyo</th>                                        
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody id="dirac_outputs">
                                    <?php
                                    $requests = $daf->getSuppliers("notificacion = 1 AND estatus = 1 AND fecha_ingreso >= '" . date("Y-m-d") . "'");
                                    foreach ($requests["data"] as $key => $req) {
                                        ?>
                                        <tr>
                                            <td><?php echo $req["id"]; ?></td>
                                            <td>
                                                <?php
                                                $user = $daf->getInfoUsrsView("id_usuario = " . $req["id_usuario"]);
                                                echo $user["data"][0]["nombre"] . " " . $user["data"][0]["apellidos"];
                                                ?>
                                            </td>
                                            <td><?php echo $req["fecha_ingreso"]; ?></td>
                                            <td><?php echo $req["nombre_proveedor"]; ?></td>
                                            <td><?php echo $req["empresa"]; ?></td>
                                            <td><?php echo $req["comentarios"]; ?></td>
                                            <td><?php echo $req["personal_apoyo"]; ?></td>
                                            <td>                                                 
                                                <h4><a href="http://arjion.com/daf/controller/auth_supplier.php?id=<?php echo $req["id"] . "&auth=2"; ?>" title="Autorizar" class="text-success" target="_blank" onclick="refresh();"><i class="fa fa-check-circle-o"></i> Autorizar</a></h4> 
                                                <h4><a href="http://arjion.com/daf/controller/auth_supplier.php?id=<?php echo $req["id"] . "&auth=3"; ?>" title="Rechazar" class="text-danger" target="_blank" onclick="refresh();"><i class="fa fa-times-circle-o"></i> Rechazar</a></h4> 
                                            </td>                                    
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                </tbody>
                            </table>
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
                            <input type="hidden" name="opcion" id="opcion" value="1" />

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
        <div id="myModal2" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <form name="paramsForm2" id="paramsForm2">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Cambiar correo de autorizador 2</h4>
                        </div>
                        <div class="modal-body">
                            <label>Correo: </label>
                            <input type="email" name="valor" id="valor" class="form-control" required="true">

                            <input type="hidden" name="evento" id="evento" value="2" />
                            <input type="hidden" name="opcion" id="opcion" value="4" />

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

                                                    function refresh() {
                                                        setTimeout(function () {
                                                            window.location.reload();
                                                        }, 1500)
                                                    }

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
    </script>
</body>
