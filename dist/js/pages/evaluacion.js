$(document).ready(function () {
    $("#formato1").submit(function (event) {
        event.preventDefault();
        $("#msg").html('<h2>Enviando evaluaci&oacute;n...</h2>');
        $.post("../controller/evaluacionController.php",
                $("#formato1").serializeArray(),
                function (response) {
                    if (response.errorCode === 0) {
                        showAlert(response.msg, "Evaluaci&oacute;n registrada exitosamente", "success", "bounce");
                        setTimeout(function () {
                            window.location.href = 'evaluacion_desempeno.php';
                        }, 2000);

                    } else {
                        showAlert("¡Error!", response.msg, "error", "swing");
                        $("#msg").html('');
                    }
                }, 'json');
    });

    $("#formato2").submit(function (event) {
        event.preventDefault();
        $("#msg").html('<h2>Enviando evaluaci&oacute;n...</h2>');
        $.post("../controller/evaluacionController.php",
                $("#formato2").serializeArray(),
                function (response) {
                    if (response.errorCode === 0) {
                        showAlert(response.msg, "Evaluaci&oacute;n registrada exitosamente", "success", "bounce");
                        setTimeout(function () {
                            window.location.href = 'evaluacion_desempeno.php';

                        }, 2000);

                    } else {
                        showAlert("¡Error!", response.msg, "error", "swing");
                        $("#msg").html('');
                    }
                }, 'json');
    });

    $("#formato3").submit(function (event) {
        event.preventDefault();
        $("#msg").html('<h2>Enviando evaluaci&oacute;n...</h2>');
        $.post("../controller/evaluacionController.php",
                $("#formato3").serializeArray(),
                function (response) {
                    if (response.errorCode === 0) {
                        showAlert(response.msg, "Evaluaci&oacute;n registrada exitosamente", "success", "bounce");
                        setTimeout(function () {
                            window.location.href = 'evaluacion_desempeno.php';

                        }, 2000);
                    } else {
                        showAlert("¡Error!", response.msg, "error", "swing");
                        $("#msg").html('');
                    }
                }, 'json');
    });

    $("#formato4").submit(function (event) {
        event.preventDefault();
        $("#msg").html('<h2>Enviando evaluaci&oacute;n...</h2>');
        $.post("../controller/evaluacionController.php",
                $("#formato4").serializeArray(),
                function (response) {
                    if (response.errorCode === 0) {
                        showAlert(response.msg, "Evaluaci&oacute;n registrada exitosamente", "success", "bounce");
                        setTimeout(function () {
                            window.location.href = 'evaluacion_desempeno.php';

                        }, 2000);
                    } else {
                        showAlert("¡Error!", response.msg, "error", "swing");
                        $("#msg").html('');
                    }
                }, 'json');
    });
});

function evaluacionUsr(id_usuario, clave_encuesta) {
    window.location.href = 'formato' + clave_encuesta + '.php?id_usuario=' + id_usuario;
}


function operacionesF1() {
    console.log("OperacionesF1");
    var resultados = $('input:radio[name=resultados_periodo]:checked').val();
    var conocimientos = $('input:radio[name=conocimiento_funciones]:checked').val();
    var experiencia = $('input:radio[name=experiencia_evaluado]:checked').val();
    var competencias = 0;

    $.each($('input[name="competenciasf1[]"]'), function (index, value) {
        competencias += parseInt(value.value);
    });
    console.log(competencias);

    $("#resultados_obtenidos").val(resultados);
    $("#conocimientos_obtenidos").val(conocimientos);
    $("#experiencia_obtenida").val(experiencia);
    $("#competencias_obtenidas").val(competencias);

    var total_obtenido = parseFloat(resultados) + parseFloat(conocimientos) + parseFloat(experiencia) + parseFloat(competencias);
    $("#total_obtenido").val(total_obtenido);
    var resultado_final = total_obtenido / 2;
    $("#resultado_final").val(resultado_final);

}

