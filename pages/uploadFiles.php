<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//require_once '../hfmr/config/ConnectionDB.php';
require_once '../utils/Archivo.php';
require_once '../config/properties.php';

//Recibimos id del tipo de documento a subir
$id_solicitud = filter_input(INPUT_GET, "id_solicitud");
$id_comprobante = filter_input(INPUT_GET, "id_comprobante");

$tamanio = $_FILES["file"]["size"];
$extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
$nombreTemp = $_FILES["file"]["tmp_name"];
$tipo = $_FILES["file"]["type"];
$nombreOrig = $_FILES["file"]["name"];
$nombre = $nombreOrig;
$path = '../comprobantes/';

$archivo = new Archivo();
$archivo->setNombre($id_solicitud . "-" . $id_comprobante . "-" . $nombre);
$archivo->setNombreOriginal($nombreOrig);
$archivo->setNombreTemporal($nombreTemp);
$archivo->setTamanio($tamanio);
$archivo->setExtension($extension);
$archivo->setPath($path);

//Llamamos función para guardar archivo
$guardarArchivo = $archivo->cargarArchivo($archivo, $_FILES);

if ($guardarArchivo["errorCode"] === 0) {

    require_once '../model/Model.php';
    $model = Model::ModelSngltn();
    $data = array();

    $data["id_solicitud"] = $id_solicitud;
    $data["id_comprobante"] = $id_comprobante;
    $data["nombre"] = $id_solicitud . "-" . $id_comprobante . "-" . $nombre;
    $data["tamanio"] = $tamanio;
    $data["tipo"] = $tipo;
    $data["path"] = $path;

//    $addDoc = addUsrFiles("candidatos_archivos", $id_proyecto, filter_input(INPUT_GET, "path"), $archivo->getNombre(), $archivo->getTamanio(), $tipo, $path);
    $addDoc = $model->addDocGAC($data);
    echo json_encode($addDoc);
} else {
    echo json_encode($guardarArchivo);
//    }
}

