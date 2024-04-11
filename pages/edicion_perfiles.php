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
                    Edici&oacute;n de perfiles
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
                            <!--                            <div class="row">
                                                            <div class="col-lg-offset-9 col-lg-3">
                                                                <a href="#" class="btn btn-block btn-warning btn-flat center-block" onclick="agregarTipoSolicitud();"><i class="fa fa-plus"></i> Agregar tipo de solicitud</a>
                                                            </div>
                                                        </div>-->
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div id="msg"></div>
                            <table id="perfiles" class="table dt-responsive nowrap table-responsive text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Usuario</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead> 
                                <tbody id="dirac_perfiles">
                                    <?php
                                    $users = $model->getInfoUsrsView("(id_direccion = 6 AND nivel = 'A' AND status = 1) OR (id_direccion = 2 AND nivel = 'A' AND status = 1) OR (id_area = 5 AND status = 1)");
                                    $perfiles = $model->getParams1("direccion LIKE '%GAC%'");
                                    
                                    foreach ($perfiles["data"] as $key => $p) {
                                        echo '<tr>';
                                        echo '<td>' . $p["id"] . '</td>';
                                        echo '<td>' . $p["parametro"] . '</td>';
                                        echo '<td>';
                                        echo '<select class="form-control" name="perfil_' . $p["id"] . '" id="perfil_' . $p["id"] . '">';
                                        foreach ($users["data"] as $key2 => $u) {
                                            if (intval($u["id_usuario"]) === intval($p["valor"])) {
                                                echo '<option value="' . $u["id_usuario"] . '" selected="true">' . $u["nombre"] . ' ' . $u["apellidos"] . '</option>';
                                            } else {
                                                echo '<option value="' . $u["id_usuario"] . '">' . $u["nombre"] . ' ' . $u["apellidos"] . '</option>';
                                            }
                                        }
                                        echo '</select>';
                                        echo '</td>';
                                        echo '<td>';
                                        echo '<button class="btn btn-flat btn-primary" onclick="editInfo(' . $p["id"] . ');" data-toggle="tooltip" title="Guardar cambios"> <i class="fa fa-save"></i> </button>';
//                                        echo '<button class="btn btn-flat btn-danger" onclick="deleteInfo(' . $e["id"] . ');" data-toggle="tooltip" title="Eliminar registro"> <i class="fa fa-times"></i> </button>';
                                        echo '</td>';
                                        echo '</tr>';
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
            initTable("perfiles");
 
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
        function editInfo(id) {
            $.ajax({
                type: "POST",
                url: '../controller/controller.php',
                data: {evento: 5, id: id, valor: $("#perfil_" + id).val()},
                dataType: 'json',
                beforeSend: function () {
//                console.log("Replace project....");
                    $("#msg").html('<div class="text-center"><i class="fa fa-spinner fa-spin" style="font-size:48px; color: #F49625"></i><p><b class="text-center"><b></p></div>');
                },
                success: function (response) {
                    if (response.errorCode === 0) {
                        $("#msg").html('');
                        showAlert(response.msg, "Informaci&oacute;n actualizada correctamente", "success", "bounce");
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

       
    </script>
</body>
