<?php

/**
 * Clase Archivo
 *
 * @author FroébelIván
 * @copyright (c) 2016, DIRAC
 */
class Archivo implements JsonSerializable {

    private $nombre;
    private $nombreOriginal;
    private $nombreTemporal;
    private $tamanio;
    private $extension;
    private $path;
    private $errorCode;
    private $msg;

    public function cargarArchivo(Archivo $archivo, $files) {
        try {
//            if (!file_exists($archivo->getPath() . $archivo->getNombre())) {
                //Si existio algun error al cargar archivo
                if ($files["file"]["error"] > 0) {
                    //echo "<p>Error al procesar archivo</p>";
                    $archivo->setErrorCode(WARNING_UPLOAD_FILE_C3);
                    $archivo->setMsg(WARNING_UPLOAD_FILE3);
                } else {
                    //Si no hay error creamos carpeta de usuario
                    if (!file_exists($archivo->getPath())) {
                        mkdir($archivo->getPath(), 0777, true);
                    }
//                    if (file_exists($archivo->getPath() . $archivo->getNombre())) {
//                        //echo "<p>El archivo " . $nombreOriginal . " ya existe.</p>";
//                        $archivo->setErrorCode(WARNING_UPLOAD_FILE_C);
//                        $archivo->setMsg(WARNING_UPLOAD_FILE);
//                    } else {
                        // Si el archivo no existey no hubo ningun error, lo subimos.
                        if (move_uploaded_file($archivo->getNombreTemporal(), $archivo->getPath() . $archivo->getNombre())) {
                            //$documento = ['nombre' => $nombre, 'path' => $path, 'tamanio' => $tamanio, 'extension' => $extension];
//                    echo "Se manda a llamar funcion que liste archivos";
//                            echo "¡Archivo cargado exitosamente!";
                            $archivo->setErrorCode(SUCCESS_CODE);
                            $archivo->setMsg(SUCCESS);
                        } else {
                            //echo "<p>Error al cargar archivo</p>";
                            $archivo->setErrorCode(ERROR_CODE);
                            $archivo->setMsg(ERROR);
                        }
//                    }
                }
//            } else {
//                $archivo->setErrorCode(WARNING_LOGIN_C);
//                $archivo->setMsg(WARNING_UPLOAD_FILE);
//            }
        } catch (Exception $exc) {
//            echo $exc->getTraceAsString();
            $archivo->setErrorCode(ERROR_CODE);
            $archivo->setMsg(ERROR);
        }
        return $archivo->jsonSerialize();
    }

    function getNombre() {
        return $this->nombre;
    }

    function getPath() {
        return $this->path;
    }

    function getErrorCode() {
        return $this->errorCode;
    }

    function getMsg() {
        return $this->msg;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setPath($path) {
        $this->path = $path;
    }

    function setErrorCode($errorCode) {
        $this->errorCode = $errorCode;
    }

    function setMsg($msg) {
        $this->msg = $msg;
    }

    function getNombreOriginal() {
        return $this->nombreOriginal;
    }

    function getNombreTemporal() {
        return $this->nombreTemporal;
    }

    function getTamanio() {
        return $this->tamanio;
    }

    function getExtension() {
        return $this->extension;
    }

    function setNombreOriginal($nombreOriginal) {
        $this->nombreOriginal = $nombreOriginal;
    }

    function setNombreTemporal($nombreTemporal) {
        $this->nombreTemporal = $nombreTemporal;
    }

    function setTamanio($tamanio) {
        $this->tamanio = $tamanio;
    }

    function setExtension($extension) {
        $this->extension = $extension;
    }

    public function jsonSerialize() {
        $var = get_object_vars($this);
        foreach ($var as &$value) {
            if (is_object($value) && method_exists($value, 'getJsonData')) {
                $value = $value->getJsonData();
            }
        }
        return $var;
    }

}
