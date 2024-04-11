<?php
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
                    Registro de pago de caja chica
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
                                    <!--<a href="#" class="btn btn-block btn-warning btn-flat center-block" onclick="agregarTipoSolicitud();"><i class="fa fa-plus"></i> Agregar tipo de solicitud</a>-->
                                </div>
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div id="msg"></div>
                            <table id="egresos" class="table dt-responsive nowrap table-responsive text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Descripci&oacute;n</th>
                                        <th>Importe</th>
                                        <th>Saldo</th>
                                        <th>Importe a depositar</th>                                        
                                        <th>Opciones</th>
                                    </tr>
                                </thead> 
                                <tbody id="dirac_solicitudes">
                                    <?php
                                    $caja_chica = $model->getSolicitudesGAC("id_tipo = 1");
                                    $cantidad_porc = 0;

                                    foreach ($caja_chica["data"] as $key => $cc) {
                                        $saldo = 0;
                                        $comprobado = 0;
                                        $comp_auth = $model->getComprobantes(" id_solicitud = " . $cc["id"] . " AND estatus = 3");
                                        foreach ($comp_auth["data"] as $key => $comp) {
                                            $comprobado += $comp["importe"];
                                        }
                                        ###########################################################################
                                        $deposito = 0;
                                        $dep = $model->getRegistroCCH("id_solicitud = " . $cc["id"]);
                                        foreach ($dep["data"] as $key => $d) {
                                            $deposito += $d["importe"];
                                        }
                                        ###########################################################################
                                        $saldo = floatval($cc["importe"] - $comprobado + $deposito);
                                        $cantidad_porc = ($cc["importe"] * 10) / 100;
//                                        var_dump($cantidad_porc);
                                        $class = "";
                                        if ($cantidad_porc >= $saldo) {
                                            $class = "<i class='fa fa-warning text-warning' data-toggle='tooltip' title='El registro de caja chica cuenta con menos del 10%'></i>";
                                        }

                                        echo "<tr>";
                                        echo "<td>" . $cc["id"] . " " . $class . "</td>";
                                        echo "<td>" . $cc["solicita_usuario"]["data"][0]["nombre"] . "</td>";
                                        echo "<td>" . $cc["descripcion"] . "</td>";
                                        echo "<td>$" . number_format($cc["importe"], 2) . "</td>";
                                        echo "<td>$" . number_format($saldo, 2) . "</td>";
                                        echo '<td><input type="text" class="form-control" name="tope" id="importe_' . $cc["id"] . '" value="0" /></td>';
                                        echo '<td>';
                                        echo '<button class="btn btn-flat btn-primary" onclick="saveDep(' . $cc["id"] . ');" data-toggle="tooltip" title="Registrar deposito"> <i class="fa fa-bitcoin"></i> </button>';
//                                        echo '<button class="btn btn-flat btn-primary" onclick="VerDep(' . $p["id"] . ');" data-toggle="tooltip" title="Ver bitacora de depositos"> <i class="fa fa-eye"></i> </button>';
                                        echo '</td>';
                                        echo "</tr>";
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

            $("#agregarTipoSolicitud").submit(function (event) {
                event.preventDefault();
                $.ajax({
                    type: "POST",
                    url: '../controller/pmController.php',
                    data: $("#agregarTipoSolicitud").serializeArray(),
                    dataType: 'json',
                    beforeSend: function () {
//                console.log("Replace project....");
                        $("#msgE").html('<div class="text-center"><i class="fa fa-spinner fa-spin" style="font-size:48px; color: #F49625"></i><p><b class="text-center"><b></p></div>');
                    },
                    success: function (response) {
                        if (response.errorCode === 0) {
                            showAlert(response.msg, "Informaci&oacute;n actualizada correctamente", "success", "bounce");
                            getEgresos();
                        } else {
                            showAlert("¡Error!", response.msg, "error", "swing");
                        }
                    },
                    error: function (a, b, c) {
                        console.log(a, b, c);
                    }
                });
            });
            $("#editEgreso").submit(function (event) {
                event.preventDefault();
                $.ajax({
                    type: "POST",
                    url: '../controller/pmController.php',
                    data: $("#editEgreso").serializeArray(),
                    dataType: 'json',
                    beforeSend: function () {
//                console.log("Replace project....");
                        $("#msgE").html('<div class="text-center"><i class="fa fa-spinner fa-spin" style="font-size:48px; color: #F49625"></i><p><b class="text-center"><b></p></div>');
                    },
                    success: function (response) {
                        if (response.errorCode === 0) {
                            showAlert(response.msg, "Informaci&oacute;n actualizada correctamente", "success", "bounce");
                            getEgresos();
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
        function saveDep(id) {
            console.log("ID: " + id);
            console.log($("#importe_" + id).val());
            $.ajax({
                type: "POST",
                url: '../controller/controller.php',
                data: {evento: 25, id_solicitud: id, importe: $("#importe_" + id).val()},
                dataType: 'json',
                beforeSend: function () {
//                console.log("Replace project....");
                    $("#msg").html('<div class="text-center"><i class="fa fa-spinner fa-spin" style="font-size:48px; color: #F49625"></i><p><b class="text-center"><b></p></div>');
                },
                success: function (response) {
                    if (response.errorCode === 0) {
                        $("#msg").html('');
                        showAlert(response.msg, "Informaci&oacute;n registrada correctamente", "success", "bounce");
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



        function deleteInfo(id) {
            swal({
                title: '¿Estas seguro?',
                text: "¡Esta operación es irreversible!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Si, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then(function () {
                $.post("../controller/controller.php", {evento: 2, id: id}, function (response) {
                    if (response.errorCode === 0) {
                        showAlert(response.msg, "Informaci&oacute;n actualizada correctamente", "success", "bounce");
                        setTimeout(window.location.reload(), 1500);
                    } else {
                        showAlert("¡Error!", response.msg, "error", "swing");
                    }
                }, 'json');
            });
        }


    </script>
</body>
