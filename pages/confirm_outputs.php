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
                    Confirmar recepci&oacute;n de material y equipo
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
                                        <th>Salida registrada</th>
                                        <th>Comentarios</th>
                                        <th>Confirmar</th>
                                    </tr>
                                </thead>
                                <tbody id="dirac_outputs">
                                    <?php
                                    $requests = $daf->getOutputs("estatus = 3 AND destinatario = " . $_SESSION["sgi_id_usr"] . " AND estatus_envio != 2");
                                    foreach ($requests["data"] as $key => $req) {
                                        $salida = $req["fecha_salida"];
                                        $valid = strtotime('+'.$req["vigencia"].' day', strtotime($salida));
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
                                                <td><?php echo $req["hora_salida"]; ?></td>
                                                <td><?php echo $req["comentarios"]; ?></td>
                                                <td>
                                                    <h4><b><a href="#" title="Confirmar recepci&oacute;n" class="text-yellow" onclick="confirm(<?php echo $req["id"]; ?>);"><i class="fa fa-check-circle-o"></i> Confirmar recepci&oacute;n</a></b></h4> 
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

                                                function confirm(id) {
                                                    event.preventDefault();
                                                    $.ajax({
                                                        type: "POST",
                                                        url: '../controller/dafController.php',
                                                        data: {evento: 7, id: id},
                                                        dataType: 'json',
                                                        beforeSend: function () {
                                                            $("#msg").html('<div class="text-center"><i class="fa fa-spinner fa-spin" style="font-size:48px; color: #F49625"></i><br /><b class="text-center">Procesando informaci&oacute;n...<b></div>');
                                                        },
                                                        success: function (response) {
                                                            if (response.errorCode === 0) {
                                                                showAlert(response.msg, "Informaci&oacute;n enviada correctamente", "success", "bounce");
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


    </script>
</body>
