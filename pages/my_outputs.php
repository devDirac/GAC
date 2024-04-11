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
                    Mis salidas vigentes de material y equipo
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
                        <!--                        <div class="box-header">
                                                    <h3 class="box-title">&Aacute;reas disponibles. </h3>
                        <?php
//                            $auth = $daf->getParams("direccion = 'DAF' AND parametro = 'correo';");
                        ?>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="col-lg-offset-3 col-lg-6 text-center">
                                                                <p>
                                                                    Correo autorizador de s&aacute;lidas: 
                                                                    <b class="sweet-figg-title"><?php echo $auth["data"]->valor; ?></b>                                            
                                                                </p>
                                                            </div>      
                                                            <div class="col-lg-offset-5 col-lg-2 text-center">                                        
                                                                <a href="<?php echo SYSTEM_PATH . 'pages/new_project.php' ?>" class="btn btn-warning btn-flat center-block">Cambiar correo autorizador</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> /.box-header -->
                        <div class="box-body">
                            <table id="projects" class="table table-bordered dt-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Persona asignada</th>
                                        <th>Solicitante</th>
                                        <th>Descripci&oacute;n</th>
                                        <th>Destino</th>
                                        <th>Fecha s&aacute;lida</th>
                                        <th>Destinatario</th>
                                        <th>Vigencia</th>
                                        <th>Documento</th>
                                        <th>Comentarios</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody id="dirac_outputs">
                                    <?php
                                    $requests = $daf->getOutputs("estatus = 3 AND id_usuario = " . $_SESSION["sgi_id_usr"]);
                                    foreach ($requests["data"] as $key => $req) {
                                        $salida = $req["fecha_salida"];
                                        $valid = strtotime('+5 day', strtotime($salida));
                                        $valid = date('Y-m-d', $valid);

                                        if (strtotime($valid) > strtotime(date("Y-m-d"))) {
                                            ?>
                                            <tr>
                                                <td><?php echo $req["id"]; ?></td>
                                                <td id="requester">
                                                    <?php
                                                    if (intval($req["id_solicitante"]) === 0) {
                                                        echo $req["otro_usuario"];
                                                    } else {
                                                        echo $req["solicitante"];
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo $req["nombre"]; ?></td>
                                                <td><?php echo $req["descripcion"]; ?></td>
                                                <td><?php echo $req["destino"]; ?></td>
                                                <td><?php echo $req["fecha_salida"]; ?></td>
                                                <td><?php echo $req["destinatario"]; ?></td>
                                                <td><?php echo $req["vigencia"]; ?> d&iacute;as</td>
                                                <td><a href="../documentos_salida/<?php echo $req["archivo"]; ?>" target="_blank"><?php echo $req["archivo"]; ?></a></td>
                                                <td><?php echo $req["comentarios"]; ?></td>
                                                <td>
                                                    <h4><b><a href="#" title="Editar solicitante" class="text-primary" onclick="editRequest(<?php echo $req["id"]; ?>);"><i class="fa fa-check-circle-o"></i> Editar asignaci&oacute;n</a></b></h4> 
                                                    <h4><b><a href="#" title="Eliminar solicitud" class="text-warning" onclick="openModalAuth(4, <?php echo $req["id"]; ?>);"><i class="fa fa-times-circle-o"></i> Eliminar solicitud</a></b></h4> 
                                                </td>                                    
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                    <!-- /.row (nested) -->
                </div>
                <!-- Modal -->
                <div id="myModalDrop" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <form name="authOutput" id="authOutput">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title text-aqua" id="title">Eliminar solicitud</h4>
                                </div>
                                <div class="modal-body">
                                    <label>Comentarios: </label>
                                    <textarea name="comentario" id="comentario" rows="5" class="form-control"></textarea>
                                    <input type="hidden" name="evento" id="evento" value="4" />
                                    <input type="hidden" name="estatus" id="estatus" value="4" />
                                    <input type="hidden" name="id" id="id" value="" />

                                </div>
                                <div class="modal-footer">
                                    <input type="submit" name="authBtn" id="authBtn" value="Eliminar" class="btn btn-danger" />
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                            <div id="msg"></div>
                        </form>

                    </div>
                </div>
                <!-- Modal -->
                <div id="myModalEdit" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <form name="editRequester" id="editRequester">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title text-aqua" id="title">Editar asignaci&oacute;n</h4>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">


                                        <div class="modal-body">
                                            <div class="col-lg-9">
                                                <div class="form-group">
                                                    <label for="direccion">Solicita:</label>
                                                    <i class="fa fa-fw fa-question-circle text-warning" data-toggle="tooltip" title="Persona que solicita el equipo" class="mensaje" onclick="return false;"></i>
                                                    <div id="myUsrs">
                                                        <select class="form-control" name="id_usuario" id="id_usuario">
                                                            <?php
                                                            $usuarios = $daf->getInfoUsrsView("id_director_area=" . $_SESSION["sgi_id_usr"] . " AND status = 1 ORDER BY nombre ASC");
//                                                $usuarios = $daf->getInfoUsrsView("status = 1");

                                                            foreach ($usuarios["data"] as $key => $usr) {
                                                                ?>
                                                                <option value="<?php echo $usr["id_usuario"]; ?>"><?php echo $usr["nombre"] . " " . $usr["apellidos"]; ?></option>
                                                                <?php
                                                            }
                                                            ?>

                                                        </select>
                                                    </div>
                                                    <div id="allUsrs" style="display: none;">
                                                        <select class="form-control" name="id_usuario1" id="id_usuario">
                                                            <?php
//                                                $usuarios = $daf->getInfoUsrsView("id_director_area=" . $_SESSION["sgi_id_usr"] . " AND status = 1");
                                                            $usuarios = $daf->getInfoUsrsView("status = 1 ORDER BY nombre ASC");

                                                            foreach ($usuarios["data"] as $key => $usr) {
                                                                ?>
                                                                <option value="<?php echo $usr["id_usuario"]; ?>"><?php echo $usr["nombre"] . " " . $usr["apellidos"]; ?></option>
                                                                <?php
                                                            }
                                                            ?>

                                                        </select>
                                                    </div>
                                                    <div id="otUsrs" style="display: none;">
                                                        <label for="exampleInputPassword1">Nombre usuario:</label>
                                                        <i class="fa fa-fw fa-question-circle text-warning" data-toggle="tooltip" title="Escriba el nombre de la persona que sacar&aacute; el equipo" class="mensaje" onclick="return false;"></i>
                                                        <input type="text" class="form-control" id="othr_usr" name="othr_usr" value="0" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <br />&nbsp;
                                                <a href="#" onclick="showAllUsrs();" class="btn btn-warning" data-toggle="tooltip" title="Otro usuario"><i class="fa fa-plus-circle"></i></a>
                                                <a href="#" onclick="writeUsrs();" class="btn btn-warning" data-toggle="tooltip" title="Escribir usuario"><i class="fa fa-users"></i></a>
                                            </div>
                                            <input type="hidden" name="evento" id="evento" value="5" />
                                            <input type="hidden" name="id" id="id" value="" />

                                        </div>
                                    </div>
                                </div>
                                <br />
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="modal-footer">
                                            <input type="submit" name="authBtn" id="authBtn" value="Actualizar" class="btn btn-primary" />
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="msg"></div>
                            <input type="hidden" name="valor" id="valor" value="0" />
                        </form>

                    </div>
                </div>
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->  

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

                                                    function openModalAuth(estatus, id) {
                                                        $('#myModalDrop').modal('toggle');
                                                        $("#authOutput input[name='estatus']").val(estatus);
                                                        $("#authOutput input[name='id']").val(id);
                                                    }

                                                    function editRequest(id) {
                                                        $('#myModalEdit').modal('toggle');
                                                        $("#editRequester input[name='id']").val(id);
                                                    }

                                                    function showAllUsrs() {

                                                        if (parseInt($("#valor").val()) === 0) {
                                                            $("#myUsrs").hide("slow");
                                                            $("#allUsrs").show("slow");
                                                            $("#valor").val("1");
                                                        } else {
                                                            $("#myUsrs").show("slow");
                                                            $("#allUsrs").hide("slow");
                                                            $("#valor").val("0");
                                                        }

                                                    }

                                                    function writeUsrs() {
                                                        $("#myUsrs").hide("slow");
                                                        $("#allUsrs").hide("slow");
                                                        $("#otUsrs").show("slow");
                                                    }
    </script>
</body>
