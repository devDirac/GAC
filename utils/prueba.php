<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
set_time_limit(0);

require_once '../model/Transfer.php';

$transfer = Transfer::TransferSngltn();

$usuarios = $transfer->getInfoUsrsView("1=1");

foreach ($usuarios["data"] as $key => $value) {
    $data = array();
    $data["id_usuario"] = $value["id_usuario"];
    $data["id_director"] = $value["id_director_area"];
    $data["id_cargo"] = $value["id_perfil"];
    $data["id_proyecto_anterior"] = $value["id_proyecto"];
    $data["id_proyecto"] = $value["id_proyecto"];
    $data["id_direccion_anterior"] = $value["id_direccion"];
    $data["id_direccion"] = $value["id_direccion"];
    $salary = $transfer->getLastSalaryByUsr($value["id_usuario"]);
    $data["sueldo"] = $salary["data"]->sueldo;
    $data["viaticos"] = 0;
    $data["compensaciones"] = $salary["data"]->compensaciones;
    $data["fecha_inicio"] = $value["fecha_ingreso"];
    $data["fecha_fin"] = '0000-00-00';
    $data["utilizacion"] = 100;
    $data["nota"] = "Carga de proyectos actuales.";
    $data["nota_dg"] = "Se cargan proyectos actuales de los recursos registrados.";
    $add = $transfer->addAllUsrAssign($data);

    echo $add["data"] . " - " . $value["id_usuario"] . "<br />";
}
