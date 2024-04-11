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
                    Registro/Edici&oacute;n de proyectos
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
                            <h3 class="box-title">Edici&oacute;n/registro de proyectos</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <form role="form" name="projectForm" id="projectForm" method="POST">
                                        <div class="form-group">
                                            Clave
                                            <input class="form-control" name="clave" id="clave" type="text" placeholder="Clave" value="" />
                                        </div>
                                        <div class="form-group">
                                            Nombre
                                            <input class="form-control" name="nombre" id="nombre" type="text" placeholder="Nombre" value="" />
                                        </div>
                                        <div class="form-group">
                                            Descripción
                                            <textarea class="form-control" name="descripcion" id="descripcion" type="text" placeholder="Descripci&oacute;n" value="" ></textarea>
                                        </div>
                                        <div class="form-group">
                                            Estatus
                                            <select name="estatus" id="estatus" class="form-control">
                                                <option value="1">Activo</option>
                                                <option value="2">Inactivo</option>
                                            </select>
                                        </div>
                                        <input type="hidden" id="evento" name="evento" value="2" />
                                        <input type="hidden" id="table" name="table" value="proyectos_sgi" />
                                        <input type="hidden" id="id" name="id" value="<?php if(isset($_REQUEST["id"])){echo $_REQUEST["id"]; }else{echo "";}?>" />
                                         <input type="hidden" id="opcion" name="opcion" value="1" />
                                        <div class="input-group">
                                            <button name="newProject" id="newProject " class="btn btn-block btn-warning btn-flat center-block">Registrar informaci&oacute;n</button>
                                        </div>
                                    </form>
                                </div>                                
                            </div>
                        </div>
                        <div id="msg"></div>
                    </div>
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
    <script type="text/javascript" src="<?php echo SYSTEM_PATH ?>dist/js/pages/properties.js?v=<?php echo $fecha_scripts->getTimestamp(); ?>"></script>
    <script type="text/javascript" src="<?php echo SYSTEM_PATH ?>dist/js/pages/login.js"></script>
    <script type="text/javascript" src="<?php echo SYSTEM_PATH ?>dist/js/pages/utils.js"></script>
    <script type="text/javascript" src="<?php echo SYSTEM_PATH ?>dist/js/pages/projects.js"></script>
    <script type="text/javascript">
$(document).ready(function(){
   var id = $("#id").val();
   var table = $("#table").val();
   if(id !== null && id!==""){
       $("#opcion").val(2);
       getProject(id, table);
   }
});
    </script>
</body>
