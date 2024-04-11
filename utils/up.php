<?php
require_once '../config/properties.php';
require_once 'Archivo.php';


//var_dump($_FILES);
//var_dump($_REQUEST);

//Obtenemos tamaño de archivo, extension, nombre temporal y tipo.
$tamanio = $_FILES["file"]["size"];
$extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
$nombreTemp = $_FILES["file"]["tmp_name"];
$tipo = $_FILES["file"]["type"];
$nombreOrig = $_FILES["file"]["name"];
$nombre = $nombreOrig;

$path = '../../sgi-dirac/uploads/fotos/';
//$path = '../../../dirac/take-photo';
//$path = '/var/www/dirac/take-photo/'; //Servidor Produccion
//$path = '/var/www/html/dirac/take-photo/'; //Local IP Publica
//if ($extension === 'mp4') {
//    $path = PATH_MOVIES;
//}
//if ($extension === "3gp") {
//    $path = PATH_VOICES;
//}
//if($extension === "jpg"){
//    $path = PATH_IMAGES;
//}

$archivo = new Archivo();
$archivo->setNombre($nombre);
$archivo->setNombreOriginal($nombreOrig);
$archivo->setNombreTemporal($nombreTemp);
$archivo->setTamanio($tamanio);
$archivo->setExtension($extension);
$archivo->setPath($path);

//Llamamos función para guardar archivo
$guardarArchivo = $archivo->cargarArchivo($archivo, $_FILES);
echo json_encode($guardarArchivo);