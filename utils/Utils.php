<?php

/**
 * Description of Utils
 *
 * @author FroébelIván
 * @copyright (c) 2017, DIRAC
 */
class Utils {

    public $response;
    private static $instance;

    function __construct() {
        $this->response = array();
    }

// Método singleton
    public static function utlsSngltn() {
        if (!isset(self::$instance)) {
            $Utils = __CLASS__;
            self::$instance = new $Utils;
        }
        return self::$instance;
    }

// Evita que el objeto se pueda clonar
    public function __clone() {
        trigger_error('La clonación de este objeto no está permitida', E_USER_ERROR);
    }

    public function sumarDiasFecha($fecha, $dia) {
        $intervalo = 'P' . $dia . 'D';
        $nuevaFecha = new DateTime($fecha);
        $nuevaFecha->add(new DateInterval($intervalo));

        return $nuevaFecha->format('Y-m-d H:i:s');
    }

//Método con str_shuffle() 
    public function generateRandomString($length = 6) {
        $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        return substr(str_shuffle($characters), 0, $length);
    }

    public function sendMail($addr, $name, $subject, $msg) {
        require_once '../config/configMail.php';
        require_once '../config/properties.php';
        require_once 'class.phpmailer.php';
        require_once 'class.smtp.php';

//Crear una instancia de PHPMailer
        $mail = new PHPMailer();
//Definir que vamos a usar SMTP
        $mail->IsSMTP();
//Esto es para activar el modo depuración. En entorno de pruebas lo mejor es 2, en producción siempre 0
// 0 = off (producción)
// 1 = client messages
// 2 = client and server messages
        $mail->SMTPDebug = SMTP_DEBUG;
        $mail->CharSet = 'UTF-8';
//Ahora definimos gmail como servidor que aloja nuestro SMTP
//$mail->Host       = 'smtp.gmail.com';
        $mail->Host = SMTP_HOST;
//El puerto será el 587 ya que usamos encriptación TLS
//$mail->Port       = 587;
        $mail->Port = SMTP_PORT;
//Definmos la seguridad como TLS
//$mail->SMTPSecure = 'tls';
//Tenemos que usar gmail autenticados, así que esto a TRUE
        $mail->SMTPAuth = true;
//Definimos la cuenta que vamos a usar. Dirección completa de la misma
        $mail->Username = SMTP_USER;
//Introducimos nuestra contraseña de gmail
        $mail->Password = SMTP_PASS;
//Definimos el remitente (dirección y, opcionalmente, nombre)
        $mail->SetFrom(SMTP_FROM, SMTP_FROM_ALIAS);
//Esta línea es por si queréis enviar copia a alguien (dirección y, opcionalmente, nombre)
//$mail->AddReplyTo('replyto@correoquesea.com','El de la réplica');
//Y, ahora sí, definimos el destinatario (dirección y, opcionalmente, nombre)
        $mail->AddAddress($addr, $name);
        $mail->addBCC('ivan@dirac.mx');
//Definimos el tema del email
        $mail->Subject = $subject;
//Para enviar un correo formateado en HTML lo cargamos con la siguiente función. Si no, puedes meterle directamente una cadena de texto.
//$mail->MsgHTML(file_get_contents('correomaquetado.html'), dirname(ruta_al_archivo));
        $mail->MsgHTML($msg);
//Y por si nos bloquean el contenido HTML (algunos correos lo hacen por seguridad) una versión alternativa en texto plano (también será válida para lectores de pantalla)
        $mail->AltBody = 'This is a plain-text message body';
//Enviamos el correo
        if (!$mail->Send()) {
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = ERROR;
        } else {
            $this->response["errorCode"] = SUCCESS_CODE;
            $this->response["msg"] = SUCCESS;
        }
        return $this->response;
    }

    function getPageHTML($url, $inicio = '', $final) {
        $source = @file_get_contents($url) or trigger_error('Error al obtener url ' . $url, E_USER_ERROR);
        $posicion_inicio = strpos($source, $inicio) + strlen($inicio);
        $posicion_final = strpos($source, $final) - $posicion_inicio;
        $found_text = substr($source, $posicion_inicio, $posicion_final);
        return $inicio . $found_text . $final;
    }

