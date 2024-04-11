<?php

/*
 * Model.php
 * @author FIGG - DIRAC
 * @copyright (c) 2022, DIRAC.
 * @description Clase General para acciones en modulo de GAC
 */

require_once __DIR__ . '/../config/ConnectionDB.php';
require_once __DIR__ . '/../config/properties.php';
require_once __DIR__ . '/../utils/Utils.php';

class Model {

    private $db;
    private $response;
    private static $instance;

    function __construct() {
        $this->db = ConnectionDB::connectSngtn()->DBConnect();
        $this->response = array();
    }

    // Método singleton
    public static function ModelSngltn() {
        if (!isset(self::$instance)) {
            $Model = __CLASS__;
            self::$instance = new $Model;
        }
        return self::$instance;
    }

    // Evita que el objeto se pueda clonar
    public function __clone() {
        trigger_error('La clonación de este objeto no está permitida', E_USER_ERROR);
    }

    /*     * ********************************************************************************** */

    function getParams($q = "1=1") {
        try {
            $query = "SELECT * FROM dcmx_parametros_configuracion WHERE " . $q;
            $oUsr = $this->db->prepare($query);
            $oUsr->execute();
            //Si el usuario existe asignamos valores al objeto

            if ($oUsr->rowCount() == 1) {
                $usr = $oUsr->fetch(PDO::FETCH_OBJ);

                $this->response["data"] = $usr;
                $this->response["errorCode"] = SUCCESS_CODE;
                $this->response["msg"] = SUCCESS;
            } else {
                $this->response["errorCode"] = ERROR_CODE;
                $this->response["msg"] = ERROR;
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = ERROR;
        }
        return $this->response;
    }

    function getInfoUsrsView($q = "1=1") {
        try {
            $query = "SELECT * FROM v_usuarios_dirac WHERE " . $q;
            $oUsr = $this->db->prepare($query);
            $oUsr->execute();
            $data = array();
//            echo $query;

            foreach ($oUsr as $key => $infoUsr) {
                $allInfo = array();
                $allInfo["id_usuario"] = $infoUsr["id_usuario"];
                $allInfo["usuario"] = $infoUsr["usuario"];
                $allInfo["no_control"] = $infoUsr["no_control"];
                $allInfo["nombre"] = $infoUsr["nombre"];
                $allInfo["apellidos"] = $infoUsr["apellidos"];
                $allInfo["genero"] = $infoUsr["genero"];
                $allInfo["correo"] = $infoUsr["correo"];
                $allInfo["imagen"] = $infoUsr["imagen"];
                $allInfo["telefono"] = $infoUsr["telefono"];
                $allInfo["id_direccion"] = $infoUsr["id_direccion"];
                $allInfo["status"] = $infoUsr["status"];
                $allInfo["id_director_area"] = $infoUsr["id_director_area"];
                $allInfo["nivel"] = $infoUsr["nivel"];
                $allInfo["eliminado"] = $infoUsr["eliminado"];
                $allInfo["fecha_ingreso"] = $infoUsr["fecha_ingreso"];
                $allInfo["id_empresa"] = $infoUsr["id_empresa"];
                $allInfo["jefe_inmediato"] = $infoUsr["jefe_inmediato"];

                /*                 * **************************************************** */
                $allInfo["fecha_nacimiento"] = $infoUsr["fecha_nacimiento"];
                $allInfo["rfc"] = $infoUsr["rfc"];
                $allInfo["curp"] = $infoUsr["curp"];
                $allInfo["fecha_registro"] = $infoUsr["fecha_registro"];
                /*                 * **************************************************** */

                $allInfo["direccion"] = $infoUsr["direccion"];
                $allInfo["id_area"] = $infoUsr["id_area"];
                $allInfo["area"] = $infoUsr["area"];
                $allInfo["id_colonia"] = $infoUsr["id_colonia"];
                $allInfo["calle"] = $infoUsr["calle"];
                $allInfo["numero"] = $infoUsr["numero"];
                $allInfo["nombre_contacto"] = $infoUsr["nombre_contacto"];
                $allInfo["tel_contacto"] = $infoUsr["tel_contacto"];
                $allInfo["tel_empresa"] = $infoUsr["tel_empresa"];
                $allInfo["tel_celular"] = $infoUsr["tel_celular"];
                $allInfo["tipo_sangre"] = $infoUsr["tipo_sangre"];
                $allInfo["alergias"] = $infoUsr["alergias"];
                $allInfo["foto"] = $infoUsr["foto"];
                $allInfo["lat"] = $infoUsr["lat"];
                $allInfo["lon"] = $infoUsr["lon"];
                $allInfo["id_escolaridad"] = $infoUsr["id_escolaridad"];
                $allInfo["escolaridad"] = $infoUsr["escolaridad"];
                $allInfo["titulado"] = $infoUsr["titulado"];
                $allInfo["id_pais"] = $infoUsr["id_pais"];
                $allInfo["pais"] = $infoUsr["pais"];
                $allInfo["id_estado"] = $infoUsr["id_estado"];
                $allInfo["estado"] = $infoUsr["estado"];
                $allInfo["id_ciudad"] = $infoUsr["id_ciudad"];
                $allInfo["ciudad"] = $infoUsr["ciudad"];
                $allInfo["nombre_colonia"] = $infoUsr["nombre_colonia"];
                $allInfo["id_cp"] = $infoUsr["id_cp"];
                $allInfo["valor"] = $infoUsr["valor"];
                $allInfo["id_proyecto"] = $infoUsr["id_proyecto"];
                $allInfo["proyecto"] = $infoUsr["proyecto"];
                $allInfo["id_perfil"] = $infoUsr["id_perfil"];
                $allInfo["puesto"] = $infoUsr["puesto"];
                $allInfo["evaluacion"] = $infoUsr["evaluacion"];
                $allInfo["id_perfil_sgi"] = $infoUsr["id_perfil_sgi"];
                $allInfo["perfil_sgi"] = $infoUsr["perfil_sgi"];

                $data[] = $allInfo;
            }

            $this->response["numElems"] = $oUsr->rowCount();
            $this->response["data"] = $data;
            $this->response["errorCode"] = SUCCESS_CODE;
            $this->response["msg"] = SUCCESS;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            echo $exc->getMessage();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = $exc->getMessage();
        }
        return $this->response;
    }

    function getUsrByIdGral($id_usuario) {
        try {
            $query = "SELECT * FROM usuarios_dirac WHERE id_usuario = ?";
            $oUsr = $this->db->prepare($query);
            $oUsr->execute(array($id_usuario));
            //Si el usuario existe asignamos valores al objeto

            if ($oUsr->rowCount() == 1) {
                $usr = $oUsr->fetch(PDO::FETCH_OBJ);

                $this->response["data"] = $usr;
                $this->response["errorCode"] = SUCCESS_CODE;
                $this->response["msg"] = SUCCESS;
            } else {
                $this->response["errorCode"] = ERROR_CODE;
                $this->response["msg"] = ERROR;
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = ERROR;
        }
        return $this->response;
    }

    function getUsrGral($q = "1=1") {
        try {
            $query = "SELECT * FROM usuarios_dirac WHERE " . $q;
            $oUsr = $this->db->prepare($query);
            $oUsr->execute();
            //Si el usuario existe asignamos valores al objeto

            if ($oUsr->rowCount() > 0) {
                $usr = $oUsr->fetch(PDO::FETCH_OBJ);

                $this->response["data"] = $usr;
                $this->response["errorCode"] = SUCCESS_CODE;
                $this->response["msg"] = SUCCESS;
            } else {
                $this->response["errorCode"] = ERROR_CODE;
                $this->response["msg"] = ERROR;
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = ERROR;
        }
        return $this->response;
    }

    /* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */

    function getTipoSolicitudes($q = "1=1") {
        try {
            $query = "SELECT * FROM daf_gac_cat_solicitud WHERE " . $q;
            $oUsr = $this->db->prepare($query);
            $oUsr->execute();
            $data = array();
//            echo $query;

            foreach ($oUsr as $key => $infoUsr) {
                $allInfo = array();
                $allInfo["id"] = $infoUsr["id"];
                $allInfo["nombre"] = $infoUsr["nombre"];
                $allInfo["descripcion"] = $infoUsr["descripcion"];
                $allInfo["tope"] = $infoUsr["tope"];
                $allInfo["id_notificacion"] = $infoUsr["id_notificacion"];
                $allInfo["fecha"] = $infoUsr["fecha"];
                $allInfo["estatus"] = $infoUsr["estatus"];
                $allInfo["limite_inferior"] = $infoUsr["limite_inferior"];

                $data[] = $allInfo;
            }

            $this->response["numElems"] = $oUsr->rowCount();
            $this->response["data"] = $data;
            $this->response["errorCode"] = SUCCESS_CODE;
            $this->response["msg"] = SUCCESS;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = $exc->getMessage();
        }
        return $this->response;
    }

    function updateTSolicitud($id, $estatus, $nombre, $descripcion, $tope, $id_notificacion, $limite_inferior) {
        $this->db->beginTransaction();
        try {
            $query = "UPDATE daf_gac_cat_solicitud SET nombre = ?, descripcion = ?, tope = ?, id_notificacion = ?, estatus = ?, limite_inferior = ? WHERE id =? ";
            $oRec = $this->db->prepare($query);
            $oRec->execute(
                    array($nombre, $descripcion, $tope, $id_notificacion, $estatus, $limite_inferior, $id)
            );
            $this->db->Commit();

            $this->response["errorCode"] = SUCCESS_CODE;
            $this->response["msg"] = SUCCESS;
        } catch (Exception $exc) {
//            echo $exc->getTraceAsString();
            $this->db->rollback();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = ERROR;
            $this->response["info"] = $exc->getTraceAsString();
        }
        return $this->response;
    }

    function deleteTSolicitud($id) {
        $this->db->beginTransaction();
        try {
            $query = "DELETE FROM daf_gac_cat_solicitud WHERE id =? ";
            $oRec = $this->db->prepare($query);
            $oRec->execute(array($id));
            $this->db->Commit();

            $this->response["errorCode"] = SUCCESS_CODE;
            $this->response["msg"] = SUCCESS;
        } catch (Exception $exc) {
//            echo $exc->getTraceAsString();
            $this->db->rollback();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = ERROR;
            $this->response["info"] = $exc->getTraceAsString();
        }
        return $this->response;
    }

    function addTSolicitud($estatus, $nombre, $descripcion, $tope, $id_notificacion) {
        $this->db->beginTransaction();
        try {
            $query = "INSERT INTO daf_gac_cat_solicitud (nombre, descripcion, estatus, fecha, tope, id_notificacion) VALUES(?,?,?,?,?,?) ";
            $oResp = $this->db->prepare($query);
            $oResp->execute(array(
                $nombre,
                $descripcion,
                $estatus,
                date("Y-m-d H:i:s"),
                $tope,
                $id_notificacion
            ));
            $id = $this->db->lastInsertId();
            $this->db->Commit();
            $this->response["data"] = $id;
            $this->response["errorCode"] = SUCCESS_CODE;
            $this->response["msg"] = SUCCESS;
        } catch (Exception $exc) {
//            echo $exc->getMessage();
            $this->db->rollback();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = $exc->getMessage();
        }
        return $this->response;
    }

    function getParams1($q = "1=1") {
        try {
            $query = "SELECT * FROM dcmx_parametros_configuracion WHERE " . $q;
            $oUsr = $this->db->prepare($query);
            $oUsr->execute();
            $data = array();

            foreach ($oUsr as $key => $infoUsr) {
                $allInfo = array();
                $allInfo["id"] = $infoUsr["id"];
                $allInfo["direccion"] = $infoUsr["direccion"];
                $allInfo["parametro"] = $infoUsr["parametro"];
                $allInfo["valor"] = $infoUsr["valor"];
                $allInfo["estatus"] = $infoUsr["estatus"];

                $data[] = $allInfo;
            }

            $this->response["numElems"] = $oUsr->rowCount();
            $this->response["data"] = $data;
            $this->response["errorCode"] = SUCCESS_CODE;
            $this->response["msg"] = SUCCESS;
        } catch (Exception $exc) {
            echo $exc->getMessage();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = ERROR;
        }
        return $this->response;
    }

    function updateParamsGAC($valor, $id) {
        $this->db->beginTransaction();
        try {
            $query = "UPDATE dcmx_parametros_configuracion SET valor = ? WHERE id = ? ";
            $oRec = $this->db->prepare($query);
            $oRec->execute(
                    array($valor, $id)
            );
            $this->db->Commit();

            $this->response["errorCode"] = SUCCESS_CODE;
            $this->response["msg"] = SUCCESS;
        } catch (Exception $exc) {
//            echo $exc->getTraceAsString();
            $this->db->rollback();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = ERROR;
            $this->response["info"] = $exc->getMessage();
        }
        return $this->response;
    }

    function getProjectsDirac($q = "1=1") {
        try {
            $query = "SELECT * FROM proyectos_sgi WHERE " . $q;
            $oAddress = $this->db->prepare($query);
            $oAddress->execute();
            $data = array();

            foreach ($oAddress as $key => $addr) {
                $address = array();
                $address["id"] = $addr["id"];
                $address["clave"] = $addr["clave"];
                $address["nombre"] = $addr["nombre"];
                $address["descripcion"] = $addr["descripcion"];
                $address["estatus"] = $addr["estatus"];
                $address["responsable"] = $addr["responsable"];
                $address["orden"] = $addr["orden"];
                $address["vigente"] = $addr["vigente"];
                $address["participativo"] = $addr["participativo"];
                $address["dashboard"] = $addr["dashboard"];

                $address["indirectos_campo"] = $addr["indirectos_campo"];
                $address["indirectos_oficina"] = $addr["indirectos_oficina"];
                $address["financiamiento"] = $addr["financiamiento"];
                $address["utilidad"] = $addr["utilidad"];
                $address["cargo_adicional_a"] = $addr["cargo_adicional_a"];
                $address["cargo_adicional_b"] = $addr["cargo_adicional_b"];
                $address["dias"] = $addr["dias"];

                $data[] = $address;
            }
            $this->response["numElems"] = $oAddress->rowCount();
            $this->response["data"] = $data;
            $this->response["errorCode"] = SUCCESS_CODE;
            $this->response["msg"] = SUCCESS;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = ERROR;
        }
        return $this->response;
    }

    function agregarSolicitudGAC($data) {
        @session_start();
        $this->db->beginTransaction();
        try {
            $query = "INSERT INTO daf_gac_solicitud (solicita, beneficiario, id_proyecto, importe, descripcion, id_tipo, forma_pago, banco, cuenta, clabe, fecha_solicitud, estatus, proyecto_sr, id_empresa, jefe_inmediato, id_director, proveedor) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
            $oResp = $this->db->prepare($query);
            $oResp->execute(array(
                $_SESSION["sgi_id_usr"],
                $data["id_usuario"],
                $data["id_proyecto"],
                $data["importe"],
                $data["concepto"],
                $data["tipo_solicitud"],
                $data["forma_pago"],
                $data["banco"],
                $data["cuenta"],
                $data["clabe"],
                date("Y-m-d H:i:s"),
                $data["estatus"],
                $data["proyecto_sr"],
                $data["id_empresa"],
                $data["jefe"],
                $data["id_director"],
                $data["proveedor"]
            ));
            $id = $this->db->lastInsertId();
            $this->db->Commit();
            $this->response["data"] = $id;
            $this->response["errorCode"] = SUCCESS_CODE;
            $this->response["msg"] = SUCCESS;
        } catch (Exception $exc) {
//            echo $exc->getMessage();
            $this->db->rollback();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = $exc->getMessage();
        }
        return $this->response;
    }

    function getSolicitudesGAC($q = "1=1") {
        try {
            $query = "SELECT * FROM daf_gac_solicitud WHERE " . $q;
            $oUsr = $this->db->prepare($query);
            $oUsr->execute();
            $data = array();
//            echo $query;

            foreach ($oUsr as $key => $infoUsr) {
                $allInfo = array();
                $allInfo["id"] = $infoUsr["id"];
                $allInfo["solicita"] = $infoUsr["solicita"];
                $allInfo["beneficiario"] = $infoUsr["beneficiario"];
                $allInfo["id_proyecto"] = $infoUsr["id_proyecto"];
                $allInfo["importe"] = $infoUsr["importe"];
                $allInfo["descripcion"] = $infoUsr["descripcion"];
                $allInfo["id_tipo"] = $infoUsr["id_tipo"];
                $allInfo["forma_pago"] = $infoUsr["forma_pago"];
                $allInfo["fecha_solicitud"] = $infoUsr["fecha_solicitud"];
                $allInfo["fecha_atencion"] = $infoUsr["fecha_atencion"];
                $allInfo["fecha_pago"] = $infoUsr["fecha_pago"];
                $allInfo["estatus"] = $infoUsr["estatus"];
                $allInfo["proyecto_sr"] = $infoUsr["proyecto_sr"];
                $allInfo["id_empresa"] = $infoUsr["id_empresa"];
                $allInfo["jefe_inmediato"] = $infoUsr["jefe_inmediato"];

                $allInfo["banco"] = $infoUsr["banco"];
                $allInfo["cuenta"] = $infoUsr["cuenta"];
                $allInfo["clabe"] = $infoUsr["clabe"];

                $allInfo["solicita_usuario"] = $this->getInfoUsrsView("id_usuario = " . $infoUsr["solicita"]);

                $allInfo["beneficiario_usuario"] = $this->getInfoUsrsView("id_usuario = " . $infoUsr["beneficiario"]);
                $allInfo["beneficiario_txt"] = "";

                if ($allInfo["beneficiario_usuario"]["numElems"] > 0) {
                    $allInfo["beneficiario_txt"] = $allInfo["beneficiario_usuario"]["data"][0]["nombre"] . " " . $allInfo["beneficiario_usuario"]["data"][0]["apellidos"];
                } else {
                    $allInfo["beneficiario_txt"] = $infoUsr["proveedor"];
                }

                $proyecto = $this->getProjectsDirac("id = " . $infoUsr["id_proyecto"]);
                if ($proyecto["numElems"] > 0) {
                    $allInfo["proyecto"] = $proyecto["data"][0]["nombre"];
                } else {
                    $allInfo["proyecto"] = $infoUsr["proyecto_sr"];
                }


                $allInfo["tipo_solicitud"] = $this->getTipoSolicitudes("id = " . $infoUsr["id_tipo"]);
                $allInfo["forma_pago_nombre"] = "";

                switch (intval($infoUsr["forma_pago"])) {
                    case 1:
                        $allInfo["forma_pago_nombre"] = "Cheque";
                        break;
                    case 2:
                        $allInfo["forma_pago_nombre"] = "Transferencia bancaria";
                        break;
                    default:
                        $allInfo["forma_pago_nombre"] = "Sin informaci&oacute;n";
                        break;
                }

                $allInfo["estatus_nombre"] = "";

                switch (intval($infoUsr["estatus"])) {
                    case 0:
                        $allInfo["estatus_nombre"] = "Rechazada";
                        break;
                    case 1:
                        $allInfo["estatus_nombre"] = "Creada/Por autorizar DAF";
                        break;
                    case 2:
                        $allInfo["estatus_nombre"] = "Creada/Por autorizar DG";
                        break;
                    case 3:
                        $allInfo["estatus_nombre"] = "Por revisar/Por pagar";
                        break;
                    case 4:
                        $allInfo["estatus_nombre"] = "Autorizada/Por comprobar";
                        break;
                    case 5:
                        $allInfo["estatus_nombre"] = "Terminada";
                        break;
                    case 6:
                        $allInfo["estatus_nombre"] = "Por pagar administraci&oacute;n";
                        break;
                    case 7:
                        $allInfo["estatus_nombre"] = "Pendiente de autotizar area";
                        break;
                    default:
                        $allInfo["estatus_nombre"] = "Sin estatus disponible";
                        break;
                }

                $allInfo["empresa"] = "";
                switch (intval($infoUsr["id_empresa"])) {
                    case 1:
                        $allInfo["empresa"] = "Dirac";
                        break;
                    case 2:
                        $allInfo["empresa"] = "Dielem";
                        break;
                    case 3:
                        $allInfo["empresa"] = "Laboratorio";
                        break;
                    case 4:
                        $allInfo["empresa"] = "Diseno";
                        break;

                    default:
                        break;
                }

                $data[] = $allInfo;
            }

            $this->response["numElems"] = $oUsr->rowCount();
            $this->response["data"] = $data;
            $this->response["errorCode"] = SUCCESS_CODE;
            $this->response["msg"] = SUCCESS;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = $exc->getMessage();
        }
        return $this->response;
    }

    function addDocGAC($data) {
        @session_start();
        $this->db->beginTransaction();
        try {
            $query = "INSERT INTO daf_gac_archivos_comprobacion (id_solicitud, id_comprobante, nombre, tamanio, tipo, path, fecha) VALUES(?,?,?,?,?,?,?)";
            $oResp = $this->db->prepare($query);
            $oResp->execute(array(
                $data["id_solicitud"],
                $data["id_comprobante"],
                $data["nombre"],
                $data["tamanio"],
                $data["tipo"],
                $data["path"],
                date("Y-m-d H:i:s")
            ));
            $id = $this->db->lastInsertId();
            $this->db->Commit();
            $this->response["data"] = $id;
            $this->response["errorCode"] = SUCCESS_CODE;
            $this->response["msg"] = SUCCESS;
        } catch (Exception $exc) {
//            echo $exc->getMessage();
            $this->db->rollback();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = $exc->getMessage();
        }
        return $this->response;
    }

    function deleteFile($id) {
        @session_start();
        $this->db->
                beginTransaction();
        try {
            $query = "DELETE FROM da_documentos_proyectos WHERE id = ? ";
            $oResp = $this->db->prepare($query);
            $oResp->execute(array($id));

            $id = $this->db->lastInsertId();
            $this->db->Commit();
            $this->response["data"] = $id;
            $this->response["errorCode"] = SUCCESS_CODE;
            $this->response["msg"] = SUCCESS;
        } catch (Exception $exc) {
//            echo $exc->getMessage();
            $this->db->rollback();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = $exc->getMessage();
        }
        return $this->response;
    }

    function getComprobantes($q = "1=1") {
        try {
            $query = "SELECT * FROM daf_gac_comprobantes WHERE " . $q;
            $oUsr = $this->db->prepare($query);
            $oUsr->execute();
            $data = array();
//            echo $query;

            foreach ($oUsr as $key => $infoUsr) {
                $allInfo = array();
                $allInfo["id"] = $infoUsr["id"];
                $allInfo["id_solicitud"] = $infoUsr["id_solicitud"];
                $allInfo["importe"] = $infoUsr["importe"];
                $allInfo["descripcion"] = $infoUsr["descripcion"];
                $allInfo["fecha"] = $infoUsr["fecha"];
                $allInfo["estatus"] = $infoUsr["estatus"];

                $allInfo["estatus_nombre"] = "";

                switch (intval($infoUsr["estatus"])) {
                    case 0:
                        $allInfo["estatus_nombre"] = "Cargada/Por enviar";
                        break;
                    case 1:
                        $allInfo["estatus_nombre"] = "Enviada/Por revisar DA";
                        break;
                    case 2:
                        $allInfo["estatus_nombre"] = "Revisi&oacute;n fiscal";
                        break;
                    case 3:
                        $allInfo["estatus_nombre"] = "Aceptado";
                        break;
                    case 4:
                        $allInfo["estatus_nombre"] = "Cajero";
                        break;
                    case 5:
                        $allInfo["estatus_nombre"] = "Rechazado";
                        break;
                    case 9:
                        $allInfo["estatus_nombre"] = "Eliminado";
                        break;
                    default:
                        $allInfo["estatus_nombre"] = "Cerrado";
                        break;
                }

                $data[] = $allInfo;
            }

            $this->response["numElems"] = $oUsr->rowCount();
            $this->response["data"] = $data;
            $this->response["errorCode"] = SUCCESS_CODE;
            $this->response["msg"] = SUCCESS;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = $exc->getMessage();
        }
        return $this->response;
    }

    function addComprobantes($data) {
        @session_start();
        $this->db->beginTransaction();
        try {
            $query = "INSERT INTO daf_gac_comprobantes (id_solicitud, importe, descripcion, fecha, fecha_registro, estatus) VALUES(?,?,?,?,?,?)";
            $oResp = $this->db->prepare($query);
            $oResp->execute(array(
                $data["id_solicitud"],
                $data["importe"],
                $data["descripcion"],
                $data["fecha"],
                date("Y-m-d H:i:s"),
                $data["estatus"]
            ));
            $id = $this->db->lastInsertId();
            $this->db->Commit();
            $this->response["data"] = $id;
            $this->response["errorCode"] = SUCCESS_CODE;
            $this->response["msg"] = SUCCESS;
        } catch (Exception $exc) {
//            echo $exc->getMessage();
            $this->db->rollback();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = $exc->getMessage();
        }
        return $this->response;
    }

    function getArchivosComprobantes($q = "1=1") {
        try {
            $query = "SELECT * FROM daf_gac_archivos_comprobacion WHERE " . $q;
//            echo $query;
            $oUsr = $this->db->prepare($query);
            $oUsr->execute();
            $data = array();

            foreach ($oUsr as $key => $infoUsr) {
                $allInfo = array();
                $allInfo["id"] = $infoUsr["id"];
                $allInfo["id_solicitud"] = $infoUsr["id_solicitud"];
                $allInfo["id_comprobante"] = $infoUsr["id_comprobante"];
                $allInfo["nombre"] = $infoUsr["nombre"];
                $allInfo["tamanio"] = $infoUsr["tamanio"];
                $allInfo["tipo"] = $infoUsr["tipo"];
                $allInfo["path"] = $infoUsr["path"];
                $allInfo["fecha"] = $infoUsr["fecha"];
                $allInfo["estatus"] = $infoUsr["estatus"];

                $data[] = $allInfo;
            }

            $this->response["numElems"] = $oUsr->rowCount();
            $this->response["data"] = $data;
            $this->response["errorCode"] = SUCCESS_CODE;
            $this->response["msg"] = SUCCESS;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = $exc->getMessage();
        }
        return $this->response;
    }

    function authSolicitudGAC($id, $estatus) {
        $this->db->beginTransaction();
        try {
            $query = "UPDATE daf_gac_solicitud SET estatus = ? WHERE id = ? ";
            $oRec = $this->db->prepare($query);
            $oRec->execute(
                    array($estatus, $id)
            );
            $this->db->Commit();

            $this->response["errorCode"] = SUCCESS_CODE;
            $this->response["msg"] = SUCCESS;
        } catch (Exception $exc) {
//            echo $exc->getTraceAsString();
            $this->db->rollback();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = ERROR;
            $this->response["info"] = $exc->getMessage();
        }
        return $this->response;
    }

    function authSolicitudGACB($id, $estatus) {
        $this->db->beginTransaction();
        try {
            $query = "UPDATE daf_gac_solicitud SET estatus = ?, jefe_inmediato = 0 WHERE id = ? ";
            $oRec = $this->db->prepare($query);
            $oRec->execute(
                    array($estatus, $id)
            );
            $this->db->Commit();

            $this->response["errorCode"] = SUCCESS_CODE;
            $this->response["msg"] = SUCCESS;
        } catch (Exception $exc) {
//            echo $exc->getTraceAsString();
            $this->db->rollback();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = ERROR;
            $this->response["info"] = $exc->getMessage();
        }
        return $this->response;
    }

    function updateFechaAtt($id) {
        $this->db->beginTransaction();
        try {
            $query = "UPDATE daf_gac_solicitud SET fecha_atencion = ? WHERE id = ? ";
            $oRec = $this->db->prepare($query);
            $oRec->execute(
                    array(date("Y-m-d H:i:s"), $id)
            );
            $this->db->Commit();

            $this->response["errorCode"] = SUCCESS_CODE;
            $this->response["msg"] = SUCCESS;
        } catch (Exception $exc) {
//            echo $exc->getTraceAsString();
            $this->db->rollback();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = ERROR;
            $this->response["info"] = $exc->getMessage();
        }
        return $this->response;
    }

    function updateFechaPag($id) {
        $this->db->beginTransaction();
        try {
            $query = "UPDATE daf_gac_solicitud SET fecha_pago = ?, estatus = 4 WHERE id = ? ";
            $oRec = $this->db->prepare($query);
            $oRec->execute(
                    array(date("Y-m-d H:i:s"), $id)
            );
            $this->db->Commit();

            $this->response["errorCode"] = SUCCESS_CODE;
            $this->response["msg"] = SUCCESS;
        } catch (Exception $exc) {
//            echo $exc->getTraceAsString();
            $this->db->rollback();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = ERROR;
            $this->response["info"] = $exc->getMessage();
        }
        return $this->response;
    }

    function updateFechaPagR($id) {
        $this->db->beginTransaction();
        try {
            $query = "UPDATE daf_gac_solicitud SET fecha_pago = ?, estatus = 5 WHERE id = ? ";
            $oRec = $this->db->prepare($query);
            $oRec->execute(
                    array(date("Y-m-d H:i:s"), $id)
            );
            $this->db->Commit();

            $this->response["errorCode"] = SUCCESS_CODE;
            $this->response["msg"] = SUCCESS;
        } catch (Exception $exc) {
//            echo $exc->getTraceAsString();
            $this->db->rollback();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = ERROR;
            $this->response["info"] = $exc->getMessage();
        }
        return $this->response;
    }

    function deleteComp($id) {
        $this->db->beginTransaction();
        try {
            $query = "DELETE FROM daf_gac_comprobantes WHERE id = ? ";
            $oRec = $this->db->prepare($query);
            $oRec->execute(array($id));
            $this->db->Commit();

            $this->response["errorCode"] = SUCCESS_CODE;
            $this->response["msg"] = SUCCESS;
        } catch (Exception $exc) {
//            echo $exc->getTraceAsString();
            $this->db->rollback();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = ERROR;
            $this->response["info"] = $exc->getTraceAsString();
        }
        return $this->response;
    }

    function deleteCompFiles($id_comprobante) {
        $this->db->beginTransaction();
        try {
            $query = "DELETE FROM daf_gac_archivos_comprobacion WHERE id_comprobante = ? ";
            $oRec = $this->db->prepare($query);
            $oRec->execute(array($id_comprobante));
            $this->db->Commit();

            $this->response["errorCode"] = SUCCESS_CODE;
            $this->response["msg"] = SUCCESS;
        } catch (Exception $exc) {
//            echo $exc->getTraceAsString();
            $this->db->rollback();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = ERROR;
            $this->response["info"] = $exc->getTraceAsString();
        }
        return $this->response;
    }

    function updateEstatusComp($id, $estatus) {
        $this->db->beginTransaction();
        try {
            $query = "UPDATE daf_gac_comprobantes SET estatus = ? WHERE id = ? ";
            $oRec = $this->db->prepare($query);
            $oRec->execute(
                    array($estatus, $id)
            );
            $this->db->Commit();

            $this->response["errorCode"] = SUCCESS_CODE;
            $this->response["msg"] = SUCCESS;
        } catch (Exception $exc) {
//            echo $exc->getTraceAsString();
            $this->db->rollback();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = ERROR;
            $this->response["info"] = $exc->getMessage();
        }
        return $this->response;
    }

    /* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */

    function authOutput($id, $estatus, $comentario) {
        $this->db->beginTransaction();
        try {
            $query = "UPDATE daf_salidas_equipo SET estatus = ?, comentarios = ? WHERE id = ? ";
            $oRec = $this->db->prepare($query);
            $oRec->execute(
                    array($estatus, $comentario, $id)
            );
            $this->db->Commit();

            $this->response["errorCode"] = SUCCESS_CODE;
            $this->response["msg"] = SUCCESS;
        } catch (Exception $exc) {
//            echo $exc->getTraceAsString();
            $this->db->rollback();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = ERROR;
            $this->response["info"] = $exc->getMessage();
        }
        return $this->response;
    }

    function getOutputs($q = "1=1") {
        try {
            $query = "SELECT * FROM daf_salidas_equipo WHERE " . $q;
//            echo $query;
            $oOutputs = $this->db->prepare($query);
            $oOutputs->execute();
            $data = array();

            foreach ($oOutputs as $key => $outputs) {
                $output = array();
                $output["id"] = $outputs["id"];
                $output["id_solicitante"] = $outputs["id_solicitante"];
                $output["id_usuario"] = $outputs["id_usuario"];
                $output["descripcion"] = $outputs["descripcion"];
                $output["fecha_salida"] = $outputs["fecha_salida"];
                $output["fecha"] = $outputs["fecha"];
                $output["destino"] = $outputs["destino"];
                $output["comentarios"] = $outputs["comentarios"];
                $output["archivo"] = $outputs["archivo"];
                $output["otro_usuario"] = $outputs["otro_usuario"];
                $output["id_destinatario"] = $outputs["destinatario"];
                $output["estatus_envio"] = $outputs["estatus_envio"];
                $output["estatus"] = $outputs["estatus"];
                $output["hora_salida"] = $outputs["hora_salida"];
                $output["hora_regreso"] = $outputs["hora_regreso"];
                $output["hora_recibido"] = $outputs["hora_recibido"];
                $output["vigencia"] = $outputs["vigencia"];
                $output["persona_salida"] = $outputs["persona_salida"];
                $output["destinatario2"] = $outputs["destinatario2"];
                $output["ccp"] = $outputs["ccp"];

                if (is_null($outputs["persona_salida"])) {
                    $output["persona_salida_nombre"] = "";
                } else {
                    $persona_nombre = $this->getUsrT("no_control = " . $outputs["persona_salida"]);
                    $output["persona_salida_nombre"] = $persona_nombre["data"][0]["nombre"];
                }

                if (intval($output["id_solicitante"]) === 0) {
                    $output["solicitante"] = $output["otro_usuario"];
                } else {
                    $solicitante = $this->getUsrByIdGral($output["id_solicitante"]);
                    $output["solicitante"] = $solicitante["data"]->nombre . " " . $solicitante["data"]->apellidos;
                }

                $usuario = $this->getUsrByIdGral($output["id_usuario"]);
                $output["nombre"] = $usuario["data"]->nombre . " " . $usuario["data"]->apellidos;

                if (intval($output["id_destinatario"]) === 0) {
                    $output["destinatario"] = $outputs["destinatario2"];
                } else {
                    $destinatario = $this->getUsrByIdGral($output["id_destinatario"]);
                    $output["destinatario"] = $destinatario["data"]->nombre . " " . $destinatario["data"]->apellidos;
                }



                $data[] = $output;
            }

            $this->response["numElems"] = $oOutputs->rowCount();
            $this->response["data"] = $data;
            $this->response["errorCode"] = SUCCESS_CODE;
            $this->response["msg"] = SUCCESS;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = $exc->getMessage();
        }
        return $this->response;
    }

    function updateMailAuth($valor, $id) {
        $this->db->beginTransaction();
        try {
            $query = "UPDATE dcmx_parametros_configuracion SET valor = ? WHERE id = ? ";
            $oRec = $this->db->prepare($query);
            $oRec->execute(
                    array($valor, $id)
            );
            $this->db->Commit();

            $this->response["errorCode"] = SUCCESS_CODE;
            $this->response["msg"] = SUCCESS;
        } catch (Exception $exc) {
//            echo $exc->getTraceAsString();
            $this->db->rollback();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = ERROR;
            $this->response["info"] = $exc->getMessage();
        }
        return $this->response;
    }

    function updateSend($id) {
        $this->db->beginTransaction();
        try {
            $query = "UPDATE daf_salidas_equipo SET estatus_envio = 1 WHERE id = ? ";
            $oRec = $this->db->prepare($query);
            $oRec->execute(
                    array($id)
            );
            $this->db->Commit();

            $this->response["errorCode"] = SUCCESS_CODE;
            $this->response["msg"] = SUCCESS;
        } catch (Exception $exc) {
//            echo $exc->getTraceAsString();
            $this->db->rollback();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = ERROR;
            $this->response["info"] = $exc->getMessage();
        }
        return $this->response;
    }

    function authRequester($data) {
        $this->db->beginTransaction();
        try {
            $query = "UPDATE daf_salidas_equipo SET id_solicitante = ?, otro_usuario = ? WHERE id = ? ";
            $oRec = $this->db->prepare($query);
            $oRec->execute(
                    array($data["id_usuario"], $data["othr_usr"], $data["id"])
            );
            $this->db->Commit();

            $this->response["errorCode"] = SUCCESS_CODE;
            $this->response["msg"] = SUCCESS;
        } catch (Exception $exc) {
//            echo $exc->getTraceAsString();
            $this->db->rollback();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = ERROR;
            $this->response["info"] = $exc->getMessage();
        }
        return $this->response;
    }

    function confirmRecption($id) {
        $this->db->beginTransaction();
        try {
            $query = "UPDATE daf_salidas_equipo SET estatus_envio = 2, hora_recibido = ? WHERE id = ? ";
            $oRec = $this->db->prepare($query);
            $oRec->execute(
                    array(date("Y-m-d H:i:s"), $id)
            );
            $this->db->Commit();

            $this->response["errorCode"] = SUCCESS_CODE;
            $this->response["msg"] = SUCCESS;
        } catch (Exception $exc) {
//            echo $exc->getTraceAsString();
            $this->db->rollback();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = ERROR;
            $this->response["info"] = $exc->getMessage();
        }
        return $this->response;
    }

    function checkOut($id, $no_control) {
        $usr = $this->getUsrT("no_control = " . $no_control);
        if (intval($usr["numElems"]) === 1) {
            $this->db->beginTransaction();
            try {
                $query = "UPDATE daf_salidas_equipo SET hora_salida = ?, persona_salida = ? WHERE id = ? ";
                $oRec = $this->db->prepare($query);
                $oRec->execute(
                        array(
                            date('Y-m-d H_i:s'),
                            $no_control,
                            $id
                        )
                );
                $this->db->Commit();

                $this->response["errorCode"] = SUCCESS_CODE;
                $this->response["msg"] = SUCCESS;
            } catch (Exception $exc) {
//            echo $exc->getTraceAsString();
                $this->db->rollback();
                $this->response["errorCode"] = ERROR_CODE;
                $this->response["msg"] = ERROR;
                $this->response["info"] = $exc->getMessage();
            }
        } else {
            $this->response["errorCode"] = 1;
            $this->response["msg"] = "El numero de control introducido no coincide, intente nuevamente.";
        }

        return $this->response;
    }

    function getUsrT($q = "1=1") {
        try {
            $query = "SELECT * FROM usuarios_dirac WHERE " . $q;
            $oUsr = $this->db->prepare($query);
            $oUsr->execute();
            $data = array();
//            echo $query;

            foreach ($oUsr as $key => $infoUsr) {
                $allInfo = array();
                $allInfo["id_usuario"] = $infoUsr["id_usuario"];
                $allInfo["usuario"] = $infoUsr["usuario"];
                $allInfo["no_control"] = $infoUsr["no_control"];
                $allInfo["nombre"] = $infoUsr["nombre"];
                $allInfo["apellidos"] = $infoUsr["apellidos"];
                $allInfo["genero"] = $infoUsr["genero"];
                $allInfo["correo"] = $infoUsr["correo"];
                $allInfo["imagen"] = $infoUsr["imagen"];
                $allInfo["telefono"] = $infoUsr["telefono"];
                $allInfo["id_area"] = $infoUsr["id_area"];
                $allInfo["status"] = $infoUsr["status"];
                $allInfo["id_director_area"] = $infoUsr["id_director_area"];
                $allInfo["nivel"] = $infoUsr["nivel"];
                $allInfo["eliminado"] = $infoUsr["eliminado"];
                $allInfo["fecha_ingreso"] = $infoUsr["fecha_ingreso"];
                $allInfo["fecha_nacimiento"] = $infoUsr["fecha_nacimiento"];
                $allInfo["curp"] = $infoUsr["curp"];
                $allInfo["rfc"] = $infoUsr["rfc"];
                $allInfo["fecha_registro"] = $infoUsr["fecha_registro"];
                $allInfo["id_empresa"] = $infoUsr["id_empresa"];
                $allInfo["jefe_inmediato"] = $infoUsr["jefe_inmediato"];

                $data[] = $allInfo;
            }

            $this->response["numElems"] = $oUsr->rowCount();
            $this->response["data"] = $data;
            $this->response["errorCode"] = SUCCESS_CODE;
            $this->response["msg"] = SUCCESS;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = $exc->getMessage();
        }
        return $this->response;
    }

    /*     * *******************************************************************************
     * FIGG - DIRAC
     * Fecha: 12.Agosto.2019
     * Descripción: Se agregan funciones para modulo de salida de personal   
     * ******************************************************************************* */

    function checkOutPersonnel($data) {
        @session_start();
        $this->db->beginTransaction();
        try {
            $query = "INSERT INTO daf_salidas_personal (id_solicitante, id_usuario, fecha_salida, fecha, destino, comentarios, estatus) VALUES(?,?,?,?,?,?,?) ";
            $oResp = $this->db->prepare($query);
            $oResp->execute(array(
                $_SESSION["sgi_id_usr"],
                $data["id_usuario"],
                $data["fecha_salida"],
                date("Y-m-d H:i:s"),
                $data["destino"],
                $data["comentarios"],
                1
            ));
            $id = $this->db->lastInsertId();
            $this->db->Commit();
            $this->response["data"] = $id;
            $this->response["errorCode"] = SUCCESS_CODE;
            $this->response["msg"] = SUCCESS;
        } catch (Exception $exc) {
//            echo $exc->getMessage();
            $this->db->rollback();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = $exc->getMessage();
        }
        return $this->response;
    }

    function getOutputsPersonnel($q = "1=1") {
        try {
            $query = "SELECT * FROM daf_salidas_personal WHERE " . $q;
            $oOutputs = $this->db->prepare($query);
            $oOutputs->execute();
            $data = array();

            foreach ($oOutputs as $key => $outputs) {
                $output = array();
                $output["id"] = $outputs["id"];
                $output["id_solicitante"] = $outputs["id_solicitante"];
                $output["id_usuario"] = $outputs["id_usuario"];
                $output["fecha_salida"] = $outputs["fecha_salida"];
                $output["fecha"] = $outputs["fecha"];
                $output["comentarios"] = $outputs["comentarios"];
                $output["estatus"] = $outputs["estatus"];
                $output["hora_salida"] = $outputs["hora_salida"];
                $output["hora_regreso"] = $outputs["hora_regreso"];
                $output["destino"] = $outputs["destino"];

                $solicitante = $this->getUsrByIdGral($output["id_solicitante"]);
                $output["solicitante"] = $solicitante["data"]->nombre . " " . $solicitante["data"]->apellidos;

                $usuario = $this->getUsrByIdGral($output["id_usuario"]);
                $output["nombre"] = $usuario["data"]->nombre . " " . $usuario["data"]->apellidos;

                $data[] = $output;
            }

            $this->response["numElems"] = $oOutputs->rowCount();
            $this->response["data"] = $data;
            $this->response["errorCode"] = SUCCESS_CODE;
            $this->response["msg"] = SUCCESS;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = $exc->getMessage();
        }
        return $this->response;
    }

    /*     * *******************************************************************************
     * FIGG - DIRAC
     * Fecha: 04.Noviembre.2019
     * Descripción: Se agregan funciones para modulo de registro de proveedores.
     * ******************************************************************************* */

    function checkSuppliers($data) {
        @session_start();
        $this->db->beginTransaction();
        try {
            $query = "INSERT INTO daf_visita_proveedores (id_usuario, fecha, fecha_ingreso, nombre_proveedor, empresa, comentarios, personal_apoyo, notificacion, estatus) VALUES(?,?,?,?,?,?,?,?,?) ";
            $oResp = $this->db->prepare($query);
            $oResp->execute(array(
                $_SESSION["sgi_id_usr"],
                date("Y-m-d H:i:s"),
                $data["fecha_visita"],
                $data["proveedor"],
                $data["empresa"],
                $data["comentarios"],
                $data["personal_apoyo"],
                $data["notificacion"],
                $data["estatus"]
            ));
            $id = $this->db->lastInsertId();
            $this->db->Commit();
            $this->response["data"] = $id;
            $this->response["errorCode"] = SUCCESS_CODE;
            $this->response["msg"] = SUCCESS;
        } catch (Exception $exc) {
//            echo $exc->getMessage();
            $this->db->rollback();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = $exc->getMessage();
        }
        return $this->response;
    }

    function getSuppliers($q = "1=1") {
        try {
            $query = "SELECT * FROM daf_visita_proveedores WHERE " . $q;
            $oOutputs = $this->db->prepare($query);
            $oOutputs->execute();
            $data = array();

            foreach ($oOutputs as $key => $outputs) {
                $output = array();
                $output["id"] = $outputs["id"];
                $output["id_usuario"] = $outputs["id_usuario"];
                $output["fecha"] = $outputs["fecha"];
                $output["fecha_ingreso"] = $outputs["fecha_ingreso"];
                $output["nombre_proveedor"] = $outputs["nombre_proveedor"];
                $output["empresa"] = $outputs["empresa"];
                $output["comentarios"] = $outputs["comentarios"];
                $output["hora_entrada"] = $outputs["hora_entrada"];
                $output["hora_salida"] = $outputs["hora_salida"];
                $output["estatus"] = $outputs["estatus"];
                $output["personal_apoyo"] = $outputs["personal_apoyo"];
                $output["notificacion"] = $outputs["notificacion"];

                $usuario = $this->getUsrByIdGral($output["id_usuario"]);
                $output["nombre_usuario"] = $usuario["data"]->nombre . " " . $usuario["data"]->apellidos;

                $data[] = $output;
            }

            $this->response["numElems"] = $oOutputs->rowCount();
            $this->response["data"] = $data;
            $this->response["errorCode"] = SUCCESS_CODE;
            $this->response["msg"] = SUCCESS;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = $exc->getMessage();
        }
        return $this->response;
    }

    function authSupplier($id, $estatus) {
        $this->db->beginTransaction();
        try {
            $query = "UPDATE daf_visita_proveedores SET estatus = ? WHERE id = ? ";
            $oRec = $this->db->prepare($query);
            $oRec->execute(
                    array($estatus, $id)
            );
            $this->db->Commit();

            $this->response["errorCode"] = SUCCESS_CODE;
            $this->response["msg"] = SUCCESS;
        } catch (Exception $exc) {
//            echo $exc->getTraceAsString();
            $this->db->rollback();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = ERROR;
            $this->response["info"] = $exc->getMessage();
        }
        return $this->response;
    }

    function deleteSol($id) {
        $this->db->beginTransaction();
        try {
            $query = "DELETE FROM daf_gac_solicitud WHERE id =? ";
            $oRec = $this->db->prepare($query);
            $oRec->execute(array($id));
            $this->db->Commit();

            $this->response["errorCode"] = SUCCESS_CODE;
            $this->response["msg"] = SUCCESS;
        } catch (Exception $exc) {
//            echo $exc->getTraceAsString();
            $this->db->rollback();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = ERROR;
            $this->response["info"] = $exc->getTraceAsString();
        }
        return $this->response;
    }

    function updateEstatusArchivosComp($id, $estatus) {
        $this->db->beginTransaction();
        try {
            $query = "UPDATE daf_gac_archivos_comprobacion SET estatus = ? WHERE id = ? ";
            $oRec = $this->db->prepare($query);
            $oRec->execute(
                    array($estatus, $id)
            );
            $this->db->Commit();

            $this->response["errorCode"] = SUCCESS_CODE;
            $this->response["msg"] = SUCCESS;
        } catch (Exception $exc) {
//            echo $exc->getTraceAsString();
            $this->db->rollback();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = ERROR;
            $this->response["info"] = $exc->getMessage();
        }
        return $this->response;
    }

    #04.Julio.2023

    function addRegistroCCH($data) {
        @session_start();
        $this->db->beginTransaction();
        try {
            $query = "INSERT INTO daf_gac_registro_cch (id_solicitud, importe, comentarios, id_usuario, fecha) VALUES(?,?,?,?,?)";
            $oResp = $this->db->prepare($query);
            $oResp->execute(array(
                $data["id_solicitud"],
                $data["importe"],
                "",
//                $data["comentarios"],
                $_SESSION["sgi_id_usr"],
                date("Y-m-d H:i:s")
            ));
            $id = $this->db->lastInsertId();
            $this->db->Commit();
            $this->response["data"] = $id;
            $this->response["errorCode"] = SUCCESS_CODE;
            $this->response["msg"] = SUCCESS;
        } catch (Exception $exc) {
//            echo $exc->getMessage();
            $this->db->rollback();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = $exc->getMessage();
        }
        return $this->response;
    }

    function getRegistroCCH($q = "1=1") {
        try {
            $query = "SELECT * FROM daf_gac_registro_cch WHERE " . $q;
            $oOutputs = $this->db->prepare($query);
            $oOutputs->execute();
            $data = array();

            foreach ($oOutputs as $key => $outputs) {
                $output = array();
                $output["id"] = $outputs["id"];
                $output["id_solicitud"] = $outputs["id_usuario"];
                $output["importe"] = $outputs["importe"];
                $output["comentarios"] = $outputs["comentarios"];
                $output["id_usuario"] = $outputs["id_usuario"];
                $output["fecha"] = $outputs["fecha"];

                $usuario = $this->getUsrByIdGral($output["id_usuario"]);
                $output["nombre_usuario"] = $usuario["data"]->nombre . " " . $usuario["data"]->apellidos;

                $data[] = $output;
            }

            $this->response["numElems"] = $oOutputs->rowCount();
            $this->response["data"] = $data;
            $this->response["errorCode"] = SUCCESS_CODE;
            $this->response["msg"] = SUCCESS;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            $this->response["errorCode"] = ERROR_CODE;
            $this->response["msg"] = $exc->getMessage();
        }
        return $this->response;
    }

}
