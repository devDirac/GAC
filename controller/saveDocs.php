<?php
set_time_limit(0);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


$tamanio = $_FILES["file"]["size"];
$extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
$nombreTemp = $_FILES["file"]["tmp_name"];
$tipo = $_FILES["file"]["type"];
$nombreOrig = $_FILES["file"]["name"];
$nombre = normaliza($nombreOrig);

//$path = $_SERVER["DOCUMENT_ROOT"] . "/dirac/work_docs/";
$path = "../documentos_salida/";

$archivo = $nombre;
//$extension = pathinfo($archivo, PATHINFO_EXTENSION);
$nombre_base = basename($archivo, '.' . $extension);

$response = array();
try {
    //Si no hay error creamos carpeta
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
    // Si el archivo no existe no hubo ningun error, lo subimos.
    if (move_uploaded_file($nombreTemp, $path . $nombre)) {
        $response["errorCode"] = 0;
        $response["archivo"] = $nombre;
        $response["path"] = $path.$nombre;
        $response["msg"] = "Archivo cargado exitosamente";
    } else {
        $response["errorCode"] = 1;
        $response["msg"] = "Error al subir archivo, por favor intente más tarde";
    }
} catch (Exception $exc) {
    $response["errorCode"] = 0;
    $response["msg"] = $exc->getTraceAsString();
}

//echo json_encode($response);

function normaliza($cadena) {
    $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
    $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
    $cadena = utf8_decode($cadena);
    $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
//        $cadena = strtolower($cadena);
    return utf8_encode($cadena);
}
