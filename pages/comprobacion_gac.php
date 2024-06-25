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
                    Carga de comprobantes
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
                            <div id="msg"></div>
                            <div id="carga_de_comprobantes">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h3 class="box-title">Solicitudes </h3>
                                        <br />
                                        <form name="carga_comp" id="carga_comp">

                                            <div class="row">
                                                <div class="col-lg-12 center-block text-center">
                                                    <div class="form-group form-inline">
                                                        <label>Seleccione solicitud: </label>
                                                        <?php
//                                                        $mis_solicitudes = $model->getSolicitudesGAC("beneficiario = " . $_SESSION["sgi_id_usr"] . " AND estatus = 3 AND id_tipo = 1");
                                                        $mis_solicitudes = $model->getInfoSolicitudesGAC("(S.solicita = " . $_SESSION["sgi_id_usr"] . " OR S.beneficiario = " . $_SESSION["sgi_id_usr"] . ") AND S.estatus = 3 AND C.tipo = 2");
                                                        echo '<select class="form-control" name="id_solicitud" id="id_solicitud" onchange="getComprobantes();" required="true">';
                                                        echo '<option value="0">Seleccione solicitud</option>';
                                                        foreach ($mis_solicitudes["data"] as $key2 => $ms) {
                                                            echo '<option value="' . $ms["id"] . '">' . $ms["descripcion"] . ' [$' . number_format($ms["importe"], 2) . ']</option>';
                                                        }
                                                        echo '</select>';
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <h3 class="text-center">Carga de comprobantes</h3>
                                                <hr />
                                                <input type="hidden" name="id_comprobante" id="id_comprobante" value="" />
                                                <div class="form-group-inline">
                                                    <label for="importe">Importe:</label>
                                                    <input type="number" step="0.01" name="importe" id="importe" class="form-control" max="1000" min="1" />
                                                </div>
                                                <div class="form-group-inline">
                                                    <label for="descripcion">Descripci&oacute;n:</label>
                                                    <textarea name="descripcion" id="descripcion" class="form-control"></textarea>
                                                </div>
                                                <br />
                                                <div class="form-group-inline">
                                                    <label for="fecha">Fecha:</label>
                                                    <input type="date" name="fecha" id="fecha" class="form-control" value="<?php echo date("Y-m-d"); ?>" />
                                                    <input type="hidden" name="evento" id="evento" value="7" />
                                                    <input type="hidden" name="estatus" id="estatus" value="0" />
                                                </div>
                                                <br />
                                                <div class="form-group-inline">
                                                    <button type="submit" class="btn btn-block btn-warning" id="btn_save_c"><i class="fa fa-save"></i> Guardar comprobante</button>
                                                    <button type="button" class="btn btn-block btn-info" onclick="othrComp();"><i class="fa fa-save"></i> Registrar otro comprobante</button>
                                                </div>
                                                <div id="msg_dz"></div>
                                                <br />
                                                <div class="form-group-inline" id="upFiles" style="pointer-events: none; opacity: 0.4;">
                                                    <label for="myDrop" class="text-xs"> Carga de archivos: </label>
                                                    <div class="dropzone" id="myDrop"></div>
                                                </div>
                                            </div>
                                        </form>

                                        <div class="col-lg-6">
                                            <form id="archivos_comp" name="archivos_comp">
                                                <h3 class="text-center">Archivos cargados</h3>
                                                <hr />
                                                <div id="comprobantes_cargados"></div>          
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>                                
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
    <!--<script type="text/javascript" src="<?php // echo SYSTEM_PATH                    ?>dist/js/pages/projects.js?v1.0"></script>-->
    <script type="text/javascript">
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
                                                                    myDropzone.removeAllFiles();
                                                                    getComprobantes();
                                                                }, 1500);
                                                            } else {
                                                                showAlert("¡Error!", response.msg, "error", "swing");
                                                                myDropzone.removeAllFiles();
                                                            }

                                                        });
                                                        /* *********************** DROPZONE ************************* */

                                                        $(document).ready(function () {

                                                            getIDParam();
                                                            $("#carga_comp").submit(function (event) {
                                                                if (parseInt($("#id_solicitud").val()) !== 0) {
                                                                    event.preventDefault();

                                                                    var importe = parseFloat($("#importe").val());
                                                                    var por_comprobar = parseFloat($("#por_comprobar").val());
                                                                    if(importe > por_comprobar){
                                                                        $("#msg").html('<div class="text-center"><i class="fa fa-spinner fa-warning" style="font-size:48px; color: #F49625"></i><p> El importe restante es mayor se recomeinda realizar una solicitud de reembolso.<b class="text-center"><b></p></div>');
                                                                    }
                                                                    $.ajax({
                                                                        type: "POST",
                                                                        url: '../controller/controller.php',
                                                                        data: $("#carga_comp").serializeArray(),
                                                                        dataType: 'json',
                                                                        beforeSend: function () {
//                console.log("Replace project....");
                                                                            $("#msg").html('<div class="text-center"><i class="fa fa-spinner fa-spin" style="font-size:48px; color: #F49625"></i><p><b class="text-center"><b></p></div>');
                                                                        },
                                                                        success: function (response) {
                                                                            if (response.errorCode === 0) {
                                                                                showAlert(response.msg, "Informaci&oacute;n actualizada correctamente", "success", "bounce");
                                                                                $("#id_comprobante").val(response.data);
                                                                                $("#upFiles").css("pointer-events", "");
                                                                                $("#upFiles").css("opacity", "");
                                                                                getComprobantes();
                                                                                $("#btn_save_c").prop("disabled", true);
                                                                                $("#msg").html('');
                                                                            } else {
                                                                                showAlert("¡Error!", response.msg, "error", "swing");
                                                                            }
                                                                        },
                                                                        error: function (a, b, c) {
                                                                            console.log(a, b, c);
                                                                        }
                                                                    });
                                                                } else {
                                                                    showAlert("¡Error!", "Selecciona una solicitud", "error", "swing");
                                                                    return false;
                                                                }
                                                            });

                                                            $("#archivos_comp").submit(function (event) {
                                                                event.preventDefault();
                                                                $.ajax({
                                                                    type: "POST",
                                                                    url: '../controller/controller.php',
                                                                    data: $("#archivos_comp").serializeArray(),
                                                                    dataType: 'json',
                                                                    beforeSend: function () {
//                console.log("Replace project....");
                                                                        $("#msg_p_files").html('<div class="text-center"><i class="fa fa-spinner fa-spin" style="font-size:48px; color: #F49625"></i><p><b class="text-center"><b></p></div>');
                                                                    },
                                                                    success: function (response) {
                                                                        if (response.errorCode === 0) {
                                                                            showAlert(response.msg, "Informaci&oacute;n actualizada correctamente", "success", "bounce");
                                                                            getComprobantes();
                                                                            $("#msg_p_files").html('');
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

                                                        function othrComp() {
                                                            $("#carga_comp")[0].reset();
                                                            $("#id_comprobante").val(0);
                                                            $("#upFiles").css("pointer-events", "none");
                                                            $("#upFiles").css("opacity", "0.4");
                                                            $("#btn_save_c").prop("disabled", false);
                                                        }

                                                        function getIDParam() {
                                                            let searchParams = new URLSearchParams(window.location.search);
                                                            if (searchParams.has("id")) {
                                                                let par = searchParams.get("id");
                                                                $("#id_solicitud").val(par);
                                                                getComprobantes();
                                                            }
                                                        }


    </script>
</body>
