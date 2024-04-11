<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
//header("Access-Control-Allow-Origin: *");

require_once '../model/Model.php';
$model = Model::ModelSngltn();

$daf = $model->getUsrByIdGral(ID_DIRECCION_AF);
$cajero = $model->getUsrByIdGral(ID_CP);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>DIRAC | Ingenieros Consultores</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <body style="margin: 0; padding: 0;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">	
            <tr>
                <td style="padding: 10px 0 30px 0;">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
                        <tr>
                            <td align="center" bgcolor="#FEFEFE" style="padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
                                 <!--<img src="<?php //  echo SYSTEM_PATH;                                               ?>dist/img/arjion1.png" alt="Creating Email Magic" width="200" height="130" style="display: block;" />-->
                                <img src="../dist/img/arjion1.png" alt="Creating Email Magic" width="200" height="130" style="display: block;" />
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td align="center" style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                                            <?php
                                            $id = $_REQUEST["id"];
                                            $proceso = $_REQUEST["p"];
                                            $auth = $_REQUEST["auth"];
                                            $path = $_SERVER["DOCUMENT_ROOT"] . "/gac/comprobantes/";

                                            $flag = 0;
                                            $estado = "<b style='color: red;'>rechazada</b>";
                                            if (intval($auth) !== 0) {
                                                $estado = "<b style='color: green;'>autorizada</b>";
                                                $flag = 1;
                                            }
                                            $solicitud = $model->getSolicitudesGAC("id = " . $id);
                                            $tipo_solicitud = $model->getTipoSolicitudes("id = " . $solicitud["data"][0]["id_tipo"]);
                                            //var_dump($solicitud["data"][0]["estatus"]);
                                            if (intval($solicitud["data"][0]["estatus"]) === 9) {
                                                echo '<b style="color: #F89E44">La solicitud ha sido eliminada por el usuario</b>';
                                            } else {
                                                $authOutp = $model->authSolicitudGAC($id, $auth);
                                                if (intval($authOutp["errorCode"]) === 0) {
                                                    switch (intval($proceso)) {
                                                        case 1:// Autorizo DG por un exceso de tope en la solicitud, enviamos notificacion a DAF
//                                                        $tipo_solicitud = $model->getTipoSolicitudes("id = " . $solicitud["data"][0]["id_tipo"]);
//                                                        $solicitud = $model->getSolicitudesGAC("id = " . $id);
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
//                                                            $foot .= "<p align='center'><a href='http://arjion.com/gac/controller/auth_gac.php?id=" . $id . "&p=2&auth=3'><b style='color: green;'>AUTORIZAR SOLICITUD</b></a></p>";
//                                                            $foot .= "<p align='center'><a href='http://arjion.com/gac/controller/auth_gac.php?id=" . $id . "&p=2&auth=0'><b style='color: red;'>RECHAZAR SOLICITUD</b></a></p>";
//
                                                            if ($flag === 1) {
                                                                $archivos = $model->getArchivosComprobantes("id_solicitud = " . $id);
//                                                                sendM2($usuario["data"]->correo, $usuario["data"]->nombre, $subject, $msg . $foot, $path, $archivos["data"]);
                                                                sendM2($daf["data"]->correo, $daf["data"]->nombre, $subject, $msg . $foot, $path, $archivos["data"]);
                                                                sendM2($cajero["data"]->correo, $cajero["data"]->nombre, $subject, $msg . $foot, $path, $archivos["data"]);
                                                            } else {
                                                                $usuario = $model->getUsrByIdGral($solicitud["data"][0]["solicita"]);
                                                                sendM($subject, $usuario["data"]->nombre, $msg, $usuario["data"]->correo);
                                                                sendM($subject, $daf["data"]->nombre, $msg, $daf["data"]->correo);
                                                            }
                                                            echo $msg;
                                                            break;
                                                        case 2:// DAF Decide que3 hacer con la solicitud
//                                                        $solicitud = $model->getSolicitudesGAC("id = " . $id);
                                                            //Actualizar fecha de atencion
                                                            $model->updateFechaAtt($id);
//                                                        $tipo_solicitud = $model->getTipoSolicitudes("id = " . $solicitud["data"][0]["id_tipo"]);
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
                                                                $msg .= "<p align='center'><a href='http://arjion.com/gac/controller/auth_gac.php?id=" . $id . "&p=1&auth=3'><b style='color: green;'>AUTORIZAR SOLICITUD</b></a></p>";
                                                                $msg .= "<p align='center'><a href='http://arjion.com/gac/controller/auth_gac.php?id=" . $id . "&p=1&auth=0'><b style='color: red;'>RECHAZAR SOLICITUD</b></a></p>";
                                                                $archivos = $model->getArchivosComprobantes("id_solicitud = " . $id);
                                                                sendM2($usuario["data"]->correo, $usuario["data"]->nombre, $subject, $msg . $foot, $path, $archivos["data"]);
                                                            } else {
                                                                $usuario = $model->getUsrByIdGral($solicitud["data"][0]["solicita"]);
                                                                sendM($subject, $usuario["data"]->nombre, $msg, $usuario["data"]->correo);
                                                                sleep(2);
                                                                $beneficiario = $model->getUsrByIdGral($solicitud["data"][0]["beneficiario"]);
                                                                sendM($subject, $beneficiario["data"]->nombre, $msg, $beneficiario["data"]->correo);
                                                            }
//                                                       

                                                            echo $msg;
                                                            break;
                                                        case 3:// Autoriza un B solicitud de un B
//                                                        $tipo_solicitud = $model->getTipoSolicitudes("id = " . $solicitud["data"][0]["id_tipo"]);
//                                                        $solicitud = $model->getSolicitudesGAC("id = " . $id);
                                                            //Buscamos al A del usuario
                                                            $jefe = $model->getUsrByIdGral($solicitud["data"][0]["jefe_inmediato"]);
                                                            $usuario = $model->getUsrByIdGral($jefe["data"]->id_director_area);
                                                            $subject = "Solicitud de gastos a comprobar ";
                                                            $msg = " <p>Se ha generado una solicitud de gastos a comprobar, la información es la siguiente:</p>"
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
                                                            $authOutp = $model->authSolicitudGACB($id, $auth);
                                                            echo $msg;
                                                            break;
                                                        case 4:// Autorizo DA Un pago de remmbolso o proveedore
//                                                        $tipo_solicitud = $model->getTipoSolicitudes("id = " . $solicitud["data"][0]["id_tipo"]);
//                                                        $solicitud = $model->getSolicitudesGAC("id = " . $id);
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
                                                            if ($flag === 1) {
                                                                $archivos = $model->getArchivosComprobantes("id_solicitud = " . $id);
                                                                sendM2($usuario["data"]->correo, $usuario["data"]->nombre, $subject, $msg . $foot, $path, $archivos["data"]);
                                                            } else {
                                                                $usuario = $model->getUsrByIdGral($solicitud["data"][0]["solicita"]);
                                                                sendM($subject, $usuario["data"]->nombre, $msg, $usuario["data"]->correo);
                                                            }
                                                            echo $msg;
                                                            break;

                                                        default:
                                                            break;
                                                    }
                                                    echo '<b style="color: green;">Solicitud procesada exitosamente.</b>';
                                                } else {
                                                    echo '<b style="color: #F89E44">' . $authOutp["msg"] . '</b>';
                                                }
                                            }

                                            function sendM($subject, $destinatario, $body, $correo_destinatario) {
                                                $utils = Utils::utlsSngltn();
                                                $url = SYSTEM_PATH . 'utils/templates/send_alert.php?destinatario=' . urlencode($destinatario) . "&msg=" . urlencode($body);
                                                $msg = $utils->getPageHTML($url, '<html>', '</html>');
                                                $sendMail = $utils->sendMail($correo_destinatario, $destinatario, utf8_decode($subject), $msg);
                                                return $sendMail;
                                            }

                                            function sendM2($correo, $nombre, $subject, $body, $path, $archivos) {
                                                $utils = Utils::utlsSngltn();
                                                $url = SYSTEM_PATH . 'utils/templates/send_alert.php?destinatario=' . urlencode($nombre) . "&msg=" . urlencode($body);
                                                $msg = $utils->getPageHTML($url, '<html>', '</html>');
                                                $sendMail = $utils->sendAttachments($correo, $nombre, $subject, $msg, $path, $archivos);
                                                return $sendMail;
                                            }
                                            ?>
                                        </td>
                                    </tr>                                    
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#003365" style="padding: 30px 30px 30px 30px;">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;" width="75%">
                                            &reg; DIRAC | Ingenieros Consultores<br/>
                                            <!--<a href="#" style="color: #ffffff;"><font color="#ffffff">Unsubscribe</font></a> to this newsletter instantly-->
                                        </td>
                                        <td align="right" width="25%">
                                            <table border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>