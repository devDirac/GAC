<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../snippets/header.php';
require_once '../model/DAF.php';

$daf = DAF::DAFSngltn();
?>
<link href="../dist/js/select2-4.0.3/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
<style>
    .select2-dropdown {
        /*color: #36A0FF;*/
        color: black!important;
    }

    .select2-container--default .select2-selection--single {
        background-color: #aaa;
        border: 1px solid #aaa;
        border-radius: 6px;
        background-color: rgba(244, 244, 244, 0.44);
        color: white;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #F49625!important;
        line-height: 28px;
    }
</style>
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
                    Registro de visita de proveedores
                </h1>
                <ol class="breadcrumb">
                    <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Salida</li>
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">

                <div class="box box-warning col-lg-6" >
                    <div class="box-header">
                        <!--<h3 class="box-title">Detalle<?php echo $_SESSION["sgi_id_area"]; ?></h3>-->
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form method="POST" role="form" name="suppliers_check" id="suppliers_check">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Nombre proveedor:</label>
                                        <i class="fa fa-fw fa-question-circle text-warning" data-toggle="tooltip" title="Escriba el nombre del proveedor" class="mensaje" ></i>
                                        <input type="text" class="form-control" id="proveedor" name="proveedor" value="" required="true" />
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Empresa:</label>
                                        <i class="fa fa-fw fa-question-circle text-warning" data-toggle="tooltip" title="Escriba el nombre del proveedor" class="mensaje" ></i>
                                        <input type="text" class="form-control" id="empresa" name="empresa" value="" required="true" />
                                    </div>                                                                   
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Comentarios/Asunto:</label>
                                        <i class="fa fa-fw fa-question-circle text-warning" data-toggle="tooltip" title="Escriba comentarios, motivo y anotaciones pertinentes." class="mensaje" onclick="return false;"></i>
                                        <textarea class="form-control" id="comentarios" name="comentarios" rows="5" required="true"></textarea>
                                    </div>                                    
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Personal de apoyo:</label>
                                        <i class="fa fa-fw fa-question-circle text-warning" data-toggle="tooltip" title="Escriba personal que acudir&aacute; y/o apoyar&aacute; al visitante." class="mensaje" onclick="return false;"></i>
                                        <textarea class="form-control" id="personal_apoyo" name="personal_apoyo" rows="5" required="true"></textarea>
                                    </div>                                    
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Fecha visita:</label>     
                                        <i class="fa fa-fw fa-question-circle text-warning" data-toggle="tooltip" title="Fecha en la que el proveedor registrar&aacute; la visita." class="mensaje" onclick="return false;"></i>
                                        <input class="form-control" name="fecha_visita" id="fecha_visita" type="date" value="<?php echo date("Y-m-d"); ?>" />
                                    </div>                                   
                                    <div class="form-group">
                                        <input type="checkbox" name="notificacion" id="notificacion" value="1"> <label for="cbox2">Notificar a Administraci&oacute;n de finanzas.</label>
                                        <label for="exampleInputPassword1"></label>     
                                        <i class="fa fa-fw fa-question-circle text-warning" data-toggle="tooltip" title="Seleccione la casilla si la visita requiere autorizaci&oacute;n por parte de DAF." class="mensaje" onclick="return false;"></i>
                                    </div>                                   
                                    <br />                                 
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-block btn-warning" id="send_output_p"><i class="fa fa-support"></i> Registrar visita</button>
                                        <input type="hidden" name="evento" id="evento" value="11" />
                                        <input type="hidden" name="valor" id="valor" value="0" />
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
                    </form>
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
    <script src="../dist/js/select2-4.0.3/dist/js/select2.full.min.js" type="text/javascript"></script> 


    <script type="text/javascript">
                                            $(document).ready(function () {
                                                $('[data-toggle="tooltip"]').tooltip();


                                                $("#suppliers_check").submit(function (event) {
                                                    event.preventDefault();
                                                    var formData = $("#suppliers_check").serializeArray();
                                                    $("#send_output_p").prop("disabled", true);
                                                    $.ajax({
                                                        type: "POST",
                                                        url: '../controller/dafController.php',
                                                        data: formData,
                                                        dataType: 'json',
                                                        beforeSend: function () {
                                                            console.log("Insertando solicitud");
                                                            $("#msg").html('<div class="text-center"><i class="fa fa-spinner fa-spin" style="font-size:48px; color: #F49625"></i><br /><b class="text-center">Procesando informaci&oacute;n...<b></div>');
                                                        },
                                                        success: function (response) {
                                                            if (response.errorCode === 0) {
                                                                showAlert(response.msg, "Informaci&oacute;n enviada correctamente", "success", "bounce");
                                                                setTimeout(function () {
                                                                    $("#send_output_p").prop("disabled", false);
                                                                    location.reload();
                                                                }, 1500);
                                                            } else {
                                                                showAlert("¡Error!", response.msg, "error", "swing");
                                                            }
                                                        },
                                                        error: function (a, b, c) {
                                                            console.log(a, b, c);
                                                            showAlert("¡Error!", "Tu sesi&oacute;n ha caducado.", "error", "swing");
//                                                            setTimeout(function () {
//                                                                window.location.href = "dashboard.php";
//                                                            }, 2500);
                                                        }
                                                    });
                                                });
                                            });


    </script>
</body>
