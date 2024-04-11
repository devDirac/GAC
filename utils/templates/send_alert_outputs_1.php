<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);


header("Access-Control-Allow-Origin: *");
require_once '../../model/DAF.php';

$daf = DAF::DAFSngltn();

$destinatario = utf8_encode($_REQUEST['destinatario']);
$msg = utf8_encode($_REQUEST['msg']);
$otro = utf8_encode($_REQUEST['otro']);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>DIRAC | Ingenieros COnsultores</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <body style="border: 1px solid #cccccc; border-collapse: collapse;">
        <table align="center" width="100%">
            <tr>
                <td style="padding: 10px 0 30px 0;">
                    <table align="center" width="100%">
                        <tr>
                            <td align="center" bgcolor="#FEFEFE" style="padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
                                <!--<img src="<?php //  echo SYSTEM_PATH; ?>dist/img/arjion1.png" alt="Creating Email Magic" width="200" height="130" style="display: block;" />-->
                                <img src="../dist/img/arjion1.png" alt="Creating Email Magic" width="200" height="130" style="display: block;" />
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                                            <b style="color: #F89E44">Hola <?php echo $destinatario; ?> </b>, la plataforma <b style="color: #003365">Arjion</b>  te notifica:
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                            <p align="justify"><?php echo $msg; ?><br /><br />
                                                <br />
                                                <br />
                                                <table width="100%" align="center" border="1">
                                                    <thead align="center">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Persona asignada</th>
                                                            <th>Solicitante</th>
                                                            <th>Descripci&oacute;n</th>
                                                            <th>Destino</th>
                                                            <th>Fecha s&aacute;lida</th>
                                                            <th>Destinatario</th>
                                                            <th>Vigencia</th>
                                                            <!--<th>Comentarios</th>-->                                                           
                                                        </tr>
                                                    </thead>
                                                    <tbody id="dirac_outputs">
                                                        <?php
                                                        $requests = $daf->getOutputs("estatus = 1 AND estatus_envio = 0");
                                                        foreach ($requests["data"] as $key => $req) {
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $req["id"]; ?></td>
                                                                <td>
                                                                    <?php
                                                                    if (intval($req["id_solicitante"]) === 0) {
                                                                        echo $req["otro_usuario"];
                                                                    } else {
                                                                        echo $req["solicitante"];
                                                                    }
                                                                    $color = "green";
                                                                    if (intval($req["vigencia"]) > 5) {
                                                                        $color = "red";
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td><?php echo $req["nombre"]; ?></td>
                                                                <td><?php echo $req["descripcion"]; ?></td>
                                                                <td><?php echo $req["destino"]; ?></td>
                                                                <td><?php echo $req["fecha_salida"]; ?></td>
                                                                <td><?php echo $req["destinatario"]; ?></td>
                                                                <td style="color: <?php echo $color; ?>;"><?php echo $req["vigencia"]; ?> d&iacute;as</td>
                                                                <!--<td><?php // echo $req["comentarios"];               ?></td>-->                                                                                                  
                                                            </tr>
                                                            <?php
                                                            //Actualizamos campo de envio de solicitud.
//                                                            $update = $daf->updateSend($req["id"]);
                                                        }
                                                        ?>

                                                    </tbody>
                                                </table>
                                                                    <!--<p>Para ingresar a la secci&oacute;n entra a Arjion y da clic en : Administraci&oacute;n >> Transfer .</p>-->
                                                <br />
                                                <br />
                                                <br />
                                                <b> &iexcl;Excelente d&iacute;a!</b>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
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