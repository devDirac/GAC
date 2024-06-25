<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *");

require_once '../model/DAF.php';
$daf = DAF::DAFSngltn();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>DIRAC | Ingenieros COnsultores</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <body style="margin: 0; padding: 0;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">	
            <tr>
                <td style="padding: 10px 0 30px 0;">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
                        <tr>
                            <td align="center" bgcolor="#FEFEFE" style="padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
                                 <!--<img src="<?php //  echo SYSTEM_PATH;  ?>dist/img/arjion1.png" alt="Creating Email Magic" width="200" height="130" style="display: block;" />-->
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
                                            $estatus = $_REQUEST["estatus"];
                                            $authOutp = $daf->authOutput($id, $estatus, "Actualizacion realizada desde mi correo");

                                            if (intval($authOutp["errorCode"]) === 0) {
                                                $estado = "<b style='color: red;'>RECHAZADA</b>";
                                                if (intval($estatus) === 3) {
                                                    $estado = "<b style='color: green;'>ACEPTADA</b>";
                                                }
                                                echo '<b style="color: #F89E44">La solicitud de salida fue ' . $estado . ' exitosamente.</b>';
                                                //Consultamos la solicitud en proceso
                                                $solicitud = $daf->getOutputs("id=" . $id);
                                                $solicitante = $daf->getUsrByIdGral($solicitud["data"][0]["id_usuario"]);
                                                $msg = "La solicitud de s&aacute;lida con la siguiente informaci&oacute;n: <br />"
                                                        . "Persona autorizada: <b>" . $solicitud["data"][0]["solicitante"] . " .</b><br />"
                                                        . "Descripci&oacute;n:<b> " . $solicitud["data"][0]["descripcion"] . ".</b><br />"
                                                        . "Destino: <b>" . $solicitud["data"][0]["destino"] . ".</b><br />"
                                                        . "Vigencia: <b>" . $solicitud["data"][0]["vigencia"] . " dias.</b><br />"
                                                        . "Fecha s&aacute;lida: <b>" . $solicitud["data"][0]["fecha_salida"] . ".</b><br /><br /><br />";

                                                if (intval($estatus) === 2) {//Si fue rechazado enviamos correo a solicitante
                                                    $subject = "Solicitud Rechazada.";
                                                    $msg .= "Ha sido <b>RECHAZADA<b/> por la Direcci&oacute;n de Administraci&oacute;n de Finanzas.";
                                                    sendM($subject, $solicitante["data"]->nombre, $msg, $solicitante["data"]->correo);
                                                } else {//Si fue aceptado enviamos correo a compras ya al destinatario
                                                    $subject = "Solicitud Aceptada.";
                                                    $msg .= "Ha sido <b>ACEPTADA<b/> por la Direcci&oacute;n de Administraci&oacute;n de Finanzas.";
                                                    $compras = $daf->getUsrByIdGral(1454);
                                                    $destinatario = $daf->getUsrByIdGral($solicitud["data"][0]["id_destinatario"]);


                                                    sendM($subject, $solicitante["data"]->nombre, $msg, $solicitante["data"]->correo);
                                                    sendM($subject, $compras["data"]->nombre, $msg, $compras["data"]->correo);
                                                    sendM($subject, $destinatario["data"]->nombre, $msg, $destinatario["data"]->correo);
                                                }

                                                /*
                                                 * FIGG - DIRAC
                                                 * Fecha: 04-Marzo-2021
                                                 * Descripción: Se Agrega funcionalidad para enviar ccpa
                                                 */
                                                $ccpa = $solicitud["data"][0]["ccp"];

                                                if (intval($estatus) === 2) {//Si fue rechazado enviamos correo a solicitante y si existe ccp a tambien a él
                                                    $subject = "Solicitud Rechazada.";
                                                    $msg .= "Ha sido <b>RECHAZADA<b/> por la Direcci&oacute;n de Administraci&oacute;n de Finanzas.";
                                                    sendM($subject, $solicitante["data"]->nombre, $msg, $solicitante["data"]->correo);

                                                    if ($ccpa !== "") {
                                                        sendM($subject, $ccpa, $msg, $ccpa);
                                                    }
                                                } else {//Si fue aceptado enviamos correo a compras
                                                    $subject = "Solicitud Aceptada.";
                                                    $msg .= "Ha sido <b>ACEPTADA<b/> por la Direcci&oacute;n de Administraci&oacute;n de Finanzas.";
                                                    $compras = $daf->getUsrByIdGral(1454);
                                                    $destinatario = $daf->getUsrByIdGral($solicitud["data"][0]["id_destinatario"]);

                                                    sendM($subject, $solicitante["data"]->nombre, $msg, $solicitante["data"]->correo);
                                                    sendM($subject, $compras["data"]->nombre, $msg, $compras["data"]->correo);
                                                    sendM($subject, $destinatario["data"]->nombre, $msg, $destinatario["data"]->correo);
                                                    if ($ccpa !== "") {
                                                        sendM($subject, $ccpa, $msg, $ccpa);
                                                    }
                                                }
                                            } else {
                                                echo '<b style="color: #F89E44">' . $authOutp["msg"] . '</b>';
                                            }

                                            function sendM($subject, $destinatario, $body, $correo_destinatario) {
                                                $utils = Utils::utlsSngltn();
                                                $url = SYSTEM_PATH . 'utils/templates/send_alert.php?destinatario=' . urlencode($destinatario) . "&msg=" . urlencode($body);
                                                $msg = $utils->getPageHTML($url, '<html>', '</html>');
                                                $sendMail = $utils->sendMail($correo_destinatario, $destinatario, utf8_decode($subject), $msg);
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