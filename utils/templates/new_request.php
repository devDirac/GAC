<?php
require_once '../../config/properties.php';
$nombre_revisor = $_REQUEST['nombre_revisor'];
$nombre = $_REQUEST['nombre'];
$titulo = $_REQUEST['titulo'];
$documento = $_REQUEST['documento'];
$clave = $_REQUEST['clave'];
$descripcion = $_REQUEST['descripcion'];
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
                                 <!--<img src="<?php //  echo SYSTEM_PATH; ?>dist/img/arjion1.png" alt="Creating Email Magic" width="200" height="130" style="display: block;" />-->
                                <img src="../dist/img/arjion1.png" alt="Creating Email Magic" width="200" height="130" style="display: block;" />
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                                            <b style="color: #F89E44">Hola <?php echo $nombre_revisor; ?></b>, la plataforma <b style="color: #003365">Arjion</b>  te notifica:
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                            <p>El usuario <b style="color: #F89E44"><?php echo $nombre; ?></b> ha generado una nueva solicitud de documento.<br />
                                                Por lo cual se solicita tu intervenci&oacute;n .<br /><br />
                                                Con la siguiente informaci&oacute;n:<br />
                                                T&iacute;tulo: <b style="color: #F89E44"><?php echo $titulo; ?></b><br />
                                                Nombre del documento: <b style="color: #F89E44"><?php echo $documento; ?></b><br />
                                                Clave: <b style="color: #F89E44"><?php echo $clave; ?></b><br />
                                                Descripci&oacute;n:<b style="color: #F89E44"><?php echo $descripcion; ?></b><br />
                                                <br />
                                                Excelente d&iacute;a!
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