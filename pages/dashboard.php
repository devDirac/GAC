<?php
require_once '../snippets/header.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../model/Model.php';
require_once '../utils/Utils.php';

$model = Model::ModelSngltn();
$utils = Utils::utlsSngltn();
?>
<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #0e0e0e;
        border: 1px solid #171515;
        border-radius: 4px;
        cursor: default;
        float: left;
        margin-right: 5px;
        margin-top: 5px;
        padding: 0 5px;
    }
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
        color: #000000!important;
        line-height: 28px;
    }
    .modal-dialog {
        background-color: rgb(0,0,0) !important;
        /*width: max-content;*/
        /*width: 100%;*/

    }

    .modal-content{
        background-color: rgb(0 0 0 / 68%)!important;
    }

    .nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover {
        cursor: default;
        background-color: #00c0ef;
        color: #FFFFFF!important;
        border-bottom-color: transparent;
    }

    .nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover {
        cursor: default;
        background-color: #00c0ef;
        color: #FFFFFF!important;
        border-bottom-color: transparent;
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
                <h1 class="sweet-figg-title">
                    Dashboard
                    <small>[Solicitudes de gastos a comprobar]</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Dashboard</li>
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="box box-warning">
                        <div class="box-header">
                            <!--                            <h3 class="box-title text-center">Tablero de proyectos de &Aacute;rea. </h3>                            -->
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <h4 class="sweet-figg-title">Solicitudes gastos a comprobar</h4>                                    
                            <hr />
                            <div class="row">
                                <?php
                                //Mis Solicitudes activas como beneficiario o solicitnate
                                $solicitudes_activas = $model->getSolicitudesGAC("((solicita = " . $_SESSION["sgi_id_usr"] . " OR beneficiario = " . $_SESSION["sgi_id_usr"] . ") AND estatus != 9 AND estatus != 5) AND (estatus > 2 OR estatus < 7)");
                                //Pendientes DG
                                $solicitudes_dg = $model->getSolicitudesGAC("(solicita = " . $_SESSION["sgi_id_usr"] . " OR beneficiario = " . $_SESSION["sgi_id_usr"] . ") AND estatus = 2");
                                //Pendientes DAF
                                $solicitudes_daf = $model->getSolicitudesGAC("(solicita = " . $_SESSION["sgi_id_usr"] . " OR beneficiario = " . $_SESSION["sgi_id_usr"] . ") AND estatus = 1");
                                //pendientes de pago
                                $solicitudes_pago = $model->getSolicitudesGAC("(solicita = " . $_SESSION["sgi_id_usr"] . " OR beneficiario = " . $_SESSION["sgi_id_usr"] . ") AND estatus = 3");
                                //Pendientes de comprobar
                                $solicitudes_comp = $model->getSolicitudesGAC("(solicita = " . $_SESSION["sgi_id_usr"] . " OR beneficiario = " . $_SESSION["sgi_id_usr"] . ") AND estatus = 4");
                                ?>
                                <div class="col-lg-3 col-xs-6">
                                    <!-- small box -->
                                    <div class="small-box bg-aqua ">
                                        <div class="inner">
                                            <h3><div id="numSolicitud"><?php echo $solicitudes_activas["numElems"]; ?></div></h3>
                                            <p>Solicitudes activas<br> Beneficiario o solicitante</p>
                                        </div>
                                        <div class="icon icon-dashboard">
                                            <i class="fa fa-file-text-o"></i>
                                        </div>
                                        <a href="#" id="sc" class="small-box-footer" data-toggle="modal" data-target="#mis_solicitudes_activas">M&aacute;s informaci&oacute;n <i class="fa fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>                           
                                <div class="col-lg-3 col-xs-6">
                                    <!-- small box -->
                                    <div class="small-box bg-blue">
                                        <div class="inner">
                                            <h3><div id="numSolicitud"><?php echo $solicitudes_dg["numElems"]; ?></div></h3>
                                            <p>Pendientes de autorizaci&oacute;n<br> Direcci&oacute;n General</p>
                                        </div>
                                        <div class="icon icon-dashboard">
                                            <i class="fa fa-suitcase"></i>
                                        </div>
                                        <a href="#" id="sc" class="small-box-footer" data-toggle="modal" data-target="#mis_solicitudes_dg">M&aacute;s informaci&oacute;n <i class="fa fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>                           
                                <div class="col-lg-3 col-xs-6">
                                    <!-- small box -->
                                    <div class="small-box bg-green">
                                        <div class="inner">
                                            <h3><div id="numSolicitud"><?php echo $solicitudes_daf["numElems"]; ?></div></h3>
                                            <p>Pendientes de autorizaci&oacute;n<br> Direcci&oacute;n Administraci&oacute;n</p>
                                        </div>
                                        <div class="icon icon-dashboard">
                                            <i class="fa fa-cogs"></i>
                                        </div>
                                        <a href="#" id="sc" class="small-box-footer" data-toggle="modal" data-target="#mis_solicitudes_daf">M&aacute;s informaci&oacute;n <i class="fa fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>                           
                                <div class="col-lg-3 col-xs-6">
                                    <!-- small box -->
                                    <div class="small-box bg-yellow">
                                        <div class="inner">
                                            <h3><div id="numSolicitud"><?php echo $solicitudes_pago["numElems"]; ?></div></h3>
                                            <p>Pendientes de Pago<br> Perfil de Caja</p>
                                        </div>
                                        <div class="icon icon-dashboard">
                                            <i class="fa fa-dollar"></i>
                                        </div>
                                        <a href="#" id="sc" class="small-box-footer" data-toggle="modal" data-target="#mis_solicitudes_pago">M&aacute;s informaci&oacute;n <i class="fa fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                            </div><!-- /.row --> 
                            <div class="row">
                                <div class="col-lg-3 col-xs-6">
                                    <!-- small box -->
                                    <div class="small-box bg-orange">
                                        <div class="inner">
                                            <h3><div id="numSolicitud"><?php echo $solicitudes_comp["numElems"]; ?></div></h3>
                                            <p>Pendientes de Comprobrar<br>Usuario Beneficiario</p>
                                        </div>
                                        <div class="icon icon-dashboard">
                                            <i class="fa fa-ticket"></i>
                                        </div>
                                        <a href="#" id="sc" class="small-box-footer" data-toggle="modal" data-target="#mis_solicitudes_comp">M&aacute;s informaci&oacute;n <i class="fa fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                            </div>                           
                            <h4 class="sweet-figg-title">Solicitudes pendientes de autorizaci&oacute;n y/o intervenci&oacute;n</h4>                                    
                            <hr />
                            <div class="row">
                                <?php
                                $perfiles = $model->getParams1("direccion LIKE '%GAC%'");
                                $director_gral = ID_DIRECCION_GENERAL;

                                $fiscal = $perfiles["data"][0]["valor"];
                                $admistrativo = $perfiles["data"][1]["valor"];
                                $cajero = $perfiles["data"][2]["valor"];
                                $fiscal2 = $perfiles["data"][3]["valor"];
                                ?>

                                <!-- SI ERES UN B y tienes otro B abajo --> 
                                <?php
                                if ($_SESSION["sgi_nivel"] === "B" || intval($_SESSION["sgi_id_usr"]) === 93 || intval($_SESSION["sgi_id_usr"]) === 102) {
                                    $pendientes_b = $model->getSolicitudesGAC("estatus = 7 AND jefe_inmediato = " . $_SESSION["sgi_id_usr"]);
                                    if ($pendientes_b["numElems"] > 0) {
                                        ?>
                                        <div class="col-lg-3 col-xs-6">
                                            <!-- small box -->
                                            <div class="small-box bg-aqua">
                                                <div class="inner">
                                                    <h3><div id="numSolicitud"><?php echo $pendientes_b["numElems"]; ?></div></h3>
                                                    <p>Pendientes de autorizaci&oacute;n<br> Sub</p>
                                                </div>
                                                <div class="icon icon-dashboard">
                                                    <i class="fa fa-file-text-o"></i>
                                                </div>
                                                <a href="#" id="sc" class="small-box-footer" data-toggle="modal" data-target="#pendientes_b">M&aacute;s informaci&oacute;n <i class="fa fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div> 
                                        <?php
                                    }
                                }
                                ?>


                                <!-- SI ERES DG  Y TIENES QUE AUTORIZAR --> 
                                <?php
                                if ($_SESSION["sgi_id_usr"] === ID_DIRECCION_GENERAL || intval($_SESSION["sgi_id_usr"]) === 93 || intval($_SESSION["sgi_id_usr"]) === 102) {
                                    $pendientes_dg = $model->getSolicitudesGAC("estatus = 2");
                                    if ($pendientes_dg["numElems"] > 0) {
                                        ?>
                                        <div class="col-lg-3 col-xs-6">
                                            <!-- small box -->
                                            <div class="small-box bg-aqua">
                                                <div class="inner">
                                                    <h3><div id="numSolicitud"><?php echo $pendientes_dg["numElems"]; ?></div></h3>
                                                    <p>Pendientes de autorizaci&oacute;n<br> Direcci&oacute;n General</p>
                                                </div>
                                                <div class="icon icon-dashboard">
                                                    <i class="fa fa-file-text-o"></i>
                                                </div>
                                                <a href="#" id="sc" class="small-box-footer" data-toggle="modal" data-target="#pendientes_dg">M&aacute;s informaci&oacute;n <i class="fa fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div> 
                                        <?php
                                    }
                                }
                                ?>
                                <!-- SI ERES ADMINISTRATIVO  Y TIENES QUE AUTORIZAR --> 
                                <?php
                                if ($_SESSION["sgi_id_usr"] === $admistrativo || intval($_SESSION["sgi_id_usr"]) === 93 || intval($_SESSION["sgi_id_usr"]) === 102) {
                                    $pendientes_daf = $model->getSolicitudesGAC("estatus = 1");
                                    if ($pendientes_daf["numElems"] > 0) {
                                        ?>
                                        <div class="col-lg-3 col-xs-6">
                                            <!-- small box -->
                                            <div class="small-box bg-aqua">
                                                <div class="inner">
                                                    <h3><div id="numSolicitud"><?php echo $pendientes_daf["numElems"]; ?></div></h3>
                                                    <p>Pendientes de autorizaci&oacute;n<br>Administraci&oacute;n</p>
                                                </div>
                                                <div class="icon icon-dashboard">
                                                    <i class="fa fa-file-text-o"></i>
                                                </div>
                                                <a href="#" id="sc" class="small-box-footer" data-toggle="modal" data-target="#pendientes_daf">M&aacute;s informaci&oacute;n <i class="fa fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div> 
                                        <?php
                                    }
                                    $pendientes_daf_cierre = $model->getSolicitudesGAC("estatus = 6");
                                    if ($pendientes_daf_cierre["numElems"] > 0) {
                                        ?>
                                        <div class="col-lg-3 col-xs-6">
                                            <!-- small box -->
                                            <div class="small-box bg-aqua">
                                                <div class="inner">
                                                    <h3><div id="numSolicitud"><?php echo $pendientes_daf_cierre["numElems"]; ?></div></h3>
                                                    <p>Pendientes de pago y cierre<br>Administraci&oacute;n</p>
                                                </div>
                                                <div class="icon icon-dashboard">
                                                    <i class="fa fa-file-text-o"></i>
                                                </div>
                                                <a href="#" id="sc" class="small-box-footer" data-toggle="modal" data-target="#pendientes_daf_cierre">M&aacute;s informaci&oacute;n <i class="fa fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div> 
                                        <?php
                                    }
                                }
                                ?>
                                <!-- SI ERES CAJERO  --> 
                                <?php
                                if ($_SESSION["sgi_id_usr"] === $cajero || intval($_SESSION["sgi_id_usr"]) === 93 || intval($_SESSION["sgi_id_usr"]) === 102) {
                                    $pendientes_cajero = $model->getSolicitudesGAC("estatus = 3 ANd id_tipo != 1");
                                    if ($pendientes_cajero["numElems"] > 0) {
                                        ?>
                                        <div class="col-lg-3 col-xs-6">
                                            <!-- small box -->
                                            <div class="small-box bg-aqua">
                                                <div class="inner">
                                                    <h3><div id="numSolicitud"><?php echo $pendientes_cajero["numElems"]; ?></div></h3>
                                                    <p>Pendientes de autorizaci&oacute;n<br>Caja - pago</p>
                                                </div>
                                                <div class="icon icon-dashboard">
                                                    <i class="fa fa-file-text-o"></i>
                                                </div>
                                                <a href="#" id="sc" class="small-box-footer" data-toggle="modal" data-target="#pendientes_cajero">M&aacute;s informaci&oacute;n <i class="fa fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div> 
                                        <?php
                                    }
                                }
                                ?>
                                <!-- SI ERES FISCAL  Y TIENES SOLICITUDES QUE AUTORIZAR --> 
                                <?php
                                if ($_SESSION["sgi_id_usr"] === $fiscal || $_SESSION["sgi_id_usr"] === $fiscal2 || intval($_SESSION["sgi_id_usr"]) === 93 || intval($_SESSION["sgi_id_usr"]) === 102 || intval($_SESSION["sgi_id_usr"]) === 19) {
                                    $pendientes_f = $model->getSolicitudesGAC("estatus = 3 AND id_tipo = 1");
                                    $pendientes_fiscal = 0;
                                    foreach ($pendientes_f["data"] as $key => $pf) {
                                        $comprobantes = $model->getComprobantes("id_solicitud = " . $pf["id"] . " AND estatus = 2");
                                        if ($comprobantes["numElems"] > 0) {
                                            $pendientes_fiscal++;
                                        }
                                    }


                                    if ($pendientes_fiscal > 0) {
                                        ?>
                                        <div class="col-lg-3 col-xs-6">
                                            <!-- small box -->
                                            <div class="small-box bg-aqua">
                                                <div class="inner">
                                                    <h3><div id="numSolicitud"><?php echo $pendientes_fiscal; ?></div></h3>
                                                    <p>Pendientes revisar fiscal<br>RF</p>
                                                </div>
                                                <div class="icon icon-dashboard">
                                                    <i class="fa fa-file-text-o"></i>
                                                </div>
                                                <a href="#" id="sc" class="small-box-footer" data-toggle="modal" data-target="#pendientes_fiscal">M&aacute;s informaci&oacute;n <i class="fa fa-arrow-circle-right"></i></a>
                                            </div>
                                        </div> 
                                        <?php
                                    }
                                }
                                ?>
                                <!-- SI ERES DA  Y TIENES COMPROBANTES --> 
                                <?php
                                $pendientes_da = $model->getSolicitudesGAC("solicita = " . $_SESSION["sgi_id_usr"] . " AND estatus = 4");
                                $pendientes_da_c = 0;
                                foreach ($pendientes_da["data"] as $key => $pf) {
                                    $comprobantes = $model->getComprobantes("id_solicitud = " . $pf["id"] . " AND estatus = 1");
                                    if ($comprobantes["numElems"] > 0) {
                                        $pendientes_da_c++;
                                    }
                                }
                                if ($pendientes_da_c > 0) {
                                    ?>
                                    <div class="col-lg-3 col-xs-6">
                                        <!-- small box -->
                                        <div class="small-box bg-aqua">
                                            <div class="inner">
                                                <h3><div id="numSolicitud"><?php echo $pendientes_da_c; ?></div></h3>
                                                <p>Pendientes de revisar <br>DA</p>
                                            </div>
                                            <div class="icon icon-dashboard">
                                                <i class="fa fa-file-text-o"></i>
                                            </div>
                                            <a href="#" id="sc" class="small-box-footer" data-toggle="modal" data-target="#pendientes_da">M&aacute;s informaci&oacute;n <i class="fa fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div> 
                                    <?php
                                }
                                //<!-- SI ERES DA  Y TIENES QUE AUTORIZAR --> 
                                $pendientes_da_auth = $model->getSolicitudesGAC("id_director = " . $_SESSION["sgi_id_usr"] . " AND estatus = 7 AND jefe_inmediato = 0");
                                if ($pendientes_da_auth["numElems"] > 0) {
                                    ?>
                                    <div class="col-lg-3 col-xs-6">
                                        <!-- small box -->
                                        <div class="small-box bg-aqua">
                                            <div class="inner">
                                                <h3><div id="numSolicitud"><?php echo $pendientes_da_auth["numElems"]; ?></div></h3>
                                                <p>Pendientes de autorizar <br>DA</p>
                                            </div>
                                            <div class="icon icon-dashboard">
                                                <i class="fa fa-file-text-o"></i>
                                            </div>
                                            <a href="#" id="sc" class="small-box-footer" data-toggle="modal" data-target="#pendientes_da_auth">M&aacute;s informaci&oacute;n <i class="fa fa-arrow-circle-right"></i></a>
                                        </div>
                                    </div> 
                                    <?php
                                }
                                ?>

                            </div>                
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                    <!-- /.row (nested) -->
                </div>                

            </section><!-- /.content -->
            <section>
                <?php
//Autorizadas
                $autorizadas = $model->getSolicitudesGAC("(solicita = " . $_SESSION["sgi_id_usr"] . " OR beneficiario = " . $_SESSION["sgi_id_usr"] . ") AND estatus > 2 AND estatus < 5");
                $mis_solicitudes = $model->getSolicitudesGAC("(solicita = " . $_SESSION["sgi_id_usr"] . " OR beneficiario = " . $_SESSION["sgi_id_usr"] . ")");
                $rechazadas = $model->getSolicitudesGAC("(solicita = " . $_SESSION["sgi_id_usr"] . " OR beneficiario = " . $_SESSION["sgi_id_usr"] . ") AND estatus = 0");
                ?>
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title sweet-figg-title">Historico</h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div><!-- /.box-header -->

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-green"><i class="ion ion-ios-people-outline"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Solicitud(es)</span>
                                            <span class="info-box-number">Autorizada(s)<small><div id="numSolAutDgXXXXX"><?php echo $autorizadas["numElems"]; ?></div></small></span>
                                            <a href="#" id="hist0" class="small-box-footer" data-toggle="modal" data-target="#autorizadas">M&aacute;s informaci&oacute;n <i class="fa fa-arrow-circle-right"></i></a>
                                        </div><!-- /.info-box-content -->
                                    </div><!-- /.info-box -->
                                </div><!-- /.col -->

                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-aqua"><i class="ion ion-ios-people-outline"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Historico</span>
                                            <span class="info-box-number">Todas <small><div id="numSolHistserv"><?php echo $mis_solicitudes["numElems"]; ?></div></small></span>
                                            <a href="#" id="hist" class="small-box-footer" data-toggle="modal" data-target="#mis_solicitudes2">M&aacute;s informaci&oacute;n <i class="fa fa-arrow-circle-right"></i></a>
                                        </div><!-- /.info-box-content -->
                                    </div><!-- /.info-box -->
                                </div><!-- /.col -->

                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="info-box">                           
                                        <span class="info-box-icon bg-red"><i class="ion ion-ios-close-outline"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Solicitud(es)</span>
                                            <span class="info-box-number">Rechazada(s)<small><div id="numSolRech"><?php echo $rechazadas["numElems"]; ?></div></small></span>
                                            <a href="#" id="rech" class="small-box-footer" data-toggle="modal" data-target="#rechazadas">M&aacute;s informaci&oacute;n <i class="fa fa-arrow-circle-right"></i></a>
                                        </div><!-- /.info-box-content -->
                                    </div><!-- /.info-box -->
                                </div><!-- /.col -->
                            </div><!-- /.row -->
                        </div><!-- ./box-body -->

                    </div><!-- /.box -->
                </div>
            </section>
        </div><!-- /.content-wrapper -->  

        <?php
        require_once '../snippets/sidebar2.php';
        require_once '../snippets/footer.php';
        require_once '../utils/datatables.php';
        ?>

        <!--MODALS-->
        <div id="mis_solicitudes_activas" class="modal fade" role="dialog">
            <div class="modal-dialog-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Solicitudes activas</h4>
                    </div>
                    <div class="modal-body text-center">
                        <table id="egresos" class="table dt-responsive nowrap table-responsive text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Solicita</th>
                                    <th>Beneficiario</th>
                                    <th>Proyecto</th>
                                    <th>Importe</th>
                                    <th>Concepto</th>
                                    <th>Forma de pago</th>
                                    <th>Tipo de solicitud</th>
                                    <th>Fecha solicitud</th>
                                    <th>Fecha atenci&oacute;n</th>
                                    <th>Fecha pago</th>
                                    <th>Estatus</th>
                                    <th>eliminar solicitud</th>
                                </tr>
                            </thead> 
                            <tbody id="dirac_solicitudes">
                                <?php
                                foreach ($solicitudes_activas["data"] as $key => $s) {
                                    echo '<tr>';
                                    echo '<td>' . $s["id"] . '</td>';
                                    echo '<td>' . $s["solicita_usuario"]["data"][0]["nombre"] . ' ' . $s["solicita_usuario"]["data"][0]["apellidos"] . '</td>';
                                    echo '<td>' . $s["beneficiario_txt"] . '</td>';
                                    echo '<td>' . $s["proyecto"] . '<br /><b class="text-warning">' . $s["empresa"] . '</b></td>';
                                    echo '<td>$' . number_format($s["importe"], 2) . '</td>';
                                    echo '<td>' . $s["descripcion"] . '</td>';
                                    echo '<td>' . $s["forma_pago_nombre"] . '</td>';
                                    echo '<td>' . $s["tipo_solicitud"]["data"][0]["nombre"] . '</td>';
                                    echo '<td>' . $s["fecha_solicitud"] . '</td>';
                                    echo '<td>' . $s["fecha_atencion"] . '</td>';
                                    echo '<td>' . $s["fecha_pago"] . '</td>';
                                    echo '<td>' . $s["estatus_nombre"] . '</td>';

                                    echo '<td>';
                                    //echo '<button class="btn btn-flat btn-primary" onclick="editInfo(' . $s["id"] . ');" data-toggle="tooltip" title="Guardar cambios"> <i class="fa fa-save"></i> </button>';
                                    echo '<button class="btn btn-flat btn-danger" onclick="deleteSol(' . $s["id"] . ');" data-toggle="tooltip" title="Eliminar solicitud"> <i class="fa fa-times"></i> </button>';
                                    echo '</td>';
                                    echo '</tr>';
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <div id="msgSol"></div>
                        <br />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="mis_solicitudes_dg" class="modal fade" role="dialog">
            <div class="modal-dialog-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Solicitudes pendientes de autorizaci&oacute;n DG</h4>
                    </div>
                    <div class="modal-body text-center">
                        <table id="egresos" class="table dt-responsive nowrap table-responsive text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Solicita</th>
                                    <th>Beneficiario</th>
                                    <th>Proyecto</th>
                                    <th>Importe</th>
                                    <th>Concepto</th>
                                    <th>Forma de pago</th>
                                    <th>Tipo de solicitud</th>
                                    <th>Fecha solicitud</th>
                                    <th>Fecha atenci&oacute;n</th>
                                    <th>Fecha pago</th>
                                    <th>Estatus</th>
                                    <!--<th>Opciones</th>-->
                                </tr>
                            </thead> 
                            <tbody id="dirac_solicitudes">
                                <?php
                                foreach ($solicitudes_dg["data"] as $key => $s) {
                                    echo '<tr>';
                                    echo '<td>' . $s["id"] . '</td>';
                                    echo '<td>' . $s["solicita_usuario"]["data"][0]["nombre"] . ' ' . $s["solicita_usuario"]["data"][0]["apellidos"] . '</td>';
                                    echo '<td>' . $s["beneficiario_txt"] . '</td>';
                                    echo '<td>' . $s["proyecto"] . ' <b class="text-warning">' . $s["empresa"] . '</b></td>';
                                    echo '<td>$' . number_format($s["importe"], 2) . '</td>';
                                    echo '<td>' . $s["descripcion"] . '</td>';
                                    echo '<td>' . $s["forma_pago_nombre"] . '</td>';
                                    echo '<td>' . $s["tipo_solicitud"]["data"][0]["nombre"] . '</td>';
                                    echo '<td>' . $s["fecha_solicitud"] . '</td>';
                                    echo '<td>' . $s["fecha_atencion"] . '</td>';
                                    echo '<td>' . $s["fecha_pago"] . '</td>';
                                    echo '<td>' . $s["estatus_nombre"] . '</td>';

//                                        echo '<td>';
//                                        echo '<button class="btn btn-flat btn-primary" onclick="editInfo(' . $s["id"] . ');" data-toggle="tooltip" title="Guardar cambios"> <i class="fa fa-save"></i> </button>';
//                                        echo '<button class="btn btn-flat btn-danger" onclick="deleteInfo(' . $s["id"] . ');" data-toggle="tooltip" title="Eliminar registro"> <i class="fa fa-times"></i> </button>';
//                                        echo '</td>';
                                    echo '</tr>';
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <div id="msg"></div>
                        <br />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="mis_solicitudes_daf" class="modal fade" role="dialog">
            <div class="modal-dialog-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Solicitudes pendientes de autorizaci&oacute;n DAF</h4>
                    </div>
                    <div class="modal-body text-center">
                        <table id="egresos" class="table dt-responsive nowrap table-responsive text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Solicita</th>
                                    <th>Beneficiario</th>
                                    <th>Proyecto</th>
                                    <th>Importe</th>
                                    <th>Concepto</th>
                                    <th>Forma de pago</th>
                                    <th>Tipo de solicitud</th>
                                    <th>Fecha solicitud</th>
                                    <th>Fecha atenci&oacute;n</th>
                                    <th>Fecha pago</th>
                                    <th>Estatus</th>
                                    <!--<th>Opciones</th>-->
                                </tr>
                            </thead> 
                            <tbody id="dirac_solicitudes">
                                <?php
                                foreach ($solicitudes_daf["data"] as $key => $s) {
                                    echo '<tr>';
                                    echo '<td>' . $s["id"] . '</td>';
                                    echo '<td>' . $s["solicita_usuario"]["data"][0]["nombre"] . ' ' . $s["solicita_usuario"]["data"][0]["apellidos"] . '</td>';
                                    echo '<td>' . $s["beneficiario_txt"] . '</td>';
                                    echo '<td>' . $s["proyecto"] . '<br />' . $s["empresa"] . '</td>';
                                    echo '<td>$' . number_format($s["importe"], 2) . '</td>';
                                    echo '<td>' . $s["descripcion"] . '</td>';
                                    echo '<td>' . $s["forma_pago_nombre"] . '</td>';
                                    echo '<td>' . $s["tipo_solicitud"]["data"][0]["nombre"] . '</td>';
                                    echo '<td>' . $s["fecha_solicitud"] . '</td>';
                                    echo '<td>' . $s["fecha_atencion"] . '</td>';
                                    echo '<td>' . $s["fecha_pago"] . '</td>';
                                    echo '<td>' . $s["estatus_nombre"] . '</td>';

//                                        echo '<td>';
//                                        echo '<button class="btn btn-flat btn-primary" onclick="editInfo(' . $s["id"] . ');" data-toggle="tooltip" title="Guardar cambios"> <i class="fa fa-save"></i> </button>';
//                                        echo '<button class="btn btn-flat btn-danger" onclick="deleteInfo(' . $s["id"] . ');" data-toggle="tooltip" title="Eliminar registro"> <i class="fa fa-times"></i> </button>';
//                                        echo '</td>';
                                    echo '</tr>';
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <div id="msg"></div>
                        <br />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="mis_solicitudes_pago" class="modal fade" role="dialog">
            <div class="modal-dialog-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Solicitudes pendientes de pago</h4>
                    </div>
                    <div class="modal-body text-center">
                        <table id="egresos" class="table dt-responsive nowrap table-responsive text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Solicita</th>
                                    <th>Beneficiario</th>
                                    <th>Proyecto</th>
                                    <th>Importe</th>
                                    <th>Concepto</th>
                                    <th>Forma de pago</th>
                                    <th>Tipo de solicitud</th>
                                    <th>Fecha solicitud</th>
                                    <th>Fecha atenci&oacute;n</th>
                                    <th>Fecha pago</th>
                                    <th>Estatus</th>
                                    <!--<th>Opciones</th>-->
                                </tr>
                            </thead> 
                            <tbody id="dirac_solicitudes">
                                <?php
                                foreach ($solicitudes_pago["data"] as $key => $s) {
                                    echo '<tr>';
                                    echo '<td>' . $s["id"] . '</td>';
                                    echo '<td>' . $s["solicita_usuario"]["data"][0]["nombre"] . ' ' . $s["solicita_usuario"]["data"][0]["apellidos"] . '</td>';
                                    echo '<td>' . $s["beneficiario_txt"] . '</td>';
                                    echo '<td>' . $s["proyecto"] . '<br /><b class="text-warning">' . $s["empresa"] . '</b></td>';
                                    echo '<td>$' . number_format($s["importe"], 2) . '</td>';
                                    echo '<td>' . $s["descripcion"] . '</td>';
                                    echo '<td>' . $s["forma_pago_nombre"] . '</td>';
                                    echo '<td>' . $s["tipo_solicitud"]["data"][0]["nombre"] . '</td>';
                                    echo '<td>' . $s["fecha_solicitud"] . '</td>';
                                    echo '<td>' . $s["fecha_atencion"] . '</td>';
                                    echo '<td>' . $s["fecha_pago"] . '</td>';
                                    echo '<td>' . $s["estatus_nombre"] . '</td>';

//                                        echo '<td>';
//                                        echo '<button class="btn btn-flat btn-primary" onclick="editInfo(' . $s["id"] . ');" data-toggle="tooltip" title="Guardar cambios"> <i class="fa fa-save"></i> </button>';
//                                        echo '<button class="btn btn-flat btn-danger" onclick="deleteInfo(' . $s["id"] . ');" data-toggle="tooltip" title="Eliminar registro"> <i class="fa fa-times"></i> </button>';
//                                        echo '</td>';
                                    echo '</tr>';
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <div id="msg"></div>
                        <br />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="mis_solicitudes_comp" class="modal fade" role="dialog">
            <div class="modal-dialog-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Solicitudes pendientes de comprobar</h4>
                    </div>
                    <div class="modal-body text-center">
                        <table id="egresos" class="table dt-responsive nowrap table-responsive text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Solicita</th>
                                    <th>Beneficiario</th>
                                    <th>Proyecto</th>
                                    <th>Importe</th>
                                    <th>Concepto</th>
                                    <th>Forma de pago</th>
                                    <th>Tipo de solicitud</th>
                                    <th>Fecha solicitud</th>
                                    <th>Fecha atenci&oacute;n</th>
                                    <th>Fecha pago</th>
                                    <th>Estatus</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead> 
                            <tbody id="dirac_solicitudes">
                                <?php
                                foreach ($solicitudes_comp["data"] as $key => $s) {
                                    echo '<tr>';
                                    echo '<td>' . $s["id"] . '</td>';
                                    echo '<td>' . $s["solicita_usuario"]["data"][0]["nombre"] . ' ' . $s["solicita_usuario"]["data"][0]["apellidos"] . '</td>';
                                    echo '<td>' . $s["beneficiario_txt"] . '</td>';
                                    echo '<td>' . $s["proyecto"] . '<br /><b class="text-warning">' . $s["empresa"] . '</b></td>';
                                    echo '<td>$' . number_format($s["importe"], 2) . '</td>';
                                    echo '<td>' . $s["descripcion"] . '</td>';
                                    echo '<td>' . $s["forma_pago_nombre"] . '</td>';
                                    echo '<td>' . $s["tipo_solicitud"]["data"][0]["nombre"] . '</td>';
                                    echo '<td>' . $s["fecha_solicitud"] . '</td>';
                                    echo '<td>' . $s["fecha_atencion"] . '</td>';
                                    echo '<td>' . $s["fecha_pago"] . '</td>';
                                    echo '<td>' . $s["estatus_nombre"] . '</td>';

                                    echo '<td>';
                                    echo '<a  href="comprobacion_gac.php?id=' . $s["id"] . '" class="btn btn-flat btn-primary" data-toggle="tooltip" title="Ir a carga de comprobantes"> <i class="fa fa-eye"></i> </a>';
//                                        echo '<button class="btn btn-flat btn-danger" onclick="deleteInfo(' . $s["id"] . ');" data-toggle="tooltip" title="Eliminar registro"> <i class="fa fa-times"></i> </button>';
                                    echo '</td>';
                                    echo '</tr>';
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <div id="msg"></div>
                        <br />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="autorizadas" class="modal fade" role="dialog">
            <div class="modal-dialog-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Solicitudes autorizadas</h4>
                    </div>
                    <div class="modal-body text-center">
                        <table id="egresos" class="table dt-responsive nowrap table-responsive text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Solicita</th>
                                    <th>Beneficiario</th>
                                    <th>Proyecto</th>
                                    <th>Importe</th>
                                    <th>Concepto</th>
                                    <th>Forma de pago</th>
                                    <th>Tipo de solicitud</th>
                                    <th>Fecha solicitud</th>
                                    <th>Fecha atenci&oacute;n</th>
                                    <th>Fecha pago</th>
                                    <th>Estatus</th>
                                    <!--<th>Opciones</th>-->
                                </tr>
                            </thead> 
                            <tbody id="dirac_solicitudes">
                                <?php
                                foreach ($autorizadas["data"] as $key => $s) {
                                    echo '<tr>';
                                    echo '<td>' . $s["id"] . '</td>';
                                    echo '<td>' . $s["solicita_usuario"]["data"][0]["nombre"] . ' ' . $s["solicita_usuario"]["data"][0]["apellidos"] . '</td>';
                                    echo '<td>' . $s["beneficiario_txt"] . '</td>';
                                    echo '<td>' . $s["proyecto"] . '<br /><b class="text-warning">' . $s["empresa"] . '</b></td>';
                                    echo '<td>$' . number_format($s["importe"], 2) . '</td>';
                                    echo '<td>' . $s["descripcion"] . '</td>';
                                    echo '<td>' . $s["forma_pago_nombre"] . '</td>';
                                    echo '<td>' . $s["tipo_solicitud"]["data"][0]["nombre"] . '</td>';
                                    echo '<td>' . $s["fecha_solicitud"] . '</td>';
                                    echo '<td>' . $s["fecha_atencion"] . '</td>';
                                    echo '<td>' . $s["fecha_pago"] . '</td>';
                                    echo '<td>' . $s["estatus_nombre"] . '</td>';

//                                        echo '<td>';
//                                        echo '<button class="btn btn-flat btn-primary" onclick="editInfo(' . $s["id"] . ');" data-toggle="tooltip" title="Guardar cambios"> <i class="fa fa-save"></i> </button>';
//                                        echo '<button class="btn btn-flat btn-danger" onclick="deleteInfo(' . $s["id"] . ');" data-toggle="tooltip" title="Eliminar registro"> <i class="fa fa-times"></i> </button>';
//                                        echo '</td>';
                                    echo '</tr>';
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <div id="msg"></div>
                        <br />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="mis_solicitudes2" class="modal fade" role="dialog">
            <div class="modal-dialog-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Historico de solictudes</h4>
                    </div>
                    <div class="modal-body text-center">
                        <table id="egresos" class="table dt-responsive nowrap table-responsive text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Solicita</th>
                                    <th>Beneficiario</th>
                                    <th>Proyecto</th>
                                    <th>Importe</th>
                                    <th>Concepto</th>
                                    <th>Forma de pago</th>
                                    <th>Tipo de solicitud</th>
                                    <th>Fecha solicitud</th>
                                    <th>Fecha atenci&oacute;n</th>
                                    <th>Fecha pago</th>
                                    <th>Estatus</th>
                                    <!--<th>Opciones</th>-->
                                </tr>
                            </thead> 
                            <tbody id="dirac_solicitudes">
                                <?php
                                foreach ($mis_solicitudes["data"] as $key => $s) {
                                    echo '<tr>';
                                    echo '<td>' . $s["id"] . '</td>';
                                    echo '<td>' . $s["solicita_usuario"]["data"][0]["nombre"] . ' ' . $s["solicita_usuario"]["data"][0]["apellidos"] . '</td>';
                                    echo '<td>' . $s["beneficiario_txt"] . '</td>';
                                    echo '<td>' . $s["proyecto"] . '<br /><b class="text-warning">' . $s["empresa"] . '</b></td>';
                                    echo '<td>$' . number_format($s["importe"], 2) . '</td>';
                                    echo '<td>' . $s["descripcion"] . '</td>';
                                    echo '<td>' . $s["forma_pago_nombre"] . '</td>';
                                    echo '<td>' . $s["tipo_solicitud"]["data"][0]["nombre"] . '</td>';
                                    echo '<td>' . $s["fecha_solicitud"] . '</td>';
                                    echo '<td>' . $s["fecha_atencion"] . '</td>';
                                    echo '<td>' . $s["fecha_pago"] . '</td>';
                                    echo '<td>' . $s["estatus_nombre"] . '</td>';

//                                        echo '<td>';
//                                        echo '<button class="btn btn-flat btn-primary" onclick="editInfo(' . $s["id"] . ');" data-toggle="tooltip" title="Guardar cambios"> <i class="fa fa-save"></i> </button>';
//                                        echo '<button class="btn btn-flat btn-danger" onclick="deleteInfo(' . $s["id"] . ');" data-toggle="tooltip" title="Eliminar registro"> <i class="fa fa-times"></i> </button>';
//                                        echo '</td>';
                                    echo '</tr>';
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <div id="msg"></div>
                        <br />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="rechazadas" class="modal fade" role="dialog">
            <div class="modal-dialog-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Solicitudes rechazadas</h4>
                    </div>
                    <div class="modal-body text-center">
                        <table id="egresos" class="table dt-responsive nowrap table-responsive text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Solicita</th>
                                    <th>Beneficiario</th>
                                    <th>Proyecto</th>
                                    <th>Importe</th>
                                    <th>Concepto</th>
                                    <th>Forma de pago</th>
                                    <th>Tipo de solicitud</th>
                                    <th>Fecha solicitud</th>
                                    <th>Fecha atenci&oacute;n</th>
                                    <th>Fecha pago</th>
                                    <th>Estatus</th>
                                    <!--<th>Opciones</th>-->
                                </tr>
                            </thead> 
                            <tbody id="dirac_solicitudes">
                                <?php
                                foreach ($rechazadas["data"] as $key => $s) {
                                    echo '<tr>';
                                    echo '<td>' . $s["id"] . '</td>';
                                    echo '<td>' . $s["solicita_usuario"]["data"][0]["nombre"] . ' ' . $s["solicita_usuario"]["data"][0]["apellidos"] . '</td>';
                                    echo '<td>' . $s["beneficiario_txt"] . '</td>';
                                    echo '<td>' . $s["proyecto"] . '<br /><b class="text-warning">' . $s["empresa"] . '</b></td>';
                                    echo '<td>$' . number_format($s["importe"], 2) . '</td>';
                                    echo '<td>' . $s["descripcion"] . '</td>';
                                    echo '<td>' . $s["forma_pago_nombre"] . '</td>';
                                    echo '<td>' . $s["tipo_solicitud"]["data"][0]["nombre"] . '</td>';
                                    echo '<td>' . $s["fecha_solicitud"] . '</td>';
                                    echo '<td>' . $s["fecha_atencion"] . '</td>';
                                    echo '<td>' . $s["fecha_pago"] . '</td>';
                                    echo '<td>' . $s["estatus_nombre"] . '</td>';

//                                        echo '<td>';
//                                        echo '<button class="btn btn-flat btn-primary" onclick="editInfo(' . $s["id"] . ');" data-toggle="tooltip" title="Guardar cambios"> <i class="fa fa-save"></i> </button>';
//                                        echo '<button class="btn btn-flat btn-danger" onclick="deleteInfo(' . $s["id"] . ');" data-toggle="tooltip" title="Eliminar registro"> <i class="fa fa-times"></i> </button>';
//                                        echo '</td>';
                                    echo '</tr>';
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <div id="msg"></div>
                        <br />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!--*****************************************************************************************-->
        <!--SOLICTUDES PENDIENTES DE AUTORIZACION REVISION ETC-->
        <div id="pendientes_b" class="modal fade" role="dialog">
            <div class="modal-dialog-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Pendientes Sub B</h4>
                    </div>
                    <div class="modal-body text-center">
                        <table id="egresos" class="table dt-responsive nowrap table-responsive text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Solicita</th>
                                    <th>Beneficiario</th>
                                    <th>Proyecto</th>
                                    <th>Importe</th>
                                    <th>Concepto</th>
                                    <th>Forma de pago</th>
                                    <th>Tipo de solicitud</th>
                                    <th>Fecha solicitud</th>
                                    <th>Fecha atenci&oacute;n</th>
                                    <th>Fecha pago</th>
                                    <th>Estatus</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead> 
                            <tbody id="dirac_solicitudes">
                                <?php
                                foreach ($pendientes_b["data"] as $key => $s) {
                                    $archivos = "";
                                    if (intval($s["id_tipo"]) === 5) {
                                        $comps = $model->getArchivosComprobantes("id_solicitud = " . $s["id"]);
                                        foreach ($comps["data"] as $key => $c) {
                                            $archivos .= '<a class="text-info" href="' . $c["path"] . $c["nombre"] . '" target="_blank">' . $c["nombre"] . '</a><br />';
                                        }
                                    }
                                    echo '<tr>';
                                    echo '<td>' . $s["id"] . '</td>';
                                    echo '<td>' . $s["solicita_usuario"]["data"][0]["nombre"] . ' ' . $s["solicita_usuario"]["data"][0]["apellidos"] . '</td>';
                                    echo '<td>' . $s["beneficiario_txt"] . '</td>';
                                    echo '<td>' . $s["proyecto"] . '<br /><b class="text-warning">' . $s["empresa"] . '</b></td>';
                                    echo '<td>$' . number_format($s["importe"], 2) . '</td>';
                                    echo '<td>' . $s["descripcion"] . '</td>';
                                    echo '<td>' . $s["forma_pago_nombre"] . '</td>';
                                    echo '<td>' . $s["tipo_solicitud"]["data"][0]["nombre"] . ' <br />' . $archivos . '</td>';
                                    echo '<td>' . $s["fecha_solicitud"] . '</td>';
                                    echo '<td>' . $s["fecha_atencion"] . '</td>';
                                    echo '<td>' . $s["fecha_pago"] . '</td>';
                                    echo '<td>' . $s["estatus_nombre"] . '</td>';

                                    echo '<td>';
                                    echo '<button class="btn btn-flat btn-success" onclick="authBB(' . $s["id"] . ', 1);" data-toggle="tooltip" title="Autorizar"> <i class="fa fa-check"></i> </button>';
                                    echo '<button class="btn btn-flat btn-danger" onclick="authBB(' . $s["id"] . ', 0);" data-toggle="tooltip" title="Rechazar"> <i class="fa fa-times"></i> </button>';
                                    echo '</td>';
                                    echo '</tr>';
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <div id="msgBB"></div>
                        <br />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="pendientes_dg" class="modal fade" role="dialog">
            <div class="modal-dialog-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Pendientes Direcci&oacute;n General</h4>
                    </div>
                    <div class="modal-body text-center">
                        <table id="egresos" class="table dt-responsive nowrap table-responsive text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Solicita</th>
                                    <th>Beneficiario</th>
                                    <th>Proyecto</th>
                                    <th>Importe</th>
                                    <th>Concepto</th>
                                    <th>Forma de pago</th>
                                    <th>Tipo de solicitud</th>
                                    <th>Fecha solicitud</th>
                                    <th>Fecha atenci&oacute;n</th>
                                    <th>Fecha pago</th>
                                    <th>Estatus</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead> 
                            <tbody id="dirac_solicitudes">
                                <?php
                                foreach ($pendientes_dg["data"] as $key => $s) {
                                    $archivos = "";
                                    if (intval($s["id_tipo"]) === 5) {
                                        $comps = $model->getArchivosComprobantes("id_solicitud = " . $s["id"]);
                                        foreach ($comps["data"] as $key => $c) {
                                            $archivos .= '<a class="text-info" href="' . $c["path"] . $c["nombre"] . '" target="_blank">' . $c["nombre"] . '</a><br />';
                                        }
                                    }
                                    echo '<tr>';
                                    echo '<td>' . $s["id"] . '</td>';
                                    echo '<td>' . $s["solicita_usuario"]["data"][0]["nombre"] . ' ' . $s["solicita_usuario"]["data"][0]["apellidos"] . '</td>';
                                    echo '<td>' . $s["beneficiario_txt"] . '</td>';
                                    echo '<td>' . $s["proyecto"] . '<br /><b class="text-warning">' . $s["empresa"] . '</b></td>';
                                    echo '<td>$' . number_format($s["importe"], 2) . '</td>';
                                    echo '<td>' . $s["descripcion"] . '</td>';
                                    echo '<td>' . $s["forma_pago_nombre"] . '</td>';
                                    echo '<td>' . $s["tipo_solicitud"]["data"][0]["nombre"] . ' <br />' . $archivos . '</td>';
                                    echo '<td>' . $s["fecha_solicitud"] . '</td>';
                                    echo '<td>' . $s["fecha_atencion"] . '</td>';
                                    echo '<td>' . $s["fecha_pago"] . '</td>';
                                    echo '<td>' . $s["estatus_nombre"] . '</td>';

                                    echo '<td>';
                                    echo '<button class="btn btn-flat btn-success" onclick="authDG(' . $s["id"] . ', 1);" data-toggle="tooltip" title="Autorizar"> <i class="fa fa-check"></i> </button>';
                                    echo '<button class="btn btn-flat btn-danger" onclick="authDG(' . $s["id"] . ', 0);" data-toggle="tooltip" title="Rechazar"> <i class="fa fa-times"></i> </button>';
                                    echo '</td>';
                                    echo '</tr>';
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <div id="msgDG"></div>
                        <br />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="pendientes_daf" class="modal fade" role="dialog">
            <div class="modal-dialog-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Pendientes Direcci&oacute;n Administraci&oacute;n</h4>
                    </div>
                    <div class="modal-body text-center">
                        <table id="egresos" class="table dt-responsive nowrap table-responsive text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Solicita</th>
                                    <th>Beneficiario</th>
                                    <th>Proyecto</th>
                                    <th>Importe</th>
                                    <th>Concepto</th>
                                    <th>Forma de pago</th>
                                    <th>Tipo de solicitud</th>
                                    <th>Fecha solicitud</th>
                                    <th>Fecha atenci&oacute;n</th>
                                    <th>Fecha pago</th>
                                    <th>Estatus</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead> 
                            <tbody id="dirac_solicitudes">
                                <?php
                                foreach ($pendientes_daf["data"] as $key => $s) {
                                    $archivos = "";
//                                    if (intval($s["id_tipo"]) === 5) {
                                    $comps = $model->getArchivosComprobantes("id_solicitud = " . $s["id"]);
                                    foreach ($comps["data"] as $key => $c) {
                                        $archivos .= '<a class="text-info" href="' . $c["path"] . $c["nombre"] . '" target="_blank">' . $c["nombre"] . '</a><br />';
                                    }
//                                    }
                                    echo '<tr>';
                                    echo '<td>' . $s["id"] . '</td>';
                                    echo '<td>' . $s["solicita_usuario"]["data"][0]["nombre"] . ' ' . $s["solicita_usuario"]["data"][0]["apellidos"] . '</td>';
                                    echo '<td>' . $s["beneficiario_txt"] . '</td>';
                                    echo '<td>' . $s["proyecto"] . '<br /><b class="text-warning">' . $s["empresa"] . '</b></td>';
                                    echo '<td>$' . number_format($s["importe"], 2) . '</td>';
                                    echo '<td>' . $s["descripcion"] . '</td>';
                                    echo '<td>' . $s["forma_pago_nombre"] . '</td>';
                                    echo '<td>' . $s["tipo_solicitud"]["data"][0]["nombre"] . '<br />' . $archivos . '</td>';
                                    echo '<td>' . $s["fecha_solicitud"] . '</td>';
                                    echo '<td>' . $s["fecha_atencion"] . '</td>';
                                    echo '<td>' . $s["fecha_pago"] . '</td>';
                                    echo '<td>' . $s["estatus_nombre"] . '</td>';

                                    echo '<td>';
                                    echo '<button class="btn btn-flat btn-success" onclick="authDAF(' . $s["id"] . ', 3);" data-toggle="tooltip" title="Autorizar"> <i class="fa fa-check"></i> </button>';
                                    echo '<button class="btn btn-flat btn-primary" onclick="authDAF(' . $s["id"] . ', 2);" data-toggle="tooltip" title="Enviar a DG"> <i class="fa fa-question"></i> </button>';
                                    echo '<button class="btn btn-flat btn-danger" onclick="authDAF(' . $s["id"] . ', 0);" data-toggle="tooltip" title="Rechazar"> <i class="fa fa-times"></i> </button>';
                                    echo '</td>';
                                    echo '</tr>';
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <div id="msgDAF"></div>
                        <br />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="pendientes_daf_cierre" class="modal fade" role="dialog">
            <div class="modal-dialog-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Pendientes De Pago y/o Cierre Direcci&oacute;n Administraci&oacute;n</h4>
                    </div>
                    <div class="modal-body text-center">
                        <table id="egresos" class="table dt-responsive nowrap table-responsive text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Solicita</th>
                                    <th>Beneficiario</th>
                                    <th>Proyecto</th>
                                    <th>Importe</th>
                                    <th>Concepto</th>
                                    <th>Forma de pago</th>
                                    <th>Tipo de solicitud</th>
                                    <th>Fecha solicitud</th>
                                    <th>Fecha atenci&oacute;n</th>
                                    <th>Fecha pago</th>
                                    <th>Estatus</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead> 
                            <tbody id="dirac_solicitudes">
                                <?php
                                foreach ($pendientes_daf_cierre["data"] as $key => $s) {
                                    $archivos = "";
//                                    if (intval($s["id_tipo"]) === 5) {
                                    $comps = $model->getArchivosComprobantes("id_solicitud = " . $s["id"]);
                                    foreach ($comps["data"] as $key => $c) {
                                        $archivos .= '<a class="text-info" href="' . $c["path"] . $c["nombre"] . '" target="_blank">' . $c["nombre"] . '</a><br />';
                                    }
//                                    }
                                    echo '<tr>';
                                    echo '<td>' . $s["id"] . '</td>';
                                    echo '<td>' . $s["solicita_usuario"]["data"][0]["nombre"] . ' ' . $s["solicita_usuario"]["data"][0]["apellidos"] . '</td>';
                                    echo '<td>' . $s["beneficiario_txt"] . '</td>';
                                    echo '<td>' . $s["proyecto"] . '<br /><b class="text-warning">' . $s["empresa"] . '</b></td>';
                                    echo '<td>$' . number_format($s["importe"], 2) . '</td>';
                                    echo '<td>' . $s["descripcion"] . '</td>';
                                    echo '<td>' . $s["forma_pago_nombre"] . '</td>';
                                    echo '<td>' . $s["tipo_solicitud"]["data"][0]["nombre"] . '<br />' . $archivos . '</td>';
                                    echo '<td>' . $s["fecha_solicitud"] . '</td>';
                                    echo '<td>' . $s["fecha_atencion"] . '</td>';
                                    echo '<td>' . $s["fecha_pago"] . '</td>';
                                    echo '<td>' . $s["estatus_nombre"] . '</td>';

                                    echo '<td>';
                                    echo '<button class="btn btn-flat btn-success" onclick="pagar(' . $s["id"] . ');" data-toggle="tooltip" title="Cambiar estatus a cerrado y pagado (finalización de la solicitud)."> <i class="fa fa-check"></i> </button>';
//                                    echo '<button class="btn btn-flat btn-success" onclick="authDAF(' . $s["id"] . ', 3);" data-toggle="tooltip" title="Autorizar"> <i class="fa fa-check"></i> </button>';
//                                    echo '<button class="btn btn-flat btn-primary" onclick="authDAF(' . $s["id"] . ', 2);" data-toggle="tooltip" title="Enviar a DG"> <i class="fa fa-question"></i> </button>';
//                                    echo '<button class="btn btn-flat btn-danger" onclick="authDAF(' . $s["id"] . ', 0);" data-toggle="tooltip" title="Rechazar"> <i class="fa fa-times"></i> </button>';
                                    echo '</td>';
                                    echo '</tr>';
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <div id="msgDAF_cierre"></div>
                        <br />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="pendientes_cajero" class="modal fade" role="dialog">
            <div class="modal-dialog-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Pendientes de Pago por parte de DAF</h4>
                    </div>
                    <div class="modal-body text-center">
                        <table id="egresos" class="table dt-responsive nowrap table-responsive text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Solicita</th>
                                    <th>Beneficiario</th>
                                    <th>Proyecto</th>
                                    <th>Importe</th>
                                    <th>Concepto</th>
                                    <th>Forma de pago</th>
                                    <th>Tipo de solicitud</th>
                                    <th>Fecha solicitud</th>
                                    <th>Fecha atenci&oacute;n</th>
                                    <th>Fecha pago</th>
                                    <th>Estatus</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead> 
                            <tbody id="dirac_solicitudes">
                                <?php
                                foreach ($pendientes_cajero["data"] as $key => $s) {
                                    $archivos = "";
//                                    if (intval($s["id_tipo"]) === 5) {
                                    $comps = $model->getArchivosComprobantes("id_solicitud = " . $s["id"]);
                                    foreach ($comps["data"] as $key => $c) {
                                        $archivos .= '<a class="text-info" href="' . $c["path"] . $c["nombre"] . '" target="_blank">' . $c["nombre"] . '</a><br />';
                                    }
//                                    }
                                    echo '<tr>';
                                    echo '<td>' . $s["id"] . '</td>';
                                    echo '<td>' . $s["solicita_usuario"]["data"][0]["nombre"] . ' ' . $s["solicita_usuario"]["data"][0]["apellidos"] . '</td>';
                                    echo '<td>' . $s["beneficiario_txt"] . '</td>';
                                    echo '<td>' . $s["proyecto"] . '<br /><b class="text-warning">' . $s["empresa"] . '</b></td>';
                                    echo '<td>$' . number_format($s["importe"], 2) . '</td>';
                                    echo '<td>' . $s["descripcion"] . '</td>';
                                    echo '<td>' . $s["forma_pago_nombre"] . '</td>';
                                    echo '<td>' . $s["tipo_solicitud"]["data"][0]["nombre"] . '<br />' . $archivos . '</td>';
                                    echo '<td>' . $s["fecha_solicitud"] . '</td>';
                                    echo '<td>' . $s["fecha_atencion"] . '</td>';
                                    echo '<td>' . $s["fecha_pago"] . '</td>';
                                    echo '<td>' . $s["estatus_nombre"] . '</td>';

                                    echo '<td>';
//                                    echo '<button class="btn btn-flat btn-warning" onclick="pagar(' . $s["id"] . ');" data-toggle="tooltip" title="Colocar estado de pagado"> <i class="fa fa-bitcoin"></i> </button>';
                                    echo '<a href="ver_solicitud_caja.php?id=' . $s["id"] . '" data-toggle="tooltip" title="Ver solicitud" class="btn btn-flat btn-warning"> <i class="fa fa-eye"></i> </a>';
                                    echo '</td>';
                                    echo '</tr>';
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <div id="msgCaja"></div>
                        <br />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="pendientes_da" class="modal fade" role="dialog">
            <div class="modal-dialog-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Pendientes de revisi&oacute;n por parte de DA</h4>
                    </div>
                    <div class="modal-body text-center">
                        <table id="egresos" class="table dt-responsive nowrap table-responsive text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Solicita</th>
                                    <th>Beneficiario</th>
                                    <th>Proyecto</th>
                                    <th>Importe</th>
                                    <th>Concepto</th>
                                    <th>Forma de pago</th>
                                    <th>Tipo de solicitud</th>
                                    <th>Fecha solicitud</th>
                                    <th>Fecha atenci&oacute;n</th>
                                    <th>Fecha pago</th>
                                    <th>Estatus</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead> 
                            <tbody id="dirac_solicitudes">
                                <?php
                                foreach ($pendientes_da["data"] as $key => $s) {
                                    $pendientes_da_c = 0;
                                    $comprobantes = $model->getComprobantes("id_solicitud = " . $s["id"] . " AND estatus = 1");
                                    if ($comprobantes["numElems"] > 0) {
                                        $pendientes_da_c++;
                                        echo '<tr>';
                                        echo '<td>' . $s["id"] . '</td>';
                                        echo '<td>' . $s["solicita_usuario"]["data"][0]["nombre"] . ' ' . $s["solicita_usuario"]["data"][0]["apellidos"] . '</td>';
                                        echo '<td>' . $s["beneficiario_txt"] . '</td>';
                                        echo '<td>' . $s["proyecto"] . '<br /><b class="text-warning">' . $s["empresa"] . '</b></td>';
                                        echo '<td>$' . number_format($s["importe"], 2) . '</td>';
                                        echo '<td>' . $s["descripcion"] . '</td>';
                                        echo '<td>' . $s["forma_pago_nombre"] . '</td>';
                                        echo '<td>' . $s["tipo_solicitud"]["data"][0]["nombre"] . '</td>';
                                        echo '<td>' . $s["fecha_solicitud"] . '</td>';
                                        echo '<td>' . $s["fecha_atencion"] . '</td>';
                                        echo '<td>' . $s["fecha_pago"] . '</td>';
                                        echo '<td>' . $s["estatus_nombre"] . '</td>';

                                        echo '<td>';
                                        echo '<button class="btn btn-flat btn-warning" onclick="verComprobantes(' . $s["id"] . ');" data-toggle="tooltip" title="Ver comprobantes de solicitud"> <i class="fa fa-ticket"></i> </button>';
                                        echo '</td>';
                                        echo '</tr>';
                                    }
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <div id="msgCaja"></div>
                        <br />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="pendientes_fiscal" class="modal fade" role="dialog">
            <div class="modal-dialog-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Pendientes de Revisi&oacute;n</h4>
                    </div>
                    <div class="modal-body text-center">
                        <table id="egresos" class="table dt-responsive nowrap table-responsive text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Solicita</th>
                                    <th>Beneficiario</th>
                                    <th>Proyecto</th>
                                    <th>Importe</th>
                                    <th>Concepto</th>
                                    <th>Forma de pago</th>
                                    <th>Tipo de solicitud</th>
                                    <th>Fecha solicitud</th>
                                    <th>Fecha atenci&oacute;n</th>
                                    <th>Fecha pago</th>
                                    <th>Estatus</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead> 
                            <tbody id="dirac_solicitudes">
                                <?php
                                foreach ($pendientes_f["data"] as $key => $s) {
                                    $pendientes_f_c = 0;
                                    $comprobantes = $model->getComprobantes("id_solicitud = " . $s["id"] . " AND estatus = 2");
                                    if ($comprobantes["numElems"] > 0) {
                                        $pendientes_f_c++;
                                        echo '<tr>';
                                        echo '<td>' . $s["id"] . '</td>';
                                        echo '<td>' . $s["solicita_usuario"]["data"][0]["nombre"] . ' ' . $s["solicita_usuario"]["data"][0]["apellidos"] . '</td>';
                                        echo '<td>' . $s["beneficiario_txt"] . '</td>';
                                        echo '<td>' . $s["proyecto"] . '<br /><b class="text-warning">' . $s["empresa"] . '</b></td>';
                                        echo '<td>$' . number_format($s["importe"], 2) . '</td>';
                                        echo '<td>' . $s["descripcion"] . '</td>';
                                        echo '<td>' . $s["forma_pago_nombre"] . '</td>';
                                        echo '<td>' . $s["tipo_solicitud"]["data"][0]["nombre"] . '</td>';
                                        echo '<td>' . $s["fecha_solicitud"] . '</td>';
                                        echo '<td>' . $s["fecha_atencion"] . '</td>';
                                        echo '<td>' . $s["fecha_pago"] . '</td>';
                                        echo '<td>' . $s["estatus_nombre"] . '</td>';

                                        echo '<td>';
                                        echo '<button class="btn btn-flat btn-warning" onclick="verComprobantesF(' . $s["id"] . ');" data-toggle="tooltip" title="Ver comprobantes de solicitud"> <i class="fa fa-ticket"></i> </button>';
                                        echo '</td>';
                                        echo '</tr>';
                                    }
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <div id="msgCaja"></div>
                        <br />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="pendientes_da_auth" class="modal fade" role="dialog">
            <div class="modal-dialog-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Pendientes Autorizar Direcci&oacute;n de &aacute;rea</h4>
                    </div>
                    <div class="modal-body text-center">
                        <table id="egresos" class="table dt-responsive nowrap table-responsive text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Solicita</th>
                                    <th>Beneficiario</th>
                                    <th>Proyecto</th>
                                    <th>Importe</th>
                                    <th>Concepto</th>
                                    <th>Forma de pago</th>
                                    <th>Tipo de solicitud</th>
                                    <th>Fecha solicitud</th>
                                    <th>Fecha atenci&oacute;n</th>
                                    <th>Fecha pago</th>
                                    <th>Estatus</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead> 
                            <tbody id="dirac_solicitudes">
                                <?php
                                foreach ($pendientes_da_auth["data"] as $key => $s) {
                                    $archivos = "";
                                    if (intval($s["id_tipo"]) === 5) {
                                        $comps = $model->getArchivosComprobantes("id_solicitud = " . $s["id"]);
                                        foreach ($comps["data"] as $key => $c) {
                                            $archivos .= '<a class="text-info" href="' . $c["path"] . $c["nombre"] . '" target="_blank">' . $c["nombre"] . '</a><br />';
                                        }
                                    }
                                    echo '<tr>';
                                    echo '<td>' . $s["id"] . '</td>';
                                    echo '<td>' . $s["solicita_usuario"]["data"][0]["nombre"] . ' ' . $s["solicita_usuario"]["data"][0]["apellidos"] . '</td>';
                                    echo '<td>' . $s["beneficiario_txt"] . '</td>';
                                    echo '<td>' . $s["proyecto"] . '<br /><b class="text-warning">' . $s["empresa"] . '</b></td>';
                                    echo '<td>$' . number_format($s["importe"], 2) . '</td>';
                                    echo '<td>' . $s["descripcion"] . '</td>';
                                    echo '<td>' . $s["forma_pago_nombre"] . '</td>';
                                    echo '<td>' . $s["tipo_solicitud"]["data"][0]["nombre"] . ' <br />' . $archivos . '</td>';
                                    echo '<td>' . $s["fecha_solicitud"] . '</td>';
                                    echo '<td>' . $s["fecha_atencion"] . '</td>';
                                    echo '<td>' . $s["fecha_pago"] . '</td>';
                                    echo '<td>' . $s["estatus_nombre"] . '</td>';

                                    echo '<td>';
                                    echo '<button class="btn btn-flat btn-success" onclick="authDA_(' . $s["id"] . ', 1);" data-toggle="tooltip" title="Autorizar"> <i class="fa fa-check"></i> </button>';
                                    echo '<button class="btn btn-flat btn-danger" onclick="authDA_(' . $s["id"] . ', 0);" data-toggle="tooltip" title="Rechazar"> <i class="fa fa-times"></i> </button>';
                                    echo '</td>';
                                    echo '</tr>';
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <div id="msgAU_"></div>
                        <br />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>


    </div><!-- ./wrapper -->    
    <input type="hidden" name="area_direccion" id="area_direccion" value="<?php echo $_SESSION["sgi_id_area"];
                                ?>" />
    <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION["sgi_id_usr"]; ?>" />

    <script type="text/javascript" src="<?php echo SYSTEM_PATH ?>dist/js/pages/properties.js?v=<?php echo $fecha_scripts->getTimestamp(); ?>"></script>
    <script type="text/javascript" src="<?php echo SYSTEM_PATH ?>dist/js/pages/login.js?v=<?php echo $fecha_scripts->getTimestamp(); ?>"></script>
    <script type="text/javascript" src="<?php echo SYSTEM_PATH ?>dist/js/pages/utils.js?v=<?php echo $fecha_scripts->getTimestamp(); ?>"></script>
    <!--<script type="text/javascript" src="<?php echo SYSTEM_PATH ?>dist/js/pages/users.js?v=<?php echo $fecha_scripts->getTimestamp(); ?>"></script>-->
    <!--<script type="text/javascript" src="<?php echo SYSTEM_PATH ?>dist/js/pages/transfer.js?v=<?php echo $fecha_scripts->getTimestamp(); ?>"></script>-->
    <script type="text/javascript">
        $(document).ready(function () {

            //            TABLAS**********************
            $(".dash-tables").dataTable({
                "order": [[5, 'desc']],
                "dom": 'Bfrtip',
                "buttons": [
                    'colvis', 'csv', 'excel', 'pdf', 'print'
                            //                            'excel', 'pdf', 'print'
                ],
                "stateSave": true,
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
                    "sEmptyTable": "Ningun dato disponible en esta tabla",
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
                        "sLast": "Ultimo",
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

        function pagar(id) {
            $.ajax({
                type: "POST",
                url: '../controller/controller.php',
                data: {evento: 24, id: id, estatus: 5},
                dataType: 'json',
                beforeSend: function () {
//                console.log("Replace project....");
                    $("#msgDAF_cierre").html('<div class="text-center"><i class="fa fa-spinner fa-spin" style="font-size:48px; color: #F49625"></i><p><b class="text-center"><b></p></div>');
                },
                success: function (response) {
                    if (response.errorCode === 0) {
                        $("#msgDAF_cierre").html('');
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

        function authDG(id, auth) {
            $.ajax({
                type: "POST",
                url: '../controller/controller.php',
                data: {evento: 11, id: id, auth: auth},
                dataType: 'json',
                beforeSend: function () {
//                console.log("Replace project....");
                    $("#msgDG").html('<div class="text-center"><i class="fa fa-spinner fa-spin" style="font-size:48px; color: #F49625"></i><p><b class="text-center"><b></p></div>');
                },
                success: function (response) {
                    if (response.errorCode === 0) {
                        $("#msgDG").html('');
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

        function authBB(id, auth) {
            $.ajax({
                type: "POST",
                url: '../controller/controller.php',
                data: {evento: 17, id: id, auth: auth},
                dataType: 'json',
                beforeSend: function () {
//                console.log("Replace project....");
                    $("#msgBB").html('<div class="text-center"><i class="fa fa-spinner fa-spin" style="font-size:48px; color: #F49625"></i><p><b class="text-center"><b></p></div>');
                },
                success: function (response) {
                    if (response.errorCode === 0) {
                        $("#msgBB").html('');
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

        function authDA_(id, auth) {
            $.ajax({
                type: "POST",
                url: '../controller/controller.php',
                data: {evento: 18, id: id, auth: auth},
                dataType: 'json',
                beforeSend: function () {
//                console.log("Replace project....");
                    $("#msgAU_").html('<div class="text-center"><i class="fa fa-spinner fa-spin" style="font-size:48px; color: #F49625"></i><p><b class="text-center"><b></p></div>');
                },
                success: function (response) {
                    if (response.errorCode === 0) {
                        $("#msgAU_").html('');
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

        function authDAF(id, auth) {
            $.ajax({
                type: "POST",
                url: '../controller/controller.php',
                data: {evento: 12, id: id, auth: auth},
                dataType: 'json',
                beforeSend: function () {
//                console.log("Replace project....");
                    $("#msgDAF").html('<div class="text-center"><i class="fa fa-spinner fa-spin" style="font-size:48px; color: #F49625"></i><p><b class="text-center"><b></p></div>');
                },
                success: function (response) {
                    if (response.errorCode === 0) {
                        $("#msgDAF").html('');
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

        function deleteSol(id) {
            $.ajax({
                type: "POST",
                url: '../controller/controller.php',
                data: {evento: 19, id: id, estatus: 9},
                dataType: 'json',
                beforeSend: function () {
//                console.log("Replace project....");
                    $("#msgSol").html('<div class="text-center"><i class="fa fa-spinner fa-spin" style="font-size:48px; color: #F49625"></i><p><b class="text-center"><b></p></div>');
                },
                success: function (response) {
                    if (response.errorCode === 0) {
                        $("#msgSol").html('');
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

        function verComprobantes(id) {
            window.location.href = 'comprobacion_gac_da.php?id=' + id;
        }
        function verComprobantesF(id) {
            window.location.href = 'comprobacion_gac_caj.php?id=' + id;
        }
    </script>
</body>
