<?php
require_once '../snippets/header.php';
require_once '../model/Model.php';

$model = Model::ModelSngltn();

$solicitud = $model->getSolicitudesGAC("id = " . $_REQUEST["id"]);
$comprobantes = $model->getComprobantes("id_solicitud = " . $_REQUEST["id"] . " AND estatus = 2");
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
                    Autorizaci&oacute;n de comprobantes
                    <small>[Gastos a comprobar]</small>
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
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-lg-offset-2 col-lg-8">
                                    <h3>Solicitud:</h3>
                                    <table class="table dt-responsive nowrap table-responsive text-center">
                                        <tr>
                                            <td>Solicita: <b class="text-aqua"><?php echo $solicitud["data"][0]["solicita_usuario"]["data"][0]["nombre"] . " " . $solicitud["data"][0]["solicita_usuario"]["data"][0]["apellidos"]; ?></b></td>
                                            <td>Beneficiario: <b class="text-aqua"><?php echo $solicitud["data"][0]["beneficiario_txt"]; ?></b></td>
                                            <td>Proyecto: <b class="text-aqua"><?php echo $solicitud["data"][0]["proyecto"]; ?></b></td>
                                        </tr>
                                        <tr>
                                            <td>Fecha: <b class="text-aqua"><?php echo $solicitud["data"][0]["fecha_solicitud"]; ?></b></td>
                                            <td>Importe: <b class="text-aqua">$<?php echo number_format($solicitud["data"][0]["importe"], 2); ?></b></td>
                                            <td>Concepto: <b class="text-aqua"><?php echo $solicitud["data"][0]["descripcion"]; ?></b></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-lg-12">
                                    <h3>Comprobantes: </h3>
                                    <form name="authCompDA" id="authCompDA">
                                        <input type="hidden" name="evento" id="evento" value="14" />
                                        <table id="comprobantes" class="table dt-responsive nowrap table-responsive text-center">
                                            <thead>
                                                <tr>
                                                    <th class="check-header hidden-xs">
                                                        <label><input id="checkAll" name="checkAll" type="checkbox"><span></span></label>
                                                    </th>   
                                                    <!--<th>#</th>-->
                                                    <th>Importe</th>
                                                    <th>Descripci&oacute;n</th>
                                                    <th>Fecha</th>
                                                    <th>Archivos</th>
                                                    <th>Estatus</th>
                                                    <!--<th>Opciones</th>-->
                                                </tr>
                                            </thead>
                                            <tbody id = "dirac_comprobantes_gac">
                                                <?php
                                                $total_importe = 0;

                                                $showBtnSend = 0;
                                                $showBtnsAuth = 0;
                                                foreach ($comprobantes["data"] as $key => $s) {
                                                    $showBtnsAuth++;
                                                    $showBtnSend++;

                                                    $total_importe += $s["importe"];

                                                    echo '<tr>';

                                                    if (intval($s["estatus"]) === 2) {
                                                        echo '<td class="check hidden-xs">';
                                                        echo '<input class="checkbox" type="checkbox" name="idsC[]" id= "' . $s["id"] . '" value= "' . $s["id"] . '"  >';
                                                        echo '</td>';
                                                    } else {
                                                        echo '<td></td>';
                                                    }

                                                    echo '<td>$' . number_format($s["importe"], 2) . '</td>';
                                                    echo '<td>' . $s["descripcion"] . '</td>';
                                                    echo '<td>' . $s["fecha"] . '</td>';
                                                    echo '<td>';

                                                    $archivos = $model->getArchivosComprobantes("id_solicitud = " . $_REQUEST["id"] . " AND id_comprobante = " . $s["id"]);
                                                    foreach ($archivos["data"] as $key2 => $a) {
                                                        echo '<a href="' . $a["path"] . $a["nombre"] . '" target="_blank">' . substr($a["nombre"], 0, 20) . '...</a><br />';
                                                    }
                                                    echo '</td>';
                                                    echo '<td>' . $s["estatus_nombre"] . '</td>';

//                                                if (intval($s["estatus"]) === 0) {
//                                                    echo '<td>';
//                                                    echo '<button class="btn btn-flat btn-danger" onclick="deleteComp(' . $s["id"] . ');" data-toggle="tooltip" title="Eliminar registro"> <i class="fa fa-times"></i> </button>';
//                                                    echo '</td>';
//                                                } else {
//                                                    echo '<td></td>';
//                                                }
                                                    echo '</tr>';
                                                }
                                                ?>
                                            </tbody>
                                            <?php
                                            $deposito = 0;
                                            $dep = $model->getRegistroCCH("id_solicitud = " . $_REQUEST["id"]);
                                            foreach ($dep["data"] as $key => $d) {
                                                $deposito += $d["importe"];
                                            }
                                            ?>
                                            <tfoot>
                                                <tr class="text-primary text-bold">
                                                    <td></td>
                                                    <td>$<?php echo number_format($total_importe, 2); ?></td>
                                                    <td>Total por comprobar</td>
                                                    <td colspan="4"></td>
                                                </tr>
                                                <tr class="text-info text-bold">
                                                    <td></td>
                                                    <td><!--$-->
                                                        <?php
