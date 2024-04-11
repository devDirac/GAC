<?php
require_once '../snippets/header.php';
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
                    Proyectos DIRAC
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
                                <div class="col-lg-offset-10 col-lg-2">
                                    <a href="<?php echo SYSTEM_PATH . 'pages/new_project.php' ?>" class="btn btn-block btn-warning btn-flat center-block">Agregar proyecto</a>
                                </div>
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <table id="projects" class="table table-bordered dt-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Clave</th>
                                        <th>Nombre</th>
                                        <th>Descripci&oacute;n</th>
                                        <th>Estatus</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody id="dirac_projects">

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
    <script type="text/javascript" src="<?php echo SYSTEM_PATH ?>dist/js/pages/projects.js"></script>
    <script type="text/javascript">
        getProjects("proyectos_sgi");       
    </script>
</body>
