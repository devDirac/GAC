<?php
require_once '../config/properties.php';
session_start();
if (!isset($_SESSION["sgi_id_usr"])) {
    header('Location: ../../wpage/login.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="cache-control" content="max-age=0" />
        <meta http-equiv="cache-control" content="no-cache" />
        <meta http-equiv="expires" content="0" />
        <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
        <meta http-equiv="pragma" content="no-cache" />
        <meta http-equiv="Last-Modified" content="0">
        <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
        <title>DAF | Dirac</title>
        <link rel="shortcut icon" href="<?php echo SYSTEM_PATH ?>dist/img/dirac.ico">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap 3.3.2 -->
        <link href="<?php echo SYSTEM_PATH ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />    
        <!-- FontAwesome 4.3.0 -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons 2.0.0 -->
        <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" /> 

        <!-- Ion Slider -->
        <link href="<?php echo SYSTEM_PATH ?>plugins/ionslider/ion.rangeSlider.css" rel="stylesheet" type="text/css" />
        <!-- ion slider Nice -->
        <link href="<?php echo SYSTEM_PATH ?>plugins/ionslider/ion.rangeSlider.skinNice.css" rel="stylesheet" type="text/css" />
        <!-- bootstrap slider -->
        <link href="<?php echo SYSTEM_PATH ?>plugins/bootstrap-slider/slider.css" rel="stylesheet" type="text/css" />
        <!-- DATA TABLES -->
        <link href="<?php echo SYSTEM_PATH ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo SYSTEM_PATH ?>dist/css/Patron.min.css" rel="stylesheet" type="text/css" />
        <!-- Patron Skins. Choose a skin from the css/skins 
             folder instead of downloading all of them to reduce the load. -->
        <link href="<?php echo SYSTEM_PATH ?>dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
        <!-- iCheck -->
        <link href="<?php echo SYSTEM_PATH ?>plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo SYSTEM_PATH ?>plugins/iCheck/all.css" rel="stylesheet" type="text/css" />
        <!-- Morris chart -->
        <link href="<?php echo SYSTEM_PATH ?>plugins/morris/morris.css" rel="stylesheet" type="text/css" />
        <!-- jvectormap -->
        <link href="<?php echo SYSTEM_PATH ?>plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <!-- Date Picker -->
        <link href="<?php echo SYSTEM_PATH ?>plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="<?php echo SYSTEM_PATH ?>plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="<?php echo SYSTEM_PATH ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />

        <!-- FIGG CSS -->
        <link href="<?php echo SYSTEM_PATH ?>dist/css/figgCss.css?v=<?php echo $fecha_scripts->getTimestamp(); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo SYSTEM_PATH ?>dist/css/sweetalert2.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo SYSTEM_PATH ?>dist/css/animate.css" rel="stylesheet" type="text/css" />

        <link href="<?php echo SYSTEM_PATH ?>dist/js/dropzone/css/dropzone.css" rel="stylesheet" type="text/css" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <!--<link href="../../../arjionv1/utils/select2-4.0.3/dist/css/select2.min.css" rel="stylesheet" type="text/css" />-->
    </head>