//                                                        $restante = $solicitud["data"][0]["importe"] - $total_importe + $deposito;
//                                                        echo number_format($restante, 2);
                                                        ?>
                                                    </td>
                                                    <td><!--Restante por comprobar--></td>
                                                    <td colspan="4"></td>
                                                </tr>
                                                <?php
                                                if ($showBtnsAuth !== 0) {
                                                    ?>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <!--<td></td>-->
                                                        <td>
                                                            <button type="button" name="send_comp_ref" onclick="auth(5);" id="send_comp_ref" class="btn btn-flat btn-danger"><i class="fa fa-times"></i> Rechazar comprobantes seleccionados</button>
                                                        </td>
                                                        <td>                                                   
                                                            <button type="button" name="send_comp_auth" onclick="auth(3);" id="send_comp_auth" class="btn btn-flat btn-success"><i class="fa fa-check"></i> Autorizar comprobantes seleccionados</button>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <!--<td></td>-->
                                                    <td>
                                                        <!--<button type="button" onclick="closeReq();" name="closeReq" id="closeReq" class="btn btn-flat btn-warning"><i class="fa fa-lock"></i> Cerrar solicitud</button>-->
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if ($showBtnSend === 0) {
                                                            ?>
                                                            <button type="button" onclick="closeReq1(6);" name="closeReq" id="closeReq" class="btn btn-flat btn-warning"><i class="fa fa-send"></i> Enviar solicitud a DAF para pago</button>
                                                            <?php
                                                        }
                                                        ?>

<!--<button type="button" name="send_comp_auth" onclick="auth(3);" id="send_comp_auth" class="btn btn-flat btn-success"><i class="fa fa-check"></i> Autorizar comprobantes seleccionados</button>-->
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <div id="msg"></div>
                                        <input type="hidden" name="restante" id="restante" value="<?php echo $restante; ?>" /> 
                                        <input type="hidden" name="$total_importe" id="total_importe" value="<?php echo $total_importe; ?>" /> 

                                    </form>
                                </div>
                            </div>
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
        <input type="hidden" name="id_solicitud" id="id_solicitud" value="<?php echo $_REQUEST["id"]; ?>" />
    </div><!-- ./wrapper -->    
    <script type="text/javascript" src="<?php echo SYSTEM_PATH ?>dist/js/pages/login.js"></script>
    <script type="text/javascript" src="<?php echo SYSTEM_PATH ?>dist/js/pages/utils.js"></script>
    <!--<script type="text/javascript" src="<?php // echo SYSTEM_PATH                                                                        ?>dist/js/pages/projects.js?v1.0"></script>-->
    <script type="text/javascript">

                                                            $(document).ready(function () {

                                                                //                                                                initTable('comprobantes');
                                                                $('#checkAll').click(function () {
                                                                    //var oTable = $("#comprobantes").dataTable();
                                                                    //var allPages = oTable.fnGetNodes();
                                                                    if (this.checked) {
                                                                        $('.checkbox').each(function () {
                                                                            //this.checked = true;
                                                                            //$('input[type="checkbox"]', allPages).prop('checked', true);
                                                                            $('#comprobantes input[type="checkbox"]').prop('checked', true);
                                                                        });
                                                                    } else {
                                                                        $('.checkbox').each(function () {
                                                                            // this.checked = false;
                                                                            //$('input[type="checkbox"]', allPages).prop('checked', false);
                                                                            $('input[type="checkbox"]').prop('checked', false);
                                                                        });
                                                                    }
                                                                });

                                                            });

                                                            function auth(estatus) {
                                                                var data = $("#authCompDA").serializeArray();
                                                                data.push({"name": "estatus", "value": estatus});

                                                                var pp = false;
                                                                $.each(data, function (index, value) {
                                                                    if (value.name === "idsC[]") {
                                                                        pp = true;
                                                                    }
                                                                });
                                                                console.log("PP: " + pp);
                                                                if (pp === true) {
                                                                    console.log(data);
                                                                    $.ajax({
                                                                        type: "POST",
                                                                        url: '../controller/controller.php',
                                                                        data: data,
                                                                        dataType: 'json',
                                                                        beforeSend: function () {//                console.log("Replace project....");
                                                                            $("#msg").html('<div class="text-center"><i class="fa fa-spinner fa-spin" style="font-size:48px; color: #F49625"></i><p><b class="text-center"><b></p></div>');
                                                                        },
                                                                        success: function (response) {
                                                                            if (response.errorCode === 0) {
                                                                                showAlert(response.msg, "Informaci&oacute;n actualizada correctamente", "success", "bounce");
                                                                                $("#msg").html('');
                                                                                setTimeout(function () {
                                                                                    window.location.reload();
                                                                                }, 1500);
                                                                            } else {
                                                                                showAlert("¡Error!", response.msg, "error", "swing");
                                                                            }
                                                                        },
                                                                        error: function (a, b, c) {
                                                                            console.log(a, b, c);
                                                                        }
                                                                    });
                                                                } else {
                                                                    showAlert("¡Error!", "Favor de seleccionar minimo un comprobante", "error", "swing");
                                                                }
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
                                                            function getComprobantes() {
                                                                $.ajax({
                                                                    type: "POST",
                                                                    url: '../controller/getComprobantes.php',
                                                                    data: {id: $("#id_solicitud").val()},
                                                                    dataType: 'html',
                                                                    beforeSend: function () {//                console.log("Replace project....");
                                                                        $("#comprobantes_cargados").html('<div class="text-center"><i class="fa fa-spinner fa-spin" style="font-size:48px; color: #F49625"></i><p><b class="text-center"><b></p></div>');
                                                                    },
                                                                    success: function (response) {
                                                                        $("#comprobantes_cargados").html(response);
                                                                    },
                                                                    error: function (a, b, c) {
                                                                        console.log(a, b, c);
                                                                    }
                                                                });
                                                            }

                                                            function closeReq1(estatus) {
//                                                                alert("ALV");
                                                                $.ajax({
                                                                    type: "POST",
                                                                    url: '../controller/controller.php',
                                                                    data: {id: $("#id_solicitud").val(), evento: 23, estatus: estatus},
                                                                    dataType: 'json',
                                                                    beforeSend: function () {//                console.log("Replace project....");
                                                                        $("#msg3").html('<div class="text-center"><i class="fa fa-spinner fa-spin" style="font-size:48px; color: #F49625"></i><p><b class="text-center"><b></p></div>');
                                                                    },
                                                                    success: function (response) {
                                                                        showAlert(response.msg, "Informaci&oacute;n enviada correctamente", "success", "bounce");
                                                                        setTimeout(function () {
                                                                            window.location.href = 'dashboard.php';
                                                                        }, 1500);
                                                                        $("#msg3").html('');
                                                                    },
                                                                    error: function (a, b, c) {
                                                                        console.log(a, b, c);
                                                                    }
                                                                });
                                                            }
    </script>
</body>
