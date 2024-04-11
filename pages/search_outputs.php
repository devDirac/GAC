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
                    Consulta de solicitudes de salida
                    <small>[material y equipo]</small>
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
                                        <input class="form-control" name="fecha_inicio" id="fecha_inicio" type="date" value="" />
                                    </div>
                                    <div class="col-lg-4 form-group">
                                        Fecha fin
                                        <input class="form-control" name="fecha_fin" id="fecha_fin" type="date" value="" />
                                    </div>
                                    <div class="col-lg-4 form-group">  
                                        &nbsp;
                                        <button name="enviar" id="enviar" value="Buscar" onclick="search_outs();" class="btn btn-block btn-primary" >Buscar</button>
                                    </div>
                                </div>
                                <!--</form>-->
                            </div>
                        </div> 
                        <div class="box-body">
                            <table id="projects" class="table table-bordered dt-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Persona asignada</th>
                                        <th>Solicitante</th>
                                        <th>Descripci&oacute;n</th>
                                        <th>Destino</th>
                                        <th>Fecha s&aacute;lida</th>
                                        <th>Destinatario</th>
                                        <th>Vigencia</th>
                                        <th>Documento</th>
                                        <th>Salida registrada</th>
                                        <th>Registr&oacute; salida</th>
                                        <th>Comentarios</th>
                                        <th>Estatus</th>
                                        <!--<th>Opciones</th>-->
                                    </tr>
                                </thead>
                                <tbody id="dirac_outputs">
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
                                                $("#projects").dataTable({
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
                                            function search_outs() {
                                                $("#projects").dataTable().fnDestroy();
                                                $("#dirac_outputs").html("");
                                                var q = "1=1";
                                                $.post("../controller/dafController.php",
                                                        {evento: 6, fecha_inicio: $("#fecha_inicio").val(), fecha_fin: $("#fecha_fin").val()},
                                                        function (response) {
                                                            if (response.errorCode === 0) {
                                                                console.log(response.data);
                                                                var records = '';
                                                                $.each(response.data, function (index, value) {
                                                                    records += '<tr>';
                                                                    records += '<td>' + value.id + '</td>';
                                                                    records += '<td>' + value.solicitante + '</td>';
                                                                    records += '<td>' + value.nombre + '</td>';
                                                                    records += '<td>' + value.descripcion + '</td>';
                                                                    records += '<td>' + value.destino + '</td>';
                                                                    records += '<td>' + value.fecha_salida + '</td>';
                                                                    records += '<td>' + value.destinatario + '</td>';
                                                                    records += '<td>' + value.vigencia + ' d&iacute;as</td>';
                                                                    records += '<td><a href="../documentos_salida/' + value.archivo + '" target="_blank">' + value.archivo + '</a></td>';
                                                                    records += '<td>' + value.hora_salida + '</td>';
                                                                    records += '<td>' + value.persona_salida_nombre + '</td>';
                                                                    records += '<td>' + value.comentarios + '</td>';



                                                                    var estatus = "";
                                                                    switch (parseInt(value.estatus_envio)) {
                                                                        case 0:
                                                                            estatus += "<b class='text-yellow'>Por enviar<b/>/";
                                                                            break;
                                                                        case 1:
                                                                            estatus += "<b class='text-primary'>Enviado<b/>/";
                                                                            break;
                                                                        case 2:
                                                                            estatus += "<b class='text-success'>Recepci&oacute;n confirmada<b/>/";
                                                                            break;
                                                                        default:

                                                                            break;
                                                                    }
                                                                    switch (parseInt(value.estatus)) {
                                                                        case 1:
                                                                            estatus += "<b class='text-yellow'>Creada</b>";
                                                                            break;
                                                                        case 2:
                                                                            estatus += "<b class='text-danger'>Rechazada</b>";
                                                                            break;
                                                                        case 3:
                                                                            estatus += "<b class='text-success'>Autorizada</b>";
                                                                            break;
                                                                        case 4:
                                                                            estatus += "<b class='text-danger'>Eliminada</b>";
                                                                            break;
                                                                        default:
                                                                            break;
                                                                    }

                                                                    records += '<td class="text-bold text-yellow">' + estatus + '</td>';
                                                                    records += '</tr>';
                                                                });
                                                                $("#dirac_outputs").append(records);
                                                                $("#projects").dataTable({
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
