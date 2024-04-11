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
                    Catalogo de tipos de solicitudes
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
                            <div class="row">
                                <div class="col-lg-offset-9 col-lg-3">
                                    <a href="#" class="btn btn-block btn-warning btn-flat center-block" onclick="agregarTipoSolicitud();"><i class="fa fa-plus"></i> Agregar tipo de solicitud</a>
                                </div>
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div id="msg"></div>
                            <table id="egresos" class="table dt-responsive nowrap table-responsive text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Descripci&oacute;n</th>
                                        <th>Tope</th>
                                        <th>Notificar a</th>
                                        <th>Limite inf. p/not.</th>
                                        <th>Estatus</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead> 
                                <tbody id="dirac_solicitudes">
                                    <?php
                                    $users = $model->getInfoUsrsView("nivel = 'A' AND status = 1");
                                    $t_solicitudes = $model->getTipoSolicitudes("1=1");
                                    $estat = array();
                                    $estat[1] = "Activo";
                                    $estat[0] = "Inactivo";
                                    foreach ($t_solicitudes["data"] as $key => $e) {

                                        $readonly = "";
                                        $disabled = "";

                                        if ($e["descripcion"] === "caja_chica" || $e["descripcion"] === "Reembolso" || $e["descripcion"] === "Pago de Proveedores") {
                                            $disabled = "disabled";
                                            $readonly = "readonly";
                                        }

                                        echo '<tr>';
                                        echo '<td>' . $e["id"] . '</td>';
                                        echo '<td><input type="text" class="form-control" name="nombre" id="nombre_' . $e["id"] . '" value="' . $e["nombre"] . '" ' . $readonly . ' /></td>';
                                        echo '<td><input type="text" class="form-control" name="descripcion" id="descripcion_' . $e["id"] . '" value="' . $e["descripcion"] . '" ' . $readonly . ' /></td>';
                                        echo '<td><input type="text" class="form-control" name="tope" id="tope_' . $e["id"] . '" value="' . $e["tope"] . '" /></td>';
                                        echo '<td>';
                                        echo '<select class="form-control" name="id_notificacion_' . $e["id"] . '" id="id_notificacion_' . $e["id"] . '">';
                                        foreach ($users["data"] as $key2 => $u) {
                                            if (intval($u["id_usuario"]) === intval($e["id_notificacion"])) {
                                                echo '<option value="' . $u["id_usuario"] . '" selected="true">' . $u["nombre"] . ' ' . $u["apellidos"] . '</option>';
                                            } else {
                                                echo '<option value="' . $u["id_usuario"] . '">' . $u["nombre"] . ' ' . $u["apellidos"] . '</option>';
                                            }
                                        }
                                        echo '</select>';
                                        echo '</td>';
                                        if (is_null($e["limite_inferior"])) {
                                            echo '<td>N/A</td>';
                                        } else {
                                            echo '<td><input type="text" class="form-control" name="limite_inferior" id="limite_inferior_' . $e["id"] . '" value="' . $e["limite_inferior"] . '" /></td>';
                                        }
                                        echo '<td>';
                                        echo '<select class="form-control" name="estatus_' . $e["id"] . '" id="estatus_' . $e["id"] . '">';
                                        foreach ($estat as $key3 => $value) {
                                            if (intval($e["estatus"]) === $key3) {
                                                echo '<option value="' . $key3 . '" selected="true">' . $value . '</option>';
                                            } else {
                                                echo '<option value="' . $key3 . '">' . $value . '</option>';
                                            }
                                        }
                                        echo '</select></td>';
                                        echo '<td>';
                                        echo '<button class="btn btn-flat btn-primary" onclick="editInfo(' . $e["id"] . ');" data-toggle="tooltip" title="Guardar cambios"> <i class="fa fa-save"></i> </button>';
                                        echo '<button class="btn btn-flat btn-danger" onclick="deleteInfo(' . $e["id"] . ');" data-toggle="tooltip" title="Eliminar registro" ' . $disabled . '> <i class="fa fa-times"></i> </button>';
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
                                            initTable("egresos");

                                            $("#agregarTipoSolicitud").submit(function (event) {
                                                event.preventDefault();
                                                $.ajax({
                                                    type: "POST",
                                                    url: '../controller/pmController.php',
                                                    data: $("#agregarTipoSolicitud").serializeArray(),
                                                    dataType: 'json',
                                                    beforeSend: function () {
//                console.log("Replace project....");
                                                        $("#msgE").html('<div class="text-center"><i class="fa fa-spinner fa-spin" style="font-size:48px; color: #F49625"></i><p><b class="text-center"><b></p></div>');
                                                    },
                                                    success: function (response) {
                                                        if (response.errorCode === 0) {
                                                            showAlert(response.msg, "Informaci&oacute;n actualizada correctamente", "success", "bounce");
                                                            getEgresos();
                                                        } else {
                                                            showAlert("¡Error!", response.msg, "error", "swing");
                                                        }
                                                    },
                                                    error: function (a, b, c) {
                                                        console.log(a, b, c);
                                                    }
                                                });
                                            });
                                            $("#editEgreso").submit(function (event) {
                                                event.preventDefault();
                                                $.ajax({
                                                    type: "POST",
                                                    url: '../controller/pmController.php',
                                                    data: $("#editEgreso").serializeArray(),
                                                    dataType: 'json',
                                                    beforeSend: function () {
//                console.log("Replace project....");
                                                        $("#msgE").html('<div class="text-center"><i class="fa fa-spinner fa-spin" style="font-size:48px; color: #F49625"></i><p><b class="text-center"><b></p></div>');
                                                    },
                                                    success: function (response) {
                                                        if (response.errorCode === 0) {
                                                            showAlert(response.msg, "Informaci&oacute;n actualizada correctamente", "success", "bounce");
                                                            getEgresos();
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
                                        function getEgresos(query) {
                                            $.ajax({
                                                type: "POST",
                                                url: '../controller/pmController.php',
                                                data: {evento: 15, query: query},
                                                dataType: 'json',
                                                beforeSend: function () {
                                                    console.log("Get egresos .....");
                                                },
                                                success: function (response) {
                                                    if (response.errorCode === 0) {
                                                        console.log(response);
                                                        var requests = "";
                                                        $.each(response.data, function (index, value) {
                                                            var act_btn = "";
                                                            var valor = 2;
                                                            var color = "red";
                                                            requests += '<tr>'
                                                                    + '<td>' + value.id + '</td>'
                                                                    + '<td>' + value.nombre + '</td>'
                                                                    + '<td>' + value.descripcion + '</td>';
                                                            if (parseInt(value.estatus) === 1) {
                                                                requests += '<td class="text-success"><b>Activo<b></td>';
                                                                act_btn = "ban";
                                                            } else if (parseInt(value.estatus) === 2) {
                                                                requests += '<td class="text-danger"><b>Inactivo<b></td>';
                                                                act_btn = "check";
                                                                valor = 1;
                                                                color = "green";
                                                            } else if (parseInt(value.estatus) === 3) {
                                                                requests += '<td class="text-primary"><b>Terminado<b></td>';
                                                            } else {
                                                                requests += '<td class="text-warning"><b>Nuevo<b></td>';
                                                            }
                                                            requests += '<td>'
                                                                    + '<form name="editEgreso" id="editEgreso" method="POST" action="new_project.php" data-toggle="tooltip" title="Editar egreso">'
                                                                    + '<input type="hidden" name="id" value="' + value.id + '" />'
                                                                    + '<input type="hidden" name="valor" value="' + valor + '" />'
                                                                    + '<input type="hidden" name="evento" value="" />'
                                                                    + '<button type="submit" class="btn btn-primary btn-flat text-' + color + '"><li class="fa fa-' + act_btn + '"></li></button>'
                                                                    + '</form></td></tr>';
//                                                                    + '<a href="#" class="btn btn-primary btn-flat"><li class="fa fa-folder-open" data-toggle="tooltip" title="Crear carpeta de proyecto" onclick="createFolder(' + value.id + ',\'' + value.clave + '\');"></li></a></td>';
                                                        });
                                                        $("#dirac_egresos").append(requests);
                                                        initTable("egresos");
                                                    } else {
                                                        console.log(response);
                                                    }
                                                },
                                                error: function (a, b, c) {
                                                    console.log(a, b, c);
                                                }
                                            });
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
                                        function editInfo(id) {
                                            $.ajax({
                                                type: "POST",
                                                url: '../controller/controller.php',
                                                data: {evento: 1, id: id, estatus: $("#estatus_" + id).val(), nombre: $("#nombre_" + id).val(), descripcion: $("#descripcion_" + id).val(), tope: $("#tope_" + id).val(), id_notificacion: $("#id_notificacion_" + id).val(), limite_inferior: $("#limite_inferior_" + id).val()},
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

                                        function addTSolicitud() {
                                            $.ajax({
                                                type: "POST",
                                                url: '../controller/controller.php',
                                                data: {evento: 4, estatus: $("#estatus_").val(), nombre: $("#nombre_").val(), descripcion: $("#descripcion_").val(), tope: $("#tope_").val(), id_notificacion: $("#id_notificacion_").val()},
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


                                        function deleteInfo(id) {
                                            swal({
                                                title: '¿Estas seguro?',
                                                text: "¡Esta operación es irreversible!",
                                                type: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#3085d6',
                                                cancelButtonColor: '#d33',
                                                confirmButtonText: '¡Si, eliminar!',
                                                cancelButtonText: 'Cancelar'
                                            }).then(function () {
                                                $.post("../controller/controller.php", {evento: 2, id: id}, function (response) {
                                                    if (response.errorCode === 0) {
                                                        showAlert(response.msg, "Informaci&oacute;n actualizada correctamente", "success", "bounce");
                                                        setTimeout(window.location.reload(), 1500);
                                                    } else {
                                                        showAlert("¡Error!", response.msg, "error", "swing");
                                                    }
                                                }, 'json');
                                            });
                                        }

                                        function agregarTipoSolicitud() {
                                            var form = "";

                                            $.post("../controller/controller.php", {evento: 3, query: "nivel = 'A' AND status = 1"}, function (response) {
                                                console.log(response);
                                                if (response.errorCode === 0) {
                                                    form += '<tr>';
                                                    form += '<td>#</td>';
                                                    form += '<td><input type="text" class="form-control" name="nombre" id="nombre_" value="" /></td>';
                                                    form += '<td><input type="text" class="form-control" name="descripcion" id="descripcion_" value="" /></td>';
                                                    form += '<td><input type="text" class="form-control" name="tope" id="tope_" value="" /></td>';
                                                    form += '<td>';
                                                    form += '<select class="form-control" name="id_notificacion_" id="id_notificacion_">';
                                                    $.each(response.data, function (index, value) {
                                                        form += '<option value="' + value.id_usuario + '">' + value.nombre + ' ' + value.apellidos + '</option>';
                                                    });
                                                    form += '</select>';
                                                    form += '</td>';
                                                    form += '<td><select class="form-control" name="estatus_" id="estatus_"><option value="1" selected="true">Activo</option>'
                                                            + '<option value="0">Inactivo</option></select></td>';
                                                    form += '<td><button class="btn btn-warning" onclick="addTSolicitud();"> <i class="fa fa-plus"></i> Agregar tipo</button></td>';
                                                    form += '</tr>';
//                                            console.log(form);
                                                    $("#dirac_solicitudes").prepend(form);
                                                } else {
                                                    showAlert("¡Error!", response.msg, "error", "swing");
                                                }
                                                console.log(form);
                                            }, 'json');
                                        }

    </script>
</body>
