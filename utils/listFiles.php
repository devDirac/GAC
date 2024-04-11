<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head lang="en">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <title></title>
    </head>
    <body>
        <?php
        set_time_limit(0);
        require_once '../model/Solicitud.php';
        $cont = 0;

        function ScanDirectory($Directory) {

            $MyDirectory = opendir($Directory) or die('Error');
            while ($Entry = @readdir($MyDirectory)) {
                $area = 0;
                $tipo_documento = 0;
                $proyecto = 0;

                if ($Entry != '.' && $Entry != '..') {
                    //Encontrar tipo de documento
                    if (strpos($Directory . '/' . $Entry, "Manual")) {//Manual
                        $tipo_documento = 4;
                    } elseif (strpos($Directory . '/' . $Entry, "Formatos")) {//Formato
                        $tipo_documento = 1;
                    } elseif (strpos($Directory . '/' . $Entry, "Guías")) {//Guia
                        $tipo_documento = 2;
                    } elseif (strpos($Directory . '/' . $Entry, "Instructivos")) {//Instructivo
                        $tipo_documento = 3;
                    } elseif (strpos($Directory . '/' . $Entry, "Plan")) {//Plan
                        $tipo_documento = 5;
                    } elseif (strpos($Directory . '/' . $Entry, "Plan Maestro")) {//Plan Maestro
                        $tipo_documento = 6;
                    } elseif (strpos($Directory . '/' . $Entry, "Procedimientos")) {//Procedimientos
                        $tipo_documento = 7;
                    } else {
                        $tipo_documento = 8;
                    }
                    //Encontrar area
                    if (strpos($Directory . '/' . $Entry, "DA -")) {//Direccion de area
                        $area = 5;
                    } else {
                        $area = 6;
                    }
                    //Encontrar proyecto
                    if (strpos($Directory . '/' . $Entry, "Ambientales")) {//Ambientales
                        $proyecto = 1;
                    } elseif (strpos($Directory . '/' . $Entry, "CPQ") || strpos($Directory . '/' . $Entry, "CP")) {//Pajaritos
                        $proyecto = 2;
                    } elseif (strpos($Directory . '/' . $Entry, "Generales")) {//Generales
                        $proyecto = 3;
                    } elseif (strpos($Directory . '/' . $Entry, "Linea 3") || strpos($Directory . '/' . $Entry, "Línea 3 del Tren ")) {//Línea 3
                        $proyecto = 4;
                    } elseif (strpos($Directory . '/' . $Entry, "Refinería Gral")) {//Refinería
                        $proyecto = 5;
                    } elseif (strpos($Directory . '/' . $Entry, "Supervisión")) {//Supervisión
                        $proyecto = 6;
                    } elseif (strpos($Directory . '/' . $Entry, "TEO")) {//TEO
                        $proyecto = 7;
                    } elseif (strpos($Directory . '/' . $Entry, "TEP ")) {//TEP
                        $proyecto = 8;
                    } elseif (strpos($Directory . '/' . $Entry, "Tercera ")) {//Tercera
                        $proyecto = 9;
                    } elseif (strpos($Directory . '/' . $Entry, "Terminal ")) {//Terminal
                        $proyecto = 10;
                    } elseif (strpos($Directory . '/' . $Entry, "Topografía" || strpos($Directory . '/' . $Entry, "/Topograf"))) {//Topografía
                        $proyecto = 11;
                    } elseif (strpos($Directory . '/' . $Entry, "Túnel") || strpos($Directory . '/' . $Entry, 'Toluca')) {//Túnel
                        $proyecto = 12;
                    } elseif (strpos($Directory . '/' . $Entry, "Costa")) {//Costa
                        $proyecto = 13;
                    } elseif (strpos($Directory . '/' . $Entry, "Refinería Ing")) {//Refinería Ing
                        $proyecto = 14;
                    } elseif (strpos($Directory . '/' . $Entry, "Refinerías Coordinación")) {//Refinerías Coordi
                        $proyecto = 15;
                    } else {
                        $proyecto = 16;
                    }

                    if (is_dir($Directory . '/' . $Entry) && $Entry != '.' && $Entry != '..') {

                        echo "<pre>" . $area . "</pre>";
                        echo "<pre>" . $proyecto . "</pre>";
                        echo "<pre>" . $tipo_documento . "</pre>";
                        echo '<ul>' . utf8_encode($Directory . '/' . $Entry);
                        ScanDirectory($Directory . '/' . $Entry);
                        echo '</ul>';
                    } else {
                        $extension = substr($Entry, -4);
                        if (($extension === ".pdf" || $extension === ".xls" || $extension === ".doc" || substr($Entry, -5) === ".docx") && ($Entry[0] !== "." && $Entry[0] !== "~")) {
                            echo '<li>' . utf8_encode($Entry) . ' Soy un archivo </li>';
                            echo $area . '-' . $proyecto . '-' . $tipo_documento . '-' . utf8_encode($Entry) . "<br />";
                            global $cont;
                            $cont++;
                            echo "<pre>" . $cont . "</pre>";

                            $solicitud = Solicitud::slctdSngltn();
                            $solicitud->setTitulo(utf8_encode($Entry));
                            $solicitud->setNombre_archivo(utf8_encode($Entry));
                            $solicitud->setFecha(date('Y-m-d H:i:s'));
                            $solicitud->setCreador(110);
//                    $solicitud->getDocumento_base();
//                    $solicitud->getRevisor_local();
                            $solicitud->setTipo_documento($tipo_documento);
                            $solicitud->setDescripcion(utf8_encode($Entry));
                            $solicitud->setId_area($area);
                            $solicitud->setId_estatus_solicitud(5);
                            $solicitud->setId_proyecto($proyecto);
                            $solicitud->setEstatus(1);

//                            var_dump($solicitud);
                            $insertar = $solicitud->addRequestFile2($solicitud);
                        }
                    }

//                    $solicitud = Solicitud::slctdSngltn();
//                    $solicitud->getTitulo(utf8_encode($Entry));
//                    $solicitud->getNombre_archivo(utf8_encode($Entry));
//                    $solicitud->getFecha(date('Y-m-d H:i:s'));
//                    $solicitud->getCreador(110);
////                    $solicitud->getDocumento_base();
////                    $solicitud->getRevisor_local();
//                    $solicitud->getTipo_documento($tipo_documento);
//                    $solicitud->getDescripcion(utf8_encode($Entry));
//                    $solicitud->getId_area($area);
//                    $solicitud->getId_estatus_solicitud(4);
//                    $solicitud->getId_proyecto($proyecto);
//                    $solicitud->getEstatus(1);
//
//                    $insertar = $solicitud->addRequest2($solicitud);
//                    var_dump($insertar);
                }
            }
            closedir($MyDirectory);
        }

//        ScanDirectory('./navegador/files/directorio/');
        ScanDirectory('../docs_sgi/SGI Sistemas2/SISTEMA DE GESTION INTEGRAL/');
//        include_once '../docs_sgi/SGI Sistemas/SISTEMA DE GESTION INTEGRAL/';
        ?>
    </body>
</html>
