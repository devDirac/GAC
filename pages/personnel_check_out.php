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
                    Salida de Personal
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
                    <form method="POST" role="form" name="personnel_check" id="personnel_check">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <div class="form-group">
                                        <label for="direccion">Persona saldr&aacute;:</label>
                                        <i class="fa fa-fw fa-question-circle text-warning" data-toggle="tooltip" title="Persona que saldr&aacute;" class="mensaje" onclick="return false;"></i>
                                        <div id="myUsrs">
                                            <select class="form-control" name="id_usuario" id="id_usuario" required>
                                                <option value="0">Seleccione usuario</option>
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
                                            <select class="form-control" name="id_usuario1" id="id_usuario" required>
                                                <option value="0">Seleccione usuario</option>

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
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Destino:</label>
                                        <i class="fa fa-fw fa-question-circle text-warning" data-toggle="tooltip" title="Escriba destino d ela persona que saldr&aacute;" class="mensaje" onclick="return false;"></i>
                                        <textarea class="form-control" id="destino" name="destino" rows="5" required="true"></textarea>
                                    </div>                                    
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Comentarios/Asunto:</label>
                                        <i class="fa fa-fw fa-question-circle text-warning" data-toggle="tooltip" title="Escriba comentarios, motivo y anotaciones pertinentes." class="mensaje" onclick="return false;"></i>
                                        <textarea class="form-control" id="comentarios" name="comentarios" rows="5" required="true"></textarea>
                                    </div>                                    
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Fecha de salida:</label>     
                                        <i class="fa fa-fw fa-question-circle text-warning" data-toggle="tooltip" title="Fecha en la que saldr&aacute; la persona." class="mensaje" onclick="return false;"></i>
                                        <input class="form-control" name="fecha_salida" id="fecha_salida" type="date" value="<?php echo date("Y-m-d"); ?>" />
                                    </div>                                   
                                    <br />                                 
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-block btn-warning" id="send_output_p">Enviar</button>
                                        <input type="hidden" name="evento" id="evento" value="9" />
                                        <input type="hidden" name="valor" id="valor" value="0" />
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <br />&nbsp;
                                        <a href="#" onclick="showAllUsrs();" class="btn btn-primary" data-toggle="tooltip" title="Otro usuario"><i class="fa fa-plus-circle"></i></a>
                                        <!--<a href="#" onclick="writeUsrs();" class="btn btn-primary" data-toggle="tooltip" title="Escribir usuario"><i class="fa fa-users"></i></a>-->
                                    </div>
                                    <br />
                                    <br />                              
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


    <script>
                                            $(document).ready(function () {
                                                $('[data-toggle="tooltip"]').tooltip();
                                                $('#id_usuario').select2();


                                                $("#personnel_check").submit(function (event) {
                                                    event.preventDefault();
                                                    if (parseInt($('select[name=id_usuario]').val()) === 0) {
                                                        if (parseInt($('select[name=id_usuario1]').val()) === 0) {
                                                            showAlert("¡Error!", "Favor de ingresar un usuario", "error", "swing");
                                                        } else {
                                                            checkPersonnel();
                                                        }
                                                    } else {
                                                        checkPersonnel();
                                                    }
                                                });
                                            });


                                            function checkPersonnel() {
                                                var formData = $("#personnel_check").serializeArray();
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
                                                        setTimeout(function () {
                                                            window.location.href = "dashboard.php";
                                                        }, 2500);
                                                    }
                                                });
                                            }
                                            function showAllUsrs() {
                                                if (parseInt($("#valor").val()) === 0) {
                                                    $("#myUsrs").hide("slow");
                                                    $("#allUsrs").show("slow");
                                                    $("#valor").val("1");
                                                    $('select[name=id_usuario]').val('0');
                                                    $('select[name=id_usuario]').trigger('change');
                                                } else {
                                                    $("#myUsrs").show("slow");
                                                    $("#allUsrs").hide("slow");
                                                    $("#valor").val("0");
                                                    $('select[name=id_usuario1]').val('0');
                                                    $('select[name=id_usuario1]').trigger('change');
                                                }

                                                setTimeout(function () {
                                                    $('select[name*=id_usuario1]').select2();
                                                }, 1000);
                                            }

                                            function writeUsrs() {
                                                $("#myUsrs").hide("slow");
                                                $("#allUsrs").hide("slow");
                                                $("#otUsrs").show("slow");
                                            }

                                            function writeD() {
                                                $("#otherD").toggle("slow");
                                                $("#id_destinatario").toggle("slow");
                                            }
    </script>
</body>
