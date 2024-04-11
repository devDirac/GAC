/* 
 * dashboardsgi.js
 * @author FIGG - DIRAC
 * @description Archivo que contiene las funciones necesarias para realizar login SGI.
 */
$(document).ready(function () {

    $("#loginForm").submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: '../controller/usrController.php',
            data: $('#loginForm').serializeArray(),
            dataType: 'json',
            beforeSend: function () {
                console.log("Login...");
            },
            success: function (response) {
                if (response.errorCode === 0) {
                    console.log(response);
//                    $("#msg").html('<div class="col-md-8 col-md-offset-3"><div class="alert alert-dismissable alert-success"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong><i class="fa fa-success"> </i></strong>' + response.msg + '</div></div>');
                    if ($("#remember").prop("checked")) {
                        console.log("Remember me!");
                        //Si esta checkeado box de recordar usuario creamos las cookies
                        localStorage.setItem("usrSGI", $("#usuario").val());
                        localStorage.setItem("passSGI", $("#contrasenia").val());
                        localStorage.setItem("remSGI", 1);
                    } else {
                        console.log("No Remember me!");
                        localStorage.setItem("usrSGI", "");
                        localStorage.setItem("passSGI", "");
                        localStorage.setItem("remSGI", 0);
                    }
                    showAlert(response.msg, "Redireccionando..", "success", "bounce");
                    //Redireccionamos al dashboard
                    setTimeout(function () {
                        window.location.href = "dashboard.php";
                    }, 2500);

                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            },
            error: function (a, b, c) {
                console.log(a, b, c);
            }
        });
    });

    $("#updateUsrForm").submit(function (event) {
        event.preventDefault();
//        alert("Actualizar Usuario");
        if ($("#contrasenia").val() === $("#contrasenia2").val()) {
            $.ajax({
                type: "POST",
                url: '../controller/usrController.php',
                data: $('#updateUsrForm').serializeArray(),
                dataType: 'json',
                beforeSend: function () {
                    console.log("Update User...");
                },
                success: function (response) {
                    if (response.errorCode === 0) {
                        console.log(response);
//                        $("#msg").html('<div class="col-md-12 col-md-offset-0"><div class="alert alert-dismissable alert-success"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong><i class="fa fa-success"> </i></strong>' + response.msg + '</div></div>');
                        showAlert(response.msg, "Usuario actualizado.", "success", "bounce");
                        //Redireccionamos al dashboard
                        setTimeout(function () {
                            $("#msg").html('');
                            window.location.href = "dashboard.php";
                        }, 2500);
                    } else {
                        showAlert("¡Error!", response.msg, "error", "swing");
                    }
                },
                error: function (a, b, c) {
                    console.log(a, b, c);
                }
            });
        } else {
            $("#msg").html('<div class="col-md-12 col-md-offset-0"><div class="alert alert-dismissable alert-danger"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong><i class="fa fa-danger"> </i></strong>Las contraseñas no coinciden</div></div>');
            setTimeout(function () {
                $("#msg").html('');
            }, 2500);
        }

    });
});

