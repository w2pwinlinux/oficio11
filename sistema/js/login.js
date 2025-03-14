// JavaScript Document
var gmostrar_div_pedi = 1;
$(document).ready(function() {
    
        $("#menu").show();
        //$("#principal").height("550");
        $("#Aceptar").click(function() {
            f_inicio();
        });
        $("#clave").keypress(function(event) {
            var code = (event.keyCode ? event.keyCode : event.which);
            if (code == 13 || code == "13") {
                f_inicio();
            }
        });
        cancelar();
        //novedad();
        //informativo_pedi();
        //div_pedi_click();
        //
    
});

//OBTENCIO DE TOTAL
function f_inicio() {
    //cargando(1);
    opcion = eb64e(0);
    datos = {
        "opcion": opcion
    };
    datos.usuario = b64e($("#usuario").val());
    datos.clave = b64e($("#clave").val());
    $("#clave,#usuario").val('');
    $.post("jquery/login.php", datos, function(data) {
        if (data.fila_afectada == 1) {
            //cargando(2);
            g_cancelar("home.php");
        } else {
            //cargando(2);
            //mensajes(db64d(data.mensaje));
            //$.messager.alert("","ERROR EN DATOS O USUARIO INACTIVO");
            ms("Error", "ERROR EN DATOS O USUARIO INACTIVO");
            $("#usuario,#clave").val("");
            $("#usuario").focus();
        }
    }, "json");
}

function cancelar() {
    $("#Cancelar").click(function() {
        $("#usuario,#clave").val("");
        $("#usuario").focus();
    });
}

