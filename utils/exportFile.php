<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once '../config/properties.php';
require_once '../plugins/dompdf/dompdf_config.inc.php';
require_once 'Utils.php';

$utils = Utils::utlsSngltn();

//$url = SYSTEM_PATH . 'utils/templates/recover_pass.php?nombre=Froebel&usuario=froebel.ivan&contrasenia=232324';
$url = SYSTEM_PATH . 'pages/usr_info.php?id_usuario=93';
$msg = $utils->getPageHTML($url, '<html>', '</html>');

$dompdf = new DOMPDF();
//$dompdf->load_html(file_get_contents('http://148.243.10.117/encuesta/pages/usr_info.php?id_usuario=93'));
$dompdf->load_html($msg);
$dompdf->render();
$dompdf->stream("mi_archivo.pdf");

