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

if (intval($data["id"]) !== 0) {



    $comprobantes = $model->getComprobantes("id_solicitud = " . $data["id"]);
    $solicitud = $model->getSolicitudesGAC("id = " . $data["id"]);
    ?>
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
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody id = "dirac_comprobantes_gac">
            <?php
            $total_importe = 0;
            foreach ($comprobantes["data"] as $key => $s) {

                $total_importe += $s["importe"];
                echo '<tr>';

                if (intval($s["estatus"]) === 0) {
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

                $archivos = $model->getArchivosComprobantes("id_solicitud = " . $data["id"] . " AND id_comprobante = " . $s["id"]);
//            var_dump($archivos);
                foreach ($archivos["data"] as $key2 => $a) {
                    echo '<a href="' . $a["path"] . $a["nombre"] . '" target="_blank">' . substr($a["nombre"], 0, 20) . '...</a><br />';
                }
                echo '</td>';
                echo '<td>' . $s["estatus_nombre"] . '</td>';

                if (intval($s["estatus"]) === 0) {
                    echo '<td>';
                    echo '<button class="btn btn-flat btn-danger" onclick="deleteComp(' . $s["id"] . ');" data-toggle="tooltip" title="Eliminar registro"> <i class="fa fa-times"></i> </button>';
                    echo '</td>';
                } else {
                    echo '<td></td>';
                }
                echo '</tr>';
            }
            ?>
        </tbody>
        <?php
        $deposito = 0;
        $dep = $model->getRegistroCCH("id_solicitud = " . $data["id"]);
        foreach ($dep["data"] as $key => $d) {
            $deposito += $d["importe"];
        }
        ?>
        <tfoot>
            <tr class="text-primary text-bold">
                <td></td>
                <td>$<?php echo number_format($total_importe, 2); ?></td>
                <td>Total</td>
                <td colspan="4"></td>
            </tr>
            <tr class="text-info text-bold">
                <td></td>
                <td>$<?php echo number_format($solicitud["data"][0]["importe"] - $total_importe + $deposito, 2); ?></td>
                <td>Restante por comprobar</td>
                <td colspan="4"></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><input type="hidden" name="evento" id="evento" value="9" /></td>
                <td colspan="2">
                    <button name="send_comp" id="send_comp" class="btn btn-flat btn-primary"><i class="fa fa-send"></i> Enviar comprobantes</button>
                </td>
            </tr>
        </tfoot>
    </table>
    <input type="hidden" name="por_comprobar" id="por_comprobar" value="<?php echo $solicitud["data"][0]["importe"] - $total_importe + $deposito; ?>" />
    <div id="msg_p_files"></div>
    <?php
}
?>
<script type="text/javascript">
    $(document).ready(function () {
//        initTable("comprobantes");
        $("#importe").val($("#por_comprobar").val());
        $("#importe").attr({
            "max": $("#por_comprobar").val(),
            "min": 1
        });

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