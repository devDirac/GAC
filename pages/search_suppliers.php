<?php
require_once '../snippets/header.php';
require_once '../model/DAF.php';

$daf = DAF::DAFSngltn();
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
                    Consulta de visita de proveedores
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
                            <div class="row">
                                <!--<form name="search_records" id="search_records">-->
                                <div class="col-lg-12">
                                    <div class="col-lg-4 form-group">
                                        Fecha inicio
                                        <input class="form-control" name="fecha_inicio" id="fecha_inicio" type="date" value="<?php echo date("Y-m-d"); ?>" />
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        Fecha fin
                                        <input class="form-control" name="fecha_fin" id="fecha_fin" type="date" value="<?php echo date("Y-m-d"); ?>" />
                                    </div>
                                    <div class="col-lg-4 form-group">  
                                        &nbsp;
                                        <button name="enviar" id="enviar" value="Buscar" onclick="search_suppliers();" class="btn btn-block btn-primary" >Buscar</button>
                                    </div>
                                </div>
                                <!--</form>-->
                            </div>
                        </div> 
                        <div class="box-body">
                            <table id="dirac_suppliers" class="table table-bordered dt-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Persona a quien visitan</th>
                                        <th>Proveedor</th>
                                        <th>Empresa</th>
                                        <th>Comentarios</th>                                        
                                        <th>Fecha visita</th>
                                        <th>Entrada</th>                                        
                                        <th>Salida</th>
                                    </tr>
                                </thead>
                                <tbody id="dirac_body_suppliers">
                                    <?php
//                                    $requests = $daf->getOutputs("estatus = 3");
//                                    foreach ($requests["data"] as $key => $req) {
//                                        $salida = $req["fecha_salida"];
//                                        $valid = strtotime('+5 day', strtotime($salida));
//                                        $valid = date('Y-m-d', $valid);
//
//                                        if (strtotime($valid) > strtotime(date("Y-m-d"))) {
//                                            
                                    ?>
<!--                                            <tr>
                                                <td>//<?php echo $req["id"]; ?></td>
                                                <td>//<?php echo $req["solicitante"]; ?></td>
                                                <td>//<?php echo $req["nombre"]; ?></td>
                                                <td>//<?php echo $req["descripcion"]; ?></td>
                                                <td>//<?php echo $req["destino"]; ?></td>
                                                <td>//<?php echo $req["fecha_salida"]; ?></td>
                                                <td>//<?php echo $req["comentarios"]; ?></td>
                                                    <td>
                                                    <h4><a href="auth" title="Autorizar Salida" class="text-success"><i class="fa fa-check-circle-o"></i> Autorizar</a></h4> 
                                                    <h4><a href="auth" title="Rechazar Salida" class="text-danger"><i class="fa fa-times-circle-o"></i> Rechazar</a></h4> 
                                                </td>                                    
                                            </tr>-->
                                    <?php
//                                        }
//                                    }
//                                    
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
    <script type="text/javascript" src="<?php echo SYSTEM_PATH ?>dist/js/pages/properties.js"></script>
    <script type="text/javascript" src="<?php echo SYSTEM_PATH ?>dist/js/pages/login.js"></script>
    <script type="text/javascript" src="<?php echo SYSTEM_PATH ?>dist/js/pages/utils.js"></script>
    <script type="text/javascript">

                                            $(document).ready(function () {
                                                $("#dirac_suppliers").dataTable({
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
                                            });
                                            function search_suppliers() {
                                                $("#dirac_suppliers").dataTable().fnDestroy();
                                                $("#dirac_body_suppliers").html("");
                                                var q = "1=1";
                                                $.post("../controller/dafController.php",
                                                        {evento: 12, fecha_inicio: $("#fecha_inicio").val(), fecha_fin: $("#fecha_fin").val()},
                                                function (response) {
                                                    if (response.errorCode === 0) {
                                                        console.log(response.data);
                                                        var records = '';
                                                        $.each(response.data, function (index, value) {
                                                            records += '<tr>';
                                                            records += '<td>' + value.id + '</td>';
                                                            records += '<td>' + value.nombre_usuario + '</td>';
                                                            records += '<td>' + value.nombre_proveedor + '</td>';
                                                            records += '<td>' + value.empresa + '</td>';
                                                            records += '<td>' + value.comentarios + '</td>';

                                                            var hoy = new Date();
                                                            var hoy = new Date();
                                                            var dd = hoy.getDate();
                                                            var mm = hoy.getMonth() + 1; //hoy es 0!
                                                            var yyyy = hoy.getFullYear();

                                                            if (dd < 10) {
                                                                dd = '0' + dd;
                                                            }
                                                            if (mm < 10) {
                                                                mm = '0' + mm;
                                                            }
                                                            hoy = yyyy + "-" + mm + "-" + dd;

                                                            var fechaFormulario = value.fecha_ingreso;


                                                            var color_fecha = '';

                                                            console.log("hoy: " + hoy);
                                                            console.log("FF: " + fechaFormulario);

                                                            if (hoy === fechaFormulario) {
                                                                console.log("IGUAL");
                                                                color_fecha = 'success';
                                                            } else if (hoy > fechaFormulario) {
                                                                console.log("MENOR");
                                                                color_fecha = 'warning';
                                                            } else {
                                                                console.log("DIFERENTE");
                                                                color_fecha = 'info';
                                                            }


                                                            records += '<td class="text-' + color_fecha + '">' + value.fecha_ingreso + '</td>';
                                                            var hora_entrada = "";
                                                            var hora_salida = "";

                                                            var color_salida = "success";
                                                            var color_regreso = "success";

                                                            if (value.hora_entrada !== null) {
                                                                hora_entrada = value.hora_entrada;
                                                            } else {
                                                                hora_entrada = "Sin registro"
                                                                color_salida = 'danger';
                                                            }

                                                            if (value.hora_salida !== null) {
                                                                hora_salida = value.hora_salida;
                                                            } else {
                                                                hora_salida = "Sin registro"
                                                                color_regreso = 'danger';
                                                            }
                                                            records += '<td class="text-' + color_salida + '">' + hora_entrada + '</td>';
                                                            records += '<td class="text-' + color_regreso + '">' + hora_salida + '</td>';
                                                            records += '</tr>';
                                                        });
                                                        $("#dirac_body_suppliers").append(records);
                                                        $("#dirac_suppliers").dataTable({
                                                            "order": [[4, "asc"]],
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

                                                    } else {
                                                        $("#msg").html("Ha ocurrido un error, por favor intente m&aacute;s tarde.");
                                                    }
                                                }, 'json');
                                            }

                                            function getUsr() {

                                            }

    </script>
</body>