    function printDateLetter($fecha) {
        $dias = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
        $meses = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

        return $dias[strftime('%w', strtotime($fecha))] . " " . strftime("%d", strtotime($fecha)) . " de " . $meses[intval(strftime('%m', strtotime($fecha)))] . " del " . strftime("%Y", strtotime($fecha)) . "";
    }

    function fechaDMA($fecha) {
        return date("d-m-Y", strtotime($fecha));
    }

    function dmaFecha($fecha) {
        return date("d/m/Y", strtotime($fecha));
    }

    function fexcel2unix($f) {
        return ($f - 25568) * 86400;
    }

    function getDayMonthSpanish($flag, $position) {
        $dias = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
        $meses = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

        if ($flag === 1) {
            return $dias[$position];
        } else {
            return $meses[$position];
        }
    }

    public function sendAttachments($addr, $name, $subject, $msg, $path_adjunto, $adjunto) {
        require_once '../config/configMail.php';
        require_once '../config/properties.php';
        require_once 'class.phpmailer.php';
        require_once 'class.smtp.php';

//Crear una instancia de PHPMailer
        $mail = new PHPMailer();
//Definir que vamos a usar SMTP
        $mail->IsSMTP();
//Esto es para activar el modo depuración. En entorno de pruebas lo mejor es 2, en producción siempre 0
// 0 = off (producción)
// 1 = client messages
// 2 = client and server messages
        $mail->SMTPDebug = SMTP_DEBUG;
        $mail->CharSet = 'UTF-8';
//Ahora definimos gmail como servidor que aloja nuestro SMTP
//$mail->Host       = 'smtp.gmail.com';
        $mail->Host = SMTP_HOST;
//El puerto será el 587 ya que usamos encriptación TLS
//$mail->Port       = 587;
        $mail->Port = SMTP_PORT;
//Definmos la seguridad como TLS
//$mail->SMTPSecure = 'tls';
//Tenemos que usar gmail autenticados, así que esto a TRUE
        $mail->SMTPAuth = true;
//Definimos la cuenta que vamos a usar. Dirección completa de la misma
        $mail->Username = SMTP_USER;
//Introducimos nuestra contraseña de gmail
        $mail->Password = SMTP_PASS;
//Definimos el remitente (dirección y, opcionalmente, nombre)
        $mail->SetFrom(SMTP_FROM, SMTP_FROM_ALIAS);
//Esta línea es por si queréis enviar copia a alguien (dirección y, opcionalmente, nombre)
//$mail->AddReplyTo('replyto@correoquesea.com','El de la réplica');
//Y, ahora sí, definimos el destinatario (dirección y, opcionalmente, nombre)
        $mail->AddAddress($addr, $name);
        $mail->addBCC('ivan@dirac.mx');
//        $mail->AddCC(SMTP_FROM, $name);//<-----------------------------------------------------------CON COPIA A ARJION
//Definimos el tema del email
        $mail->Subject = $subject;
//Para enviar un correo formateado en HTML lo cargamos con la siguiente función. Si no, puedes meterle directamente una cadena de texto.
//$mail->MsgHTML(file_get_contents('correomaquetado.html'), dirname(ruta_al_archivo));
        $mail->MsgHTML($msg);
//Y por si nos bloquean el contenido HTML (algunos correos lo hacen por seguridad) una versión alternativa en texto plano (también será válida para lectores de pantalla)
        $mail->AltBody = 'This is a plain-text message body';
        foreach ($adjunto as $key => $attach) {
//Adjuntamos archivo
//            var_dump($attach);
            $mail->AddAttachment($path_adjunto . $attach["nombre"], $attach["nombre"]);
        }

//Enviamos el correo
        try {
            $mail->Send();
            $this->response["errorCode"] = SUCCESS_CODE;
            $this->response["msg"] = SUCCESS;
        } catch (Exception $exc) {
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = ERROR;
            echo $exc->getTraceAsString();
            echo $exc->getMessage();
        }

        return $this->response;
    }

}