$("#registerUsrForm").submit(function () {
    event.preventDefault();
//    alert("Registrar Usuario");
    console.log($('#registerUsrForm').serializeArray());
    if ($("#contrasenia").val() === $("#contrasenia2").val()) {
        $.ajax({
            type: "POST",
            url: '../controller/usrController.php',
            data: $('#registerUsrForm').serializeArray(),
            dataType: 'json',
            beforeSend: function () {
                console.log("Register User...");
            },
            success: function (response) {
                if (response.errorCode === 0) {
                    console.log(response);
//                    $("#msg").html('<div class="col-md-12 col-md-offset-0"><div class="alert alert-dismissable alert-success"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong><i class="fa fa-success"> </i></strong>' + response.msg + '</div></div>');
                    //Redireccionamos al login y guardamos datos en localStorage
                    localStorage.setItem("usrSGI", $("#usuario").val());
                    localStorage.setItem("passSGI", $("#contrasenia").val());
                    localStorage.setItem("remSGI", 1);
                    showAlert(response.msg, "", "success", "bounce");
                    setTimeout(function () {
//                        $("#msg").html('');
                        window.location.href = "login.php";
                    }, 2500);
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            },
            error: function (a, b, c) {
                console.log(a, b, c);
            }
        });
    } else {
        $("#msg").html('<div class="col-md-12 col-md-offset-0"><div class="alert alert-dismissable alert-danger"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong><i class="fa fa-danger"> </i></strong>Las contraseñas no coinciden</div></div>');
        setTimeout(function () {
            $("#msg").html('');
        }, 2500);
    }

});


function getActivateSurveys() {
    $.post("../controller/catEncuestaController.php",
            {evento: 3},
            function (response) {
                if (response.errorCode === 0) {
//                    console.log(response);
                    $("#numEncuestasVig").html(response.numElems);
//                    var elemSurvey = "";
//                    $.each(response.data, function (index, value) {
//                        elemSurvey += '<p>Encuesta #<b>' + value.numero + '</b> ' + value.nombre + ': <a href="#"> 100 </a></p>';
//                    });
//                    $("#infoEncuestas").html(elemSurvey);
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getSectSurveys() {
    $.post("../controller/catEncuestaController.php",
            {evento: 4},
            function (response) {
                if (response.errorCode === 0) {
                    var elemSurvey = "";
                    $.each(response.data, function (index, value) {
                        console.log("Index: " + index + " value: " + value.nombre);

                        if (index === 0) {
                            elemSurvey += '<p>' + value.nombre + ' #<b>' + value.numero + '</b> - ' + value.descripcion + ': <a href="nums_ambiente_trabajo.php" id="s_' + value.id_seccion + '"> 0 </a></p>';
                        } else {
                            elemSurvey += '<p>' + value.nombre + ' #<b>' + value.numero + '</b> - ' + value.descripcion + ': <a href="nums_clima_organizacional.php" id="s_' + value.id_seccion + '"> 0 </a></p>';
                        }


                        obtenerNumeros(value.id_seccion);
                    });
                    $("#infoEncuestas").html(elemSurvey);
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function obtenerNumeros(idSeccion) {
    $.post("../controller/catEncuestaController.php",
            {evento: 5, id_seccion: idSeccion},
            function (response) {
                if (response.errorCode === 0) {
                    $("#s_" + idSeccion + "").html(response.numElems);
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getStatisticsAL() {
//    alert("getS");
    $.post("../controller/ambienteTrabajoController.php",
            {evento: 2, id_seccion: 1},
            function (response) {

                var aplica = 0;
                var resultado = 0;

                var aplicap1 = 0;
                var resultadop1 = 0;

                var aplicap2 = 0;
                var resultadop2 = 0;

                var aplicap3 = 0;
                var resultadop3 = 0;

                var aplicap4 = 0;
                var resultadop4 = 0;

                var aplicap5 = 0;
                var resultadop5 = 0;

                var aplicap6 = 0;
                var resultadop6 = 0;

                var aplicap7 = 0;
                var resultadop7 = 0;

                var aplicap8 = 0;
                var resultadop8 = 0;

                var aplicap9 = 0;
                var resultadop9 = 0;

                var p1 = 0;
                var p2 = 0;
                var p3 = 0;
                var p4 = 0;
                var p5 = 0;
                var p6 = 0;
                var p7 = 0;
                var p8 = 0;
                var p9 = 0;

                var us1 = "";
                var us2 = "";
                var us3 = "";
                var us4 = "";
                var us5 = "";
                var us6 = "";
                var us7 = "";
                var us8 = "";
                var us9 = "";


                $.each(response.data, function (index, value) {
                    if (parseInt(value.aplica) === 1) {
                        aplica++;
                    }
                    if (parseInt(value.resultado) === 1) {
                        resultado++;
                    }

                    switch (parseInt(value.id_pregunta)) {
                        case 1:
                            p1++;
                            if (parseInt(value.aplica) === 1) {
                                aplicap1++;
                            }
                            if (parseInt(value.resultado) === 1) {
                                resultadop1++;
                            }
                            us1 += value.nombre + "/";
                            break;
                        case 2:
                            p2++;
                            if (parseInt(value.aplica) === 1) {
                                aplicap2++;
                            }
                            if (parseInt(value.resultado) === 1) {
                                resultadop2++;
                            }
                            us2 += value.nombre + "/";
                            break;
                        case 3:
                            p3++;
                            if (parseInt(value.aplica) === 1) {
                                aplicap3++;
                            }
                            if (parseInt(value.resultado) === 1) {
                                resultadop3++;
                            }
                            us3 += value.nombre + "/";
                            break;
                        case 4:
                            p4++;
                            if (parseInt(value.aplica) === 1) {
                                aplicap4++;
                            }
                            if (parseInt(value.resultado) === 1) {
                                resultadop4++;
                            }
                            us4 += value.nombre + "/";
                            break;
                        case 5:
                            p5++;
                            if (parseInt(value.aplica) === 1) {
                                aplicap5++;
                            }
                            if (parseInt(value.resultado) === 1) {
                                resultadop5++;
                            }
                            us5 += value.nombre + "/";
                            break;
                        case 6:
                            p6++;
                            if (parseInt(value.aplica) === 1) {
                                aplicap6++;
                            }
                            if (parseInt(value.resultado) === 1) {
                                resultadop6++;
                            }
                            us6 += value.nombre + "/";
                            break;
                        case 7:
                            p7++;
                            if (parseInt(value.aplica) === 1) {
                                aplicap7++;
                            }
                            if (parseInt(value.resultado) === 1) {
                                resultadop7++;
                            }
                            us7 += value.nombre + "/";
                            break;
                        case 8:
                            p8++;
                            if (parseInt(value.aplica) === 1) {
                                aplicap8++;
                            }
                            if (parseInt(value.resultado) === 1) {
                                resultadop8++;
                            }
                            us8 += value.nombre + "/";
                            break;
                        case 9:
                            p9++;
                            if (parseInt(value.aplica) === 1) {
                                aplicap9++;
                            }
                            if (parseInt(value.resultado) === 1) {
                                resultadop9++;
                            }
                            us9 += value.nombre + "/";
                            break;

                        default:
                            break;
                    }
                });

                $("#SiP1").html("<a href='#' data-toggle='tooltip' title='" + us1 + "' onClick='verUsuarios(\"SI\",1)'>" + getPercentage(aplicap1, p1) + "</a>");
                $("#NoP1").html("<a href='#' data-toggle='tooltip' title='" + us1 + "' onClick='verUsuarios(\"NO\",1)'>" + getPercentage(p1 - aplicap1, p1) + "</a>");
                $("#SP1").html("<a href='#' data-toggle='tooltip' title='" + us1 + "' onClick='verUsuarios(\"A\",1)'>" + getPercentage(resultadop1, p1) + "</a>");
                $("#NP1").html("<a href='#' data-toggle='tooltip' title='" + us1 + "' onClick='verUsuarios(\"NA\",1)'>" + getPercentage(p1 - resultadop1, p1) + "</a>");

                $("#SiP2").html("<a href='#' data-toggle='tooltip' title='" + us2 + "' onClick='verUsuarios(\"SI\",2)'>" + getPercentage(aplicap2, p2) + "</a>");
                $("#NoP2").html("<a href='#' data-toggle='tooltip' title='" + us2 + "' onClick='verUsuarios(\"NO\",2)'>" + getPercentage(p2 - aplicap2, p2) + "</a>");
                $("#SP2").html("<a href='#' data-toggle='tooltip' title='" + us2 + "' onClick='verUsuarios(\"A\",2)'>" + getPercentage(resultadop2, p2) + "</a>");
                $("#NP2").html("<a href='#' data-toggle='tooltip' title='" + us2 + "' onClick='verUsuarios(\"NA\",2)'>" + getPercentage(p2 - resultadop2, p2) + "</a>");

                $("#SiP3").html("<a href='#' data-toggle='tooltip' title='" + us3 + "' onClick='verUsuarios(\"SI\",3)'>" + getPercentage(aplicap3, p3) + "</a>");
                $("#NoP3").html("<a href='#' data-toggle='tooltip' title='" + us3 + "' onClick='verUsuarios(\"NO\",3)'>" + getPercentage(p3 - aplicap3, p3) + "</a>");
                $("#SP3").html("<a href='#' data-toggle='tooltip' title='" + us3 + "' onClick='verUsuarios(\"A\",3)'>" + getPercentage(resultadop3, p3) + "</a>");
                $("#NP3").html("<a href='#' data-toggle='tooltip' title='" + us3 + "' onClick='verUsuarios(\"NA\",3)'>" + getPercentage(p3 - resultadop3, p3) + "</a>");

                $("#SiP4").html("<a href='#' data-toggle='tooltip' title='" + us4 + "' onClick='verUsuarios(\"SI\",4)'>" + getPercentage(aplicap4, p4) + "</a>");
                $("#NoP4").html("<a href='#' data-toggle='tooltip' title='" + us4 + "' onClick='verUsuarios(\"NO\",4)'>" + getPercentage(p4 - aplicap4, p4) + "</a>");
                $("#SP4").html("<a href='#' data-toggle='tooltip' title='" + us4 + "' onClick='verUsuarios(\"A\",4)'>" + getPercentage(resultadop4, p4) + "</a>");
                $("#NP4").html("<a href='#' data-toggle='tooltip' title='" + us4 + "' onClick='verUsuarios(\"NA\",4)'>" + getPercentage(p4 - resultadop4, p4) + "</a>");

                $("#SiP5").html("<a href='#' data-toggle='tooltip' title='" + us5 + "' onClick='verUsuarios(\"SI\",5)'>" + getPercentage(aplicap5, p5) + "</a>");
                $("#NoP5").html("<a href='#' data-toggle='tooltip' title='" + us5 + "' onClick='verUsuarios(\"NO\",5)'>" + getPercentage(p5 - aplicap5, p5) + "</a>");
                $("#SP5").html("<a href='#' data-toggle='tooltip' title='" + us5 + "' onClick='verUsuarios(\"A\",5)'>" + getPercentage(resultadop5, p5) + "</a>");
                $("#NP5").html("<a href='#' data-toggle='tooltip' title='" + us5 + "' onClick='verUsuarios(\"NA\",5)'>" + getPercentage(p5 - resultadop5, p5) + "</a>");

                $("#SiP6").html("<a href='#' data-toggle='tooltip' title='" + us6 + "' onClick='verUsuarios(\"SI\",6)'>" + getPercentage(aplicap6, p6) + "</a>");
                $("#NoP6").html("<a href='#' data-toggle='tooltip' title='" + us6 + "' onClick='verUsuarios(\"NO\",6)'>" + getPercentage(p6 - aplicap6, p6) + "</a>");
                $("#SP6").html("<a href='#' data-toggle='tooltip' title='" + us6 + "' onClick='verUsuarios(\"A\",6)'>" + getPercentage(resultadop6, p6) + "</a>");
                $("#NP6").html("<a href='#' data-toggle='tooltip' title='" + us6 + "' onClick='verUsuarios(\"NA\",6)'>" + getPercentage(p6 - resultadop6, p6) + "</a>");

                $("#SiP7").html("<a href='#' data-toggle='tooltip' title='" + us7 + "' onClick='verUsuarios(\"SI\",7)'>" + getPercentage(aplicap7, p7) + "</a>");
                $("#NoP7").html("<a href='#' data-toggle='tooltip' title='" + us7 + "' onClick='verUsuarios(\"NO\",7)'>" + getPercentage(p7 - aplicap7, p7) + "</a>");
                $("#SP7").html("<a href='#' data-toggle='tooltip' title='" + us7 + "' onClick='verUsuarios(\"A\",7)'>" + getPercentage(resultadop7, p7) + "</a>");
                $("#NP7").html("<a href='#' data-toggle='tooltip' title='" + us7 + "' onClick='verUsuarios(\"NA\",7)'>" + getPercentage(p7 - resultadop7, p7) + "</a>");

                $("#SiP8").html("<a href='#' data-toggle='tooltip' title='" + us8 + "' onClick='verUsuarios(\"SI\",8)'>" + getPercentage(aplicap8, p8) + "</a>");
                $("#NoP8").html("<a href='#' data-toggle='tooltip' title='" + us8 + "' onClick='verUsuarios(\"NO\",8)'>" + getPercentage(p8 - aplicap8, p8) + "</a>");
                $("#SP8").html("<a href='#' data-toggle='tooltip' title='" + us8 + "' onClick='verUsuarios(\"A\",8)'>" + getPercentage(resultadop8, p8) + "</a>");
                $("#NP8").html("<a href='#' data-toggle='tooltip' title='" + us8 + "' onClick='verUsuarios(\"NA\",8)'>" + getPercentage(p8 - resultadop8, p8) + "</a>");

                $("#SiP9").html("<a href='#' data-toggle='tooltip' title='" + us9 + "' onClick='verUsuarios(\"SI\",9)'>" + getPercentage(aplicap9, p9) + "</a>");
                $("#NoP9").html("<a href='#' data-toggle='tooltip' title='" + us9 + "' onClick='verUsuarios(\"NO\",9)'>" + getPercentage(p9 - aplicap9, p9) + "</a>");
                $("#SP9").html("<a href='#' data-toggle='tooltip' title='" + us9 + "' onClick='verUsuarios(\"A\",9)'>" + getPercentage(resultadop9, p9) + "</a>");
                $("#NP9").html("<a href='#' data-toggle='tooltip' title='" + us9 + "' onClick='verUsuarios(\"NA\",9)'>" + getPercentage(p9 - resultadop9, p9) + "</a>");

                console.log("Aplica Total SI: " + aplica);
                console.log("Resultado Total SATISFACTORIO: " + resultado);

                console.log("Aplica p1 SI: " + aplicap1);
                console.log("Resultado p1 SATISFACTORIO: " + resultadop1);

                console.log("Aplica p2 SI: " + aplicap2);
                console.log("Resultado p2 SATISFACTORIO: " + resultadop2);

                console.log("Aplica p3 SI: " + aplicap3);
                console.log("Resultado p3 SATISFACTORIO: " + resultadop3);

                console.log("Aplica p4 SI: " + aplicap4);
                console.log("Resultado p4 SATISFACTORIO: " + resultadop4);

                console.log("Aplica p5 SI: " + aplicap5);
                console.log("Resultado p5 SATISFACTORIO: " + resultadop5);

                console.log("Aplica p6 SI: " + aplicap6);
                console.log("Resultado p6 SATISFACTORIO: " + resultadop6);

                console.log("Aplica p7 SI: " + aplicap7);
                console.log("Resultado p7 SATISFACTORIO: " + resultadop7);

                $("#tableDDOCS").dataTable({
                    "dom": 'Bfrtip',
                    "buttons": [
                        'colvis', 'csv', 'excel', 'pdf', 'print'
//                            'excel', 'pdf', 'print'
                    ],
                    "bPaginate": true,
                    "bLengthChange": true,
                    "bFilter": true,
                    "bSort": false,
                    "bInfo": true,
                    "bAutoWidth": false,
                    "oLanguage": {
                        "sProcessing": "Procesando...",
                        "sLengthMenu": "Mostrar _MENU_ registros",
                        "sZeroRecords": "No se encontraron resultados",
                        "sEmptyTable": "Ningún dato disponible en esta tabla",
                        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                        "sInfoPostFix": "",
                        "sSearch": "Buscar:",
                        "sUrl": "",
                        "sInfoThousands": ",",
                        "sLoadingRecords": "Cargando...",
                        "sButtonText": "Imprimir",
                        "oPaginate": {
                            "sFirst": "Primero",
                            "sLast": "Último",
                            "sNext": "Siguiente",
                            "sPrevious": "Anterior"
                        },
                        "buttons": {
                            "print": "Imprimir",
                            "colvis": "Columnas mostradas"
                        }
                    }
                });

                if (response.errorCode === 0) {
                    console.log(response);
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function obtenerRespuesaPregunta(id_pregunta) {
    console.log("obtenerRespuesaPregunta");
    $.post("../controller/climaOrganizacionalController.php",
            {evento: 5, id_pregunta: id_pregunta},
            function (response) {
                if (response.errorCode === 0) {
                    console.log(response.numElems);
                    $("#" + id_pregunta + "A").html('<a href="#A" title="A" onclick="verUsuariosCOP1(\'A\',' + id_pregunta + ');">' + getPercentage(response.A, response.numElems) + ' /' + response.A + '</a>');
                    $("#" + id_pregunta + "B").html('<a href="#B" title="B" onclick="verUsuariosCOP1(\'B\',' + id_pregunta + ');">' + getPercentage(response.B, response.numElems) + ' /' + response.B + '</a>');
                    $("#" + id_pregunta + "C").html('<a href="#C" title="C" onclick="verUsuariosCOP1(\'C\',' + id_pregunta + ');">' + getPercentage(response.C, response.numElems) + ' /' + response.C + '</a>');
                    $("#" + id_pregunta + "D").html('<a href="#D" title="D" onclick="verUsuariosCOP1(\'D\',' + id_pregunta + ');">' + getPercentage(response.D, response.numElems) + ' /' + response.D + '</a>');
                    $("#" + id_pregunta + "E").html('<a href="#E" title="E" onclick="verUsuariosCOP1(\'E\',' + id_pregunta + ');">' + getPercentage(response.E, response.numElems) + ' /' + response.E + '</a>');
                    $("#" + id_pregunta + "T").html(response.numElems);
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function obtenerSugerencias() {
    $.post("../controller/climaOrganizacionalController.php",
            {evento: 8, id_seccion: 4},
            function (response) {
                if (response.errorCode === 0) {
                    var tablaSug = "";
                    $.each(response.data, function (index, value) {
                        console.log("FIGG");
                        console.log(response.data);
                        tablaSug += "<tr>"
                                + "<td>" + value.id + "</td>"
                                + "<td><a href='#' data-toggle='tooltip' title='" + value.nombre + "'>" + value.sugerencia + "</a></td>"
                                + "<td>" + value.departamento + "</td>"
                                + "<td>" + value.puesto + "</td>";

                        if (parseInt(value.sexo) === 1) {
                            tablaSug += "<td>Masculino</td>";
                        } else {
                            tablaSug += "<td>Femenino</td>";
                        }
                        tablaSug += "<td>" + value.fecha_captura + "</td>"
                        tablaSug += "<td>" + value.nombre + "</td>"
                                + "</tr>";
                    });
                    $("#tabla_sugerencias").append(tablaSug);
                    $("#clima_org_sugerencias").dataTable({
                        "dom": 'Bfrtip',
                        "buttons": [
                            'colvis', 'csv', 'excel', 'pdf', 'print'
//                            'excel', 'pdf', 'print'
                        ],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": true,
                        "bInfo": true,
                        "bAutoWidth": true,
                        "oLanguage": {
                            "sProcessing": "Procesando...",
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sZeroRecords": "No se encontraron resultados",
                            "sEmptyTable": "Ningún dato disponible en esta tabla",
                            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sSearch": "Buscar:",
                            "sUrl": "",
                            "sInfoThousands": ",",
                            "sLoadingRecords": "Cargando...",
                            "sButtonText": "Imprimir",
                            "oPaginate": {
                                "sFirst": "Primero",
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "buttons": {
                                "print": "Imprimir",
                                "colvis": "Columnas mostradas"
                            }
                        }
                    });

                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function obtenerAnexo() {
    $.post("../controller/climaOrganizacionalController.php",
            {evento: 7, id_seccion: 5},
            function (response) {
                if (response.errorCode === 0) {
                    var tablaAnexo = "";
                    $.each(response.data, function (index, value) {
                        tablaAnexo += "<tr>"
                                + "<td>" + value.id + "</td>"
                                + "<td>" + value.id_pregunta + "</td>"
                                + "<td><a href='#' data-toggle='tooltip' title='" + value.nombre + "'>" + value.respuesta + "</a></td>"
                                + "<td>" + value.fecha_captura + "</td>"
                                + "<td>" + value.nombre + "</td>"
                                + "</tr>";
                    });
                    $("#tabla_anexo").append(tablaAnexo);
                    $("#clima_org_anexo").dataTable({
                        "dom": 'Bfrtip',
                        "buttons": [
                            'colvis', 'csv', 'excel', 'pdf', 'print'
//                            'excel', 'pdf', 'print'
                        ],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": true,
                        "bInfo": true,
                        "bAutoWidth": true,
                        "oLanguage": {
                            "sProcessing": "Procesando...",
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sZeroRecords": "No se encontraron resultados",
                            "sEmptyTable": "Ningún dato disponible en esta tabla",
                            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sSearch": "Buscar:",
                            "sUrl": "",
                            "sInfoThousands": ",",
                            "sLoadingRecords": "Cargando...",
                            "sButtonText": "Imprimir",
                            "oPaginate": {
                                "sFirst": "Primero",
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "buttons": {
                                "print": "Imprimir",
                                "colvis": "Columnas mostradas"
                            }
                        }
                    });
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getPercentage(num, total) {
    var porcentaje = 0;
    porcentaje = (num * 100) / total;
    if (isNaN(porcentaje)) {
        porcentaje = 0;
    }
    porcentaje = porcentaje.toFixed(2) + " %";
    return porcentaje;
}


function getClimaOrg2(clave) {
    console.log("obtenerRespuesaPregunta");
    $.post("../controller/climaOrganizacionalController.php",
            {evento: 9, clave: clave},
            function (response) {
                console.log("9", response);
                if (response.errorCode === 0) {
//                    $("#V" + clave + "1").html(getPercentage(response.V1, response.numElems));
//                    $("#V" + clave + "2").html(getPercentage(response.V2, response.numElems));
//                    $("#V" + clave + "3").html(getPercentage(response.V3, response.numElems));
//                    $("#V" + clave + "4").html(getPercentage(response.V4, response.numElems));
//                    $("#V" + clave + "5").html(getPercentage(response.V5, response.numElems));

                    var total = parseInt(response.V1) + parseInt(response.V2) + parseInt(response.V3) + parseInt(response.V4) + parseInt(response.V5);

                    $("#V" + clave + "1").html('<a href="#" onClick="verUsuariosCOP2(' + clave + ',1);">' +getPercentage(response.V1, total ) + '/'+response.V1+'</a>');
                    $("#V" + clave + "2").html('<a href="#" onClick="verUsuariosCOP2(' + clave + ',2);">' +getPercentage(response.V2, total ) + '/'+response.V2+'</a>');
                    $("#V" + clave + "3").html('<a href="#" onClick="verUsuariosCOP2(' + clave + ',3);">' +getPercentage(response.V3, total ) + '/'+response.V3+'</a>');
                    $("#V" + clave + "4").html('<a href="#" onClick="verUsuariosCOP2(' + clave + ',4);">' +getPercentage(response.V4, total ) + '/'+response.V4+'</a>');
                    $("#V" + clave + "5").html('<a href="#" onClick="verUsuariosCOP2(' + clave + ',5);">' +getPercentage(response.V5, total ) + '/'+response.V5+'</a>');

                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getRCrtd() {
    $.post("../controller/slcController.php",
            {evento: 2},
            function (response) {
                if (response.errorCode === 0) {
                    console.log(response.numElems);
                    $("#reqCNum").html(response.numElems);
                    var reqCrtd = '';
                    $.each(response.data, function (index, value) {
                        reqCrtd += '<tr>'
                                + '<td>' + value.id_solicitud + '</td>'
                                + '<td>' + value.titulo + '</td>'
                                + '<td>' + value.nombre_archivo + '</td>'
                                + '<td>' + value.tipo_documento_nombre + '</td>'
                                + '<td>' + value.descripcion + '</td>'
                                + '<td>' + value.descripcion_estatus + '</td>'
                                + '</tr>';
                    });
                    $("#bodyreq").append(reqCrtd);
                    $("#tableReqCrtd").dataTable({
                        "dom": 'Bfrtip',
                        "buttons": [
                            'colvis', 'csv', 'excel', 'pdf', 'print'
//                            'excel', 'pdf', 'print'
                        ],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": true,
                        "bInfo": true,
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sProcessing": "Procesando...",
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sZeroRecords": "No se encontraron resultados",
                            "sEmptyTable": "Ningún dato disponible en esta tabla",
                            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sSearch": "Buscar:",
                            "sUrl": "",
                            "sInfoThousands": ",",
                            "sLoadingRecords": "Cargando...",
                            "sButtonText": "Imprimir",
                            "oPaginate": {
                                "sFirst": "Primero",
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "buttons": {
                                "print": "Imprimir",
                                "colvis": "Columnas mostradas"
                            }
                        }
                    });
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function initializeTables() {
    console.log("INITIALIZE TABLES");

    $("#clima_org_part1").dataTable({
        "dom": 'Bfrtip',
        "buttons": [
            'colvis', 'csv', 'excel', 'pdf', 'print'
//                            'excel', 'pdf', 'print'
        ],
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": false,
        "bInfo": true,
        "bAutoWidth": true,
        "oLanguage": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "sButtonText": "Imprimir",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "buttons": {
                "print": "Imprimir",
                "colvis": "Columnas mostradas"
            }
        }
    });


    $("#clima_org_part2").dataTable({
        "dom": 'Bfrtip',
        "buttons": [
            'colvis', 'csv', 'excel', 'pdf', 'print'
//                            'excel', 'pdf', 'print'
        ],
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": false,
        "bInfo": true,
        "bAutoWidth": true,
        "oLanguage": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "sButtonText": "Imprimir",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "buttons": {
                "print": "Imprimir",
                "colvis": "Columnas mostradas"
            }
        }
    });
}

function verUsuarios(identificador, id_pregunta) {
//    alert(identificador+"-"+id_pregunta);
    $("#myModal").modal("toggle");
    $("#table_ambiente_lab").dataTable().fnDestroy();
    $("#ambiente_laboral_respuestas_usuario").html("");
    $.post("../controller/ambienteTrabajoController.php",
            {evento: 4, id_seccion: 1, id_pregunta: id_pregunta, identificador: identificador},
            function (response) {
                if (response.errorCode === 0) {
                    var info = '';
                    $.each(response.data, function (index, value) {
                        info += '<tr>';
//                        info += '<td>' + value.id + '</td>';
                        info += '<td>' + value.pregunta + '</td>';
                        if (parseInt(value.aplica) === 1) {
                            info += '<td>SI</td>';
                        } else {
                            info += '<td>NO</td>';
                        }
                        if (parseInt(value.resultado) === 1) {
                            info += '<td>Satisfactorio</td>';
                        } else {
                            info += '<td>No satisfactorio</td>';
                        }
                        info += '<td>' + value.posible_accion + '</td>';
                        info += '<td>' + value.fecha_captura + '</td>';
                        info += '<td>' + value.nombre + '</td>';
                        info += '<td>' + value.apellidos + '</td>';
                        info += '<td>' + value.area + '</td>';
                        info += '<td>' + value.ubicacion + '</td>';
                    });
                    $("#ambiente_laboral_respuestas_usuario").append(info);
                    $("#table_ambiente_lab").dataTable({
                        "dom": 'Bfrtip',
                        "buttons": [
                            'colvis', 'csv', 'excel', 'pdf', 'print'
//                            'excel', 'pdf', 'print'
                        ],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": true,
                        "bInfo": true,
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sProcessing": "Procesando...",
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sZeroRecords": "No se encontraron resultados",
                            "sEmptyTable": "Ningún dato disponible en esta tabla",
                            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sSearch": "Buscar:",
                            "sUrl": "",
                            "sInfoThousands": ",",
                            "sLoadingRecords": "Cargando...",
                            "sButtonText": "Imprimir",
                            "oPaginate": {
                                "sFirst": "Primero",
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "buttons": {
                                "print": "Imprimir",
                                "colvis": "Columnas mostradas"
                            }
                        }
                    });


                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function verUsuarios2(respuesta, pregunta) {
    window.location.href = 'all_info_at.php';
}

function getInfoAmbienteLaboral() {
    $("#contestadasAL").text($("#s_1").text());
    $.post("../controller/ambienteTrabajoController.php",
            {evento: 3},
            function (response) {
                if (response.errorCode === 0) {
                    console.log(response);
                    var periodo = '';
                    $("#completasAL").text(response.completas);
                    $("#incompletasAL").text(response.incompletas);
                    $("#duplicadasAL").text(response.duplicadas);

                    var reqCrtd = '';
                    $.each(response.data, function (index, value) {
                        reqCrtd += '<tr>'
                                + '<td>' + value.no_control + '</td>'
                                + '<td><a href="#" onClick="getResponses(' + value.id_usuario + ')" class="sweet-figg-title"><b>' + value.nombre + '</b></a></td>'
                                + '<td>' + value.apellidos + '</td>'
                                + '<td>' + value.correo + '</td>'
                                + '<td>' + value.area + '</td>';
                        //Completos
                        if (parseInt(value.total) === 9) {
                            reqCrtd += '<td>1</td>';
                        } else {
                            reqCrtd += '<td>0</td>';
                        }
                        //Duplicados
                        if (parseInt(value.total) > 9) {
                            var duplicados = parseInt(value.total) / 9;
                            reqCrtd += '<td>' + duplicados + '</td>';
                        } else {
                            reqCrtd += '<td>0</td>';
                        }
                        //Incompletos
                        if (parseInt(value.total) < 9) {
                            reqCrtd += '<td>' + value.correo + '</td>';
                        } else {
                            reqCrtd += '<td>0</td>';
                        }
                        reqCrtd += '</tr>';
                        periodo = value.periodo;
                    });
                    $("#periodoAL").html(periodo);
                    $("#ambiente_laboral_respuestas").append(reqCrtd);
                    $("#ambiente_lab").dataTable({
                        "dom": 'Bfrtip',
                        "buttons": [
                            'colvis', 'csv', 'excel', 'pdf', 'print'
//                            'excel', 'pdf', 'print'
                        ],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": true,
                        "bInfo": true,
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sProcessing": "Procesando...",
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sZeroRecords": "No se encontraron resultados",
                            "sEmptyTable": "Ningún dato disponible en esta tabla",
                            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sSearch": "Buscar:",
                            "sUrl": "",
                            "sInfoThousands": ",",
                            "sLoadingRecords": "Cargando...",
                            "sButtonText": "Imprimir",
                            "oPaginate": {
                                "sFirst": "Primero",
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "buttons": {
                                "print": "Imprimir",
                                "colvis": "Columnas mostradas"
                            }
                        }
                    });


                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}


function obtenerNumerosAL(idSeccion, seccion) {
    $.post("../controller/catEncuestaController.php",
            {evento: 5, id_seccion: idSeccion},
            function (response) {
                if (response.errorCode === 0) {
                    if (seccion === 1) {
                        $("#contestadasAL").html(response.numElems);
                    } else {
                        $("#contestadasCOP1").html(response.numElems);
                    }

                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getResponses(id_usuario) {
    $("#myModal").modal("toggle");
    $("#table_ambiente_lab").dataTable().fnDestroy();
    $("#ambiente_laboral_respuestas_usuario").html("");
    $.post("../controller/ambienteTrabajoController.php",
            {evento: 4, id_seccion: 1, id_usuario: id_usuario},
            function (response) {
                if (response.errorCode === 0) {
                    var info = '';
                    $.each(response.data, function (index, value) {
                        info += '<tr>';
//                        info += '<td>' + value.id + '</td>';
                        info += '<td>' + value.pregunta + '</td>';
                        if (parseInt(value.aplica) === 1) {
                            info += '<td>SI</td>';
                        } else {
                            info += '<td>NO</td>';
                        }
                        if (parseInt(value.resultado) === 1) {
                            info += '<td>Satisfactorio</td>';
                        } else {
                            info += '<td>No satisfactorio</td>';
                        }
                        info += '<td>' + value.posible_accion + '</td>';
                        info += '<td>' + value.fecha_captura + '</td>';
                        info += '<td>' + value.nombre + '</td>';
                        info += '<td>' + value.apellidos + '</td>';
                        info += '<td>' + value.area + '</td>';
                        info += '<td>' + value.ubicacion + '</td>';
                    });
                    $("#ambiente_laboral_respuestas_usuario").append(info);
                    $("#table_ambiente_lab").dataTable({
                        "dom": 'Bfrtip',
                        "buttons": [
                            'colvis', 'csv', 'excel', 'pdf', 'print'
//                            'excel', 'pdf', 'print'
                        ],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": true,
                        "bInfo": true,
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sProcessing": "Procesando...",
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sZeroRecords": "No se encontraron resultados",
                            "sEmptyTable": "Ningún dato disponible en esta tabla",
                            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sSearch": "Buscar:",
                            "sUrl": "",
                            "sInfoThousands": ",",
                            "sLoadingRecords": "Cargando...",
                            "sButtonText": "Imprimir",
                            "oPaginate": {
                                "sFirst": "Primero",
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "buttons": {
                                "print": "Imprimir",
                                "colvis": "Columnas mostradas"
                            }
                        }
                    });

                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getResponsesCOP1(id_usuario) {
    $("#myModal").modal("toggle");
    $("#table_clima_org_p1").dataTable().fnDestroy();
    $("#clima_org_p1_respuestas_usuario").html("");
    $.post("../controller/climaOrganizacionalController.php",
            {evento: 13, id_seccion: 2, id_usuario: id_usuario},
            function (response) {
                if (response.errorCode === 0) {
                    var info = '';
                    $.each(response.data, function (index, value) {
                        info += '<tr>';
//                        info += '<td>' + value.id + '</td>';
                        info += '<td>' + value.pregunta + '</td>';

                        switch (value.respuesta) {
                            case 'A':
                                info += '<td>Totalmente de acuerdo</td>';
                                break;
                            case 'B':
                                info += '<td>De acuerdo</td>';
                                break;
                            case 'C':
                                info += '<td>Ni de acuerdo ni en desacuerdo</td>';
                                break;
                            case 'D':
                                info += '<td>En desacuerdo</td>';
                                break;
                            case 'E':
                                info += '<td>Totalmente en desacuerdo</td>';
                                break;

                            default:

                                break;
                        }

                        info += '<td>' + value.fecha_captura + '</td>';
                        info += '<td>' + value.nombre + '</td>';
                        info += '<td>' + value.apellidos + '</td>';
                        info += '<td>' + value.area + '</td>';
                        info += '<td>' + value.ubicacion + '</td>';
                    });
                    $("#clima_org_p1_respuestas_usuario").append(info);
                    $("#table_clima_org_p1").dataTable({
                        "dom": 'Bfrtip',
                        "buttons": [
                            'colvis', 'csv', 'excel', 'pdf', 'print'
//                            'excel', 'pdf', 'print'
                        ],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": true,
                        "bInfo": true,
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sProcessing": "Procesando...",
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sZeroRecords": "No se encontraron resultados",
                            "sEmptyTable": "Ningún dato disponible en esta tabla",
                            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sSearch": "Buscar:",
                            "sUrl": "",
                            "sInfoThousands": ",",
                            "sLoadingRecords": "Cargando...",
                            "sButtonText": "Imprimir",
                            "oPaginate": {
                                "sFirst": "Primero",
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "buttons": {
                                "print": "Imprimir",
                                "colvis": "Columnas mostradas"
                            }
                        }
                    });

                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getResponsesCOP2(id_usuario) {
    $("#myModal").modal("toggle");
    $("#table_clima_org_p2").dataTable().fnDestroy();
    $("#clima_org_p2_respuestas_usuario").html("");
    $.post("../controller/climaOrganizacionalController.php",
            {evento: 17, id_seccion: 3, id_usuario: id_usuario},
            function (response) {
                if (response.errorCode === 0) {
                    var info = '';
                    $.each(response.data, function (index, value) {
                        info += '<tr>';
//                        info += '<td>' + value.id + '</td>';
                        info += '<td>' + value.pregunta + '</td>';
                        info += '<td>Valor: ' + value.valor + '</td>';
                        info += '<td>' + value.fecha_captura + '</td>';
                        info += '<td>' + value.nombre + '</td>';
                        info += '<td>' + value.apellidos + '</td>';
                        info += '<td>' + value.area + '</td>';
                        info += '<td>' + value.ubicacion + '</td>';
                        info += '</tr>';
                    });
                    $("#clima_org_p2_respuestas_usuario").append(info);
                    $("#table_clima_org_p2").dataTable({
                        "dom": 'Bfrtip',
                        "buttons": [
                            'colvis', 'csv', 'excel', 'pdf', 'print'
//                            'excel', 'pdf', 'print'
                        ],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": true,
                        "bInfo": true,
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sProcessing": "Procesando...",
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sZeroRecords": "No se encontraron resultados",
                            "sEmptyTable": "Ningún dato disponible en esta tabla",
                            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sSearch": "Buscar:",
                            "sUrl": "",
                            "sInfoThousands": ",",
                            "sLoadingRecords": "Cargando...",
                            "sButtonText": "Imprimir",
                            "oPaginate": {
                                "sFirst": "Primero",
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "buttons": {
                                "print": "Imprimir",
                                "colvis": "Columnas mostradas"
                            }
                        }
                    });

                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}


function getUsrsWAS() {
    $.post("../controller/ambienteTrabajoController.php",
            {evento: 5, id_seccion: 1},
            function (response) {
                if (response.errorCode === 0) {
                    $("#usrsWAS").html('<a href="users_wasal.php">' + response.numElems + '</a>');
                    console.log(response);
                    var reqCrtd = '';
                    $.each(response.data, function (index, value) {
                        reqCrtd += '<tr>'
                                + '<td>' + value.id_usuario + '</td>'
                                + '<td>' + value.nombre + '</td>'
                                + '<td>' + value.apellidos + '</td>'
                                + '<td>' + value.correo + '</td>'
                                + '<td>' + value.area + '</td>'
                                + '<td>' + value.proyecto + '</td>'
                                + '</tr>';
                    });
                    $("#ambiente_laboral_respuestas_was").append(reqCrtd);
                    $("#ambiente_lab_was").dataTable({
                        "dom": 'Bfrtip',
                        "buttons": [
                            'colvis', 'csv', 'excel', 'pdf', 'print'
//                            'excel', 'pdf', 'print'
                        ],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": true,
                        "bInfo": true,
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sProcessing": "Procesando...",
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sZeroRecords": "No se encontraron resultados",
                            "sEmptyTable": "Ningún dato disponible en esta tabla",
                            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sSearch": "Buscar:",
                            "sUrl": "",
                            "sInfoThousands": ",",
                            "sLoadingRecords": "Cargando...",
                            "sButtonText": "Imprimir",
                            "oPaginate": {
                                "sFirst": "Primero",
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "buttons": {
                                "print": "Imprimir",
                                "colvis": "Columnas mostradas"
                            }
                        }
                    });
                    //Seteamos info de usuarios sin responder en segunda tarjeta de ambiente laboral
                    $("#usrsWAS2").html($("#usrsWAS").html());
                    $("#periodoAL2").html($("#periodoAL").html());
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getUsrsWASByProj(identificador) {
    $.post("../controller/ambienteTrabajoController.php",
            {evento: 8, id_seccion: 1, identificador: identificador},
            function (response) {
                if (response.errorCode === 0) {
                    var infoUsrWP = '';
                    $.each(response.data, function (index, value) {
                        infoUsrWP += '<p>' + value.proyecto + ': <b><a href="#aqui" title="aqui" onClick="viewUsrsByProject(' + value.id_proyecto + ')" class="sweet-figg-title"> ' + value.total + '</a></b></p>';
                    });
                    $("#usrsWAP").html(infoUsrWP);
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getUsrsWASByProjCOP1(identificador) {
    $.post("../controller/climaOrganizacionalController.php",
            {evento: 16, id_seccion: 2, identificador: identificador},
            function (response) {
                if (response.errorCode === 0) {
                    var infoUsrWP = '';
                    $.each(response.data, function (index, value) {
                        infoUsrWP += '<p>' + value.proyecto + ': <b><a href="#aqui" title="aqui" onClick="viewUsrsByProjectCOP1(' + value.id_proyecto + ')" class="sweet-figg-title"> ' + value.total + '</a></b></p>';
                    });
                    $("#usrsWAPCOP12").html(infoUsrWP);
                    $("#periodoCOP12").html($("#periodoCOP1").html());
                    $("#usrsWASCOP12").html($("#usrsWASCOP1").html());
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getUsrsWASByProjCOP2(identificador) {
    $.post("../controller/climaOrganizacionalController.php",
            {evento: 20, id_seccion: 3, identificador: identificador},
            function (response) {
                if (response.errorCode === 0) {
                    var infoUsrWP = '';
                    $.each(response.data, function (index, value) {
                        infoUsrWP += '<p>' + value.proyecto + ': <b><a href="#aqui" title="aqui" onClick="viewUsrsByProjectCOP2(' + value.id_proyecto + ')" class="sweet-figg-title"> ' + value.total + '</a></b></p>';
                    });
                    $("#usrsWAPCOP122").html(infoUsrWP);
                    $("#periodoCOP122").html($("#periodoCOP12").html());
                    $("#usrsWASCOP122").html($("#usrsWASCOP12").html());
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getInfoProjects(id_seccion, identificador) {
    $.post("../controller/ambienteTrabajoController.php",
            {evento: 6, id_seccion: id_seccion, identificador: identificador},
            function (response) {
                if (response.errorCode === 0) {
                    $.each(response.data, function (index, value) {
                        //Traemos toda la info de las respuestas

                        var tabla_proyecto = '<div id="proyecto_' + value.id_proyecto + '">'
                                + '<h3>Estad&iacute;sticas : <b class="sweet-figg-title">' + value.nombre_proyecto + '</b></h3>'
                                + '<div class="row">'
                                + '    <div class="col-lg-offset-1 col-lg-10">'
                                + '        <table id="table_project' + value.id_proyecto + '" class="table table-bordered dt-responsive nowrap text-center">'
                                + '            <thead>'
                                + '                <tr>'
                                + '                    <th>Factores</th>'
                                + '                    <th>SI</th>'
                                + '                    <th>NO</th>'
                                + '                    <th>Satisfactorio</th>'
                                + '                    <th>No Satisfactorio</th>                            			'
                                + '                </tr>'
                                + '            </thead>'
                                + '            <tbody>';
                        tabla_proyecto += '                <tr>'
                                + '                    <td>Fatiga muscular por falta de mobiliario'
                                + '                        <a href="#" data-toggle="tooltip" title="'
                                + '                           El equipo de trabajo o mobiliario que tiene asignadole ocasiona fatiga muscular.'
                                + '                           "><i class="fa fa-fw fa-question-circle"></i></a>'
                                + '                    </td>'
                                + '                    <td id="SI_1_' + value.id_proyecto + '"></td>'
                                + '                    <td id="NO_1_' + value.id_proyecto + '"></td>'
                                + '                    <td id="S_1_' + value.id_proyecto + '"></td>'
                                + '                    <td id="NS_1_' + value.id_proyecto + '"></td>'
                                + '                </tr>';
                        tabla_proyecto += '                <tr>'
                                + '                    <td>'
                                + '                      Ubicaci&oacute;n del lugar de trabajo'
                                + '                      <a href="#" data-toggle="tooltip" title="'
                                + '                         ¿La ubicación del lugar de trabajo afecta a su desempeño diario?'
                                + '                         "><i class="fa fa-fw fa-question-circle"></i></a>'
                                + '                  </td>'
                                + '                    <td id="SI_2_' + value.id_proyecto + '"></td>'
                                + '                    <td id="NO_2_' + value.id_proyecto + '"></td>'
                                + '                    <td id="S_2_' + value.id_proyecto + '"></td>'
                                + '                    <td id="NS_2_' + value.id_proyecto + '"></td>'
                                + '              </tr>';
                        tabla_proyecto += '                <tr>'
                                + '                  <td>'
                                + '                      Calor'
                                + '                      <a href="#" data-toggle="tooltip" title="'
                                + '                         ¿La temperatura (Calor) que tiene su lugar de trabajo afecta en el desempeño de las actividades?'
                                + '                         "><i class="fa fa-fw fa-question-circle"></i></a>'
                                + '                  </td>'
                                + '                    <td id="SI_3_' + value.id_proyecto + '"></td>'
                                + '                    <td id="NO_3_' + value.id_proyecto + '"></td>'
                                + '                    <td id="S_3_' + value.id_proyecto + '"></td>'
                                + '                    <td id="NS_3_' + value.id_proyecto + '"></td>'
                                + '            </tr>';
                        tabla_proyecto += '                <tr>'
                                + '                <td>  Fr&iacute;o'
                                + '                    <a href="#" data-toggle="tooltip" title="'
                                + '                     ¿La temperatura (Fr&iacute;o) que tiene su lugar de trabajo afecta en el desempeño de las actividades?'
                                + '                     "><i class="fa fa-fw fa-question-circle"></i></a>'
                                + '              </td>'
                                + '                    <td id="SI_4_' + value.id_proyecto + '"></td>'
                                + '                    <td id="NO_4_' + value.id_proyecto + '"></td>'
                                + '                    <td id="S_4_' + value.id_proyecto + '"></td>'
                                + '                    <td id="NS_4_' + value.id_proyecto + '"></td>'
                                + '          </tr>';
                        tabla_proyecto += '<tr>'
                                + '              <td>Iluminaci&oacute;n'
                                + '                  <a href="#" data-toggle="tooltip" title="'
                                + '                     ¿La iluminación que tiene su lugar de trabajo afecta en el desempeño de las actividades?'
                                + '                     "><i class="fa fa-fw fa-question-circle"></i></a>'
                                + '              </td>'
                                + '                    <td id="SI_5_' + value.id_proyecto + '"></td>'
                                + '                    <td id="NO_5_' + value.id_proyecto + '"></td>'
                                + '                    <td id="S_5_' + value.id_proyecto + '"></td>'
                                + '                    <td id="NS_5_' + value.id_proyecto + '"></td>'
                                + '          </tr>';
                        tabla_proyecto += '                <tr>'
                                + '              <td> Ventilaci&oacute;n'
                                + '                  <a href="#" data-toggle="tooltip" title="'
                                + '                     ¿La ventilación que tiene su lugar de trabajo afecta en el desempeño de las actividades?'
                                + '                     "><i class="fa fa-fw fa-question-circle"></i></a>'
                                + '              </td>'
                                + '                    <td id="SI_6_' + value.id_proyecto + '"></td>'
                                + '                    <td id="NO_6_' + value.id_proyecto + '"></td>'
                                + '                    <td id="S_6_' + value.id_proyecto + '"></td>'
                                + '                    <td id="NS_6_' + value.id_proyecto + '"></td>'
                                + '          </tr>';
                        tabla_proyecto += '                <tr>'
                                + '              <td>Seguridad'
                                + '                  <a href="#" data-toggle="tooltip" title="'
                                + '                     ¿Las medidas de seguridad ocupacional con la que cuenta su lugar de trabajo afectan el desempeño de las actividades?'
                                + '                     "><i class="fa fa-fw fa-question-circle"></i></a>'
                                + '              </td>'
                                + '                    <td id="SI_7_' + value.id_proyecto + '"></td>'
                                + '                    <td id="NO_7_' + value.id_proyecto + '"></td>'
                                + '                    <td id="S_7_' + value.id_proyecto + '"></td>'
                                + '                    <td id="NS_7_' + value.id_proyecto + '"></td>'
                                + '          </tr>';
                        tabla_proyecto += '                <tr>'
                                + '              <td>Higiene'
                                + '                  <a href="#" data-toggle="tooltip" title="'
                                + '                     ¿Las medidas de Higiene con las que cuenta su lugar de trabajo afectan el desempeño de las actividades diarias?'
                                + '                     "><i class="fa fa-fw fa-question-circle"></i></a>'
                                + '              </td>'
                                + '                    <td id="SI_8_' + value.id_proyecto + '"></td>'
                                + '                    <td id="NO_8_' + value.id_proyecto + '"></td>'
                                + '                    <td id="S_8_' + value.id_proyecto + '"></td>'
                                + '                    <td id="NS_8_' + value.id_proyecto + '"></td>'
                                + '          </tr>';
                        tabla_proyecto += '                <tr>'
                                + '              <td>Limpieza'
                                + '                  <a href="#" data-toggle="tooltip" title="'
                                + '                     ¿La limpieza el lugar de trabajo afecta en el desempeño de sus actividades diarias?'
                                + '                     "><i class="fa fa-fw fa-question-circle"></i></a>'
                                + '              </td>'
                                + '                    <td id="SI_9_' + value.id_proyecto + '"></td>'
                                + '                    <td id="NO_9_' + value.id_proyecto + '"></td>'
                                + '                    <td id="S_9_' + value.id_proyecto + '"></td>'
                                + '                    <td id="NS_9_' + value.id_proyecto + '"></td>'
                                + '          </tr>'
                                + '      </tbody>'
                                + '  </table>'
                                + '</div>'
                                + '</div>'
                                + '</div>';

                        $("#estadisticas_proyecto").append(tabla_proyecto);


                        for (var i = 1, max = 9; i <= max; i++) {
                            getInfoProjectApplyQ(value.id_proyecto, id_seccion, i, 2);
                            getInfoProjectR(value.id_proyecto, id_seccion, i, 3);

                            if (i === 9) {
                                setTimeout(function () {
                                    initializeDT('table_project' + value.id_proyecto);
                                }, 3000);
                            }

                        }

                    });
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getInfoProjectApplyQ(id_proyecto, id_seccion, id_pregunta, identificador) {
    $.post("../controller/ambienteTrabajoController.php",
            {evento: 6, id_proyecto: id_proyecto, id_seccion: id_seccion, id_pregunta: id_pregunta, identificador: identificador},
            function (response) {
                if (response.errorCode === 0) {
                    var SI = 0;
                    var NO = 0;


                    if (response.data.length > 1) {
                        SI = response.data[1].total;
                    }
                    if (response.data[0].aplica !== null) {
                        NO = response.data[0].total;
                    }

                    var total = parseInt(SI) + parseInt(NO);
                    $("#SI_" + id_pregunta + "_" + id_proyecto).html('<a href="#si" title="si" onClick="verUsuariosP(\'SI\',' + id_pregunta + ',' + id_proyecto + ');">' + getPercentage(SI, total) + "</a>");
                    $("#NO_" + id_pregunta + "_" + id_proyecto).html('<a href="#no" title="no" onClick="verUsuariosP(\'NO\',' + id_pregunta + ',' + id_proyecto + ');">' + getPercentage(NO, total) + "</a>");

                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getInfoProjectR(id_proyecto, id_seccion, id_pregunta, identificador) {
    $.post("../controller/ambienteTrabajoController.php",
            {evento: 6, id_proyecto: id_proyecto, id_seccion: id_seccion, id_pregunta: id_pregunta, identificador: identificador},
            function (response) {
                if (response.errorCode === 0) {
                    var R1 = 0;
                    var R2 = 0;

                    if (response.data.length > 1) {
                        R1 = response.data[1].total;
                    }
                    if (response.data[0].aplica !== null) {
                        R2 = response.data[0].total;
                    }
                    console.log("R1:" + R1);

                    var total = parseInt(R1) + parseInt(R2);
                    $("#S_" + id_pregunta + "_" + id_proyecto).html('<a href="#s" title="s" onClick="verUsuariosP(\'A\',' + id_pregunta + ',' + id_proyecto + ');">' + getPercentage(R1, total) + "</a>");
                    $("#NS_" + id_pregunta + "_" + id_proyecto).html('<a href="#ns" title="ns" onClick="verUsuariosP(\'NA\',' + id_pregunta + ',' + id_proyecto + ');">' + getPercentage(R2, total) + "</a>");

                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getInfoProjectsCO1(id_seccion, identificador) {
    $.post("../controller/climaOrganizacionalController.php",
            {evento: 22, id_seccion: id_seccion, identificador: identificador},
            function (response) {
                if (response.errorCode === 0) {
//                    console.log("RESPONSE: "+ response.data);
                    $.each(response.data, function (index, value) {
                        //Traemos toda la info de las respuestas

                        var tabla_proyecto = '<div id="proyecto_' + value.id_proyecto + '">'
                                + '<h3>Estad&iacute;sticas : <b class="sweet-figg-title">' + value.nombre_proyecto + '</b></h3>'
                                + '<div class="row">'
                                + '    <div class="col-lg-offset-1 col-lg-10">'
                                + '<table id="clima_org_part1_' + value.id_proyecto + '" class="table table-bordered dt-responsive nowrap table-responsive text-center">'
                                + '<thead>'
                                + '<tr>'
                                + '<th>PREGUNTAS</th>'
                                + '<th>TOTALMENTE DE ACUERDO</th>'
                                + '<th>DE ACUERDO</th>'
                                + '<th>NI DE ACUERDO NI EN DESACUERDO</th>'
                                + '<th>EN DESACUERDO</th>'
                                + '<th>TOTALMENTE EN DESACUERDO</th>'
                                + '<th>TOTAL</th>'
                                + '</tr>'
                                + '</thead>'
                                + '<tbody id="tPart1">'
                                + '<tr>'
                                + '<td>1.-Estoy satisfecho con el ambiente interno de trabajo.</td>'
                                + '<td id="1A_' + value.id_proyecto + '"></td>'
                                + '<td id="1B_' + value.id_proyecto + '"></td>'
                                + '<td id="1C_' + value.id_proyecto + '"></td>'
                                + '<td id="1D_' + value.id_proyecto + '"></td>'
                                + '<td id="1E_' + value.id_proyecto + '"></td>'
                                + '<td id="1T_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td>2.- En mi área de trabajo los sanitarios se encuentran limpios.</td>'
                                + '<td id="2A_' + value.id_proyecto + '"></td>'
                                + '<td id="2B_' + value.id_proyecto + '"></td>'
                                + '<td id="2C_' + value.id_proyecto + '"></td>'
                                + '<td id="2D_' + value.id_proyecto + '"></td>'
                                + '<td id="2E_' + value.id_proyecto + '"></td>'
                                + '<td id="2T_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td>3.-Mi jefe es claro al dirigir nuestro trabajo.</td>'
                                + '<td id="3A_' + value.id_proyecto + '"></td>'
                                + '<td id="3B_' + value.id_proyecto + '"></td>'
                                + '<td id="3C_' + value.id_proyecto + '"></td>'
                                + '<td id="3D_' + value.id_proyecto + '"></td>'
                                + '<td id="3E_' + value.id_proyecto + '"></td>'
                                + '<td id="3T_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td>4.- Mi jefe ha señalado mis fallas en público causándome malestar.</td>'
                                + '<td id="4A_' + value.id_proyecto + '"></td>'
                                + '<td id="4B_' + value.id_proyecto + '"></td>'
                                + '<td id="4C_' + value.id_proyecto + '"></td>'
                                + '<td id="4D_' + value.id_proyecto + '"></td>'
                                + '<td id="4E_' + value.id_proyecto + '"></td>'
                                + '<td id="4T_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td>5.-En esta empresa tengo futuro.</td>'
                                + '<td id="5A_' + value.id_proyecto + '"></td>'
                                + '<td id="5B_' + value.id_proyecto + '"></td>'
                                + '<td id="5C_' + value.id_proyecto + '"></td>'
                                + '<td id="5D_' + value.id_proyecto + '"></td>'
                                + '<td id="5E_' + value.id_proyecto + '"></td>'
                                + '<td id="5T_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td>6.- Por falta de planeación hacemos el trabajo bajo presión.</td>'
                                + '<td id="6A_' + value.id_proyecto + '"></td>'
                                + '<td id="6B_' + value.id_proyecto + '"></td>'
                                + '<td id="6C_' + value.id_proyecto + '"></td>'
                                + '<td id="6D_' + value.id_proyecto + '"></td>'
                                + '<td id="6E_' + value.id_proyecto + '"></td>'
                                + '<td id="6T_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td>7.-Estoy satisfecho con las instalaciones.</td>'
                                + '<td id="7A_' + value.id_proyecto + '"></td>'
                                + '<td id="7B_' + value.id_proyecto + '"></td>'
                                + '<td id="7C_' + value.id_proyecto + '"></td>'
                                + '<td id="7D_' + value.id_proyecto + '"></td>'
                                + '<td id="7E_' + value.id_proyecto + '"></td>'
                                + '<td id="7T_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td>8.-Conozco cuáles son los productos de mi empresa.</td>'
                                + '<td id="8A_' + value.id_proyecto + '"></td>'
                                + '<td id="8B_' + value.id_proyecto + '"></td>'
                                + '<td id="8C_' + value.id_proyecto + '"></td>'
                                + '<td id="8D_' + value.id_proyecto + '"></td>'
                                + '<td id="8E_' + value.id_proyecto + '"></td>'
                                + '<td id="8T_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td>9.-La evaluación de mi trabajo me ayuda a crecer y a superarme.</td>'
                                + '<td id="9A_' + value.id_proyecto + '"></td>'
                                + '<td id="9B_' + value.id_proyecto + '"></td>'
                                + '<td id="9C_' + value.id_proyecto + '"></td>'
                                + '<td id="9D_' + value.id_proyecto + '"></td>'
                                + '<td id="9E_' + value.id_proyecto + '"></td>'
                                + '<td id="9T_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td>10.-Podría manejar más carga de trabajo de la que tengo ahora.</td>'
                                + '<td id="10A_' + value.id_proyecto + '"></td>'
                                + '<td id="10B_' + value.id_proyecto + '"></td>'
                                + '<td id="10C_' + value.id_proyecto + '"></td>'
                                + '<td id="10D_' + value.id_proyecto + '"></td>'
                                + '<td id="10E_' + value.id_proyecto + '"></td>'
                                + '<td id="10T_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td>11.-En mi área de trabajo hay muchos chismes</td>'
                                + '<td id="11A_' + value.id_proyecto + '"></td>'
                                + '<td id="11B_' + value.id_proyecto + '"></td>'
                                + '<td id="11C_' + value.id_proyecto + '"></td>'
                                + '<td id="11D_' + value.id_proyecto + '"></td>'
                                + '<td id="11E_' + value.id_proyecto + '"></td>'
                                + '<td id="11T_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td>12.- Cuento con las herramientas necesarias para realizar mi trabajo. </td>'
                                + '<td id="12A_' + value.id_proyecto + '"></td>'
                                + '<td id="12B_' + value.id_proyecto + '"></td>'
                                + '<td id="12C_' + value.id_proyecto + '"></td>'
                                + '<td id="12D_' + value.id_proyecto + '"></td>'
                                + '<td id="12E_' + value.id_proyecto + '"></td>'
                                + '<td id="12T_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td>13.- Mi trabajo sufre muchas interrupciones innecesarias.</td>'
                                + '<td id="13A_' + value.id_proyecto + '"></td>'
                                + '<td id="13B_' + value.id_proyecto + '"></td>'
                                + '<td id="13C_' + value.id_proyecto + '"></td>'
                                + '<td id="13D_' + value.id_proyecto + '"></td>'
                                + '<td id="13E_' + value.id_proyecto + '"></td>'
                                + '<td id="13T_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td>14.-La empresa cumple con los compromisos que adquiere con sus empleados.</td>'
                                + '<td id="14A_' + value.id_proyecto + '"></td>'
                                + '<td id="14B_' + value.id_proyecto + '"></td>'
                                + '<td id="14C_' + value.id_proyecto + '"></td>'
                                + '<td id="14D_' + value.id_proyecto + '"></td>'
                                + '<td id="14E_' + value.id_proyecto + '"></td>'
                                + '<td id="14T_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td>15.- El servicio de limpieza es eficiente.</td>'
                                + '<td id="15A_' + value.id_proyecto + '"></td>'
                                + '<td id="15B_' + value.id_proyecto + '"></td>'
                                + '<td id="15C_' + value.id_proyecto + '"></td>'
                                + '<td id="15D_' + value.id_proyecto + '"></td>'
                                + '<td id="15E_' + value.id_proyecto + '"></td>'
                                + '<td id="15T_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td>16.- Trabajar en esta empresa me hace sentir que tengo un empleo seguro.</td>'
                                + '<td id="16A_' + value.id_proyecto + '"></td>'
                                + '<td id="16B_' + value.id_proyecto + '"></td>'
                                + '<td id="16C_' + value.id_proyecto + '"></td>'
                                + '<td id="16D_' + value.id_proyecto + '"></td>'
                                + '<td id="16E_' + value.id_proyecto + '"></td>'
                                + '<td id="16T_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td>17.- Las herramientas necesarias para realizar mi trabajo se encuentran en buen estado.</td>'
                                + '<td id="17A_' + value.id_proyecto + '"></td>'
                                + '<td id="17B_' + value.id_proyecto + '"></td>'
                                + '<td id="17C_' + value.id_proyecto + '"></td>'
                                + '<td id="17D_' + value.id_proyecto + '"></td>'
                                + '<td id="17E_' + value.id_proyecto + '"></td>'
                                + '<td id="17T_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td>18.- La empresa reconoce la calidad de mi trabajo.</td>'
                                + '<td id="18A_' + value.id_proyecto + '"></td>'
                                + '<td id="18B_' + value.id_proyecto + '"></td>'
                                + '<td id="18C_' + value.id_proyecto + '"></td>'
                                + '<td id="18D_' + value.id_proyecto + '"></td>'
                                + '<td id="18E_' + value.id_proyecto + '"></td>'
                                + '<td id="18T_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td>19.- Conozco a quién dirigirme en la empresa para cualquier asunto relacionado con mi puesto</td>'
                                + '<td id="19A_' + value.id_proyecto + '"></td>'
                                + '<td id="19B_' + value.id_proyecto + '"></td>'
                                + '<td id="19C_' + value.id_proyecto + '"></td>'
                                + '<td id="19D_' + value.id_proyecto + '"></td>'
                                + '<td id="19E_' + value.id_proyecto + '"></td>'
                                + '<td id="19T_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td>20.- Hay más gente de la necesaria haciendo las mismas cosas.</td>'
                                + '<td id="20A_' + value.id_proyecto + '"></td>'
                                + '<td id="20B_' + value.id_proyecto + '"></td>'
                                + '<td id="20C_' + value.id_proyecto + '"></td>'
                                + '<td id="20D_' + value.id_proyecto + '"></td>'
                                + '<td id="20E_' + value.id_proyecto + '"></td>'
                                + '<td id="20T_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td>21.- En esta empresa se paga mejor a quien da mejores resultados.</td>'
                                + '<td id="21A_' + value.id_proyecto + '"></td>'
                                + '<td id="21B_' + value.id_proyecto + '"></td>'
                                + '<td id="21C_' + value.id_proyecto + '"></td>'
                                + '<td id="21D_' + value.id_proyecto + '"></td>'
                                + '<td id="21E_' + value.id_proyecto + '"></td>'
                                + '<td id="21T_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td>22.- En mi departamento hay reuniones que nos permiten estar al día sobre nuestros resultados.</td>'
                                + '<td id="22A_' + value.id_proyecto + '"></td>'
                                + '<td id="22B_' + value.id_proyecto + '"></td>'
                                + '<td id="22C_' + value.id_proyecto + '"></td>'
                                + '<td id="22D_' + value.id_proyecto + '"></td>'
                                + '<td id="22E_' + value.id_proyecto + '"></td>'
                                + '<td id="22T_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td>23.- En esta empresa confían en mí.</td>'
                                + '<td id="23A_' + value.id_proyecto + '"></td>'
                                + '<td id="23B_' + value.id_proyecto + '"></td>'
                                + '<td id="23C_' + value.id_proyecto + '"></td>'
                                + '<td id="23D_' + value.id_proyecto + '"></td>'
                                + '<td id="23E_' + value.id_proyecto + '"></td>'
                                + '<td id="23T_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td>24.- Mi sueldo es pagado con puntualidad.</td>'
                                + '<td id="24A_' + value.id_proyecto + '"></td>'
                                + '<td id="24B_' + value.id_proyecto + '"></td>'
                                + '<td id="24C_' + value.id_proyecto + '"></td>'
                                + '<td id="24D_' + value.id_proyecto + '"></td>'
                                + '<td id="24E_' + value.id_proyecto + '"></td>'
                                + '<td id="24T_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td>25.- Estoy bien capacitado para operar el equipo especializado que requiere mi trabajo.</td>'
                                + '<td id="25A_' + value.id_proyecto + '"></td>'
                                + '<td id="25B_' + value.id_proyecto + '"></td>'
                                + '<td id="25C_' + value.id_proyecto + '"></td>'
                                + '<td id="25D_' + value.id_proyecto + '"></td>'
                                + '<td id="25E_' + value.id_proyecto + '"></td>'
                                + '<td id="25T_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td>26.- En mi departamento tenemos todo lo necesario para hacer nuestro trabajo.</td>'
                                + '<td id="26A_' + value.id_proyecto + '"></td>'
                                + '<td id="26B_' + value.id_proyecto + '"></td>'
                                + '<td id="26C_' + value.id_proyecto + '"></td>'
                                + '<td id="26D_' + value.id_proyecto + '"></td>'
                                + '<td id="26E_' + value.id_proyecto + '"></td>'
                                + '<td id="26T_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td>27.- Hay departamentos que no colaboran oportunamente y retrasan nuestro trabajo.</td>'
                                + '<td id="27A_' + value.id_proyecto + '"></td>'
                                + '<td id="27B_' + value.id_proyecto + '"></td>'
                                + '<td id="27C_' + value.id_proyecto + '"></td>'
                                + '<td id="27D_' + value.id_proyecto + '"></td>'
                                + '<td id="27E_' + value.id_proyecto + '"></td>'
                                + '<td id="27T_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td>28.- Mi jefe propicia el trabajo en equipo.</td>'
                                + '<td id="28A_' + value.id_proyecto + '"></td>'
                                + '<td id="28B_' + value.id_proyecto + '"></td>'
                                + '<td id="28C_' + value.id_proyecto + '"></td>'
                                + '<td id="28D_' + value.id_proyecto + '"></td>'
                                + '<td id="28E_' + value.id_proyecto + '"></td>'
                                + '<td id="28T_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td>29.- En mi departamento recibimos apoyo oportuno de los departamentos que se relacionan con nuestro trabajo.</td>'
                                + '<td id="29A_' + value.id_proyecto + '"></td>'
                                + '<td id="29B_' + value.id_proyecto + '"></td>'
                                + '<td id="29C_' + value.id_proyecto + '"></td>'
                                + '<td id="29D_' + value.id_proyecto + '"></td>'
                                + '<td id="29E_' + value.id_proyecto + '"></td>'
                                + '<td id="29T_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td>30.- En mi trabajo la ventilación es adecuada.</td>'
                                + '<td id="30A_' + value.id_proyecto + '"></td>'
                                + '<td id="30B_' + value.id_proyecto + '"></td>'
                                + '<td id="30C_' + value.id_proyecto + '"></td>'
                                + '<td id="30D_' + value.id_proyecto + '"></td>'
                                + '<td id="30E_' + value.id_proyecto + '"></td>'
                                + '<td id="30T_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td>31.- Cuenta más el favoritismo que el mérito personal para dar promociones.</td>'
                                + '<td id="31A_' + value.id_proyecto + '"></td>'
                                + '<td id="31B_' + value.id_proyecto + '"></td>'
                                + '<td id="31C_' + value.id_proyecto + '"></td>'
                                + '<td id="31D_' + value.id_proyecto + '"></td>'
                                + '<td id="31E_' + value.id_proyecto + '"></td>'
                                + '<td id="31T_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td>32.- En mi departamento hay reuniones donde se trabaja para mejorar nuestro desempeño</td>'
                                + '<td id="32A_' + value.id_proyecto + '"></td>'
                                + '<td id="32B_' + value.id_proyecto + '"></td>'
                                + '<td id="32C_' + value.id_proyecto + '"></td>'
                                + '<td id="32D_' + value.id_proyecto + '"></td>'
                                + '<td id="32E_' + value.id_proyecto + '"></td>'
                                + '<td id="32T_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td>33.- Comprendo cuál es la colaboración que mi departamento hace para que la empresa logre sus objetivos.</td>'
                                + '<td id="33A_' + value.id_proyecto + '"></td>'
                                + '<td id="33B_' + value.id_proyecto + '"></td>'
                                + '<td id="33C_' + value.id_proyecto + '"></td>'
                                + '<td id="33D_' + value.id_proyecto + '"></td>'
                                + '<td id="33E_' + value.id_proyecto + '"></td>'
                                + '<td id="33T_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td>34.- Mi jefe está al pendiente de mi desempeño cotidiano</td>'
                                + '<td id="34A_' + value.id_proyecto + '"></td>'
                                + '<td id="34B_' + value.id_proyecto + '"></td>'
                                + '<td id="34C_' + value.id_proyecto + '"></td>'
                                + '<td id="34D_' + value.id_proyecto + '"></td>'
                                + '<td id="34E_' + value.id_proyecto + '"></td>'
                                + '<td id="34T_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td>35.- La evaluación del desempeño es útil para mí.</td>'
                                + '<td id="35A_' + value.id_proyecto + '"></td>'
                                + '<td id="35B_' + value.id_proyecto + '"></td>'
                                + '<td id="35C_' + value.id_proyecto + '"></td>'
                                + '<td id="35D_' + value.id_proyecto + '"></td>'
                                + '<td id="35E_' + value.id_proyecto + '"></td>'
                                + '<td id="35T_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td>36.- Estoy decididamente dispuesto a colaborar con mis directivos para aumentar la productividad de la empresa.</td>'
                                + '<td id="36A_' + value.id_proyecto + '"></td>'
                                + '<td id="36B_' + value.id_proyecto + '"></td>'
                                + '<td id="36C_' + value.id_proyecto + '"></td>'
                                + '<td id="36D_' + value.id_proyecto + '"></td>'
                                + '<td id="36E_' + value.id_proyecto + '"></td>'
                                + '<td id="36T_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td>37.- En mi puesto yo decido cómo hacer las cosas.</td>'
                                + '<td id="37A_' + value.id_proyecto + '"></td>'
                                + '<td id="37B_' + value.id_proyecto + '"></td>'
                                + '<td id="37C_' + value.id_proyecto + '"></td>'
                                + '<td id="37D_' + value.id_proyecto + '"></td>'
                                + '<td id="37E_' + value.id_proyecto + '"></td>'
                                + '<td id="37T_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '</tbody>'
                                + '</table>'
                                + '</div>'
                                + '</div>'
                                + '</div>';

                        $("#estadisticas_proyecto").append(tabla_proyecto);


                        for (var i = 1, max = 38; i <= max; i++) {
                            getInfoProjectApplyQCO1(value.id_proyecto, id_seccion, i, 2);
//                            getInfoProjectRCO1(value.id_proyecto, id_seccion, i, 3);

                            if (i === 38) {
                                setTimeout(function () {
                                    initializeDT('clima_org_part1_' + value.id_proyecto);
                                }, 1000);
                            }
                        }

                    });
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}


function getInfoProjectsCO2(id_seccion, identificador) {
    $.post("../controller/climaOrganizacionalController.php",
            {evento: 24, id_seccion: id_seccion, identificador: identificador},
            function (response) {
                if (response.errorCode === 0) {
//                    console.log("RESPONSE: "+ response.data);
                    $.each(response.data, function (index, value) {
                        //Traemos toda la info de las respuestas

                        var tabla_proyecto = '<div id="proyecto_' + value.id_proyecto + '">'
                                + '<h3>Estad&iacute;sticas : <b class="sweet-figg-title">' + value.nombre_proyecto + '</b></h3>'
                                + '<div class="row">'
                                + '    <div class="col-lg-offset-1 col-lg-10">'
                                + ' <table id="clima_org_part2_' + value.id_proyecto + '" class="table table-bordered dt-responsive nowrap table-responsive text-center nowrap">'
                                + '<thead>'
                                + '<tr>'
                                + '<th>Condiciones</th>'
                                + '<th>Valoraci&oacute;n 1</th>'
                                + '<th>Valoraci&oacute;n 2</th>'
                                + '<th>Valoraci&oacute;n 3</th>'
                                + '<th>Valoraci&oacute;n 4</th>'
                                + '<th>Valoraci&oacute;n 5</th>'
                                + '</tr>'
                                + '</thead>'
                                + '<tbody id="primera_parte">'
                                + '<tr>'
                                + '<td width="50%"><p><b>Condiciones Físicas del Trabajo.</b><br />'
                                + '            Este factor se refiere al estado de iluminación,'
                                + '          ventilación y calidad de las instalaciones y servicios sanitarios.'

                                + '</td>'
                                + '<td id="V11_' + value.id_proyecto + '"></td>'
                                + '<td id="V12_' + value.id_proyecto + '"></td>'
                                + '<td id="V13_' + value.id_proyecto + '"></td>'
                                + '<td id="V14_' + value.id_proyecto + '"></td>'
                                + '<td id="V15_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td><p><b>Conocimiento de la Empresa.</b><br />'
                                + '       Se refiere a la información que tienes de la empresa, su estructura, sus productos y los de la competencia.'

                                + '</td>'
                                + '<td id="V21_' + value.id_proyecto + '"></td>'
                                + '<td id="V22_' + value.id_proyecto + '"></td>'
                                + '<td id="V23_' + value.id_proyecto + '"></td>'
                                + '<td id="V24_' + value.id_proyecto + '"></td>'
                                + '<td id="V25_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td><p><b>Equipo de Trabajo.</b><br />'
                                + '          Este factor se refiere al estado que guardan los útiles y herramientas que se te asignan para realizar tu trabajo'

                                + '</td>'
                                + '<td id="V31_' + value.id_proyecto + '"></td>'
                                + '<td id="V32_' + value.id_proyecto + '"></td>'
                                + '<td id="V33_' + value.id_proyecto + '"></td>'
                                + '<td id="V34_' + value.id_proyecto + '"></td>'
                                + '<td id="V35_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td><p><b>Evaluación de Desempeño.</b><br />'
                                + '          Se refiere a la opinión que tienes sobre la evaluación del desempeño tal y como se lleva en tu empresa.'

                                + '</td>'
                                + '<td id="V41_' + value.id_proyecto + '"></td>'
                                + '<td id="V42_' + value.id_proyecto + '"></td>'
                                + '<td id="V43_' + value.id_proyecto + '"></td>'
                                + '<td id="V44_' + value.id_proyecto + '"></td>'
                                + '<td id="V45_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td><p><b>Ambiente Interno de Trabajo.</b><br />'
                                + '          Se refiere a las relaciones de trabajo que existen en tu departamento'
                                + '</td>'
                                + '<td id="V51_' + value.id_proyecto + '"></td>'
                                + '<td id="V52_' + value.id_proyecto + '"></td>'
                                + '<td id="V53_' + value.id_proyecto + '"></td>'
                                + '<td id="V54_' + value.id_proyecto + '"></td>'
                                + '<td id="V55_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td><p><b>Liderazgo.</b><br />'
                                + '       Se refiere a la Capacidad que tiene tu jefe para delegar responsabilidades y a la orientación que te da para realizar las cosas mejor.'

                                + '</td>'
                                + '<td id="V61_' + value.id_proyecto + '"></td>'
                                + '<td id="V62_' + value.id_proyecto + '"></td>'
                                + '<td id="V63_' + value.id_proyecto + '"></td>'
                                + '<td id="V64_' + value.id_proyecto + '"></td>'
                                + '<td id="V65_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td><p><b>Seguridad en el Trabajo.</b><br />'
                                + '       Se refiere a la seguridad de contar con un empleo y el futuro que te ofrece la empresa.'

                                + '</td>'
                                + '<td id="V71_' + value.id_proyecto + '"></td>'
                                + '<td id="V72_' + value.id_proyecto + '"></td>'
                                + '<td id="V73_' + value.id_proyecto + '"></td>'
                                + '<td id="V74_' + value.id_proyecto + '"></td>'
                                + '<td id="V75_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td><p><b>Presión de Trabajo.</b><br />'
                                + '       Se refiere a las tensiones que te provoca tu trabajo, a las interrupciones innecesarias y al tiempo con el que cuentas para comer.'

                                + '</td>'
                                + '<td id="V81_' + value.id_proyecto + '"></td>'
                                + '<td id="V82_' + value.id_proyecto + '"></td>'
                                + '<td id="V83_' + value.id_proyecto + '"></td>'
                                + '<td id="V84_' + value.id_proyecto + '"></td>'
                                + '<td id="V85_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td><p><b>Remuneraciones.</b><br />'
                                + '          Se refiere a lo satisfecho o insatisfecho que te encuentras con respecto a las prestaciones, sueldos, pago equitativo a quien da mejores resultados.'

                                + '</td>'
                                + '<td id="V91_' + value.id_proyecto + '"></td>'
                                + '<td id="V92_' + value.id_proyecto + '"></td>'
                                + '<td id="V93_' + value.id_proyecto + '"></td>'
                                + '<td id="V94_' + value.id_proyecto + '"></td>'
                                + '<td id="V95_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td><p><b>Apoyo Administrativo y de Recursos Humanos.</b><br />'
                                + '          Se refiere a la eficiencia de los trabajos de mantenimiento, limpieza y otros al interés mostrado'
                                + '         por esa área para que recibas oportunamente tu sueldo y prestaciones, así como otros programas de bienestar'
                                + '        y desarrollo.'

                                + '</td>'
                                + '<td id="V101_' + value.id_proyecto + '"></td>'
                                + '<td id="V102_' + value.id_proyecto + '"></td>'
                                + '<td id="V103_' + value.id_proyecto + '"></td>'
                                + '<td id="V104_' + value.id_proyecto + '"></td>'
                                + '<td id="V105_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td><p><b>Autonomía.</b><br />'
                                + '       Se refiere a la libertad que tienes para actuar, a las facultades administrativas con las que cuentas para cumplir tus responsabilidades.'

                                + '</td>'
                                + '<td id="V111_' + value.id_proyecto + '"></td>'
                                + '<td id="V112_' + value.id_proyecto + '"></td>'
                                + '<td id="V113_' + value.id_proyecto + '"></td>'
                                + '<td id="V114_' + value.id_proyecto + '"></td>'
                                + '<td id="V115_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td><p><b>Reconocimiento al Trabajo.</b><br />'
                                + '       Se refiere al reconocimiento que tu jefe hace oportunamente de la calidad de tu trabajo.                                                    '
                                + '</td>'
                                + '<td id="V121_' + value.id_proyecto + '"></td>'
                                + '<td id="V122_' + value.id_proyecto + '"></td>'
                                + '<td id="V123_' + value.id_proyecto + '"></td>'
                                + '<td id="V124_' + value.id_proyecto + '"></td>'
                                + '<td id="V125_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td><p><b>Cargas de Trabajo.</b><br />'
                                + '       Se refiere al volumen de trabajo que implica tu puesto                                                    '
                                + '</td>'
                                + '<td id="V131_' + value.id_proyecto + '"></td>'
                                + '<td id="V132_' + value.id_proyecto + '"></td>'
                                + '<td id="V133_' + value.id_proyecto + '"></td>'
                                + '<td id="V134_' + value.id_proyecto + '"></td>'
                                + '<td id="V135_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td><p><b>Identificación con la Empresa.</b><br />'
                                + '       Se refiere al gusto que tienes por el tipo de trabajo que hace tu empresa y sentirte parte de sus logros.                                                    '
                                + '</td>'
                                + '<td id="V141_' + value.id_proyecto + '"></td>'
                                + '<td id="V142_' + value.id_proyecto + '"></td>'
                                + '<td id="V143_' + value.id_proyecto + '"></td>'
                                + '<td id="V144_' + value.id_proyecto + '"></td>'
                                + '<td id="V145_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td><p><b>Capacitación e Inducción.</b><br />'
                                + '          Se refiere a la capacitación e inducción que has recibido y su utilidad para mejorar tu desempeño.                                                    '
                                + '</td>'
                                + '<td id="V151_' + value.id_proyecto + '"></td>'
                                + '<td id="V152_' + value.id_proyecto + '"></td>'
                                + '<td id="V153_' + value.id_proyecto + '"></td>'
                                + '<td id="V154_' + value.id_proyecto + '"></td>'
                                + '<td id="V155_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '</tr>'
                                + '<td><p><b>Coordinación Interdepartamental. </b><br />'
                                + '          Se refiere al apoyo que recibes de otros departamentos que se relacionan con tu trabajo.                                                    '
                                + '</td>'
                                + '<td id="V161_' + value.id_proyecto + '"></td>'
                                + '<td id="V162_' + value.id_proyecto + '"></td>'
                                + '<td id="V163_' + value.id_proyecto + '"></td>'
                                + '<td id="V164_' + value.id_proyecto + '"></td>'
                                + '<td id="V165_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td><p><b>Comunicación Directiva.</b><br />'
                                + '       Se refiere a la comunicación y orientación que proviene de la dirección de la empresa.                                                    '
                                + '</td>'
                                + '<td id="V171_' + value.id_proyecto + '"></td>'
                                + '<td id="V172_' + value.id_proyecto + '"></td>'
                                + '<td id="V173_' + value.id_proyecto + '"></td>'
                                + '<td id="V174_' + value.id_proyecto + '"></td>'
                                + '<td id="V175_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '<tr>'
                                + '<td><p><b>Comunicación Jefe-Colaborador.</b><br />'
                                + '          Se refiere a la comunicación y trato que recibes de tu jefe.                                                    '
                                + ' </td>'
                                + '<td id="V181_' + value.id_proyecto + '"></td>'
                                + '<td id="V182_' + value.id_proyecto + '"></td>'
                                + '<td id="V183_' + value.id_proyecto + '"></td>'
                                + '<td id="V184_' + value.id_proyecto + '"></td>'
                                + '<td id="V185_' + value.id_proyecto + '"></td>'
                                + '</tr>'
                                + '</tbody>'
                                + '</table>'
                                + '</div>'
                                + '</div>'
                                + '</div>';

                        $("#estadisticas_proyecto").append(tabla_proyecto);

                        for (var i = 1, max = 19; i <= max; i++) {
                            getInfoProjectApplyQCO2(value.id_proyecto, id_seccion, i, 2);

                            if (i === 19) {
                                setTimeout(function () {
                                    initializeDT('clima_org_part2_' + value.id_proyecto);
                                }, 1000);
                            }
                        }

                    });
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getInfoProjectApplyQCO1(id_proyecto, id_seccion, id_pregunta, identificador) {
//    alert("getInfoProjectApplyQCO1");
    $.post("../controller/climaOrganizacionalController.php",
            {evento: 22, id_proyecto: id_proyecto, id_seccion: id_seccion, id_pregunta: id_pregunta, identificador: identificador},
            function (response) {
                if (response.errorCode === 0) {
                    var A = 0, B = 0, C = 0, D = 0, E = 0;
                    $.each(response.data, function (index, value) {
                        switch (value.respuesta) {
                            case 'A':
                                A = value.total;
                                break;
                            case 'B':
                                B = value.total;
                                break;
                            case 'C':
                                C = value.total;
                                break;
                            case 'D':
                                D = value.total;
                                break;
                            case 'E':
                                E = value.total;
                                break;
                            default:

                                break;
                        }
                    });

                    var total = parseInt(A) + parseInt(B) + parseInt(C) + parseInt(D) + parseInt(E);

                    $("#" + id_pregunta + "A_" + id_proyecto).html('<a href="#A" title="A" onClick="verUsuariosPCO1(\'A\',' + id_pregunta + ',' + id_proyecto + ');">' + getPercentage(A, total) + "/" + A + "</a>");
                    $("#" + id_pregunta + "B_" + id_proyecto).html('<a href="#B" title="A" onClick="verUsuariosPCO1(\'B\',' + id_pregunta + ',' + id_proyecto + ');">' + getPercentage(B, total) + "/" + B + "</a>");
                    $("#" + id_pregunta + "C_" + id_proyecto).html('<a href="#C" title="A" onClick="verUsuariosPCO1(\'C\',' + id_pregunta + ',' + id_proyecto + ');">' + getPercentage(C, total) + "/" + C + "</a>");
                    $("#" + id_pregunta + "D_" + id_proyecto).html('<a href="#D" title="A" onClick="verUsuariosPCO1(\'D\',' + id_pregunta + ',' + id_proyecto + ');">' + getPercentage(D, total) + "/" + D + "</a>");
                    $("#" + id_pregunta + "E_" + id_proyecto).html('<a href="#E" title="A" onClick="verUsuariosPCO1(\'E\',' + id_pregunta + ',' + id_proyecto + ');">' + getPercentage(E, total) + "/" + E + "</a>");
                    $("#" + id_pregunta + "T_" + id_proyecto).html(total);


//                    $("#SI_" + id_pregunta + "_" + id_proyecto).html('<a href="#si" title="si" onClick="verUsuariosP(\'SI\',' + id_pregunta + ',' + id_proyecto + ');">' + getPercentage(SI, total) + "</a>");
//                    $("#NO_" + id_pregunta + "_" + id_proyecto).html('<a href="#no" title="no" onClick="verUsuariosP(\'NO\',' + id_pregunta + ',' + id_proyecto + ');">' + getPercentage(NO, total) + "</a>");

                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getInfoProjectApplyQCO2(id_proyecto, id_seccion, id_pregunta, identificador) {
//    alert("getInfoProjectApplyQCO1");
    $.post("../controller/climaOrganizacionalController.php",
            {evento: 24, id_proyecto: id_proyecto, id_seccion: id_seccion, id_pregunta: id_pregunta, identificador: identificador},
            function (response) {
                if (response.errorCode === 0) {

//                    console.log("--------------------------------------------------------->");
//                    console.log(response.data);
                    var V1 = 0, V2 = 0, V3 = 0, V4 = 0, V5 = 0;
                    if (response.data.length > 0) {
//                        console.log("TRAIGO ALGOOOOOOOOOOOOOOOOOOOOOO..!!!");
                        $.each(response.data, function (index, value) {
                            switch (parseInt(value.valor)) {
                                case 1:
                                    V1 = value.total;
                                    break;
                                case 2:
                                    V2 = value.total;
                                    break;
                                case 3:
                                    V3 = value.total;
                                    break;
                                case 4:
                                    V4 = value.total;
                                    break;
                                case 5:
                                    V5 = value.total;
                                    break;
                                default:

                                    break;
                            }
                        });
                    } else {
//                        console.log("No traigo NADA: " + response.data.length);
//                        console.log("Valores:  V1 =" + V1 + " V2 = " + V2 + " V3 =" + V3 + " V4 =" + V4 + " V5 =" + V5);
                    }


                    var total = parseInt(V1) + parseInt(V2) + parseInt(V3) + parseInt(V4) + parseInt(V5);
//                    console.log("TOTAL: " + total);


//                    $("#V" + id_pregunta + "1_" + id_proyecto).html(V1);
//                    $("#V" + id_pregunta + "2_" + id_proyecto).html(V2);
//                    $("#V" + id_pregunta + "3_" + id_proyecto).html(V3);
//                    $("#V" + id_pregunta + "4_" + id_proyecto).html(V4);
//                    $("#V" + id_pregunta + "5_" + id_proyecto).html(V5);
//                    $("#V" + clave + "1").html('<a href="#" onClick="verUsuariosCOP2(' + clave + ',1);">' + response.V1 + '</a>');
//                    $("#V" + clave + "2").html('<a href="#" onClick="verUsuariosCOP2(' + clave + ',2);">' + response.V2 + '</a>');
//                    $("#V" + clave + "3").html('<a href="#" onClick="verUsuariosCOP2(' + clave + ',3);">' + response.V3 + '</a>');
//                    $("#V" + clave + "4").html('<a href="#" onClick="verUsuariosCOP2(' + clave + ',4);">' + response.V4 + '</a>');
//                    $("#V" + clave + "5").html('<a href="#" onClick="verUsuariosCOP2(' + clave + ',5);">' + response.V5 + '</a>');


                    $("#V" + id_pregunta + "1_" + id_proyecto).html('<a href="#V1" title="V1" onClick="verUsuariosPCO2(\'1\',' + id_pregunta + ',' + id_proyecto + ');">' + getPercentage(V1, total) + "/" + V1 + "</a>");
                    $("#V" + id_pregunta + "2_" + id_proyecto).html('<a href="#V2" title="V2" onClick="verUsuariosPCO2(\'2\',' + id_pregunta + ',' + id_proyecto + ');">' + getPercentage(V2, total) + "/" + V2 + "</a>");
                    $("#V" + id_pregunta + "3_" + id_proyecto).html('<a href="#V3" title="V3" onClick="verUsuariosPCO2(\'3\',' + id_pregunta + ',' + id_proyecto + ');">' + getPercentage(V3, total) + "/" + V3 + "</a>");
                    $("#V" + id_pregunta + "4_" + id_proyecto).html('<a href="#V4" title="V4" onClick="verUsuariosPCO2(\'4\',' + id_pregunta + ',' + id_proyecto + ');">' + getPercentage(V4, total) + "/" + V4 + "</a>");
                    $("#V" + id_pregunta + "5_" + id_proyecto).html('<a href="#V5" title="V5" onClick="verUsuariosPCO2(\'5\',' + id_pregunta + ',' + id_proyecto + ');">' + getPercentage(V5, total) + "/" + V5 + "</a>");
//                    $("#" + id_pregunta + "T_" + id_proyecto).html(total);

                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}


function getInfoProjectRCO1(id_proyecto, id_seccion, id_pregunta, identificador) {
    $.post("../controller/ambienteTrabajoController.php",
            {evento: 6, id_proyecto: id_proyecto, id_seccion: id_seccion, id_pregunta: id_pregunta, identificador: identificador},
            function (response) {
                if (response.errorCode === 0) {
                    var R1 = 0;
                    var R2 = 0;

                    if (response.data.length > 1) {
                        R1 = response.data[1].total;
                    }
                    if (response.data[0].aplica !== null) {
                        R2 = response.data[0].total;
                    }
                    console.log("R1:" + R1);

                    var total = parseInt(R1) + parseInt(R2);
                    $("#S_" + id_pregunta + "_" + id_proyecto).html('<a href="#s" title="s" onClick="verUsuariosP(\'A\',' + id_pregunta + ',' + id_proyecto + ');">' + getPercentage(R1, total) + "</a>");
                    $("#NS_" + id_pregunta + "_" + id_proyecto).html('<a href="#ns" title="ns" onClick="verUsuariosP(\'NA\',' + id_pregunta + ',' + id_proyecto + ');">' + getPercentage(R2, total) + "</a>");

                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function verUsuariosP(identificador, id_pregunta, proyecto) {
//    alert(identificador+"-"+id_pregunta);
    $("#myModal2").modal("toggle");
    $("#table_ambiente_lab_p").dataTable().fnDestroy();
    $("#ambiente_laboral_respuestas_usuario_p").html("");
    $.post("../controller/ambienteTrabajoController.php",
            {evento: 7, id_seccion: 1, id_pregunta: id_pregunta, identificador: identificador, id_proyecto: proyecto},
            function (response) {
                if (response.errorCode === 0) {
                    var info = '';
                    $.each(response.data, function (index, value) {
                        info += '<tr>';
//                        info += '<td>' + value.id + '</td>';
                        info += '<td>' + value.pregunta + '</td>';
                        if (parseInt(value.aplica) === 1) {
                            info += '<td>SI</td>';
                        } else {
                            info += '<td>NO</td>';
                        }
                        if (parseInt(value.resultado) === 1) {
                            info += '<td>Satisfactorio</td>';
                        } else {
                            info += '<td>No satisfactorio</td>';
                        }
                        info += '<td>' + value.posible_accion + '</td>';
                        info += '<td>' + value.fecha_captura + '</td>';
                        info += '<td>' + value.nombre + '</td>';
                        info += '<td>' + value.apellidos + '</td>';
                        info += '<td>' + value.area + '</td>';
                        info += '<td>' + value.ubicacion + '</td>';
                    });
                    $("#ambiente_laboral_respuestas_usuario_p").append(info);
                    $("#table_ambiente_lab_p").dataTable({
                        "dom": 'Bfrtip',
                        "buttons": [
                            'colvis', 'csv', 'excel', 'pdf', 'print'
//                            'excel', 'pdf', 'print'
                        ],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": true,
                        "bInfo": true,
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sProcessing": "Procesando...",
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sZeroRecords": "No se encontraron resultados",
                            "sEmptyTable": "Ningún dato disponible en esta tabla",
                            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sSearch": "Buscar:",
                            "sUrl": "",
                            "sInfoThousands": ",",
                            "sLoadingRecords": "Cargando...",
                            "sButtonText": "Imprimir",
                            "oPaginate": {
                                "sFirst": "Primero",
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "buttons": {
                                "print": "Imprimir",
                                "colvis": "Columnas mostradas"
                            }
                        }
                    });


                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function verUsuariosPCO1(identificador, id_pregunta, proyecto) {
//    alert(identificador+"-"+id_pregunta);
    $("#myModal2").modal("toggle");
    $("#table_clima_org_p1_p").dataTable().fnDestroy();
    $("#clima_org_p1_respuestas_usuario_p").html("");
    $.post("../controller/climaOrganizacionalController.php",
            {evento: 23, id_seccion: 2, id_pregunta: id_pregunta, identificador: identificador, id_proyecto: proyecto},
            function (response) {
                if (response.errorCode === 0) {
                    var info = '';
                    $.each(response.data, function (index, value) {
                        info += '<tr>';
//                        info += '<td>' + value.id + '</td>';
                        info += '<td>' + value.pregunta + '</td>';
                        switch (value.respuesta) {
                            case 'A':
                                info += '<td>Totalmente de acuerdo</td>';
                                break;
                            case 'B':
                                info += '<td>De acuerdo</td>';
                                break;
                            case 'C':
                                info += '<td>Ni de acuerdo ni en desacuerdo</td>';
                                break;
                            case 'D':
                                info += '<td>En desacuerdo</td>';
                                break;
                            case 'E':
                                info += '<td>Totalmente en desacuerdo</td>';
                                break;

                            default:

                                break;
                        }
                        info += '<td>' + value.fecha_captura + '</td>';
                        info += '<td>' + value.nombre + '</td>';
                        info += '<td>' + value.apellidos + '</td>';
                        info += '<td>' + value.area + '</td>';
                        info += '<td>' + value.ubicacion + '</td>';
                        info += '</tr>';
                    });
                    $("#clima_org_p1_respuestas_usuario_p").append(info);
                    $("#table_clima_org_p1_p").dataTable({
                        "dom": 'Bfrtip',
                        "buttons": [
                            'colvis', 'csv', 'excel', 'pdf', 'print'
//                            'excel', 'pdf', 'print'
                        ],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": true,
                        "bInfo": true,
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sProcessing": "Procesando...",
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sZeroRecords": "No se encontraron resultados",
                            "sEmptyTable": "Ningún dato disponible en esta tabla",
                            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sSearch": "Buscar:",
                            "sUrl": "",
                            "sInfoThousands": ",",
                            "sLoadingRecords": "Cargando...",
                            "sButtonText": "Imprimir",
                            "oPaginate": {
                                "sFirst": "Primero",
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "buttons": {
                                "print": "Imprimir",
                                "colvis": "Columnas mostradas"
                            }
                        }
                    });


                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function verUsuariosPCO2(identificador, id_pregunta, proyecto) {
//    alert(identificador+"-"+id_pregunta);
    $("#myModal2").modal("toggle");
    $("#table_clima_org_p2_p").dataTable().fnDestroy();
    $("#clima_org_p2_respuestas_usuario_p").html("");
    $.post("../controller/climaOrganizacionalController.php",
            {evento: 25, id_seccion: 3, id_pregunta: id_pregunta, identificador: identificador, id_proyecto: proyecto},
            function (response) {
                if (response.errorCode === 0) {
                    var info = '';
                    $.each(response.data, function (index, value) {
                        info += '<tr>';
                        info += '<td>' + value.id + '</td>';
                        info += '<td>' + value.pregunta + '</td>';
                        info += '<td>Valor: ' + value.valor + '</td>';
                        info += '<td>' + value.fecha_captura + '</td>';
                        info += '<td>' + value.nombre + '</td>';
                        info += '<td>' + value.apellidos + '</td>';
                        info += '<td>' + value.area + '</td>';
                        info += '<td>' + value.ubicacion + '</td>';
                        info += '</tr>';
                    });
                    console.log(info);
                    $("#clima_org_p2_respuestas_usuario_p").append(info);
                    $("#table_clima_org_p2_p").dataTable({
                        "dom": 'Bfrtip',
                        "buttons": [
                            'colvis', 'csv', 'excel', 'pdf', 'print'
//                            'excel', 'pdf', 'print'
                        ],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": true,
                        "bInfo": true,
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sProcessing": "Procesando...",
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sZeroRecords": "No se encontraron resultados",
                            "sEmptyTable": "Ningún dato disponible en esta tabla",
                            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sSearch": "Buscar:",
                            "sUrl": "",
                            "sInfoThousands": ",",
                            "sLoadingRecords": "Cargando...",
                            "sButtonText": "Imprimir",
                            "oPaginate": {
                                "sFirst": "Primero",
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "buttons": {
                                "print": "Imprimir",
                                "colvis": "Columnas mostradas"
                            }
                        }
                    });


                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}


function initializeDT(table) {
    console.log("Inicializó: " + table);
    $("#" + table + "").dataTable({
        "dom": 'Bfrtip',
        "buttons": [
            'colvis', 'csv', 'excel', 'pdf', 'print'
//                            'excel', 'pdf', 'print'
        ],
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": false,
        "bInfo": true,
        "bAutoWidth": false,
        "oLanguage": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "sButtonText": "Imprimir",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "buttons": {
                "print": "Imprimir",
                "colvis": "Columnas mostradas"
            }
        }
    });
}

function getInfoClimaOrganizacional() {
    $("#contestadasCOP1").text($("#s_1").text());
    $.post("../controller/climaOrganizacionalController.php",
            {evento: 11, id_seccion: 2},
            function (response) {
                if (response.errorCode === 0) {
                    console.log(response);
                    var periodo = '';
                    $("#completasCOP1").text(response.completas);
                    $("#incompletasCOP1").text(response.incompletas);
                    $("#duplicadasCOP1").text(response.duplicadas);

                    var reqCrtd = '';
                    $.each(response.data, function (index, value) {
                        reqCrtd += '<tr>'
                                + '<td>' + value.no_control + '</td>'
                                + '<td><a href="#" onClick="getResponsesCOP1(' + value.id_usuario + ')" class="sweet-figg-title"><b>' + value.nombre + '</b></a></td>'
                                + '<td>' + value.apellidos + '</td>'
                                + '<td>' + value.correo + '</td>'
                                + '<td>' + value.area + '</td>';
                        //Completos
                        if (parseInt(value.total) === 37) {
                            reqCrtd += '<td>1</td>';
                        } else {
                            reqCrtd += '<td>0</td>';
                        }
                        //Duplicados
                        if (parseInt(value.total) > 37) {
                            var duplicados = parseInt(value.total) / 37;
                            reqCrtd += '<td>' + duplicados.toFixed(2) + '</td>';
                        } else {
                            reqCrtd += '<td>0</td>';
                        }
                        //Incompletos
                        if (parseInt(value.total) < 37) {
                            reqCrtd += '<td>' + value.correo + '</td>';
                        } else {
                            reqCrtd += '<td>0</td>';
                        }
                        reqCrtd += '</tr>';
                        periodo = value.periodo;
                    });
                    $("#periodoAL").html(periodo);
                    $("#periodoCOP1").html($("#periodoAL").html());
                    $("#clima_org_p1_respuestas").append(reqCrtd);
                    $("#climar_org_p1").dataTable({
                        "dom": 'Bfrtip',
                        "buttons": [
                            'colvis', 'csv', 'excel', 'pdf', 'print'
//                            'excel', 'pdf', 'print'
                        ],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": true,
                        "bInfo": true,
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sProcessing": "Procesando...",
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sZeroRecords": "No se encontraron resultados",
                            "sEmptyTable": "Ningún dato disponible en esta tabla",
                            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sSearch": "Buscar:",
                            "sUrl": "",
                            "sInfoThousands": ",",
                            "sLoadingRecords": "Cargando...",
                            "sButtonText": "Imprimir",
                            "oPaginate": {
                                "sFirst": "Primero",
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "buttons": {
                                "print": "Imprimir",
                                "colvis": "Columnas mostradas"
                            }
                        }
                    });


                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getInfoClimaOrganizacional2() {

//    alert("getInfoClimaOrganizacional2");
    $.post("../controller/climaOrganizacionalController.php",
            {evento: 18, id_seccion: 3},
            function (response) {
                if (response.errorCode === 0) {
                    console.log(response);
                    var periodo = '';
                    $("#completasCOP2").text(response.completas);
                    $("#incompletasCOP2").text(response.incompletas);
                    $("#duplicadasCOP2").text(response.duplicadas);

                    var reqCrtd = '';
                    $.each(response.data, function (index, value) {
                        reqCrtd += '<tr>'
                                + '<td>' + value.no_control + '</td>'
                                + '<td><a href="#" onClick="getResponsesCOP2(' + value.id_usuario + ')" class="sweet-figg-title"><b>' + value.nombre + '</b></a></td>'
                                + '<td>' + value.apellidos + '</td>'
                                + '<td>' + value.correo + '</td>'
                                + '<td>' + value.area + '</td>';
                        //Completos
                        if (parseInt(value.total) === 5) {
                            reqCrtd += '<td>1</td>';
                        } else {
                            reqCrtd += '<td>0</td>';
                        }
                        //Duplicados
                        if (parseInt(value.total) > 5) {
                            var duplicados = parseInt(value.total) / 5;
                            reqCrtd += '<td>' + duplicados.toFixed(2) + '</td>';
                        } else {
                            reqCrtd += '<td>0</td>';
                        }
                        //Incompletos
                        if (parseInt(value.total) < 5) {
                            reqCrtd += '<td>' + value.correo + '</td>';
                        } else {
                            reqCrtd += '<td>0</td>';
                        }
                        reqCrtd += '</tr>';
                        periodo = value.periodo;
                    });
                    $("#periodoAL").html(periodo);
                    $("#contestadasCOP2").text(response.total / 5);
                    $("#periodoCOP2").html($("#periodoAL").html());
                    $("#clima_org_p2_respuestas").append(reqCrtd);
                    $("#climar_org_p2").dataTable({
                        "dom": 'Bfrtip',
                        "buttons": [
                            'colvis', 'csv', 'excel', 'pdf', 'print'
//                            'excel', 'pdf', 'print'
                        ],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": true,
                        "bInfo": true,
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sProcessing": "Procesando...",
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sZeroRecords": "No se encontraron resultados",
                            "sEmptyTable": "Ningún dato disponible en esta tabla",
                            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sSearch": "Buscar:",
                            "sUrl": "",
                            "sInfoThousands": ",",
                            "sLoadingRecords": "Cargando...",
                            "sButtonText": "Imprimir",
                            "oPaginate": {
                                "sFirst": "Primero",
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "buttons": {
                                "print": "Imprimir",
                                "colvis": "Columnas mostradas"
                            }
                        }
                    });


                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getUsrsWASCO() {
    $.post("../controller/climaOrganizacionalController.php",
            {evento: 12, id_seccion: 2},
            function (response) {
                if (response.errorCode === 0) {
                    $("#usrsWASCOP1").html('<a href="users_wasalcop1.php">' + response.numElems + '</a>');
                    console.log(response);
                    var reqCrtd = '';
                    $.each(response.data, function (index, value) {
                        reqCrtd += '<tr>'
                                + '<td>' + value.id_usuario + '</td>'
                                + '<td>' + value.nombre + '</td>'
                                + '<td>' + value.apellidos + '</td>'
                                + '<td>' + value.correo + '</td>'
                                + '<td>' + value.area + '</td>'
                                + '<td>' + value.proyecto + '</td>'
                                + '</tr>';
                    });
                    $("#clima_org_respuestas_was").append(reqCrtd);
                    $("#clima_org_was").dataTable({
                        "dom": 'Bfrtip',
                        "buttons": [
                            'colvis', 'csv', 'excel', 'pdf', 'print'
//                            'excel', 'pdf', 'print'
                        ],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": true,
                        "bInfo": true,
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sProcessing": "Procesando...",
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sZeroRecords": "No se encontraron resultados",
                            "sEmptyTable": "Ningún dato disponible en esta tabla",
                            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sSearch": "Buscar:",
                            "sUrl": "",
                            "sInfoThousands": ",",
                            "sLoadingRecords": "Cargando...",
                            "sButtonText": "Imprimir",
                            "oPaginate": {
                                "sFirst": "Primero",
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "buttons": {
                                "print": "Imprimir",
                                "colvis": "Columnas mostradas"
                            }
                        }
                    });
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function getUsrsWASCO2() {
    $.post("../controller/climaOrganizacionalController.php",
            {evento: 19, id_seccion: 3},
            function (response) {
                if (response.errorCode === 0) {
                    $("#usrsWASCOP2").html('<a href="users_wasalcop2.php">' + response.numElems + '</a>');
                    console.log(response);
                    var reqCrtd = '';
                    $.each(response.data, function (index, value) {
                        reqCrtd += '<tr>'
                                + '<td>' + value.id_usuario + '</td>'
                                + '<td>' + value.nombre + '</td>'
                                + '<td>' + value.apellidos + '</td>'
                                + '<td>' + value.correo + '</td>'
                                + '<td>' + value.area + '</td>'
                                + '<td>' + value.proyecto + '</td>'
                                + '</tr>';
                    });
                    $("#clima_org2_respuestas_was").append(reqCrtd);
                    $("#clima_org2_was").dataTable({
                        "dom": 'Bfrtip',
                        "buttons": [
                            'colvis', 'csv', 'excel', 'pdf', 'print'
//                            'excel', 'pdf', 'print'
                        ],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": true,
                        "bInfo": true,
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sProcessing": "Procesando...",
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sZeroRecords": "No se encontraron resultados",
                            "sEmptyTable": "Ningún dato disponible en esta tabla",
                            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sSearch": "Buscar:",
                            "sUrl": "",
                            "sInfoThousands": ",",
                            "sLoadingRecords": "Cargando...",
                            "sButtonText": "Imprimir",
                            "oPaginate": {
                                "sFirst": "Primero",
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "buttons": {
                                "print": "Imprimir",
                                "colvis": "Columnas mostradas"
                            }
                        }
                    });
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function verUsuariosCOP1(identificador, id_pregunta) {
//    alert(identificador+"-"+id_pregunta);
    $("#myModal").modal("toggle");
    $("#table_clima_org_p1").dataTable().fnDestroy();
    $("#clima_org_p1_respuestas_usuario").html("");
    $.post("../controller/climaOrganizacionalController.php",
            {evento: 13, id_seccion: 2, id_pregunta: id_pregunta, identificador: identificador},
            function (response) {
                if (response.errorCode === 0) {
                    var info = '';
                    $.each(response.data, function (index, value) {
                        info += '<tr>';
//                        info += '<td>' + value.id + '</td>';
                        info += '<td>' + value.pregunta + '</td>';
                        switch (value.respuesta) {
                            case 'A':
                                info += '<td>Totalmente de acuerdo</td>';
                                break;
                            case 'B':
                                info += '<td>De acuerdo</td>';
                                break;
                            case 'C':
                                info += '<td>Ni de acuerdo ni en desacuerdo</td>';
                                break;
                            case 'D':
                                info += '<td>En desacuerdo</td>';
                                break;
                            case 'E':
                                info += '<td>Totalmente en desacuerdo</td>';
                                break;

                            default:

                                break;
                        }
                        info += '<td>' + value.fecha_captura + '</td>';
                        info += '<td>' + value.nombre + '</td>';
                        info += '<td>' + value.apellidos + '</td>';
                        info += '<td>' + value.area + '</td>';
                        info += '<td>' + value.ubicacion + '</td>';
                    });
                    $("#clima_org_p1_respuestas_usuario").append(info);
                    $("#table_clima_org_p1").dataTable({
                        "dom": 'Bfrtip',
                        "buttons": [
                            'colvis', 'csv', 'excel', 'pdf', 'print'
//                            'excel', 'pdf', 'print'
                        ],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": true,
                        "bInfo": true,
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sProcessing": "Procesando...",
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sZeroRecords": "No se encontraron resultados",
                            "sEmptyTable": "Ningún dato disponible en esta tabla",
                            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sSearch": "Buscar:",
                            "sUrl": "",
                            "sInfoThousands": ",",
                            "sLoadingRecords": "Cargando...",
                            "sButtonText": "Imprimir",
                            "oPaginate": {
                                "sFirst": "Primero",
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "buttons": {
                                "print": "Imprimir",
                                "colvis": "Columnas mostradas"
                            }
                        }
                    });


                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function verUsuariosCOP2(id_pregunta, identificador) {
//    alert(identificador+"-"+id_pregunta);
    $("#myModal").modal("toggle");
    $("#table_clima_org_p2").dataTable().fnDestroy();
    $("#clima_org_p2_respuestas_usuario").html("");
    $.post("../controller/climaOrganizacionalController.php",
            {evento: 17, id_seccion: 3, id_pregunta: id_pregunta, identificador: identificador},
            function (response) {
                if (response.errorCode === 0) {
                    var info = '';
                    $.each(response.data, function (index, value) {
                        info += '<tr>';
//                        info += '<td>' + value.id + '</td>';
                        info += '<td>' + value.pregunta + '</td>';
                        info += '<td>Valor: ' + value.valor + '</td>';
                        info += '<td>' + value.fecha_captura + '</td>';
                        info += '<td>' + value.nombre + '</td>';
                        info += '<td>' + value.apellidos + '</td>';
                        info += '<td>' + value.area + '</td>';
                        info += '<td>' + value.ubicacion + '</td>';
                        info += '</tr>';
                    });
                    $("#clima_org_p2_respuestas_usuario").append(info);
                    $("#table_clima_org_p2").dataTable({
                        "dom": 'Bfrtip',
                        "buttons": [
                            'colvis', 'csv', 'excel', 'pdf', 'print'
//                            'excel', 'pdf', 'print'
                        ],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": true,
                        "bInfo": true,
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sProcessing": "Procesando...",
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sZeroRecords": "No se encontraron resultados",
                            "sEmptyTable": "Ningún dato disponible en esta tabla",
                            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sSearch": "Buscar:",
                            "sUrl": "",
                            "sInfoThousands": ",",
                            "sLoadingRecords": "Cargando...",
                            "sButtonText": "Imprimir",
                            "oPaginate": {
                                "sFirst": "Primero",
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "buttons": {
                                "print": "Imprimir",
                                "colvis": "Columnas mostradas"
                            }
                        }
                    });


                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function viewUsrsByProject(id_proyecto) {
//    alert(id_proyecto);
    $("#myModalAL").modal("toggle");
    $("#usrs_wapa").dataTable().fnDestroy();
    $("#usrs_answeres_wapa").html("");
    $.post("../controller/ambienteTrabajoController.php",
            {evento: 8, id_seccion: 1, identificador: 2, id_proyecto: id_proyecto},
            function (response) {
                if (response.errorCode === 0) {
                    var infoUsrWP = '';
                    $.each(response.data, function (index, value) {
                        infoUsrWP += '<tr>'
                                + '<td>' + value.id_usuario + '</td>'
                                + '<td>' + value.nombre + '</td>'
                                + '<td>' + value.apellidos + '</td>'
                                + '<td>' + value.correo + '</td>'
                                + '<td>' + value.area + '</td>'
                                + '<td>' + value.proyecto + '</td>'
                                + '</tr>';
                    });
                    $("#usrs_answeres_wapa").append(infoUsrWP);
                    $("#usrs_wapa").dataTable({
                        "dom": 'Bfrtip',
                        "buttons": [
                            'colvis', 'csv', 'excel', 'pdf', 'print'
//                            'excel', 'pdf', 'print'
                        ],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": true,
                        "bInfo": true,
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sProcessing": "Procesando...",
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sZeroRecords": "No se encontraron resultados",
                            "sEmptyTable": "Ningún dato disponible en esta tabla",
                            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sSearch": "Buscar:",
                            "sUrl": "",
                            "sInfoThousands": ",",
                            "sLoadingRecords": "Cargando...",
                            "sButtonText": "Imprimir",
                            "oPaginate": {
                                "sFirst": "Primero",
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "buttons": {
                                "print": "Imprimir",
                                "colvis": "Columnas mostradas"
                            }
                        }
                    });
                    //Seteamos info de usuarios sin responder en segunda tarjeta de ambiente laboral
                    $("#usrsWAS2").html($("#usrsWAS").html());
                    $("#periodoAL2").html($("#periodoAL").html());
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function viewUsrsByProjectCOP1(id_proyecto) {
//    alert("Yo"+id_proyecto);
    $("#myModalCOP1").modal("toggle");
    $("#usrs_wapaCOP1").dataTable().fnDestroy();
    $("#usrs_answeres_wapaCOP1").html("");
    $.post("../controller/climaOrganizacionalController.php",
            {evento: 16, id_seccion: 2, identificador: 2, id_proyecto: id_proyecto},
            function (response) {
                if (response.errorCode === 0) {
                    var infoUsrWP = '';
                    $.each(response.data, function (index, value) {
                        infoUsrWP += '<tr>'
                                + '<td>' + value.id_usuario + '</td>'
                                + '<td>' + value.nombre + '</td>'
                                + '<td>' + value.apellidos + '</td>'
                                + '<td>' + value.correo + '</td>'
                                + '<td>' + value.area + '</td>'
                                + '<td>' + value.proyecto + '</td>'
                                + '</tr>';
                    });
                    $("#usrs_answeres_wapaCOP1").append(infoUsrWP);
                    $("#usrs_wapaCOP1").dataTable({
                        "dom": 'Bfrtip',
                        "buttons": [
                            'colvis', 'csv', 'excel', 'pdf', 'print'
//                            'excel', 'pdf', 'print'
                        ],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": true,
                        "bInfo": true,
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sProcessing": "Procesando...",
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sZeroRecords": "No se encontraron resultados",
                            "sEmptyTable": "Ningún dato disponible en esta tabla",
                            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sSearch": "Buscar:",
                            "sUrl": "",
                            "sInfoThousands": ",",
                            "sLoadingRecords": "Cargando...",
                            "sButtonText": "Imprimir",
                            "oPaginate": {
                                "sFirst": "Primero",
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "buttons": {
                                "print": "Imprimir",
                                "colvis": "Columnas mostradas"
                            }
                        }
                    });
                    //Seteamos info de usuarios sin responder en segunda tarjeta de ambiente laboral
                    $("#usrsWAS2").html($("#usrsWAS").html());
                    $("#periodoAL2").html($("#periodoAL").html());
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function viewUsrsByProjectCOP2(id_proyecto) {
//    alert("Yo"+id_proyecto);
    $("#myModalCOP2").modal("toggle");
    $("#usrs_wapaCOP2").dataTable().fnDestroy();
    $("#usrs_answeres_wapaCOP2").html("");
    $.post("../controller/climaOrganizacionalController.php",
            {evento: 20, id_seccion: 3, identificador: 2, id_proyecto: id_proyecto},
            function (response) {
                if (response.errorCode === 0) {
                    var infoUsrWP = '';
                    $.each(response.data, function (index, value) {
                        infoUsrWP += '<tr>'
                                + '<td>' + value.id_usuario + '</td>'
                                + '<td>' + value.nombre + '</td>'
                                + '<td>' + value.apellidos + '</td>'
                                + '<td>' + value.correo + '</td>'
                                + '<td>' + value.area + '</td>'
                                + '<td>' + value.proyecto + '</td>'
                                + '</tr>';
                    });
                    $("#usrs_answeres_wapaCOP2").append(infoUsrWP);
                    $("#usrs_wapaCOP2").dataTable({
                        "dom": 'Bfrtip',
                        "buttons": [
                            'colvis', 'csv', 'excel', 'pdf', 'print'
//                            'excel', 'pdf', 'print'
                        ],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": true,
                        "bInfo": true,
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sProcessing": "Procesando...",
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sZeroRecords": "No se encontraron resultados",
                            "sEmptyTable": "Ningún dato disponible en esta tabla",
                            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sSearch": "Buscar:",
                            "sUrl": "",
                            "sInfoThousands": ",",
                            "sLoadingRecords": "Cargando...",
                            "sButtonText": "Imprimir",
                            "oPaginate": {
                                "sFirst": "Primero",
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "buttons": {
                                "print": "Imprimir",
                                "colvis": "Columnas mostradas"
                            }
                        }
                    });
                    //Seteamos info de usuarios sin responder en segunda tarjeta de ambiente laboral
//                    $("#usrsWAS2").html($("#usrsWAS").html());
//                    $("#periodoAL2").html($("#periodoAL").html());
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function obtenerProyectosClimaP1() {
    //    alert(id_proyecto);
    $("#myModalAL").modal("toggle");
    $("#usrs_wapa").dataTable().fnDestroy();
    $("#usrs_answeres_wapa").html("");
    $.post("../controller/climaOrganizacionalController.php",
            {evento: 8, id_seccion: 1, identificador: 2},
            function (response) {
                if (response.errorCode === 0) {
                    var infoUsrWP = '';
                    $.each(response.data, function (index, value) {
                        infoUsrWP += '<tr>'
                                + '<td>' + value.id_usuario + '</td>'
                                + '<td>' + value.nombre + '</td>'
                                + '<td>' + value.apellidos + '</td>'
                                + '<td>' + value.correo + '</td>'
                                + '<td>' + value.area + '</td>'
                                + '<td>' + value.proyecto + '</td>'
                                + '</tr>';
                    });
                    $("#usrs_answeres_wapa").append(infoUsrWP);
                    $("#usrs_wapa").dataTable({
                        "dom": 'Bfrtip',
                        "buttons": [
                            'colvis', 'csv', 'excel', 'pdf', 'print'
//                            'excel', 'pdf', 'print'
                        ],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": true,
                        "bInfo": true,
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sProcessing": "Procesando...",
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sZeroRecords": "No se encontraron resultados",
                            "sEmptyTable": "Ningún dato disponible en esta tabla",
                            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sSearch": "Buscar:",
                            "sUrl": "",
                            "sInfoThousands": ",",
                            "sLoadingRecords": "Cargando...",
                            "sButtonText": "Imprimir",
                            "oPaginate": {
                                "sFirst": "Primero",
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "buttons": {
                                "print": "Imprimir",
                                "colvis": "Columnas mostradas"
                            }
                        }
                    });
                    //Seteamos info de usuarios sin responder en segunda tarjeta de ambiente laboral
                    $("#usrsWAS2").html($("#usrsWAS").html());
                    $("#periodoAL2").html($("#periodoAL").html());
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

/* *********************************************** SUGERENCIAS ******************************************************** */

function getInfoSugerencias(id_seccion, identificador) {
    $.post("../controller/climaOrganizacionalController.php",
            {evento: 14, id_seccion: id_seccion, identificador: identificador},
            function (response) {
                if (response.errorCode === 0) {
                    $("#contestadasCOPS").html(response.numElems);
                    console.log(response);
                    var reqCrtd = '';
                    $.each(response.data, function (index, value) {
                        reqCrtd += '<tr>'
                                + '<td>' + value.no_control + '</td>'
                                + '<td><a href="#' + value.no_control + '" onClick="verSugerenciaParam(1, ' + value.id_usuario + ')" class="sweet-figg-title">' + value.nombre + '</a></td>'
                                + '<td>' + value.apellidos + '</td>'
                                + '<td>' + value.correo + '</td>'
                                + '<td>' + value.sugerencia + '</td>'
                                + '<td><a href="#' + value.no_control + '" onClick="verSugerenciaParam(2, ' + value.id_area + ')" class="sweet-figg-title">' + value.area + '</a></td>'
                                + '<td><a href="#' + value.no_control + '" onClick="verSugerenciaParam(3, ' + value.id_proyecto + ')" class="sweet-figg-title">' + value.proyecto + '</a></td>'
                                + '<td>' + value.departamento + '</td>'
                                + '<td>' + value.puesto + '</td>';
                        if (parseInt(value.sexo) === 0) {
                            reqCrtd += '<td><a href="#' + value.no_control + '" onClick="verSugerenciaParam(4, ' + value.sexo + ')" class="sweet-figg-title">Femenino</a></td>';
                        } else {
                            reqCrtd += '<td><a href="#' + value.no_control + '" onClick="verSugerenciaParam(4, ' + value.sexo + ')" class="sweet-figg-title">Masculino</a></td>';
                        }
                        reqCrtd += '</tr>';
                    });
                    $("#clima_sugerencias_respuestas").append(reqCrtd);
                    $("#table_clima_sugerencias").dataTable({
                        "dom": 'Bfrtip',
                        "buttons": [
                            'colvis', 'csv', 'excel', 'pdf', 'print'
//                            'excel', 'pdf', 'print'
                        ],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": true,
                        "bInfo": true,
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sProcessing": "Procesando...",
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sZeroRecords": "No se encontraron resultados",
                            "sEmptyTable": "Ningún dato disponible en esta tabla",
                            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sSearch": "Buscar:",
                            "sUrl": "",
                            "sInfoThousands": ",",
                            "sLoadingRecords": "Cargando...",
                            "sButtonText": "Imprimir",
                            "oPaginate": {
                                "sFirst": "Primero",
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "buttons": {
                                "print": "Imprimir",
                                "colvis": "Columnas mostradas"
                            }
                        }
                    });
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function verSugerenciaParam(identificador, valor) {
    $("#myModal").modal("toggle");
    $("#table_sugerencias").dataTable().fnDestroy();
    $("#sugerencias_respuestas").html("");
    $.post("../controller/climaOrganizacionalController.php",
            {evento: 14, id_seccion: 4, identificador: identificador, valor: valor},
            function (response) {
                if (response.errorCode === 0) {
                    console.log(response);
                    var reqCrtd = '';
                    $.each(response.data, function (index, value) {
                        reqCrtd += '<tr>'
                                + '<td>' + value.no_control + '</td>'
                                + '<td>' + value.nombre + '</td>'
                                + '<td>' + value.apellidos + '</td>'
                                + '<td>' + value.correo + '</td>'
                                + '<td>' + value.sugerencia + '</td>'
                                + '<td>' + value.area + '</td>'
                                + '<td>' + value.proyecto + '</td>'
                                + '<td>' + value.departamento + '</td>'
                                + '<td>' + value.puesto + '</td>';
                        if (parseInt(value.sexo) === 0) {
                            reqCrtd += '<td>Femenino</td>';
                        } else {
                            reqCrtd += '<td>Masculino</td>';
                        }
                        reqCrtd += '</tr>';
                    });
                    $("#sugerencias_respuestas").append(reqCrtd);
                    $("#table_sugerencias").dataTable({
                        "dom": 'Bfrtip',
                        "buttons": [
                            'colvis', 'csv', 'excel', 'pdf', 'print'
//                            'excel', 'pdf', 'print'
                        ],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": true,
                        "bInfo": true,
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sProcessing": "Procesando...",
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sZeroRecords": "No se encontraron resultados",
                            "sEmptyTable": "Ningún dato disponible en esta tabla",
                            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sSearch": "Buscar:",
                            "sUrl": "",
                            "sInfoThousands": ",",
                            "sLoadingRecords": "Cargando...",
                            "sButtonText": "Imprimir",
                            "oPaginate": {
                                "sFirst": "Primero",
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "buttons": {
                                "print": "Imprimir",
                                "colvis": "Columnas mostradas"
                            }
                        }
                    });
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');

}

/* *********************************************** ANEXO ******************************************************** */

function getInfoAnexo(id_seccion, identificador) {
    $.post("../controller/climaOrganizacionalController.php",
            {evento: 15, id_seccion: id_seccion, identificador: identificador},
            function (response) {
                if (response.errorCode === 0) {
                    $("#contestadasCOPA").html(parseInt(response.numElems) / 10);
                    console.log(response);
                    var reqCrtd = '';
                    $.each(response.data, function (index, value) {
                        reqCrtd += '<tr>'
                                + '<td><a href="#' + value.no_control + '" onClick="vergetInfoAnexoParam(1, ' + value.id_pregunta + ')" class="sweet-figg-title">' + value.pregunta + '</a></td>'
                                + '<td>' + value.respuesta + '</td>'
                                + '<td><a href="#' + value.no_control + '" onClick="vergetInfoAnexoParam(2, ' + value.id_usuario + ')" class="sweet-figg-title">' + value.nombre + '</a></td>'
                                + '<td>' + value.apellidos + '</td>'
                                + '<td><a href="#' + value.no_control + '" onClick="vergetInfoAnexoParam(3, ' + value.id_area + ')" class="sweet-figg-title">' + value.area + '</a></td>'
                                + '<td><a href="#' + value.no_control + '" onClick="vergetInfoAnexoParam(4, ' + value.id_proyecto + ')" class="sweet-figg-title">' + value.proyecto + '</a></td>'
                                + '</tr>';
                    });
                    $("#clima_anexo_respuestas").append(reqCrtd);
                    $("#table_clima_anexo").dataTable({
                        "dom": 'Bfrtip',
                        "buttons": [
                            'colvis', 'csv', 'excel', 'pdf', 'print'
//                            'excel', 'pdf', 'print'
                        ],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": true,
                        "bInfo": true,
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sProcessing": "Procesando...",
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sZeroRecords": "No se encontraron resultados",
                            "sEmptyTable": "Ningún dato disponible en esta tabla",
                            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sSearch": "Buscar:",
                            "sUrl": "",
                            "sInfoThousands": ",",
                            "sLoadingRecords": "Cargando...",
                            "sButtonText": "Imprimir",
                            "oPaginate": {
                                "sFirst": "Primero",
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "buttons": {
                                "print": "Imprimir",
                                "colvis": "Columnas mostradas"
                            }
                        }
                    });
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}

function vergetInfoAnexoParam(identificador, valor) {
    $("#myModal").modal("toggle");
    $("#table_anexos").dataTable().fnDestroy();
    $("#anexo_respuestas").html("");
    $.post("../controller/climaOrganizacionalController.php",
            {evento: 15, id_seccion: 5, identificador: identificador, valor: valor},
            function (response) {
                if (response.errorCode === 0) {
                    console.log(response);
                    var reqCrtd = '';
                    $.each(response.data, function (index, value) {
                        reqCrtd += '<tr>'
                                + '<td>' + value.pregunta + '</td>'
                                + '<td>' + value.respuesta + '</td>'
                                + '<td>' + value.nombre + '</td>'
                                + '<td>' + value.apellidos + '</td>'
                                + '<td>' + value.area + '</td>'
                                + '<td>' + value.proyecto + '</td>'
                                + '</tr>';
                    });
                    $("#anexo_respuestas").append(reqCrtd);
                    $("#table_anexos").dataTable({
                        "dom": 'Bfrtip',
                        "buttons": [
                            'colvis', 'csv', 'excel', 'pdf', 'print'
//                            'excel', 'pdf', 'print'
                        ],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": true,
                        "bInfo": true,
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sProcessing": "Procesando...",
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sZeroRecords": "No se encontraron resultados",
                            "sEmptyTable": "Ningún dato disponible en esta tabla",
                            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sSearch": "Buscar:",
                            "sUrl": "",
                            "sInfoThousands": ",",
                            "sLoadingRecords": "Cargando...",
                            "sButtonText": "Imprimir",
                            "oPaginate": {
                                "sFirst": "Primero",
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "buttons": {
                                "print": "Imprimir",
                                "colvis": "Columnas mostradas"
                            }
                        }
                    });
                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');

}

function getAllInfoCO1() {
    $.post("../controller/climaOrganizacionalController.php",
            {evento: 21, id_seccion: 2},
            function (response) {
                if (response.errorCode === 0) {
                    var info = '';
                    $.each(response.data, function (index, value) {
                        info += '<tr>';
//                        info += '<td>' + value.id + '</td>';
                        info += '<td>' + value.pregunta + '</td>';

                        switch (value.respuesta) {
                            case 'A':
                                info += '<td>Totalmente de acuerdo</td>';
                                break;
                            case 'B':
                                info += '<td>De acuerdo</td>';
                                break;
                            case 'C':
                                info += '<td>Ni de acuerdo ni en desacuerdo</td>';
                                break;
                            case 'D':
                                info += '<td>En desacuerdo</td>';
                                break;
                            case 'E':
                                info += '<td>Totalmente en desacuerdo</td>';
                                break;

                            default:

                                break;
                        }
                        info += '<td>' + value.fecha_captura + '</td>';
                        info += '<td>' + value.nombre + '</td>';
                        info += '<td>' + value.apellidos + '</td>';
                        info += '<td>' + value.area + '</td>';
                        info += '<td>' + value.ubicacion + '</td>';
                    });
                    $("#all_responses_co1").append(info);
                    $("#table_all_responses_co1").dataTable({
                        "dom": 'Bfrtip',
                        "buttons": [
                            'colvis', 'csv', 'excel', 'pdf', 'print'
//                            'excel', 'pdf', 'print'
                        ],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": true,
                        "bInfo": true,
                        "bAutoWidth": false,
                        "oLanguage": {
                            "sProcessing": "Procesando...",
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sZeroRecords": "No se encontraron resultados",
                            "sEmptyTable": "Ningún dato disponible en esta tabla",
                            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix": "",
                            "sSearch": "Buscar:",
                            "sUrl": "",
                            "sInfoThousands": ",",
                            "sLoadingRecords": "Cargando...",
                            "sButtonText": "Imprimir",
                            "oPaginate": {
                                "sFirst": "Primero",
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "buttons": {
                                "print": "Imprimir",
                                "colvis": "Columnas mostradas"
                            }
                        }
                    });

                } else {
                    showAlert("¡Error!", response.msg, "error", "swing");
                }
            }, 'json');
}