function operacionesF2() {
    console.log("OperacionesF2");
    var resultados = $('input:radio[name=resultados_periodo]:checked').val();
    var conocimientos = $('input:radio[name=conocimiento_funciones]:checked').val();
    var manejo_personal = $('input:radio[name=manejo_personal]:checked').val();
    var coordinacioni = 0;
    var coordinacionii = 0;

    $.each($('input[name="coordinacioni[]"]'), function (index, value) {
        coordinacioni += parseInt(value.value);
    });
    console.log(coordinacioni);
    $.each($('input[name="coordinacionid[]"]'), function (index, value) {
        coordinacionii += parseInt(value.value);
    });
    console.log(coordinacionii);

    $("#resultados_obtenidos").val(resultados);
    $("#conocimientos_obtenidos").val(conocimientos);
    $("#manejo_personal_total").val(manejo_personal);
    $("#coordinacion_departamental").val(coordinacioni);
    $("#coordinacion_interdepartamental").val(coordinacionii);

    var total_obtenido = parseFloat(resultados) + parseFloat(conocimientos) + parseFloat(manejo_personal) + parseFloat(coordinacioni) + parseFloat(coordinacionii);
    $("#total_obtenido").val(total_obtenido);
    var resultado_final = total_obtenido;
    $("#resultado_final").val(resultado_final);

}

function operacionesF3() {
    console.log("OperacionesF3");
    var resultados = $('input:radio[name=resultados_periodo]:checked').val();
    var conocimientos = $('input:radio[name=conocimiento_funciones]:checked').val();
    var habilidades_evaluado = $('input:radio[name=habilidades_evaluado]:checked').val();
    var actitudes_evaluado = $('input:radio[name=actitudes_evaluado]:checked').val();
    var conducta_laboral_1 = $('input:radio[name=conducta_laboral_1]:checked').val();
    var conducta_laboral_2 = $('input:radio[name=conducta_laboral_2]:checked').val();
    var conducta_laboral_3 = $('input:radio[name=conducta_laboral_3]:checked').val();
    var conducta_laboral_4 = $('input:radio[name=conducta_laboral_4]:checked').val();
    var conducta_laboral_5 = $('input:radio[name=conducta_laboral_5]:checked').val();
    var conducta_laboral_6 = $('input:radio[name=conducta_laboral_6]:checked').val();
    var conducta_laboral_7 = $('input:radio[name=conducta_laboral_7]:checked').val();
    var conducta_laboral_8 = $('input:radio[name=conducta_laboral_8]:checked').val();

    var conducta_total = (parseInt(conducta_laboral_1) + parseInt(conducta_laboral_2) + parseInt(conducta_laboral_3) + parseInt(conducta_laboral_4) + parseInt(conducta_laboral_5) + parseInt(conducta_laboral_6) + parseInt(conducta_laboral_7) + parseInt(conducta_laboral_8)) / 2;


    $("#resultados_obtenidos").val(resultados);
    $("#conocimientos_obtenidos").val(conocimientos);
    $("#habilidad_obtenida").val(habilidades_evaluado);
    $("#actitudes_obtenidas").val(actitudes_evaluado);
    $("#conducta_obtenida").val(conducta_total);

    var total_obtenido = parseFloat(resultados) + parseFloat(conocimientos) + parseFloat(habilidades_evaluado) + parseFloat(actitudes_evaluado) + parseFloat(conducta_total);
    $("#total_obtenido").val(total_obtenido);
    var resultado_final = total_obtenido;
    $("#resultado_final").val(resultado_final);

}

function operacionesF4() {
    console.log("OperacionesF4");
    var resultados = $('input:radio[name=resultados]:checked').val();
    var destreza_1 = $('input:radio[name=destreza_1]:checked').val();
    var destreza_2 = $('input:radio[name=destreza_2]:checked').val();
    var destreza_3 = $('input:radio[name=destreza_3]:checked').val();

    var conducta_1 = $('input:radio[name=conducta_1]:checked').val();
    var conducta_2 = $('input:radio[name=conducta_2]:checked').val();
    var conducta_3 = $('input:radio[name=conducta_3]:checked').val();
    var conducta_4 = $('input:radio[name=conducta_4]:checked').val();
    var conducta_5 = $('input:radio[name=conducta_5]:checked').val();
    var conducta_6 = $('input:radio[name=conducta_6]:checked').val();

    var destreza_total = parseInt(destreza_1) + parseInt(destreza_2) + parseInt(destreza_3);
    var conducta_total = (parseInt(conducta_1) + parseInt(conducta_2) + parseInt(conducta_3) + parseInt(conducta_4) + parseInt(conducta_5) + parseInt(conducta_6));


    $("#resultados_obtenidos").val(resultados);
    $("#destreza_obtenida").val(destreza_total);
    $("#conducta_laboral_obtenida").val(conducta_total);

    var total_obtenido = parseFloat(resultados) + parseFloat(destreza_total) + parseFloat(conducta_total);
    $("#total_obtenido").val(total_obtenido);
    var resultado_final = total_obtenido;
    $("#resultado_final").val(resultado_final);

}