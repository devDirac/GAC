<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="../../sgi-dirac/uploads/<?php echo $_SESSION["sgi_imagen"]; ?>" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p><?php echo $_SESSION["sgi_nombre"]; ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div> 
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">Menú principal</li>
            <li class="treeview">
                <a href="../../wpage/principal.php">
                    <i class="fa fa-home"></i> <span>Inicio</span> <i class="fa fa-angle-left pull-right"></i>
                </a>               
            </li>
            <li class="treeview">
                <a href="dashboard.php">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span> <i class="fa fa-angle-left pull-right"></i>
                </a>               
            </li>
            <?php
            if (intval($_SESSION["sgi_id_usr"]) === 3 || intval($_SESSION["sgi_id_usr"]) === 102 || intval($_SESSION["sgi_id_usr"]) === 93 || intval($_SESSION["sgi_id_usr"]) === 2) {
                ?>
                <li class="treeview">
                    <a href="catalogo_solicitudes.php">
                        <i class="fa fa-check-circle-o"></i> <span>Catalogo de solicitudes</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>               
                </li>
                <li class="treeview">
                    <a href="edicion_perfiles.php">
                        <i class="fa fa-users"></i> <span>Edici&oacute;n de perfiles</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>               
                </li>
                <li class="treeview">
                    <a href="registrar_pago_cch.php">
                        <i class="fa fa-dollar"></i> <span>Registrar pago de caja chica</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>               
                </li>
                <?php
            }
            ?>
            <?php
            if (intval($_SESSION["sgi_id_empresa"]) === 1 || intval($_SESSION["sgi_id_empresa"]) === 2 || intval($_SESSION["sgi_id_empresa"]) === 3) {
                ?>
                <li class="treeview">
                    <a href="solicitud_gac.php">
                        <i class="fa fa-bitcoin"></i> <span>Crear solicitud</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>               
                </li>            
                <li class="treeview">
                    <a href="solicitudes_realizadas.php">
                        <i class="fa fa-arrow-circle-o-right"></i> <span>Solicitudes realizadas</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>               
                </li>    
                <!--                <li class="treeview">
                                    <a href="supplier_visit.php">
                                        <i class="fa fa-suitcase"></i><small><span>Registro de visita de proveedores</span></small> <i class="fa fa-angle-left pull-right"></i>
                                    </a>               
                                </li>            -->
                <?php
            }

            if (intval($_SESSION["sgi_id_usr"]) === 93 || intval($_SESSION["sgi_id_usr"]) === 102 || intval($_SESSION["sgi_id_usr"]) === 2 || intval($_SESSION["sgi_id_usr"]) === 3) {
//                
                ?>

                <li class="treeview">
                    <a href="admin_solicitudes.php">
                        <i class="fa fa-support"></i> <span>Administrador de solicitudes</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>               
                </li>  

                <?php
            }
            ?>
            <li class="treeview">
                <a href="comprobacion_gac.php">
                    <i class="fa fa-ticket"></i> <span>Comprobaci&oacute;n de gastos CC</span> <i class="fa fa-angle-left pull-right"></i>
                </a>               
            </li>  

<!--            <li><a href="documentation/index.html"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
<li class="header">LABELS</li>
<li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
<li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
<li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>-->
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>