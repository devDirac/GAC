<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../snippets/header.php';
require_once '../model/Model.php';

$model = Model::ModelSngltn();

$soyB = $_SESSION["sgi_nivel"];
$valB = 0;
$jefe = 0;
//var_dump($_SESSION);
if ($soyB === "B") {
    //Busco a mi jefe inmediato que no sea B
    $jefe_inmediato = $model->getInfoUsrsView("id_usuario = " . $_SESSION["sgi_jefe_inmediato"]);
    $mjeB = $jefe_inmediato["data"][0]["nivel"];
    if ($mjeB === "B") {
//        echo "SOYN UN B CON OTRO B";
        $jefe = $jefe_inmediato["data"][0]["id_usuario"];
        $valB = 1;
    }
}
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
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-6">
                            <h1 class="text-aqua">
                                GAC 
                                <small> - Solicitud para gastos a comprobar</small>
                            </h1>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="col-lg-offset-6 col-lg-2">
                                        <?php
//                                        switch (intval($_SESSION["sgi_id_empresa"])) {
//                                            case 1:
//                                                echo '<img src="../dist/img/dirac.jpg" width="157px" alt="alt" id="logo_empresa"/>';
//                                                break;
//                                            case 2:
//                                                echo '<img src="../dist/img/dielem_logo.png" width="157px" alt="alt" id="logo_empresa"/>';
//                                                break;
//                                            case 3:
//                                                echo '<img src="../dist/img/lab_logo.png" width="157px" alt="alt" id="logo_empresa"/>';
//                                                break;
//
//                                            default:
//                                                echo '<img src="../dist/img/arjion1.png" width="157px" alt="alt" id="logo_empresa"/>';
//                                                break;
//                                        }
                                        ?>
                                    </div>                                                          
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <ol class="breadcrumb">
                    <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Solicitud</li>
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">

                <div class="box box-warning col-lg-6" >
                    <div class="box-header">
                        <!--<h3 class="box-title">Detalle<?php // echo $_SESSION["sgi_id_area"];                      ?></h3>-->
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form method="POST" role="form" name="solicitud_gac" id="solicitud_gac">
                        <div class="box-body">
                            <div class="row">
                                <?php
