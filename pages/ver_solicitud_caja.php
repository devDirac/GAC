<?php
require_once '../snippets/header.php';
require_once '../model/Model.php';

$model = Model::ModelSngltn();

$solicitud = $model->getSolicitudesGAC("id = " . $_REQUEST["id"]);
$comprobantes = $model->getArchivosComprobantes("id_solicitud = " . $_REQUEST["id"]);
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
                    Revisi&oacute;n de solicitudes, pago y autorizaci&oacute;n
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
                                    <h3>Archivos : </h3>
                                    <form name="authCompDA" id="authCompDA">
                                        <input type="hidden" name="evento" id="evento" value="20" />
                                        <table id="comprobantes" class="table dt-responsive nowrap table-responsive text-center">
                                            <thead>
                                                <tr>
<!--                                                    <th class="check-header hidden-xs">
                                                        <label><input id="checkAll" name="checkAll" type="checkbox"><span></span></label>
                                                    </th>   -->
                                                    <th>#</th>
                                                    <th>Nombre</th>
                                                    <!--<th>Descripci&oacute;n</th>-->
                                                    <th>Fecha</th>
                                                    <th>Archivo</th>
                                                    <th>Estatus</th>
                                                    <!--<th>Opciones</th>-->
                                                </tr>
                                            </thead>
                                            <tbody id = "dirac_comprobantes_gac">
                                                <?php
                                                $showBtnSend = 0;
                                                $showBtnsAuth = 0;

                                                foreach ($comprobantes["data"] as $key => $s) {
                                                    $estatus_comprobante = $s["estatus"];
                                                    $estatus_txt = "";
                                                    if (intval($estatus_comprobante) === 2) {
                                                        $estatus_txt = "<b class='text-success'>Comprobante aceptado.</b>";
                                                    } elseif (intval($estatus_comprobante) === 0) {
                                                        $estatus_txt = "<b class='text-danger'>Comprobante rechazado.</b>";
                                                    } elseif (intval($estatus_comprobante) === 1) {
                                                        $estatus_txt = "<b class='text-warning'>Pendiente de validaci&oacute;n.</b>";
                                                    } else {
                                                        $estatus_txt = "<b class='text-primary'>Sin estado.</b>";
                                                    }
                                                    echo '<tr>';

                                                    if (intval($s["estatus"]) === 1) {
                                                        echo '<td class="check hidden-xs">';
                                                        echo '<input class="checkbox" type="checkbox" name="idsC[]" id= "' . $s["id"] . '" value= "' . $s["id"] . '"  >';
                                                        echo '</td>';
                                                        $showBtnsAuth++;
                                                    } else {
                                                        echo '<td></td>';
                                                        $showBtnSend++;
                                                    }

                                                    echo '<td>' . $s["nombre"] . '</td>';
                                                    echo '<td>' . $s["fecha"] . '</td>';
                                                    echo '<td><a href="' . $s["path"] . $s["nombre"] . '" target="_blank">' . substr($s["nombre"], 0, 20) . '...</a><br /></td>';
                                                    echo '<td>' . $estatus_txt . '</td>';
                                                    echo '</tr>';
                                                }
                                                ?>
                                            </tbody>
                                            <tfoot>
<!--                                                <tr class="text-primary text-bold">
                                                    <td></td>
                                                    <td>$<?php echo number_format($total_importe, 2); ?></td>
                                                    <td>Total por comprobar</td>
                                                    <td colspan="4"></td>
                                                </tr>
                                                <tr class="text-info text-bold">
                                                    <td></td>
                                                    <td>$
                                                <?php
                                                $restante = $solicitud["data"][0]["importe"] - $total_importe;
                                                echo number_format($restante, 2);
                                                ?>
                                                    </td>
                                                    <td>Restante por comprobar</td>
                                                    <td colspan="4"></td>
                                                </tr>-->
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        <?php
                                                        if ($showBtnsAuth > 0) {
                                                            ?>
                                                            <button type="button" name="send_comp_ref" onclick="auth(0);" id="send_comp_ref" class="btn btn-flat btn-danger"><i class="fa fa-times"></i> Rechazar</button>
                                                            <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>  
                                                        <?php
                                                        if ($showBtnsAuth > 0) {
                                                            ?>
                                                            <button type="button" name="send_comp_auth" onclick="auth(2);" id="send_comp_auth" class="btn btn-flat btn-success"><i class="fa fa-check"></i> Autorizar</button>
                                                            <?php
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>                                                
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        <?php
                                                        if ($showBtnSend > 0) {
                                                            ?>
                                                            <button type="button" onclick="closeReq(6);" name="btn_closeReq" id="btn_closeReq" class="btn btn-flat btn-warning"><i class="fa fa-bitcoin"></i> Enviar solicitud a DAF para pago</button>
                                                            <?php
                                                        }
                                                        ?>
                                                    </td>
<!--                                                    <td>                                                   
                                                        <button type="button" name="send_comp_auth" onclick="auth(3);" id="send_comp_auth" class="btn btn-flat btn-success"><i class="fa fa-check"></i> Autorizar comprobantes seleccionados</button>
                                                    </td>-->
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <div id="msg"></div>
                                        <input type="hidden" name="restante" id="restante" value="<?php echo $restante; ?>" /> 
                                        <input type="hidden" name="total_importe" id="total_importe" value="<?php echo $total_importe; ?>" /> 

                                    </form>
                                </div>
                            </div>
                            <div id="msg3"></div>
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
    <!--<script type="text/javascript" src="<?php // echo SYSTEM_PATH                                                                              ?>dist/js/pages/projects.js?v1.0"></script>-->
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
                                                                    data.push({"name": "id_solicitud", "value": $("#id_solicitud").val()});

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
                                                                                $("#send_comp_ref").prop("disabled", true);
                                                                                $("#send_comp_auth").prop("disabled", true);
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
                                                                        url: '../controller/controller.php',
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

                                                                function closeReq(estatus) {
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
