<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../model/PMDirac.php';
require_once '../utils/Utils.php';

$params = json_decode(file_get_contents('php://input'), true);

$evento = 0;
$data = "";
if (is_null($params)) {
    $evento = filter_input(INPUT_POST, "evento");
    $data = catchPOST();
} else {
    $evento = $params["evento"];
    $data = $params;
}

handler($evento, $data);

function handler($evento, $data) {
    $pmDirac = PMDirac::PMDiracSngltn();
    $carpeta = $_SERVER["DOCUMENT_ROOT"] . "/proyectos/" . $data["clave"];
    switch ($evento) {
        case 1://Crear carpeta de proyectos
            $response = array();
            if (!file_exists($carpeta)) {
                mkdir($carpeta, 0777, true);
                $response["errorCode"] = 0;
                $response["msg"] = "Operacion Exitosa.";
            } else {
                $response["errorCode"] = 1;
                $response["msg"] = "Error al crear carpeta, intente m&aacute;s tarde.";
            }
            echo json_encode($response);
            break;
//        case 2:
//            try {
//                if (isset($data["utilizacionP"])) { //Si hay modificacion o mas de una asignacion
//                    foreach ($data["utilizacionP"] as $key => $value) {
//                        if (intval($value) === 0) {
//                            $updateU = $transfer->updateUtilization($data["id_asignacion"][$key], $value, $data["fecha_inicio"], 1);
//                        } else {
//                            $updateU = $transfer->updateUtilization($data["id_asignacion"][$key], $value, $data["fecha_inicio"], 2);
//                        }
//
//                        if (intval($value) === 100) {//Si se asigna al 100% en algu8un proyecto anterior actualizamos proyecto en tabla de Factor humano                            
//                            $updateProj = $transfer->updateProjectUsr($data["id_usuario"], $data["id_proyecto"]);
//                        }
//
////                        if ($value === end($data["utilizacionP"])) {
////                            $updateU = $transfer->updateUtilization($data["id_asignacion"][$key], $value, $data["fecha_inicio"], 1);
////                        } else {
////                            $updateU = $transfer->updateUtilization($data["id_asignacion"][$key], $value, $data["fecha_inicio"], 2);
////                        }
//                    }
//                }
//                //Registramos asignacion
//                $assignUsr = $transfer->addUsrAssign($data);
//                if (intval($data["utilizacion"]) === 100) {//Si se asigna al 100% actualizamos proyecto en tabla de Factor humano                    
//                    $updateProj = $transfer->updateProjectUsr($data["id_usuario"], $data["id_proyecto"]);
//                }
//
//                //Info de usuario y de director de area y DAF
//                $usr = $transfer->getUsrByIdGral($data["id_usuario"]);
//                $usr_salary = $transfer->getLastSalaryByUsr($data["id_usuario"]);
//                /*                 * ***************************************************************** */
//                if (!isset($usr_salary["data"]->sueldo)) {
//                    $usr_salary["data"]->sueldo = 0;
//                    $usr_salary["data"]->compensaciones = 0;
//                }
//                /*                 * ***************************************************************** */
//                $da = $transfer->getUsrByIdGral($_SESSION['sgi_id_usr']);
//                $daf = $transfer->getUsrByIdGral(ID_DIRECCION_AF);
//                $cp = $transfer->getUsrByIdGral(ID_CP);
//
//                if (intval($assignUsr["errorCode"]) === 0) {//Si se inserto correctamente hacemos envios dependiendo los parametros
//                    require_once '../model/Catalogo.php';
//                    $catalogo = Catalogo::catSngltn('proyectos_sgi');
//                    $catalogo->setId($data["id_proyecto"]);
//                    $proyecto = $catalogo->getCatById($catalogo);
//
//                    $subject = 'Nuevo registro de asignacion.';
//                    $msg = 'El usuario: <b>' . $da["data"]->nombre . '</b>, ha realizado una asignacion con la siguiente informacion: <br>'
//                            . '<br> Usuario: <b>' . $usr["data"]->nombre . '</b>'
//                            . '<br> Proyecto: ' . $proyecto["data"]["nombre"]
//                            . '<br> Utilizacion : ' . $data["utilizacion"] . ' %'
//                            . '<br> Sueldo (quincenal bruto): $ ' . $data["sueldo"]
//                            . '<br> Viaticos: $ ' . $data["viaticos"]
//                            . '<br> Compensaciones: $ ' . $data["compensaciones"]
//                            . '<br> Nota: ' . $data["nota"];
//                    if ((floatval($data["sueldo"]) !== floatval($usr_salary["data"]->sueldo)) || floatval($data["viaticos"]) > 0 || /* floatval($data["compensaciones"]) > 0 */ (floatval($data["compensaciones"]) !== floatval($usr_salary["data"]->compensaciones))) {//Cambio de sueldo, notificar a Direccion General
//                        $dg = $transfer->getUsrByIdGral(ID_DIRECCION_GENERAL);
//                        $msg .= '<br /><br /> Esta solicitud esta pendiente por revision de parte de Direccion General.<br /> ';
//                        sendM($subject, $dg["data"]->nombre, $msg, $dg["data"]->correo);
//                        sendM($subject, $daf["data"]->nombre, $msg, $daf["data"]->correo);
//                        sendM($subject, $cp["data"]->nombre, $msg, $cp["data"]->correo);
//                    } else {//Si no hay notificar a Factor Humano, Nomina y DAF, usuario, y actualizar a 1 solicitud
//                        $gfh = $transfer->getUsrByIdGral(ID_GERENCIA_FH);
//                        $nom = $transfer->getUsrByIdGral(ID_JEFE_NOMINA);
//                        $transfer->authTransfer($assignUsr["data"], 1, "Autorizado automaticamente por no existir cambio de sueldo.");
//                        //Si es un cambio de direccion realizamos UPDATE en tabla de usuarios general
//                        if (intval($data["id_direccion"]) !== intval($data["id_area"])) {
//                            //UPDATE A BD DE USUARIOS
//                            $transfer->updateDirectionUsr($data["id_usuario"], $data["id_area"]);
//                        }
//                        $subject = 'Asignacion de usuario';
//                        $msg .= '<br /> Esta solicitud ha sido autorizada de manera directa por no ser necesaria la intervencion por parte de Direccion General.<br /> ';
//                        sendM($subject, $gfh["data"]->nombre, $msg, $gfh["data"]->correo);
//                        sendM($subject, $nom["data"]->nombre, $msg, $nom["data"]->correo);
//                        sendM($subject, $usr["data"]->nombre, $msg, $usr["data"]->correo);
//                        sendM($subject, $daf["data"]->nombre, $msg, $daf["data"]->correo);
//                        sendM($subject, $da["data"]->nombre, $msg, $da["data"]->correo);
//                        sendM($subject, $cp["data"]->nombre, $msg, $cp["data"]->correo);
//                    }
//                }
//                echo json_encode($assignUsr);
//            } catch (Exception $exc) {
//                echo $exc->getMessage();
//            }
//            break;
//        case 3://Consultar transfers
//            $my_transfers = $transfer->getMyTransfers($data["query"]);
//            echo json_encode($my_transfers);
//            break;
//
//        case 4://Autorizar transferencias
//            $auth_transfers = $transfer->authTransfer($data["id"], $data["valor"], $data["nota_dg"]);
//
//            if (intval($auth_transfers["errorCode"]) === 0) {//Si se realizo correctamente la actualizacion
//                $transfer_info = $transfer->getMyTransfers("A.id =" . $data["id"]); //Info del transfer
//                $da = $transfer->getUsrByIdGral($transfer_info["data"][0]["id_director"]); //Info del director de área
//                $daf = $transfer->getUsrByIdGral(ID_DIRECCION_AF); //Info del director de área
//                $usr = $transfer->getUsrByIdGral($transfer_info["data"][0]["id_usuario"]); //Info del director de área
//                $cp = $transfer->getUsrByIdGral(ID_CP); //Info del director de área
//
//                require_once '../model/Catalogo.php';
//                $catalogo = Catalogo::catSngltn('proyectos_sgi');
//                $catalogo->setId($transfer_info["data"][0]["id_proyecto"]);
//                $proyecto = $catalogo->getCatById($catalogo);
//
//                $estatus = NULL;
//                if (intval($data["valor"]) === 1) {
//                    $estatus = "<b class='text-success'>APROBADA</b>";
//                } else {
//                    $estatus = "<b class='text-danger'>RECHAZADA</b>";
//                }
//
//                $subject = 'Respuesta de registro de asignacion.';
//                $msg = 'La asignacion del usuario <b>' . $transfer_info["data"][0]["nombre_empleado"] . '</b>, con la siguiente informacion:<br />'
//                        . '<br /> Proyecto: ' . $transfer_info["data"][0]["proyecto"]
//                        . '<br /> Utilizacion : ' . $transfer_info["data"][0]["utilizacion"] . ' %'
//                        . '<br /> Sueldo (quincenal bruto): $ ' . $transfer_info["data"][0]["sueldo"]
//                        . '<br /> Viaticos: $ ' . $transfer_info["data"][0]["viaticos"]
//                        . '<br /> Compensaciones: $ ' . $transfer_info["data"][0]["compensaciones"]
//                        . '<br /> Nota: ' . $transfer_info["data"][0]["nota"] . '<br /><br />'
//                        . '<br /> Nota direccion general: ' . $transfer_info["data"][0]["nota_dg"] . '<br /><br />'
//                        . 'Ha sido ' . $estatus . ' por parte de Direccion General.';
//
//                sendM($subject, $da["data"]->nombre, $msg, $da["data"]->correo);
//                if (intval($data["valor"]) === 1) {//Si fue autorizada enviamos correo a Nomina
//                    $nom = $transfer->getUsrByIdGral(ID_JEFE_NOMINA);
//                    $gfh = $transfer->getUsrByIdGral(ID_GERENCIA_FH);
//                    sendM($subject, $nom["data"]->nombre, $msg, $nom["data"]->correo);
//                    sendM($subject, $gfh["data"]->nombre, $msg, $gfh["data"]->correo);
//                    sendM($subject, $usr["data"]->nombre, $msg, $usr["data"]->correo);
//                    sendM($subject, $da["data"]->nombre, $msg, $da["data"]->correo);
//                    sendM($subject, $daf["data"]->nombre, $msg, $daf["data"]->correo);
//                    sendM($subject, $cp["data"]->nombre, $msg, $cp["data"]->correo);
//                    //Si es un cambio de direccion realizamos UPDATE en tabla de usuarios general
//                    if (intval($transfer_info["data"][0]["id_direccion"]) !== intval($transfer_info["data"][0]["id_direccion_anterior"])) {
//                        //UPDATE A BD DE USUARIOS
//                        $transfer->updateDirectionUsr($transfer_info["data"][0]["id_usuario"], $transfer_info["data"][0]["id_direccion"]);
//                    } else {
//                        sendM($subject, $usr["data"]->nombre, $msg, $usr["data"]->correo);
//                        sendM($subject, $daf["data"]->nombre, $msg, $daf["data"]->correo);
//                        sendM($subject, $da["data"]->nombre, $msg, $da["data"]->correo);
//                        sendM($subject, $cp["data"]->nombre, $msg, $cp["data"]->correo);
//                    }
//                }
//            }
//            echo json_encode($auth_transfers);
//            break;
//        case 5://Consultar transfers
//            $delete_transfers = $transfer->deleteTransfer($data["id"]);
//            echo json_encode($delete_transfers);
//            break;
//
//        case 6://Actualizar transferencias de usuario
//            $updateU = NULL;
//            foreach ($data["utilizacionP"] as $key => $value) {
//                if (intval($value) === 100) {//Si se asigna al 100% en algu8un proyecto anterior actualizamos proyecto en tabla de Factor humano                            
//                    $updateProj = $transfer->updateProjectUsr($data["id_usuario"], $data["id_proyecto"][$key]);
//                }
//                $updateU = $transfer->updateAssignUsrs($data["id_assign"][$key], $value, $data["fechaInicioP"][$key], $data["fechaFinP"][$key]);
//            }
//            echo json_encode($updateU);
//            break;
        default:
            break;
    }
}

function catchPOST() {
    return $data = filter_input_array(INPUT_POST);
}

function sendM($subject, $destinatario, $body, $correo_destinatario) {
    $utils = Utils::utlsSngltn();
    $url = SYSTEM_PATH . 'utils/templates/send_alert.php?destinatario=' . urlencode($destinatario) . "&msg=" . urlencode($body);
    $msg = $utils->getPageHTML($url, '<html>', '</html>');
    $sendMail = $utils->sendMail($correo_destinatario, $destinatario, utf8_decode($subject), $msg);
    return $sendMail;
}
