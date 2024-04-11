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
                                    <div class="col-lg-6">
                                        <input type="hidden" name="id_solicitud" id="id_solicitud" value="<?php echo $_REQUEST["id"]; ?>" />
                                        <input type="hidden" name="id_comprobante" id="id_comprobante" value="0" />
                                        <br />
                                        <br />
                                        <br />
                                        <div class="form-group-inline" id="upFiles" >
                                            <label for="myDrop" class="text-xs"> Carga de archivos: </label>
                                            <div class="dropzone" id="myDrop"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <form id="archivos_comp" name="archivos_comp">
                                            <h3 class="text-center">Archivos cargados</h3>
                                            <hr />
                                            <div id="comprobantes_cargados"></div>          
                                        </form>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="col-lg-offset-6 col-lg-6">
                                                    <button onclick="sendNot();" class="btn btn-block btn-primary" name="sendNot" id="sendNot"><i class="fa fa-mail-forward"></i> Enviar notificacion</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

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
    </div><!-- ./wrapper -->    
    <script type="text/javascript" src="<?php echo SYSTEM_PATH ?>dist/js/pages/login.js"></script>
    <script type="text/javascript" src="<?php echo SYSTEM_PATH ?>dist/js/pages/utils.js"></script>
    <!--<script type="text/javascript" src="<?php // echo SYSTEM_PATH                                                                             ?>dist/js/pages/projects.js?v1.0"></script>-->
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
                                                            getComprobantes();

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
                                                                url: '../controller/getArchivosComprobantes.php',
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
 
                                                        function sendNot() {
                                                            $.ajax({
                                                                type: "POST",
                                                                url: '../controller/controller.php',
                                                                data: {id: $("#id_solicitud").val(), evento: 22},
                                                                dataType: 'json',
                                                                beforeSend: function () {//                console.log("Replace project....");
                                                                    $("#comprobantes_cargados").html('<div class="text-center"><i class="fa fa-spinner fa-spin" style="font-size:48px; color: #F49625"></i><p><b class="text-center"><b></p></div>');
                                                                },
                                                                success: function (response) {
                                                                    $("#comprobantes_cargados").html('<b class="text-success">' + response.msg + '</b>');
                                                                    setTimeout(function () {
                                                                        getComprobantes();
                                                                    }, 1000);

                                                                },
                                                                error: function (a, b, c) {
                                                                    console.log(a, b, c);
                                                                }
                                                            });
                                                        }
    </script>
</body>
