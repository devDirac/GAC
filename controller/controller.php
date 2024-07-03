<?php

@session_start();
if (!isset($_SESSION["sgi_id_usr"])) {
    header('Location: ../pages/login.php');
    exit();
}

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../model/Model.php';
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
    $model = Model::ModelSngltn();
    switch ($evento) {
        case 1://Editar tipo de solicitud de gac
//            var_dump($data);
            $lmin = null;
            if (isset($data["limite_inferior"])) {
                $lmin = $data["limite_inferior"];
            }
            $update = $model->updateTSolicitud($data["id"], $data["estatus"], $data["nombre"], $data["descripcion"], $data["tope"], $data["id_notificacion"], $lmin);
            echo json_encode($update);
            break;
        case 2://Eliminar tipo de solicitud de gacx
            $delete = $model->deleteTSolicitud($data["id"]);
            echo json_encode($delete);
            break;
        case 3:
            $users = $model->getInfoUsrsView($data["query"]);
            echo json_encode($users);
            break;
        case 4:
            $add = $model->addTSolicitud($data["estatus"], $data["nombre"], $data["descripcion"], $data["tope"], $data["id_notificacion"]);
            echo json_encode($add);
            break;
        case 5:
            $updateGAC = $model->updateParamsGAC($data["valor"], $data["id"]);
            echo json_encode($updateGAC);
            break;
        case 6:
            $addGAC = null;
            //Consulta el tipo de solicitud
            $tipo_solicitud = $model->getTipoSolicitudes("id = " . $data["tipo_solicitud"]);
            //Insertar solicitud
            $data["estatus"] = 0;

            if ($data["nivel"] === "B") {
                $data["estatus"] = 7;
            }
            if ($data["nivel"] === "A") {
                $data["estatus"] = 1;
            }
            /* 17.Abril2024 FIGG */
            if (intval($tipo_solicitud["data"][0]["tipo"]) === 1) {
                $data["estatus"] = 1;
            }
//            var_dump($data);
            $addGAC = $model->agregarSolicitudGAC($data);

//            switch (intval($tipo_solicitud["data"][0]["id"])) {
//                case 1://Caja Chica
//                    if (floatval($data["importe"]) > floatval($tipo_solicitud["data"][0]["tope"])) {
//                        $proceso = 1;
//                        $data["estatus"] = 2;
//                    } else {
//                        $proceso = 2;
//                        $data["estatus"] = 1;
//                    }
//                    $addGAC = $model->agregarSolicitudGAC($data);
//                    if (intval($addGAC["errorCode"]) === 0) {
//                        //Enviamos notitificacion a quien corresponda
//                        //Verificamos que la solicitud no rebase el tope del tipo de solicitud
//                        include_once './send_nots.php';
//                    }
//                    break;
//                case 5://Reembolso
//                    $data["estatus"] = 2;
//                    $addGAC = $model->agregarSolicitudGAC($data);
//                    break;
//                case 6://Pago de Proveedores
//                    $data["estatus"] = 1;
//                    $addGAC = $model->agregarSolicitudGAC($data);
//                    break;
//                default://Gastos de viaje, viaticos, otros.
//                    if (floatval($data["importe"]) > floatval($tipo_solicitud["data"][0]["tope"])) {
//                        $proceso = 1;
//                        $data["estatus"] = 2;
//                    } else {
//                        $proceso = 2;
//                        $data["estatus"] = 1;
//                    }
//                    $addGAC = $model->agregarSolicitudGAC($data);
//                    if (intval($addGAC["errorCode"]) === 0) {
//                        if (intval($data["jefe"]) !== 0) {
//                            $proceso = 7;
//                        }
//                        //Enviamos notitificacion a quien corresponda
//                        //Verificamos que la solicitud no rebase el tope del tipo de solicitud
//                        include_once './send_nots.php';
//                    }
//                    break;
//            }
            echo json_encode($addGAC);
            break;
        case 7:
            $addCompGAC = $model->addComprobantes($data);
            echo json_encode($addCompGAC);
            break;
        case 8:
//            var_dump($data);
            $delComp = $model->deleteComp($data["id"]);
            $model->deleteCompFiles($data["id"]);
            echo json_encode($delComp);
            break;
        case 9:
            $send_c = NULL;
            $query = "";
            $id_solicitud = 0;
            $estatus = 0;
            $estatus_txt = "";
            if ($_SESSION["sgi_nivel"] === "A") {
                $estatus = 2;
                $estatus_txt = "Autorizado";
            } else {
                $estatus_txt = "Rechazado";
                $estatus = 1;
            }
            foreach ($data["idsC"] as $key => $c) {
                if (end($data["idsC"]) === $c) {
                    $query .= " id = " . $c;
                } else {
                    $query .= " id = " . $c . " OR ";
                }
                //Actualizamos estatus de comprobante
                $send_c = $model->updateEstatusComp($c, $estatus);
            }
            $comprobantes = $model->getComprobantes($query);
            $solicitud = $model->getSolicitudesGAC("id = " . $comprobantes["data"][0]["id_solicitud"]);
            $model->agregarSolBitacora($comprobantes["data"][0]["id_solicitud"], "Envío de comprobantes", 4);
//            var_dump($comprobantes);
//            var_dump($solicitud);
//            echo $query;
            if (intval($send_c["errorCode"]) === 0) {
                if ($_SESSION["sgi_nivel"] === "A") {
                    $proceso = 11;
                } else {
                    //Enviamos notitificacion a DA de solicitud
                    $proceso = 3;
                }

                include_once './send_nots.php';
            }
            echo json_encode($send_c);
            break;
        case 10://Paga Cajero
            $solicitud = $model->getSolicitudesGAC("id = " . $data["id"]);
            $updatePago = null;
            if (intval($solicitud["data"][0]["id_tipo"]) === 5) {//Reembolso
                $updatePago = $model->updateFechaPagR($data["id"]);
            } else {
                $updatePago = $model->updateFechaPag($data["id"]);
            }
            if (intval($updatePago["errorCode"]) === 0) {
                //Enviamos notitificacion a DA de solicitud
                $proceso = 4;
                include_once './send_nots.php';
            }

            echo json_encode($updatePago);
            break;
        case 11: //Autoriza o rechaza DG
            $id = $data["id"];
            $auth = $data["auth"];
            $path = $_SERVER["DOCUMENT_ROOT"] . "/gac/comprobantes/";

            $flag = 0;
            $estado = "<b style='color: red;'>rechazada</b>";
            if (intval($auth) !== 0) {
                $estado = "<b style='color: green;'>autorizada</b>";
                $flag = 1;
            }


            $authOutp = $model->authSolicitudGAC($id, $auth);

            if (intval($authOutp["errorCode"]) === 0) {
                $solicitud = $model->getSolicitudesGAC("id = " . $id);
                $tipo_solicitud = $model->getTipoSolicitudes("id = " . $solicitud["data"][0]["id_tipo"]);
                $usuario = $model->getUsrByIdGral($tipo_solicitud["data"][0]["id_notificacion"]);
                $subject = "Solicitud de gastos a comprobar ";
                $msg = " <p>Ha sido " . $estado . " una solicitud por parte de la Dirección General, la información es la siguiente:</p>"
                        . "<p>* Empresa: <b>" . $solicitud["data"][0]["empresa"] . "</b></p>"
                        . "<p>* Solicita: <b>" . $solicitud["data"][0]["solicita_usuario"]["data"][0]["nombre"] . " " . $solicitud["data"][0]["solicita_usuario"]["data"][0]["apellidos"] . "</b></p>"
                        . "<p>* Beneficiario: <b>" . $solicitud["data"][0]["beneficiario_txt"] . "</b></p>"
                        . "<p>* Banco: <b>" . $solicitud["data"][0]["banco"] . "</b></p>"
                        . "<p>* Cuenta: <b>" . $solicitud["data"][0]["cuenta"] . "</b></p>"
                        . "<p>* CLABE: <b>" . $solicitud["data"][0]["clabe"] . "</b></p>"
                        . "<p>* Tipo de solicitud: <b>" . $solicitud["data"][0]["tipo_solicitud"]["data"][0]["nombre"] . "</b></p>"
                        . "<p>* Proyecto: <b>" . $solicitud["data"][0]["proyecto"] . "</b></p>"
                        . "<p>* Importe: <b>$" . number_format($solicitud["data"][0]["importe"], 2) . "</b></p>"
                        . "<p>* Concepto: <b>" . $solicitud["data"][0]["descripcion"] . "</b></p>"
                        . "<p>* Forma de pago: <b>" . $solicitud["data"][0]["forma_pago_nombre"] . "</b></p>";

                $foot = "<br /><br />";
                $foot .= "<p align='center'><a href='http://arjion.com/gac/controller/auth_gac.php?id=" . $id . "&p=2&auth=3'><b style='color: green;'>AUTORIZAR SOLICITUD</b></a></p>";
                $foot .= "<p align='center'><a href='http://arjion.com/gac/controller/auth_gac.php?id=" . $id . "&p=2&auth=0'><b style='color: red;'>RECHAZAR SOLICITUD</b></a></p>";
//
                $model->agregarSolBitacora($id, "Seleccion por parte de DG " . $estado, $auth);
                if ($flag === 1) {
                    if (intval($solicitud["data"][0]["id_tipo"]) === 5) {//Reembolso
                        $archivos = $model->getArchivosComprobantes("id_solicitud = " . $id);
                        sendM2($usuario["data"]->correo, $usuario["data"]->nombre, $subject, $msg . $foot, $path, $archivos["data"]);
                    } else {
                        sendM($subject, $usuario["data"]->nombre, $msg . $foot, $usuario["data"]->correo);
                    }
                } else {
                    $usuario = $model->getUsrByIdGral($solicitud["data"][0]["solicita"]);
                    sendM($subject, $usuario["data"]->nombre, $msg, $usuario["data"]->correo);
                }
            }
            echo json_encode($authOutp);
            break;
        case 12://Autoriza o rechaza DAF
            $id = $data["id"];
            $auth = $data["auth"];
            $path = $_SERVER["DOCUMENT_ROOT"] . "/gac/comprobantes/";

            $flag = 0;
            $estado = "<b style='color: red;'>rechazada</b>";
            if (intval($auth) !== 0) {
                $estado = "<b style='color: green;'>autorizada</b>";
                $flag = 1;
            }


            $authOutp = $model->authSolicitudGAC($id, $auth);
            if (intval($authOutp["errorCode"]) === 0) {
                //Registramos en bitacora

                $solicitud = $model->getSolicitudesGAC("id = " . $id);
                //Actualizar fecha de atencion
                $model->updateFechaAtt($id);
                $tipo_solicitud = $model->getTipoSolicitudes("id = " . $solicitud["data"][0]["id_tipo"]);
//                                                        $usuario = $model->getUsrByIdGral($tipo_solicitud["data"][0]["id_notificacion"]);
                $subject = "Solicitud de gastos a comprobar ";
                $msg = " <p>Ha sido " . $estado . " una solicitud por parte DAF, la información es la siguiente:</p>"
                        . "<p>* Empresa: <b>" . $solicitud["data"][0]["empresa"] . "</b></p>"
                        . "<p>* Solicita: <b>" . $solicitud["data"][0]["solicita_usuario"]["data"][0]["nombre"] . " " . $solicitud["data"][0]["solicita_usuario"]["data"][0]["apellidos"] . "</b></p>"
                        . "<p>* Beneficiario: <b>" . $solicitud["data"][0]["beneficiario_txt"] . "</b></p>"
                        . "<p>* Banco: <b>" . $solicitud["data"][0]["banco"] . "</b></p>"
                        . "<p>* Cuenta: <b>" . $solicitud["data"][0]["cuenta"] . "</b></p>"
                        . "<p>* CLABE: <b>" . $solicitud["data"][0]["clabe"] . "</b></p>"
                        . "<p>* Tipo de solicitud: <b>" . $solicitud["data"][0]["tipo_solicitud"]["data"][0]["nombre"] . "</b></p>"
                        . "<p>* Proyecto: <b>" . $solicitud["data"][0]["proyecto"] . "</b></p>"
                        . "<p>* Importe: <b>$" . number_format($solicitud["data"][0]["importe"], 2) . "</b></p>"
                        . "<p>* Concepto: <b>" . $solicitud["data"][0]["descripcion"] . "</b></p>"
                        . "<p>* Forma de pago: <b>" . $solicitud["data"][0]["forma_pago_nombre"] . "</b></p>";

                if (intval($auth) === 2) {
                    $model->agregarSolBitacora($id, "Envio a Direccion General", $auth);
                    $usuario = $model->getUsrByIdGral(ID_DIRECCION_GENERAL);
                    $msg = " <p>DAF ha solicitado su autorización para la siguiente solicitud de gastos a comprobar, la información es la siguiente:</p>"
                            . "<p>* Empresa: <b>" . $solicitud["data"][0]["empresa"] . "</b></p>"
                            . "<p>* Solicita: <b>" . $solicitud["data"][0]["solicita_usuario"]["data"][0]["nombre"] . " " . $solicitud["data"][0]["solicita_usuario"]["data"][0]["apellidos"] . "</b></p>"
                            . "<p>* Beneficiario: <b>" . $solicitud["data"][0]["beneficiario_txt"] . "</b></p>"
                            . "<p>* Banco: <b>" . $solicitud["data"][0]["banco"] . "</b></p>"
                            . "<p>* Cuenta: <b>" . $solicitud["data"][0]["cuenta"] . "</b></p>"
                            . "<p>* CLABE: <b>" . $solicitud["data"][0]["clabe"] . "</b></p>"
                            . "<p>* Tipo de solicitud: <b>" . $solicitud["data"][0]["tipo_solicitud"]["data"][0]["nombre"] . "</b></p>"
                            . "<p>* Proyecto: <b>" . $solicitud["data"][0]["proyecto"] . "</b></p>"
                            . "<p>* Importe: <b>$" . number_format($solicitud["data"][0]["importe"], 2) . "</b></p>"
                            . "<p>* Concepto: <b>" . $solicitud["data"][0]["descripcion"] . "</b></p>"
                            . "<p>* Forma de pago: <b>" . $solicitud["data"][0]["forma_pago_nombre"] . "</b></p>";
                    $msg .= "<br /><br />";
                    $msg .= "<p align='center'><a href='http://arjion.com/gac/controller/auth_gac.php?id=" . $id . "&p=1&auth=1'><b style='color: green;'>AUTORIZAR SOLICITUD</b></a></p>";
                    $msg .= "<p align='center'><a href='http://arjion.com/gac/controller/auth_gac.php?id=" . $id . "&p=1&auth=0'><b style='color: red;'>RECHAZAR SOLICITUD</b></a></p>";
                    if (intval($solicitud["data"][0]["id_tipo"]) === 5) {//Reembolso
                        $archivos = $model->getArchivosComprobantes("id_solicitud = " . $id);
                        sendM2($usuario["data"]->correo, $usuario["data"]->nombre, $subject, $msg, $path, $archivos["data"]);
                    } else {
                        sendM($subject, $usuario["data"]->nombre, $msg, $usuario["data"]->correo);
                    }
                } else {
                    $model->agregarSolBitacora($id, "Seleccion por parte de DAF " . $estado, $auth);
                    $usuario = $model->getUsrByIdGral($solicitud["data"][0]["solicita"]);
                    if (intval($solicitud["data"][0]["id_tipo"]) === 5) {//Reembolso
                        $archivos = $model->getArchivosComprobantes("id_solicitud = " . $id);
                        sendM2($usuario["data"]->correo, $usuario["data"]->nombre, $subject, $msg, $path, $archivos["data"]);
                    } else {
                        sendM($subject, $usuario["data"]->nombre, $msg, $usuario["data"]->correo);
                    }
                    sleep(2);
                    if (intval($solicitud["data"][0]["beneficiario"]) === 0) {
                        $beneficiario = $model->getUsrByIdGral($solicitud["data"][0]["solicita"]);
                    } else {
                        $beneficiario = $model->getUsrByIdGral($solicitud["data"][0]["beneficiario"]);
                    }
                    sendM($subject, $beneficiario["data"]->nombre, $msg, $beneficiario["data"]->correo);
                }
            }
            echo json_encode($authOutp);
            break;
        case 13://autorizacion de comprobantes de DA.
            $auth_da = NULL;
            $query = "";
            $id_solicitud = 0;
            foreach ($data["idsC"] as $key => $c) {
                if (end($data["idsC"]) === $c) {
                    $query .= " id = " . $c;
                } else {
                    $query .= " id = " . $c . " OR ";
                }
                //Actualizamos estatus de comprobante
                $auth_da = $model->updateEstatusComp($c, $data["estatus"]);
                $model->agregarSolBitacora($data["id_solicitud"], "Envío de comprobantes", 4);
            }
            $comprobantes = $model->getComprobantes($query);
            $solicitud = $model->getSolicitudesGAC("id = " . $comprobantes["data"][0]["id_solicitud"]);
//            var_dump($comprobantes);
//            var_dump($solicitud);
//            echo $query;
            if (intval($auth_da["errorCode"]) === 0) {
                //Enviamos notitificacion a DA de solicitud
                $proceso = 5;
                $estatus_comp = "Autorizado(s)";
                if (intval($data["estatus"]) === 5) {
                    $estatus_comp = "Rechazado(s)";
                }
                $model->agregarSolBitacora($data["id_solicitud"], "Validación de comprobantes por parte de DA con estatus " . $estatus_comp, $data["estatus"]);
                include_once './send_nots.php';
            }
            echo json_encode($auth_da);
            break;

        case 14://autorizacion de comprobantes de DA.
            $auth_caj = NULL;
            $query = "";
            $id_solicitud = 0;
            foreach ($data["idsC"] as $key => $c) {
                if (end($data["idsC"]) === $c) {
                    $query .= " id = " . $c;
                } else {
                    $query .= " id = " . $c . " OR ";
                }
                //Actualizamos estatus de comprobante
                $auth_caj = $model->updateEstatusComp($c, $data["estatus"]);
            }
            $comprobantes = $model->getComprobantes($query);
            $solicitud = $model->getSolicitudesGAC("id = " . $comprobantes["data"][0]["id_solicitud"]);
//            var_dump($comprobantes);
//            var_dump($solicitud);
//            echo $query;
            if (intval($auth_caj["errorCode"]) === 0) {
//                if (intval($data["restante"]) <= 0) {//Si ya se cubrio el momento cerra la solicitud
//                    $model->authSolicitudGAC($comprobantes["data"][0]["id_solicitud"], 5);
//                }
                //Enviamos notitificacion a DA de solicitud
                $proceso = 6;
                $estatus_comp = "Autorizado(s)";
                if (intval($data["estatus"]) === 5) {
                    $estatus_comp = "Rechazado(s)";
                }
                $model->agregarSolBitacora($comprobantes["data"][0]["id_solicitud"], "Validación de comprobantes por parte del RF con estatus " . $estatus_comp, $data["estatus"]);
                include_once './send_nots.php';
            }

            echo json_encode($auth_caj);
            break;
        case 15:
            $close_request = $model->authSolicitudGAC($data["id"], 5);
            echo json_encode($close_request);
            break;
        case 16;
//            var_dump($_REQUEST);
            $path = $_SERVER["DOCUMENT_ROOT"] . "/gac/comprobantes/";
            //Archivos        
            $archivos = $model->getArchivosComprobantes("id_solicitud = " . $data["id_solicitud"]);
            //Solicitud
            $solicitud = $model->getSolicitudesGAC("id = " . $data["id_solicitud"]);

            $usuario = null;
            $msg3 = "";
            if ($data["nivel"] === "B") {
                if (intval($data["jefe"]) === 0) {
                    $usuario = $model->getUsrByIdGral($data["id_director"]);
                } else {

                    $usuario = $model->getUsrByIdGral($data["jefe"]);
                }
                $msg3 .= "Por favor entra a Arjion para autorizar o rechazar la solicitud.";
            } else {
                $usuario = $model->getUsrByIdGral(ID_DIRECCION_AF);
                //Cambiar estatus d esolicitud a enviada DAF pendiente de autorización
                $aut_sol = $model->authSolicitudGAC($data["id_solicitud"], 1);
                $msg3 .= "<br /><br />";
                $msg3 .= "<p align='center'><a href='http://arjion.com/gac/controller/auth_gac.php?id=" . $data["id_solicitud"] . "&p=2&auth=3'><b style='color: green;'>AUTORIZAR SOLICITUD</b></a></p>";
                $msg3 .= "<p align='center'><a href='http://arjion.com/gac/controller/auth_gac.php?id=" . $data["id_solicitud"] . "&p=2&auth=2'><b style='color: aqua;'>ENVIAR A DG PARA AUTORIZACION</b></a></p>";
                $msg3 .= "<p align='center'><a href='http://arjion.com/gac/controller/auth_gac.php?id=" . $data["id_solicitud"] . "&p=2&auth=0'><b style='color: red;'>RECHAZAR SOLICITUD</b></a></p>";
            }

            $subject = "Solicitud de gastos a comprobar ";
            $msg2 = " <p>Ha sido generada una solicitud de reembolso con la siguiente información:</p>"
                    . "<p>* Empresa: <b>" . $solicitud["data"][0]["empresa"] . "</b></p>"
                    . "<p>* Solicita: <b>" . $solicitud["data"][0]["solicita_usuario"]["data"][0]["nombre"] . " " . $solicitud["data"][0]["solicita_usuario"]["data"][0]["apellidos"] . "</b></p>"
                    . "<p>* Beneficiario: <b>" . $solicitud["data"][0]["beneficiario_txt"] . "</b></p>"
                    . "<p>* Banco: <b>" . $solicitud["data"][0]["banco"] . "</b></p>"
                    . "<p>* Cuenta: <b>" . $solicitud["data"][0]["cuenta"] . "</b></p>"
                    . "<p>* CLABE: <b>" . $solicitud["data"][0]["clabe"] . "</b></p>"
                    . "<p>* Tipo de solicitud: <b>" . $solicitud["data"][0]["tipo_solicitud"]["data"][0]["nombre"] . "</b></p>"
                    . "<p>* Proyecto: <b>" . $solicitud["data"][0]["proyecto"] . "</b></p>"
                    . "<p>* Importe: <b>$" . number_format($solicitud["data"][0]["importe"], 2) . "</b></p>"
                    . "<p>* Concepto: <b>" . $solicitud["data"][0]["descripcion"] . "</b></p>"
                    . "<p>* Forma de pago: <b>" . $solicitud["data"][0]["forma_pago_nombre"] . "</b></p>";

            $send = sendM2($usuario["data"]->correo, $usuario["data"]->nombre, $subject, $msg2 . $msg3, $path, $archivos["data"]);

            echo json_encode($send);
            break;
        case 17: //Autoriza o rechaza DG

            $flag = 0;
            $estado = "<b style='color: red;'>rechazada</b>";
            if (intval($data["auth"]) !== 0) {
                $estado = "<b style='color: green;'>autorizada</b>";
                $flag = 1;
            }
            $solicitud = $model->getSolicitudesGAC("id = " . $data["id"]);
            $jefe = $model->getUsrByIdGral($solicitud["data"][0]["jefe_inmediato"]);
            $usuario = $model->getUsrByIdGral($jefe["data"]->id_director_area);
            $subject = "Solicitud de gastos a comprobar ";
            $msg = " <p>Ha sido " . $estado . " una solicitud de gastos a comprobar, la información es la siguiente:</p>"
                    . "<p>* Empresa: <b>" . $solicitud["data"][0]["empresa"] . "</b></p>"
                    . "<p>* Solicita: <b>" . $solicitud["data"][0]["solicita_usuario"]["data"][0]["nombre"] . " " . $solicitud["data"][0]["solicita_usuario"]["data"][0]["apellidos"] . "</b></p>"
                    . "<p>* Beneficiario: <b>" . $solicitud["data"][0]["beneficiario_txt"] . "</b></p>"
                    . "<p>* Banco: <b>" . $solicitud["data"][0]["banco"] . "</b></p>"
                    . "<p>* Cuenta: <b>" . $solicitud["data"][0]["cuenta"] . "</b></p>"
                    . "<p>* CLABE: <b>" . $solicitud["data"][0]["clabe"] . "</b></p>"
                    . "<p>* Tipo de solicitud: <b>" . $solicitud["data"][0]["tipo_solicitud"]["data"][0]["nombre"] . "</b></p>"
                    . "<p>* Proyecto: <b>" . $solicitud["data"][0]["proyecto"] . "</b></p>"
                    . "<p>* Importe: <b>$" . number_format($solicitud["data"][0]["importe"], 2) . "</b></p>"
                    . "<p>* Concepto: <b>" . $solicitud["data"][0]["descripcion"] . "</b></p>"
                    . "<p>* Forma de pago: <b>" . $solicitud["data"][0]["forma_pago_nombre"] . "</b></p>";

            $foot = "<br /><br />";
            $foot .= "<p align='center'><a href='http://arjion.com/gac/controller/auth_gac.php?id=" . $data["id"] . "&p=2&auth=3'><b style='color: green;'>AUTORIZAR SOLICITUD</b></a></p>";
            $foot .= "<p align='center'><a href='http://arjion.com/gac/controller/auth_gac.php?id=" . $data["id"] . "&p=2&auth=0'><b style='color: red;'>RECHAZAR SOLICITUD</b></a></p>";
//
            if ($flag === 1) {
                if (intval($solicitud["data"][0]["id_tipo"]) === 5) {//Reembolso
                    $archivos = $model->getArchivosComprobantes("id_solicitud = " . $data["id"]);
                    sendM2($usuario["data"]->correo, $usuario["data"]->nombre, $subject, $msg . $foot, $path, $archivos["data"]);
                } else {
                    sendM($subject, $usuario["data"]->nombre, $msg . $foot, $usuario["data"]->correo);
                }
            } else {
                $usuario = $model->getUsrByIdGral($solicitud["data"][0]["solicita"]);
                sendM($subject, $usuario["data"]->nombre, $msg, $usuario["data"]->correo);
            }
            $authOutp = $model->authSolicitudGACB($data["id"], $data["auth"]);
            echo json_encode($authOutp);
            break;
        case 18: //Autoriza DA a su BB
            $path = $_SERVER["DOCUMENT_ROOT"] . "/gac/comprobantes/";
            $flag = 0;
            $estado = "<b style='color: red;'>rechazada</b>";
            if (intval($data["auth"]) !== 0) {
                $estado = "<b style='color: green;'>autorizada</b>";
                $flag = 1;
            }
            $solicitud = $model->getSolicitudesGAC("id = " . $data["id"]);
            $usuario = $model->getUsrByIdGral($solicitud["data"][0]["id_tipo"]);
            $subject = "Nueva solicitud de gastos a comprobar";
            $msg = " <p>Ha sido registrada una nueva solicitud de gastos a comprobar  por lo cual se "
                    . "requiere de tu intervención, la información es la siguiente:</p>"
                    . "<p>* Empresa: <b>" . $solicitud["data"][0]["empresa"] . "</b></p>"
                    . "<p>* Solicita: <b>" . $solicitud["data"][0]["solicita_usuario"]["data"][0]["nombre"] . " " . $solicitud["data"][0]["solicita_usuario"]["data"][0]["apellidos"] . "</b></p>"
                    . "<p>* Beneficiario: <b>" . $solicitud["data"][0]["beneficiario_txt"] . "</b></p>"
                    . "<p>* Banco: <b>" . $solicitud["data"][0]["banco"] . "</b></p>"
                    . "<p>* Cuenta: <b>" . $solicitud["data"][0]["cuenta"] . "</b></p>"
                    . "<p>* CLABE: <b>" . $solicitud["data"][0]["clabe"] . "</b></p>"
                    . "<p>* Tipo de solicitud: <b>" . $solicitud["data"][0]["tipo_solicitud"]["data"][0]["nombre"] . "</b></p>"
                    . "<p>* Proyecto: <b>" . $solicitud["data"][0]["proyecto"] . "</b></p>"
                    . "<p>* Importe: <b>$" . number_format($solicitud["data"][0]["importe"], 2) . "</b></p>"
                    . "<p>* Concepto: <b>" . $solicitud["data"][0]["descripcion"] . "</b></p>"
                    . "<p>* Forma de pago: <b>" . $solicitud["data"][0]["forma_pago_nombre"] . "</b></p>";

            $msg .= "<br /><br />";
            $msg .= "<p align='center'><a href='http://arjion.com/gac/controller/auth_gac.php?id=" . $data["id"] . "&p=2&auth=3'><b style='color: green;'>AUTORIZAR SOLICITUD</b></a></p>";
            $msg .= "<p align='center'><a href='http://arjion.com/gac/controller/auth_gac.php?id=" . $data["id"] . "&p=2&auth=2'><b style='color: aqua;'>ENVIAR A DG PARA AUTORIZACION</b></a></p>";
            $msg .= "<p align='center'><a href='http://arjion.com/gac/controller/auth_gac.php?id=" . $data["id"] . "&p=2&auth=0'><b style='color: red;'>RECHAZAR SOLICITUD</b></a></p>";
//
            $model->agregarSolBitacora($data["id"], "Direccion de area " . $estado . " solicitud", $data["auth"]);
            if ($flag === 1) {
//                if (intval($solicitud["data"][0]["id_tipo"]) === 5) {//Reembolso
                $usuario = $model->getUsrByIdGral(ID_DIRECCION_AF);
                $archivos = $model->getArchivosComprobantes("id_solicitud = " . $data["id"]);
                sendM2($usuario["data"]->correo, $usuario["data"]->nombre, $subject, $msg, $path, $archivos["data"]);
//                } else {
//                    sendM($subject, $usuario["data"]->nombre, $msg, $usuario["data"]->correo);
//                }
            } else {
                $usuario = $model->getUsrByIdGral($solicitud["data"][0]["solicita"]);
                sendM($subject, $usuario["data"]->nombre, $msg, $usuario["data"]->correo);
            }
            $authOutp = $model->authSolicitudGAC($data["id"], $data["auth"]);
            echo json_encode($authOutp);
            break;
        case 19:
            $del_request = $model->authSolicitudGAC($data["id"], 9);
            echo json_encode($del_request);
            break;
        case 20://autorizacion de comprobantes de DA.
            $auth_caj = NULL;
            $query = "";
            $id_solicitud = 0;

            $estatus_txt = "";
            if (intval($data["estatus"]) === 2) {
                $estatus_txt = "Autorizado";
            } else {
                $estatus_txt = "Rechazado";
            }

            foreach ($data["idsC"] as $key => $c) {
                $model->agregarSolBitacora($data["id_solicitud"], "Se valida comprobante #" . $c . "# con estatus de " . $estatus_txt, $data["estatus"]);
                if (end($data["idsC"]) === $c) {
                    $query .= " id = " . $c;
                } else {
                    $query .= " id = " . $c . " OR ";
                }
                //Actualizamos estatus de comprobante
                $auth_caj = $model->updateEstatusArchivosComp($c, $data["estatus"]);
            }
            $comprobantes = $model->getArchivosComprobantes($query);
            $solicitud = $model->getSolicitudesGAC("id = " . $comprobantes["data"][0]["id_solicitud"]);
//            var_dump($comprobantes);
//            var_dump($solicitud);
//            echo $query;
            if (intval($auth_caj["errorCode"]) === 0) {
//                if (intval($data["restante"]) <= 0) {//Si ya se cubrio el momento cerra la solicitud
//                    $model->authSolicitudGAC($comprobantes["data"][0]["id_solicitud"], 5);
//                }
                //Enviamos notitificacion a DA de solicitud
                $proceso = 8;
                $estatus_comp = "Autorizado(s)";
                if (intval($data["estatus"]) === 0) {
                    $estatus_comp = "Rechazado(s)";
                }
                include_once './send_nots.php';
            }

            echo json_encode($auth_caj);
            break;
        case 22: //Enviar notificacion de envio de solicitud
            $solicitud = $model->getSolicitudesGAC("id = " . $data["id"]);
            $proceso = 9;
            include_once './send_nots.php';
            echo json_encode($solicitud);
            break;
        case 23: //Enviar notificacion a DAF sobre cierre Y/o pago de solicitud
//            var_dump($data);
            $solicitud = $model->getSolicitudesGAC("id = " . $data["id"]);
//            var_dump($solicitud);
            $authOutp = $model->authSolicitudGAC($data["id"], $data["estatus"]);
            $model->agregarSolBitacora($data["id"], "Se envía solicitud a DAF para pago", $data["estatus"]);
            if (intval($authOutp["errorCode"] === 0)) {
                $proceso = 10;
                include_once './send_nots.php';
            }
            echo json_encode($solicitud);
            break;
        case 24://Paga DAF
            $solicitud = $model->getSolicitudesGAC("id = " . $data["id"]);
            $updatePago = null;
            $updatePago = $model->updateFechaPagR($data["id"]);
            $model->agregarSolBitacora($data["id"], "Se realiza pago y/o cierre de solicitud", $data["estatus"]);
            if (intval($updatePago["errorCode"]) === 0) {
                //Enviamos notitificacion a DA de solicitud
                $proceso = 4;
                include_once './send_nots.php';
            }
            echo json_encode($updatePago);
            break;
        case 25:
            $addDepo = $model->addRegistroCCH($data);
            echo json_encode($addDepo);
            break;

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
    $sendMail = $utils->sendMail($correo_destinatario, $destinatario, $subject, $msg);
    return $sendMail;
}

function sendM2($correo, $nombre, $subject, $body, $path, $archivos) {
    $utils = Utils::utlsSngltn();
    $url = SYSTEM_PATH . 'utils/templates/send_alert.php?destinatario=' . urlencode($nombre) . "&msg=" . urlencode($body);
    $msg = $utils->getPageHTML($url, '<html>', '</html>');
    $sendMail = $utils->sendAttachments($correo, $nombre, $subject, $msg, $path, $archivos);
    return $sendMail;
}