//                                $usuarios = $model->getInfoUsrsView("id_director_area = 102 AND status = 1 ORDER BY nombre ASC");
                                $query = null;

                                $usuarios = $model->getInfoUsrsView("id_direccion = " . $_SESSION["sgi_id_area"] . " AND status = 1 ORDER BY nombre ASC");
                                $proyectos = $model->getProjectsDirac("dashboard = 1");
                                $tSolicitud = $model->getTipoSolicitudes("estatus = 1 AND id != 1");
                               // $tSolicitud = $model->getTipoSolicitudes("estatus = 1");
                                ?>
                                <div class="col-lg-12">
                                    <br /><label for="fecha">Fecha: <?php echo "<b>" . date("Y-m-d H:i:s") . "</b>" ?></label>                                                                                                        
                                    <table id="solicitud_gact" class="table dt-responsive nowrap table-responsive text-justify">
                                        <tr>
                                            <td>
                                                <div class="form-group-inline">
                                                    <label for="direccion">Empresa:</label>
                                                    <i class="fa fa-fw fa-question-circle text-warning" data-toggle="tooltip" title="Seleccione empresa" class="mensaje" onclick="return false;"></i>                                            
                                                    <select class="form-control" name="id_empresa" id="id_empresa">
                                                        <option value="1">Dirac</option>
                                                        <option value="2">Dielem</option>
                                                        <option value="3">Laboratorio</option>
                                                        <option value="4">Diseno Racional</option>
                                                    </select>
                                                </div>  

                                            </td>
                                            <td>
                                                <div class="form-group-inline">
                                                    <label for="direccion">Tipo de solicitud:</label>
                                                    <i class="fa fa-fw fa-question-circle text-warning" data-toggle="tooltip" title="Seleccione tipo de solicitud" class="mensaje" onclick="return false;"></i>                                            
                                                    <select class="form-control" name="tipo_solicitud" id="tipo_solicitud" onchange="changeTipoSol();">
                                                        <?php
                                                        foreach ($tSolicitud["data"] as $key => $t) {
                                                            echo '<option value="' . $t["id"] . '">' . $t["nombre"] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-group-inline">
                                                    <label for="direccion">Proyecto:</label>
                                                    <i class="fa fa-fw fa-question-circle text-warning" data-toggle="tooltip" title="Seleccione proyecto" class="mensaje" onclick="return false;"></i>                                            
                                                    <i class="fa fa-suitcase text-primary" data-toggle="tooltip" title="Click aquí si los gastos no pertenece a un proyecto de la lista." class="mensaje" onclick="showInput();"></i>                                            
                                                    <input type="text" name="proyecto_sr" id="proyecto_sr" value="" class="form-control" placeholder="Escriba proyecto"/>
                                                    <select class="form-control" name="id_proyecto" id="id_proyecto">
                                                        <?php
                                                        echo '<option value="0">Seleccione proyecto</option>';
                                                        foreach ($proyectos["data"] as $key => $p) {
                                                            echo '<option value="' . $p["id"] . '">' . $p["nombre"] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>                                                
                                                <div class="form-group-inline">
                                                    <label for="direccion">Solicitud de:</label>
                                                    <i class="fa fa-fw fa-question-circle text-warning" data-toggle="tooltip" title="Seleccione forma de pago" class="mensaje" onclick="return false;"></i>                                            
                                                    <select class="form-control" name="forma_pago" id="forma_pago">
                                                        <option value="1">Cheque</option>
                                                        <option value="2">Transferencia bancaria</option>
                                                    </select>
                                                </div>
                                            </td>
                                        </tr>                                        
                                        <tr>
                                            <td>
                                                <div class="form-group-inline">
                                                    <br /><label for="solicitante">Solicitante: <?php echo "<b>" . $_SESSION["sgi_nombre"] . " " . $_SESSION["sgi_apellidos"] . "</b>"; ?></label>                                                                                                        
                                                </div>                                                
                                            </td>
                                            <td>
                                                <div class="form-group-inline">
                                                    <label for="banco">Banco:</label>  
                                                    <i class="fa fa-fw fa-question-circle text-warning" data-toggle="tooltip" title="Escriba el banco" class="mensaje" onclick="return false;"></i>                                            
                                                    <input class="form-control" name="banco" id="banco" type="text" value="" required="true" />
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>                                                
                                                <div class="form-group-inline">
                                                    <label for="direccion">Beneficiario:</label>                                                    
                                                    <i class="fa fa-fw fa-question-circle text-warning" data-toggle="tooltip" title="Seleccione beneficiario" class="mensaje" onclick="return false;"></i>                                            
                                                    <i class="fa fa-users text-primary" data-toggle="tooltip" title="Clic si es pago a proveedor" class="mensaje" onclick="showInput2();"></i>                                            
                                                    <input type="text" name="proveedor" id="proveedor" value="" class="form-control" placeholder="Escriba nombre del proveedor"/>
                                                    <select class="form-control" name="id_usuario" id="id_usuario">
                                                        <?php
                                                        echo '<option value="0">Seleccione beneficiario</option>';
                                                        foreach ($usuarios["data"] as $key => $usr) {
                                                            echo '<option value="' . $usr["id_usuario"] . '">' . $usr["nombre"] . " " . $usr["apellidos"] . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </td>                                            
                                            <td>
                                                <div class="form-group-inline">
                                                    <label for="no_cuenta">No. cuenta:</label>  
                                                    <i class="fa fa-fw fa-question-circle text-warning" data-toggle="tooltip" title="Escriba el numero de cuenta" class="mensaje" onclick="return false;"></i>                                            
                                                    <input class="form-control" name="cuenta" id="cuenta" type="text" value="" required="true" />
                                                </div>
                                            </td>                                            
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-group-inline">
                                                    <label for="importe">Importe:</label>  
                                                    <i class="fa fa-fw fa-question-circle text-warning" data-toggle="tooltip" title="Escriba el importe" class="mensaje" onclick="return false;"></i>                                            
                                                    <input class="form-control" name="importe" id="importe" type="number" step="0.01" min="0.01" value="" required="true" />
                                                </div>
                                            </td>                                            
                                            <td>
                                                <div class="form-group-inline">
                                                    <label for="no_clabe">No. CLABE:</label>  
                                                    <i class="fa fa-fw fa-question-circle text-warning" data-toggle="tooltip" title="Escriba el # CLABE" class="mensaje" onclick="return false;"></i>                                            
                                                    <input class="form-control" name="clabe" id="clabe" type="text" value="" required="true" />
                                                </div>
                                            </td> 
                                        </tr>
                                    </table>
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <table id="solicitud_gactt" class="table dt-responsive nowrap table-responsive">
                                        <tr>
                                            <td>
                                                <div class="form-group-inline">
                                                    <label for="concepto">Concepto:</label>  
                                                    <i class="fa fa-fw fa-question-circle text-warning" data-toggle="tooltip" title="Escriba el concepto de la solicitud" class="mensaje" onclick="return false;"></i>                                            
                                                    <textarea class="form-control" name="concepto" id="concepto"></textarea>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
<!--                                            <td>
                                                <div class="form-group-inline">
                                                    <label for="concepto">Observaciones:</label>  
                                                    <i class="fa fa-fw fa-question-circle text-warning" data-toggle="tooltip" title="Escriba las oberservaciones" class="mensaje" onclick="return false;"></i>                                            
                                                    <textarea class="form-control" name="observaciones" id="observaciones"></textarea>
                                                </div>
                                            </td>-->
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-block btn-warning" id="send_sgac"><i class="fa fa-save"></i> Enviar</button>
                                        <input type="hidden" name="evento" id="evento" value="6" />
                                        <input type="hidden" name="valor" id="valor" value="0" />
                                        <input type="hidden" name="id_solicitud" id="id_solicitud" value="0" />
                                        <input type="hidden" name="id_comprobante" id="id_comprobante" value="0" />
                                        <input type="hidden" name="jefe" id="jefe" value="<?php echo $jefe; ?>" />
                                        <input type="hidden" name="id_director" id="id_director" value="<?php echo $_SESSION["sgi_id_dir_area"]; ?>" />
                                        <input type="hidden" name="nivel" id="nivel" value="<?php echo $_SESSION["sgi_nivel"]; ?>" />

                                    </div>        
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="divReembolso" style="display: none;">
                                <div id="msg_dz"></div>
                                <br />
                                <div class="form-group-inline" id="upFiles">
                                    <label for="myDrop" class="text-xs"> Carga de archivos:<br /><small>Favor de cargar todos los archivos correspondientes</small> </label>
                                    <div class="dropzone" id="myDrop"></div>
                                </div>
                                <br />
                                <br />
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="button" class="btn btn-block btn-primary" id="send_fileSol" onclick="enviarArchivosReembolso();" style="display: none;"><i class="fa fa-send"></i> Enviar solicitud y archivos cargados</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.box-body -->

                <!--                        <div class="box-footer center-block">
                                            <div class="row">
                                                <div class="col-lg-offset-5 col-lg-2">
                                                </div>
                                            </div>
                                        </div>-->
                <div id="msg"></div>
                <br />
                <br />
                <br />
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
<script type="text/javascript" src="<?php echo SYSTEM_PATH ?>dist/js/pages/login.js?v=<?php echo $fecha_scripts->getTimestamp(); ?>"></script>
<script type="text/javascript" src="<?php echo SYSTEM_PATH ?>dist/js/pages/utils.js?v=<?php echo $fecha_scripts->getTimestamp(); ?>"></script>
<script type="text/javascript" src="<?php echo SYSTEM_PATH ?>dist/js/pages/daf.js?v=<?php echo $fecha_scripts->getTimestamp(); ?>"></script>


<script>
                                            /* *********************** DROPZONE ************************* */
                                            // INICIALIZAR DROPZONE
                                            var myDropzone = new Dropzone("#myDrop", {// Make the whole body a dropzone            
                                                url: "uploadFiles.php?id_solicitud=" + $("#id_solicitud").val() + "&id_comprobante=" + $("#id_comprobante").val(), // Set the url
                                                thumbnailWidth: 80,
                                                thumbnailHeight: 80,
                                                parallelUploads: 20,
                                                uploadMultiple: false,
                                                datatype: "json",
                                                acceptedFiles: ".jpeg,.jpg,.png,.JPEG,.JPG,.PNG,.doc,.docx,.pdf,.DOC,.DOCX,.PDF,.xml,.XML",
                                                //previewTemplate: previewTemplate,
                                                autoQueue: false // Make sure the files aren't queued until manually added
                                                        //previewsContainer: "#imagen" // Define the container to display the previews
                                                        //clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
                                            });
                                            // Prevent Dropzone from auto discovering this element:
                                            Dropzone.options.myAwesomeDropzone = false;
                                            // This is useful when you want to create the
                                            // Dropzone programmatically later

                                            myDropzone.on("processing", function (file) {
                                                this.options.url = "uploadFiles.php?id_solicitud=" + $("#id_solicitud").val() + "&id_comprobante=" + $("#id_comprobante").val();
                                            });
                                            // Disable auto discover for all elements:
                                            Dropzone.autoDiscover = false;

                                            myDropzone.on("error", function (data, response) {
                                                showAlert("¡Error!", response.msg, "error", "swing");
                                                myDropzone.removeAllFiles();
                                            });
                                            myDropzone.on("success", function (data, response) {

                                                if (response.errorCode === 0) {
                                                    $("#msg_dz").html('<b class="text-success text-center">' + response.msg + '</b>');
//                $("#add_doc").trigger("reset");
                                                    setTimeout(function () {
                                                        $("#msg_dz").html('');
//                                                        myDropzone.removeAllFiles();
                                                        $("#send_fileSol").show("slow");
                                                    }, 1500);
                                                } else {
                                                    showAlert("¡Error!", response.msg, "error", "swing");
                                                    myDropzone.removeAllFiles();
                                                }

                                            });
                                            /* *********************** DROPZONE ************************* */
                                            $(document).ready(function () {
                                                $('[data-toggle="tooltip"]').tooltip();
                                                $("#proyecto_sr").toggle();
                                                $("#proveedor").toggle();

                                                $("#solicitud_gac").submit(function (event) {
                                                    event.preventDefault();

                                                    $.ajax({
                                                        type: "POST",
                                                        url: '../controller/controller.php',
                                                        data: $("#solicitud_gac").serializeArray(),
                                                        dataType: 'json',
                                                        beforeSend: function () {
                                                            console.log("Info project project....");
                                                            $("#msg").html('<div class="text-center"><i class="fa fa-spinner fa-spin" style="font-size:48px; color: #F49625"></i><p><b class="text-center"><b></p></div>');
                                                            $("#send_sgac").prop("disabled", true);

                                                        },
                                                        success: function (response) {
                                                            if (response.errorCode === 0) {
                                                                console.log(response);
                                                                showAlert(response.msg, "Informaci&oacute;n procesada correctamente", "success", "bounce");
                                                                $("#send_sgac").prop("disabled", true);
//                                                                if (parseInt($("#tipo_solicitud").val()) === 5 || parseInt($("#tipo_solicitud").val()) === 6) {
                                                                $("#divReembolso").show("slow");
                                                                $("#id_solicitud").val(response.data);
//                                                                }
                                                            } else {
                                                                showAlert("¡Error!", response.msg, "error", "swing");
                                                            }
                                                            $("#msg").html('');
                                                        }, error: function (a, b, c) {
                                                            console.log(a, b, c);
                                                        }
                                                    });
                                                });
                                            });

                                            function showInput() {
                                                $("#proyecto_sr").toggle();
                                            }
                                            function showInput2() {
                                                $("#proveedor").toggle();
                                            }

                                            function changeTipoSol() {
                                                if (parseInt($("#tipo_solicitud").val()) === 6) {
                                                    showInput2();
                                                }
                                            }

                                            function enviarArchivosReembolso() {
                                                $.ajax({
                                                    type: "POST",
                                                    url: '../controller/controller.php',
                                                    data: {evento: 16, id_solicitud: $("#id_solicitud").val(), jefe: $("#jefe").val(), id_director: $("#id_director").val(), nivel: $("#nivel").val()},
                                                    dataType: 'json',
                                                    beforeSend: function () {
                                                        console.log("Info project project....");
                                                        $("#msg").html('<div class="text-center"><i class="fa fa-spinner fa-spin" style="font-size:48px; color: #F49625"></i><p><b class="text-center"><b></p></div>');
                                                        $("#send_sgac").prop("disabled", true);
                                                        $("#send_fileSol").prop("disabled", true);

                                                    },
                                                    success: function (response) {
                                                        if (response.errorCode === 0) {
                                                            console.log(response);
                                                            showAlert(response.msg, "Informaci&oacute;n procesada correctamente", "success", "bounce");
                                                            $("#send_sgac").prop("disabled", true);
                                                            setTimeout(function () {
                                                                window.location.href = 'dashboard.php';
                                                            }, 1500);

                                                        } else {
                                                            showAlert("¡Error!", response.msg, "error", "swing");
                                                        }
                                                        $("#msg").html('');
                                                    }, error: function (a, b, c) {
                                                        console.log(a, b, c);
                                                    }
                                                });
                                            }
</script>
</body>
