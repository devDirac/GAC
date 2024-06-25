<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../model/Model.php';
require_once '../utils/Utils.php';
$model = Model::ModelSngltn();

switch ($proceso) {
    case 1://Enviar correo a notificacion para autorizar solicitud de gac que excede del tope cargado
//        $usuario = $model->getUsrByIdGral($tipo_solicitud["data"][0]["id_notificacion"]);
        $usuario = $model->getUsrByIdGral(ID_DIRECCION_GENERAL);
        $solicitud = $model->getSolicitudesGAC("id = " . $addGAC["data"]);
        $subject = "Nueva solicitud de gastos a comprobar";
        $msg = " <p>Ha sido registrada una nueva solicitud de gastos a comprobar con excedente del maximo registrado por DAF, por lo cual se "
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
        $msg .= "<p align='center'><a href='http://arjion.com/gac/controller/auth_gac.php?id=" . $addGAC["data"] . "&p=1&auth=1'><b style='color: green;'>AUTORIZAR SOLICITUD</b></a></p>";
        $msg .= "<p align='center'><a href='http://arjion.com/gac/controller/auth_gac.php?id=" . $addGAC["data"] . "&p=1&auth=0'><b style='color: red;'>RECHAZAR SOLICITUD</b></a></p>";

        sendMN($subject, $usuario["data"]->nombre, $msg, $usuario["data"]->correo, "send_alert.php");
        break;

    case 2://Enviar correo a notificacion para autorizar solicitud de gac
        $usuario = $model->getUsrByIdGral($tipo_solicitud["data"][0]["id_notificacion"]);
        $solicitud = $model->getSolicitudesGAC("id = " . $addGAC["data"]);
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
        $msg .= "<p align='center'><a href='http://arjion.com/gac/controller/auth_gac.php?id=" . $addGAC["data"] . "&p=2&auth=3'><b style='color: green;'>AUTORIZAR SOLICITUD</b></a></p>";
        $msg .= "<p align='center'><a href='http://arjion.com/gac/controller/auth_gac.php?id=" . $addGAC["data"] . "&p=2&auth=2'><b style='color: aqua;'>ENVIAR A DG PARA AUTORIZACION</b></a></p>";
        $msg .= "<p align='center'><a href='http://arjion.com/gac/controller/auth_gac.php?id=" . $addGAC["data"] . "&p=2&auth=0'><b style='color: red;'>RECHAZAR SOLICITUD</b></a></p>";

        sendMN($subject, $usuario["data"]->nombre, $msg, $usuario["data"]->correo, "send_alert.php");
        break;

    case 3://Enviar correo a quien solicitó sobre los comprobantes cargados
        $usuario = $model->getUsrByIdGral($solicitud["data"][0]["solicita"]);
        $subject = "Comprobantes cargados";
        $msg = " <p>Han sido cargados comprobantes de solicitud de gastos a comprobar por lo cual se "
                . "requiere de tu intervención, la información de la solicitud es la siguiente:</p>"
                . "<p>* ID: <b>" . $solicitud["data"][0]["id"] . "</b></p>"
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
        $msg .= "Para poder validar la informaci&oacute;n favor de entrar a Arjion en la sección de solicitudes a revisar.";

        sendMN($subject, $usuario["data"]->nombre, $msg, $usuario["data"]->correo, "send_alert.php");
        break;

    case 4://Enviar correo a quien solicitó sobre el pago de la solicitud        
        $solicitud = $model->getSolicitudesGAC("id = " . $data["id"]);

        $usuario = $model->getUsrByIdGral($solicitud["data"][0]["solicita"]);
        $usuario2 = $model->getUsrByIdGral($solicitud["data"][0]["beneficiario"]);

        $subject = "Solicitud de Gastos Pagada";
        $msg = " <p>Ha sido pagada una solicitud de gastos a comprobar, con la siguiente información:</p>"
                . "<p>* ID: <b>" . $solicitud["data"][0]["id"] . "</b></p>"
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
        if (intval($solicitud["data"][0]["id_tipo"]) !== 5) {
            $msg .= "Para poder comenzar a comprobar favor de entrar a Arjion en la sección de Comprobación de Gastos.";
        }

        sendMN($subject, $usuario["data"]->nombre, $msg, $usuario["data"]->correo, "send_alert.php");
        sleep(2);
        sendMN($subject, $usuario2["data"]->nombre, $msg, $usuario2["data"]->correo, "send_alert.php");
        break;

    case 5://Enviar correo a Fiscal y a usuario beneficiario
        $usuario = $model->getUsrByIdGral($solicitud["data"][0]["solicita"]);

        $subject = "Comprobante(s) " . $estatus_comp;
        $msg = " <p>Han sido " . $estatus_comp . " comprobantes de la solicitud de gastos a comprobar, con la siguiente información:</p>"
                . "<p>* ID: <b>" . $solicitud["data"][0]["id"] . "</b></p>"
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

        $comps_txt = "Información de los comprobantes:";

        foreach ($comprobantes["data"] as $key => $c) {
            $comps_txt .= "<p>" . $c["descripcion"] . ": $" . number_format($c["importe"], 2) . "</p>";
        }

        $msg .= $comps_txt;

        $msg .= "Para mas información entra a  Arjion al apartado de Gastos a Comprobar.";

        if (intval($data["estatus"]) === 5) {
            sendMN($subject, $usuario["data"]->nombre, $msg, $usuario["data"]->correo, "send_alert.php");
        } else {
            $perfiles = $model->getParams1("direccion LIKE '%GAC%'");

            $fiscal = $perfiles["data"][0]["valor"];
            $admistrativo = $perfiles["data"][1]["valor"];
            $cajero = $perfiles["data"][2]["valor"];
            $usuario2 = $model->getUsrByIdGral($cajero);

            sendMN($subject, $usuario["data"]->nombre, $msg, $usuario["data"]->correo, "send_alert.php");
            sleep(2);
            sendMN($subject, $usuario2["data"]->nombre, $msg, $usuario2["data"]->correo, "send_alert.php");
        }
        break;

    case 6://Enviar correo DA y a beneficiario
        $usuario = $model->getUsrByIdGral($solicitud["data"][0]["solicita"]);
        $usuario2 = $model->getUsrByIdGral($solicitud["data"][0]["beneficiario"]);

        $subject = "Comprobante(s) " . $estatus_comp;
        $msg = " <p>Han sido " . $estatus_comp . " comprobantes de la solicitud de gastos a comprobar, con la siguiente información:</p>"
                . "<p>* ID: <b>" . $solicitud["data"][0]["id"] . "</b></p>"
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

        $comps_txt = "Información de los comprobantes:";

        foreach ($comprobantes["data"] as $key => $c) {
            $comps_txt .= "<p>" . $c["descripcion"] . ": $" . number_format($c["importe"], 2) . "</p>";
        }

        $msg .= $comps_txt;

        $msg .= "Para mas información entra a  Arjion al apartado de Gastos a Comprobar.";

        sendMN($subject, $usuario["data"]->nombre, $msg, $usuario["data"]->correo, "send_alert.php");
        sleep(2);
        sendMN($subject, $usuario2["data"]->nombre, $msg, $usuario2["data"]->correo, "send_alert.php");
        break;

    case 7://Enviar a Jefe inmediato B de un B
        $usuario = $model->getUsrByIdGral($data["jefe"]);
        $solicitud = $model->getSolicitudesGAC("id = " . $addGAC["data"]);
        $subject = "Nueva solicitud de gastos a comprobar";
        $msg = " <p>Ha sido registrada una nueva solicitud de gastos por lo cual se requiere de tu intervención, la información es la siguiente:</p>"
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
        $msg .= "<p align='center'><a href='http://arjion.com/gac/controller/auth_gac.php?id=" . $addGAC["data"] . "&p=3&auth=1'><b style='color: green;'>AUTORIZAR SOLICITUD</b></a></p>";
        $msg .= "<p align='center'><a href='http://arjion.com/gac/controller/auth_gac.php?id=" . $addGAC["data"] . "&p=3&auth=0'><b style='color: red;'>RECHAZAR SOLICITUD</b></a></p>";

        sendMN($subject, $usuario["data"]->nombre, $msg, $usuario["data"]->correo, "send_alert.php");
        break;
    case 8://Enviar correo DA y a beneficiario
        $usuario = $model->getUsrByIdGral($solicitud["data"][0]["solicita"]);
        $usuario2 = $model->getUsrByIdGral($solicitud["data"][0]["beneficiario"]);

        $subject = "Comprobante(s) " . $estatus_comp;
        $msg = " <p>Han sido " . $estatus_comp . " comprobantes de la solicitud de gastos a comprobar, con la siguiente información:</p>"
                . "<p>* ID: <b>" . $solicitud["data"][0]["id"] . "</b></p>"
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

        $comps_txt = "Información de los comprobantes:";

        foreach ($comprobantes["data"] as $key => $c) {
            $comps_txt .= "<p>" . $c["nombre"] . "</p>";
        }

        $msg .= $comps_txt;

        $msg .= "Para mas información entra a  Arjion al apartado de Gastos a Comprobar.";

        sendMN($subject, $usuario["data"]->nombre, $msg, $usuario["data"]->correo, "send_alert.php");
        sleep(2);
        sendMN($subject, $usuario2["data"]->nombre, $msg, $usuario2["data"]->correo, "send_alert.php");
        break;
    case 9://Enviar correo a cajero sobre carga de archivos en solicitud
        $usuario = $model->getUsrByIdGral($solicitud["data"][0]["solicita"]);

        $subject = "Comprobantes cargados";
        $msg = " <p>Han sido cargados comprobantes de solicitud de gastos a comprobar por lo cual se "
                . "requiere de tu intervención, la información de la solicitud es la siguiente:</p>"
                . "<p>* ID: <b>" . $solicitud["data"][0]["id"] . "</b></p>"
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
        $msg .= "Para poder validar la informaci&oacute;n favor de entrar a Arjion en la sección de solicitudes a revisar.";

        $perfiles = $model->getParams1("direccion LIKE '%GAC%'");

        $fiscal = $perfiles["data"][0]["valor"];
        $admistrativo = $perfiles["data"][1]["valor"];
        $cajero = $perfiles["data"][2]["valor"];
        $usuario2 = $model->getUsrByIdGral($cajero);

        sendMN($subject, $usuario2["data"]->nombre, $msg, $usuario2["data"]->correo, "send_alert.php");
        break;

    case 10://Enviar correo a DAF  para realizar el cierre de la solicitud
        $usuario = $model->getUsrByIdGral($solicitud["data"][0]["solicita"]);

        $subject = "Solicitud de gastos autorizada cargados";
        $msg = " <p>Ha sido revisada y verificada la solicitud de gastos a comprobar con la siguiente información, por lo cual se requiere de tu intervención para el cierre de la misma,"
                . "la información de la solicitud es la siguiente:</p>"
                . "<p>* ID: <b>" . $solicitud["data"][0]["id"] . "</b></p>"
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
        $msg .= "Para poder validar la informaci&oacute;n favor de entrar a Arjion en la sección de solicitudes a revisar.";

        $perfiles = $model->getParams1("direccion LIKE '%GAC%'");

        $fiscal = $perfiles["data"][0]["valor"];
        $admistrativo = $perfiles["data"][1]["valor"];
        $cajero = $perfiles["data"][2]["valor"];
        $usuario2 = $model->getUsrByIdGral($admistrativo);

        sendMN($subject, $usuario2["data"]->nombre, $msg, $usuario2["data"]->correo, "send_alert.php");
        break;
    case 11://Enviar correo a Fiscal y a usuario beneficiario
        $usuario = $model->getUsrByIdGral($solicitud["data"][0]["solicita"]);

        $subject = "Comprobante(s) cargados";
        $msg = " <p>Han sido cargados comprobantes de la solicitud de gastos a comprobar, con la siguiente información:</p>"
                . "<p>* ID: <b>" . $solicitud["data"][0]["id"] . "</b></p>"
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

        $comps_txt = "Información de los comprobantes:";

        foreach ($comprobantes["data"] as $key => $c) {
            $comps_txt .= "<p>" . $c["descripcion"] . ": $" . number_format($c["importe"], 2) . "</p>";
        }

        $msg .= $comps_txt;

        $msg .= "Para mas información entra a  Arjion al apartado de Gastos a Comprobar.";

//        if (intval($data["estatus"]) === 5) {
//            sendMN($subject, $usuario["data"]->nombre, $msg, $usuario["data"]->correo, "send_alert.php");
//        } else {
        $perfiles = $model->getParams1("direccion LIKE '%GAC%'");

        $fiscal = $perfiles["data"][0]["valor"];
        $admistrativo = $perfiles["data"][1]["valor"];
        $cajero = $perfiles["data"][2]["valor"];
        $usuario1 = $model->getUsrByIdGral($fiscal);
        $usuario2 = $model->getUsrByIdGral($cajero);

//            sendMN($subject, $usuario["data"]->nombre, $msg, $usuario["data"]->correo, "send_alert.php");
        sendMN($subject, $usuario1["data"]->nombre, $msg, $usuario1["data"]->correo, "send_alert.php");
        sleep(2);
        sendMN($subject, $usuario2["data"]->nombre, $msg, $usuario2["data"]->correo, "send_alert.php");
//        }
        break;

    default:
        break;
}

function sendMN($subject, $destinatario, $body, $correo_destinatario, $plantilla) {
    require_once '../config/properties.php';
    $utils = Utils::utlsSngltn();
    $url = SYSTEM_PATH . 'utils/templates/' . $plantilla . '?destinatario=' . urlencode($destinatario) . "&msg=" . urlencode($body);
    $msg = $utils->getPageHTML($url, '<html>', '</html>');
    $sendMail = $utils->sendMail($correo_destinatario, $destinatario, utf8_decode($subject), $msg);
    return $sendMail;
}
