<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en el pasado
$fecha_scripts = new DateTime();
setlocale(LC_ALL,NULL);

define("DOMAIN", "10.0.8.67/gac");
//define("DOMAIN", "148.243.10.117/daf");
define("DIR_APP", "/");
define("SYSTEM_PATH", "http://".DOMAIN.DIR_APP);
define("PATH_VIDEOS", "http://".DOMAIN.DIR_APP.'/recursos/');


define("EXTSYS_URL_CONTROLLER", "http://10.0.8.67/sgi-dirac/controller/");
define("EXTSYS_URL_MODEL", "http://10.0.8.67/sgi-dirac/sgi-dirac/model/");
define("EXTSYS_URL_IMAGES", "http://10.0.8.67/sgi-dirac/sgi-dirac/dist/img/");
define("EXTSYS_URL_UTILS", "http://10.0.8.67/sgi-dirac/utils/");

define("ID_DIRECCION_GENERAL", "2");//2
define("ID_DIRECCION_AF", "3");//3
define("ID_GERENCIA_FH", "56");//56
define("ID_JEFE_NOMINA", "5");//5
define("ID_CP", "19");//16

define("CONFIG_PATH", "http://".DOMAIN.DIR_APP."config".DIR_APP);
//define("CONTROLLERS_PATH", "http://".DOMAIN.DIR_APP."controller".DIR_APP);
define("CONTROLLERS_PATH", DOMAIN.DIR_APP."controller".DIR_APP);
define("MODELS_PATH", "http://".DOMAIN.DIR_APP."model".DIR_APP);
define("UTILS_PATH", "http://".DOMAIN.DIR_APP."utils".DIR_APP);


//MENSAJES DE ERROR                                                      
define("SUCCESS", "¡Operación Exitosa!");
define("ERROR", "Ha ocurrido un error, por favor intente más tarde.");

define("SUCCESS_CODE", 0);
define("ERROR_CODE", 1);

define("WARNING_UPLOAD_FILE_C", 2);
define("WARNING_UPLOAD_FILE_C2", 3);
define("WARNING_UPLOAD_FILE_C3", 4);
define("WARNING_UPLOAD_FILE_C4", 5);

define("WARNING_UPLOAD_FILE", "El archivo ya existe en el servidor.");
define("WARNING_UPLOAD_FILE2", "Tipo de archivo no permitido.");
define("WARNING_UPLOAD_FILE3", "Error al procesar el archivo.");
define("WARNING_UPLOAD_FILE4", "Error al cargar archivo");
