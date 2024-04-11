<?php

require_once 'Utils.php';
require_once '../model/Usuario.php';
$utils = Utils::utlsSngltn();


switch ($plantilla) {

    case 1://Recuperar contraseña
        $usr->setContrasenia($utils->generateRandomString(6));
        $_SESSION["sgi_pass"] = $usr->getContrasenia();
        $addressee = $usr->getCorreo();
        $name = $usr->getNombre();
        $user = $usr->getUsuario();
        $pass = $usr->getContrasenia();
        $subject = "Recuperar password";

        $url = SYSTEM_PATH . 'utils/templates/recover_pass.php?nombre=' . urlencode($name) . '&usuario=' . urlencode($user) . '&contrasenia=' . urlencode($pass);
        $msg = $utils->getPageHTML($url, '<html>', '</html>');

        $sendMail = $utils->sendMail($addressee, $name, $subject, $msg);
        break;
    case 2://Correo de nueva solicitud(Revisor Area)
        require_once '../model/Solicitud.php';
        $addressee = MAIL_REVISOR_LOCAL;
        $name = $_SESSION["sgi_nombre"];
        $subject = "Solicitud SGI";

        $titulo = $solicitud->getTitulo();
        $documento = $solicitud->getNombre_archivo();
        $clave = $fileSGI->getClave();
        $descripcion = $solicitud->getDescripcion();

        $usuarios = Usuario::usrSngltn();

        if (intval($_SESSION["sgi_id_dir_area"]) === 0) {
            $destinatarios = $usuarios->getMailsUsrsforSendByProfile(2);
        } else {
            $destinatarios = $usuarios->getMailUsrAreaDirector($_SESSION["sgi_id_dir_area"]);
        }
        
        foreach ($destinatarios as $key => $destinatario) {
            $url = SYSTEM_PATH . 'utils/templates/new_request.php?nombre=' . urlencode($name)
                    . '&nombre_revisor=' . urlencode($destinatario["nombre"])
                    . '&titulo=' . urlencode($titulo)
                    . '&documento=' . urlencode($documento)
                    . '&clave=' . urlencode($clave)
                    . '&descripcion=' . urlencode($descripcion);
            $msg = $utils->getPageHTML($url, '<html>', '</html>');
            $sendMail = $utils->sendMail($destinatario["correo"], $destinatario["nombre"], $subject, $msg);
        }
        break;
    case 3://Correo de movimiento en la solicitud
        require_once '../model/Solicitud.php';
        $name = $_SESSION["sgi_nombre"];
        $subject = "Solicitud SGI";

        $solicitud_id = $id_solicitud;


        $usuarios = Usuario::usrSngltn();
        $destinatarios = $usuarios->getMailsUsrsforSendByProfile($id_perfil);

        foreach ($destinatarios as $key => $destinatario) {
            $url = SYSTEM_PATH . 'utils/templates/revision_request.php?nombre=' . urlencode($name)
                    . '&nombre_revisor=' . urlencode($destinatario["nombre"])
                    . '&archivo=' . urlencode($archivo)
                    . '&color=' . urlencode($color)
                    . '&status_nombre=' . urlencode($estatus_nombre)
                    . '&id_solicitud=' . urlencode($solicitud_id);
            $msg = $utils->getPageHTML($url, '<html>', '</html>');
            $sendMail = $utils->sendMail($destinatario["correo"], $destinatario["nombre"], $subject, $msg);
        }
        break;

    case 4://Correo de movimiento en la solicitud
        require_once '../model/Solicitud.php';
        $name = $_SESSION["sgi_nombre"];
        $subject = "Nuevo archivo en SGI";

        $solicitud_id = $id_solicitud;


        $usuarios = Usuario::usrSngltn();
        $destinatarios = $usuarios->getMailsUsrsforSendByProfile($id_perfil);

        foreach ($destinatarios as $key => $destinatario) {
            $url = SYSTEM_PATH . 'utils/templates/new_file_sgi.php?nombre_destinatario=' . urlencode($destinatario["nombre"])
                    . '&archivo=' . urlencode($archivo)
                    . '&id_solicitud=' . urlencode($solicitud_id);
            $msg = $utils->getPageHTML($url, '<html>', '</html>');
            $sendMail = $utils->sendMail($destinatario["correo"], $destinatario["nombre"], $subject, $msg);
        }
        break;
    default:
        break;
}


//echo json_encode($sendMail);

