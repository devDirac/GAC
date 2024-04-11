<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../snippets/header.php';
require_once '../model/Model.php';

$model = Model::ModelSngltn();
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
                    Solicitudes pendientes de pago
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
                            <div class="row">
                                <div class="col-lg-offset-9 col-lg-3">
                                    <!--<a href="solicitud_gac.php" class="btn btn-block btn-warning btn-flat center-block"><i class="fa fa-plus"></i> Agregar solicitud</a>-->
                                </div>
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div id="msg"></div>
                            <table id="egresos" class="table dt-responsive nowrap table-responsive text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Solicita</th>
                                        <th>Beneficiario</th>
                                        <th>Proyecto</th>
                                        <th>Importe</th>
                                        <th>Concepto</th>
                                        <th>Forma de pago</th>
                                        <th>Banco</th>
                                        <th>Cuenta</th>
                                        <th>CLABE</th>
                                        <th>Tipo de solicitud</th>
                                        <th>Fecha solicitud</th>
                                        <th>Fecha atenci&oacute;n</th>
                                        <th>Fecha pago</th>
                                        <th>Estatus</th>
                                        <th>Pagar</th>
                                    </tr>
                                </thead> 
                                <tbody id="dirac_solicitudes">
                                    <?php
                                    $solicitudes = $model->getSolicitudesGAC("solicita = " . $_SESSION["sgi_id_usr"] . " AND estatus = 3");
//                                    var_dump($solicitudes);

                                    foreach ($solicitudes["data"] as $key => $s) {
                                        echo '<tr>';
                                        echo '<td>' . $s["id"] . '</td>';
                                        echo '<td>' . $s["solicita_usuario"]["data"][0]["nombre"] . ' ' . $s["solicita_usuario"]["data"][0]["apellidos"] . '</td>';
                                        echo '<td>' . $s["beneficiario_txt"] . '</td>';
                                        echo '<td>' . $s["proyecto"]. '</td>';
                                        echo '<td>$' . number_format($s["importe"], 2) . '</td>';
                                        echo '<td>' . $s["descripcion"] . '</td>';
                                        echo '<td>' . $s["forma_pago_nombre"] . '</td>';
                                        echo '<td>' . $s["banco"] . '</td>';
                                        echo '<td>' . $s["cuenta"] . '</td>';
                                        echo '<td>' . $s["clabe"] . '</td>';
                                        echo '<td>' . $s["tipo_solicitud"]["data"][0]["nombre"] . '</td>';
                                        echo '<td>' . $s["fecha_solicitud"] . '</td>';
                                        echo '<td>' . $s["fecha_atencion"] . '</td>';
                                        echo '<td>' . $s["fecha_pago"] . '</td>';
                                        echo '<td>' . $s["estatus_nombre"] . '</td>';

                                        echo '<td>';
                                        echo '<button class="btn btn-flat btn-warning" onclick="pagar(' . $s["id"] . ');" data-toggle="tooltip" title="Colocar estado de pagado"> <i class="fa fa-bitcoin"></i> </button>';
                                        echo '</td>';
                                        echo '</tr>';
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

        <?php
        require_once '../snippets/sidebar2.php';
        require_once '../snippets/footer.php';
        require_once '../utils/datatables.php';
        ?>
    </div><!-- ./wrapper -->    
    <script type="text/javascript" src="<?php echo SYSTEM_PATH ?>dist/js/pages/login.js"></script>
    <script type="text/javascript" src="<?php echo SYSTEM_PATH ?>dist/js/pages/utils.js"></script>
    <script type="text/javascript" src="<?php echo SYSTEM_PATH ?>dist/js/pages/projects.js?v1.0"></script>
    <script type="text/javascript">
        $(document).ready(function () {
//
//                                            getEgresos("1=1");
            initTable("egresos");


        });
  

        function initTable(table) {
            $("#" + table).dataTable({
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
        }
//                                        -----------------------------------------------------------------------------------
        function pagar(id) {
            $.ajax({
                type: "POST",
                url: '../controller/controller.php',
                data: {evento: 10, id: id, estatus: 4},
                dataType: 'json',
                beforeSend: function () {
//                console.log("Replace project....");
                    $("#msg").html('<div class="text-center"><i class="fa fa-spinner fa-spin" style="font-size:48px; color: #F49625"></i><p><b class="text-center"><b></p></div>');
                },
                success: function (response) {
                    if (response.errorCode === 0) {
                        $("#msg").html('');
                        showAlert(response.msg, "Informaci&oacute;n actualizada correctamente", "success", "bounce");
                        setTimeout(window.location.reload(), 1500);
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
