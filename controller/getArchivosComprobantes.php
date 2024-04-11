<?php
//header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require_once '../model/Model.php';
require_once '../utils/Utils.php';

$model = Model::ModelSngltn();
$params = json_decode(file_get_contents('php://input'), true);

$evento = 0;
$data = "";
if (is_null($params)) {
    $evento = filter_input(INPUT_POST, "evento");
    $data = catchPOST();
} else {
    $evento = $params["evento"];
    $data = $params;
}

$comprobantes = $model->getArchivosComprobantes("id_solicitud = " . $data["id"]);
$solicitud = $model->getSolicitudesGAC("id = " . $data["id"]);
?>
<table id="comprobantes" class="table dt-responsive nowrap table-responsive text-center">
    <thead>
        <tr>
<!--            <th class="check-header hidden-xs">
                <label><input id="checkAll" name="checkAll" type="checkbox"><span></span></label>
            </th>   -->
            <!--<th>#</th>-->
            <th>Nombre</th>
            <!--<th>Descripci&oacute;n</th>-->
            <th>Fecha</th>
            <th>Archivo</th>
            <th>Estatus</th>
        </tr>
    </thead>
    <tbody id = "dirac_comprobantes_gac">
        <?php
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

//            if (intval($s["estatus"]) === 1) {
//                echo '<td class="check hidden-xs">';
//                echo '<input class="checkbox" type="checkbox" name="idsC[]" id= "' . $s["id"] . '" value= "' . $s["id"] . '"  >';
//                echo '</td>';
//            } else {
//                echo '<td></td>';
//            }

            echo '<td>' . $s["nombre"] . '</td>';
            echo '<td>' . $s["fecha"] . '</td>';
            echo '<td><a href="' . $s["path"] . $s["nombre"] . '" target="_blank">' . substr($s["nombre"], 0, 20) . '...</a><br /></td>';
            echo '<td>' . $estatus_txt . '</td>';
            echo '</tr>';
        }
        ?>
    </tbody>
    <tfoot>
<!--        <tr class="text-primary text-bold">
            <td></td>
            <td>$<?php echo number_format($total_importe, 2); ?></td>
            <td>Total</td>
            <td colspan="4"></td>
        </tr>
        <tr class="text-info text-bold">
            <td></td>
            <td>$<?php echo number_format($solicitud["data"][0]["importe"] - $total_importe, 2); ?></td>
            <td>Restante por comprobar</td>
            <td colspan="4"></td>
        </tr>-->
        <tr>
            <td></td>
            <td></td>
            <td><input type="hidden" name="evento" id="evento" value="9" /></td>
            <td colspan="2">
                <!--<button name="send_comp" id="send_comp" class="btn btn-flat btn-primary"><i class="fa fa-send"></i> Enviar comprobantes</button>-->
            </td>
        </tr>
    </tfoot>
</table>
<div id="msg_p_files"></div>
<script type="text/javascript">
    $(document).ready(function () {
//        initTable("comprobantes");

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


    function deleteComp(id) {
        $.ajax({
            type: "POST",
            url: '../controller/controller.php',
            data: {id: id, evento: 8},
            dataType: 'json',
            beforeSend: function () {
                $("#comprobantes_cargados").html('<div class="text-center"><i class="fa fa-spinner fa-spin" style="font-size:48px; color: #F49625"></i><p><b class="text-center"><b></p></div>');
            },
            success: function (response) {
                console.log(response.errorCode);
                if (response.errorCode === 0) {
                    console.log("------------------------->");
                    showAlert(response.msg, "Informaci&oacute;n procesada correctamente", "success", "bounce");
                    getComprobantes();
                } else {
                    console.log("<-------------------------");
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
                $("#comprobantes_cargados").html('');
            },
            error: function (a, b, c) {
                console.log(a, b, c);
            }
        });
    }

</script>

<?php

function catchPOST() {
    return $data = filter_input_array(INPUT_POST);
}
?>