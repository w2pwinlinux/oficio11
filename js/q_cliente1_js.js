/**
 * Archivo: pac_ejecucion_certificacion.js
 * Descripción: Este archivo gestiona las interacciones del usuario y las operaciones AJAX para la ejecución y certificación de datos.
 *
 * Secuencia de pasos y llamadas AJAX:
 * 1. Inicialización:
 *    - Se configura el DataGrid para PASO1 y PASO2 con sus respectivas URLs.
 *    - Se ocultan los elementos visuales innecesarios al cargar la página.
 *    - Se inicializan los cuadros de diálogo (se cierran por defecto).
 *
 * 
 * 2. Llamadas AJAX (por secciones):
 *    - **PASO1:**
 *        buscar_id_certificacion(0);
 *        
 *      - URL: $.post("jquery/q_cliente1_jquery.php", {opcion: 22,estado: estado}}}
 *        - Opción 22: Obtener datos iniciales de certificacion verifica si existe una pendiente (mostrar datos en <p class="datos_paso1_certificacion"></p>)
 *        - caso contrario un ma con no hay datos pendientes 
 *        
 *
 * Autor: [wrcp]
 * Fecha: [04012025]
 */
// Variable global para almacenar el resultado de buscar el ID
var result_buscar_id;
$('document').ready(function() {
    // Oculta el título del reporte al cargar la página
    $("#div_titulo_reporte").hide();
    // Muestra el título del reporte al hacer clic en el botón "view_report_export"
    $("#view_report_export").click(function() {
        $("#div_titulo_reporte").show();
    });
    // Oculta el título del reporte al hacer clic en el botón "hide_report_export"
    $("#hide_report_export").click(function() {
        $("#div_titulo_reporte").hide();
    });
    // Configura el DataGrid para la tabla PASO1
    $('#dg_PASO1').datagrid({
        url: 'jquery/q_cliente1_jquery.php?opcion=99', // URL para obtener los datos iniciales
    });
    // Abre el menú principal con la opción predeterminada
    menu_open(0);
    // Cierra varios cuadros de diálogo al cargar la página
    $("#dlg_paso1_motivo").dialog("close");
    $("#dlg_paso1").dialog("open");
    $("#dlg_paso2").dialog("close");
    $("#dlg_paso0_cabecera_presupuesto").dialog("close");
    // Llama a la función para buscar el ID de certificación con un ID inicial de 0
    //buscar_id_certificacion(0, 1);
});

function autocarga_objetivo_estrategico() {
    // ADD WILSON 1
    $("#ID_OBJETIVO_ESTRATEGICO").combobox({
        url: "jquery/q_cliente1_jquery.php?opcion=11&all_rows=1",
        valueField: "ID",
        textField: "NOMBRE",
        onSelect: function(rec) {
            //mandar a cargar el sig combo
            console.log(rec);
        },
    });
}

function clic_buscar() {
    $("#dg_PASO1").datagrid("reload", {
        FILTRO: $("#form1").serialize(),
        dinamico: 1,
        //estado_global_estado: $("#filtro_global_estado").combobox("getValue"),
        //tipo_solicitud: $("#filtro_tipo_solicitud").combobox("getValue")
    });
}

function fAddFiltro() {
    var cadena = '';
    cadena += "Criterio :";
    cadena += "<select name='CRITERIO[]' id='CRITERIO[]' class='CRITERIO'>";
    cadena += '<option value="NOMBRE">Nombre</option>';
    cadena += "</select>"
    cadena += 'Dato : <input name="DATO[]" type="text" class="DATO" id="DATO[]" size="25" maxlength="50" placeholder="Dato"/>';
    $("#hfiltro").after(cadena);
}

function q_open_dialog_edit() {
    var row = $("#dg_PASO1").datagrid("getSelected");
    if (row) {
        $("#dlg_paso0_cabecera_presupuesto").dialog("open");
        $("#dlg_paso0_cabecera_presupuesto_form").form("load", row);
        url = "jquery/q_cliente1_jquery.php?opcion=3&id=" + row.ID;
        $(".div_clave").hide();
    } else {
        ms("Info", "DEBE SELECCIONAR UN REGISTRO")
    }
}

function save_PAC_REVISION() {
    $("#form_PAC_REVISION").form("submit", {
        url: url,
        onSubmit: function() {
            return $(this).form("validate");
        },
        success: function(result) {
            var result = eval('(' + result + ')');
            if (result.fila_afectada >= 0) {
                $("#dlg_PAC_REVISION").dialog("close")
                $("#dg_PASO1").datagrid("reload");
                ms("Info", result.mensaje)
            } else {
                ms("Info", result.mensaje)
            }
        }
    });
}

function open_dialog_PAC_REVISION_new() {
    $("#dlg_PAC_REVISION").dialog("open");
    $("#form_PAC_REVISION").form("clear");
    // es para la url a cual mandar los datos a actualizar
    url = "jquery/q_cliente1_jquery.php?opcion=1&ID_PERIODO=" + $("#ID_PERIODO").val();
}

function dg_delete_row_PAC_REVISION() {
    var row = $("#dg_PASO1").datagrid("getSelected");
    if (row) {
        $.messager.confirm("Confirmar", "Está seguro de eliminar este registro?", function(r) {
            if (r) {
                $.post("jquery/q_cliente1_jquery.php", {
                    ID: row.ID,
                    opcion: 4,
                    ID_PERIODO: $("#ID_PERIODO").val()
                }, function(result) {
                    ms("Info", result.mensaje);
                    if (result.fila_afectada > 0) {
                        $("#dg_PASO1").datagrid("reload");
                    }
                }, "json");
            }
        });
    } else {
        ms("Info", "DEBE SELECCIONAR UN REGISTRO");
    }
}

function registrar_pagos_1() {
    /*var row = $("#dg_UTAEP_ORDEN_MASIVA").datagrid("getSelected");
              if (row) {*/
    gorden_masiva_id = $("#dlg_UTAEP_ORDEN_MASIVA_DATAGRID_FP #P_ID_MASIVO").textbox("getValue");
    // VER EL NUEVO DIALOG
    $("#dlg_orden_masiva_forma_pago").dialog("open");
    $("#form_dlg_orden_masiva_forma_pago").form("clear");
    // es para la url a cual mandar los datos a actualizar
    url_fp = "jquery/utaep_orden_masiva_fp.php?opcion=1&id_anexo=1&id_orden_masiva=" + gorden_masiva_id;
    // indexar_pagos_parciales_paper(gorden_masiva_id);
    $("#div_paperfpagos").hide();
    consultar_valor_pago(gorden_masiva_id);
    var inscriptores = $("#dlg_UTAEP_ORDEN_MASIVA_DATAGRID_FP #INSCRIPTORES").textbox("getValue");
    $("#form_dlg_orden_masiva_forma_pago #INSCRIPTORES").textbox("setValue", inscriptores);
    $("#form_dlg_orden_masiva_forma_pago #P_ID_MASIVO").textbox("setValue", gorden_masiva_id);
    $("#form_dlg_orden_masiva_forma_pago #dlg_ID_ORDEN").val(gorden_masiva_id);
    //$(".grabar,.grabar_fp").hide();
    /* } else {
                  ms("Info", "DEBE SELECCIONAR UN REGISTRO")
              }*/
}

function save_dlg_orden_masiva_forma_pago() {
    $("#form_dlg_orden_masiva_forma_pago").form("submit", {
        url: url_fp,
        onSubmit: function() {
            return $(this).form("validate");
        },
        success: function(result) {
            var result = eval('(' + result + ')');
            if (result.fila_afectada > 0) {
                $("#dlg_orden_masiva_forma_pago").dialog("close");
                $('#dg_forma_pago').datagrid("reload");
                $("#dg_UTAEP_ORDEN_MASIVA").datagrid("reload");
                //$("#dg_UTAEP_ORDEN").datagrid("reload");
                procesar_pago_alert();
                ms("Info", result.mensaje)
            } else {
                ms("Info", result.mensaje)
            }
        }
    });
}

function menu_open(estado) {
    if (estado == 1) {
        $(".opciones").show();
        $(".abrir_menu").hide();
        //$(".cerrar_menu").show();    
    } else {
        $(".opciones").hide();
        $(".cerrar_menu").show();
        $(".abrir_menu").show();
        //$(".cerrar_menu").hide();    
    }
}

function aprobar_individual() {
    // Obtener todas las filas seleccionadas
    var rows = $('.dg_PASO1').datagrid('getSelections');
    // Crear un array para almacenar los IDs
    var ids = [];
    // Recorrer cada fila seleccionada para extraer el ID
    for (var i = 0; i < rows.length; i++) {
        ids.push(rows[i].ID);
    }
    //console.log(ids);
    // Retorna o imprime los IDs seleccionados
    if (i > 0) {
        $.messager.confirm("Confirmar", "Está seguro de aprobar los registros seleccionados ?", function(r) {
            if (r) {
                datos = {
                    "opcion": 5
                };
                datos.estado = 'APROBADO';
                datos.rows = ids;
                $.post("jquery/q_cliente1_jquery.php", datos, function(result) {
                    ms("Info", result.mensaje);
                    if (result.fila_afectada > 0) {
                        $(".dg_PASO1").datagrid("reload");
                    }
                }, "json");
            }
        });
    } else {
        ms("Error", "DEBE SELECCIONAR UN REGISTRO");
    }
}

function reverso_individual() {
    // Obtener todas las filas seleccionadas
    var rows = $('.dg_PASO1').datagrid('getSelections');
    // Crear un array para almacenar los IDs
    var ids = [];
    // Recorrer cada fila seleccionada para extraer el ID
    for (var i = 0; i < rows.length; i++) {
        ids.push(rows[i].ID);
    }
    // Retorna o imprime los IDs seleccionados
    if (i > 0) {
        $.messager.confirm("Confirmar", "Está seguro de REVERSAR A PENDIENTE  los registros seleccionados ?", function(r) {
            if (r) {
                datos = {
                    "opcion": 5
                };
                datos.estado = 'PENDIENTE';
                datos.rows = ids;
                $.post("jquery/q_cliente1_jquery.php", datos, function(result) {
                    ms("Info", result.mensaje);
                    if (result.fila_afectada > 0) {
                        $(".dg_PASO1").datagrid("reload");
                    }
                }, "json");
            }
        });
    } else {
        ms("Error", "DEBE SELECCIONAR UN REGISTRO");
    }
}

function aprobar_por_filtro() {
    // Obtener todas las filas seleccionadas
    if (true) {
        $.messager.confirm("Confirmar", "Está seguro de aprobar los registros seleccionados ?", function(r) {
            if (r) {
                datos = {
                    "opcion": 6
                };
                datos.estado = 'APROBADO';
                datos.FILTRO = $("#form1").serialize();
                $.post("jquery/q_cliente1_jquery.php", datos, function(result) {
                    ms("Info", result.mensaje);
                    if (result.fila_afectada > 0) {
                        $(".dg_PASO1").datagrid("reload");
                    }
                }, "json");
            }
        });
    } else {
        ms("Error", "DEBE SELECCIONAR UN REGISTRO");
    }
}

function open_noaprobar_individual() {
    $("#datos-modal0").dialog("open");
    $("#observacion").val("");
}

function noaprobado_individual() {
    var rows = $('.dg_PASO1').datagrid('getSelections');
    // Crear un array para almacenar los IDs
    var ids = [];
    // Recorrer cada fila seleccionada para extraer el ID
    for (var i = 0; i < rows.length; i++) {
        ids.push(rows[i].ID);
    }
    // Retorna o imprime los IDs seleccionados
    if (i > 0) {
        $.ajax({
            url: 'jquery/q_cliente1_jquery.php?opcion=7&rows=' + ids, // Script para generar y enviar el token
            method: 'POST',
            data: {
                correouta: $('#correouta').val(),
                observacion: $("#observacion").val(),
                estado: "RECHAZADO"
            },
            success: function(tokenResponse) {
                //$.messager.progress('close');
                try {
                    //console.log(tokenResponse);
                    var tokenJson = JSON.parse(tokenResponse);
                    if (tokenJson.fila_afectada > 0) {
                        ms("OK", 'Procesado correctamente: ' + tokenJson.mensaje);
                        // mandar a cerrar el dialog 
                        $("#datos-modal0").dialog("close");
                        //    $("#verifica_token").val(tokenJson.VERIFICADO_TOKEN);
                        //    $("#correouta_notificado").val($("#correouta").val());
                        //    setTimeout(validar_actualizacion_datos(), 2000);
                    } else {
                        ma("Infom", 'Error : ' + tokenJson.mensaje);
                    }
                } catch (e) {
                    ma("Error", 'Ocurrió un error inesperado al enviar, vuelva a intentar');
                }
            },
            error: function() {
                $.messager.progress('close');
                ma("Info", 'No se pudo enviar los datos. Inténtelo más tarde.');
            }
        });
    } else {
        ma("Error", "Debe seleccionar un registro");
    }
}

function detalleFormatterbasico(value, row, index) {
    return `<span class="help-icon" data-id="${row.ID}" onmouseover="showTooltip(event, '${row.ID}', '${row.DATO_DEPENDENCIA}', '${row.DATO_FINANCIERO}')" onmouseout="hideTooltip()">❓</span>`;
}

function estados_certificacion(value, row, index) {
    console.log(value);
    if (value == 'FINALIZADO') {
        return `<span class="help-search">PENDIENTE APROBACION PLANIFICACON</span>`;
    }
}

function detalleFormatter_bien(value, row, index) {
    //return `
    //    <span><strong>Detalle Financiero:</strong> ${row.DATO_FINANCIERO_MIN}</span>
    //    <span class="help-icon" data-id="${row.ID}" 
    //          onmouseover="showTooltip(event, '${row.ID}', '${row.DATO_DEPENDENCIA}', '${row.DATO_FINANCIERO}')"
    //          onmouseout="hideTooltip()"> ℹ️ mas... </span>
    //`;
    return `
        <span><strong></strong> ${row.DATO_FINANCIERO_MIN}</span>
      
    `;
}

function showTooltip(event, id, dependencia, detalleFinanciero) {
    var tooltipContent = `
                <p><strong>Detalle Financiero:</strong> ${detalleFinanciero}</p>
            `;
    $('#tooltip').html(tooltipContent).css({
        display: 'block',
        top: event.pageY + 10,
        left: event.pageX + 10,
        opacity: 1
    });
    //console.log(detalleFinanciero);
}
// Función para ocultar el tooltip
function hideTooltip() {
    $('#tooltip').css({
        display: 'none',
        opacity: 0
    });
}

function buscar_id_certificacion(estado, tipo) {
    $.post("jquery/q_cliente1_jquery.php", {
        opcion: 22,
        estado: estado
    }, function(result) {
        result_buscar_id = result;
        if (result.fila_afectada > 0) {
            $("#ID_CERTIFICACION").val(result.id_certificacion);
            $("#ID_ESTADO_INTERNO").val(result.estado_interno);
        }
        if (result.estado_interno == 0) {
            pasos(0);
        }
        if (result.estado_interno == 1) {
            if (tipo == 'nuevo') {
                $("#id_paso0").val(result_buscar_id[0]["ID"]);
                $("#fecha_paso0").val(result_buscar_id[0]["FECHA"]);
                $("#id_usuario_paso0").val(result_buscar_id[0]["ID_USUARIO"]);
                $("#motivo_paso0").val(result_buscar_id[0]["MOTIVO"]);
            } else { // caso q se recupere datos
                pasos(1);
            }
        }
        if (result.estado_interno == 2) {
            pasos(2);
        }
    }, "json");
}

function pasos(estado) {
    /**
     *paso0 = inicial 
     *paso1 = PARA SOLICITAR CABECERA
     *pso2 =  
     *para verificar detalles / se mandar a cargar los datos 
     
     * */
    console.log("datos result");
    console.log(result_buscar_id);
    // console.log(result_buscar_id[0]["SW"]);
    if (estado == 0) {
        //console.log("datos result0");
        // $("#dlg_paso1_motivo").dialog("close");
        //$("#dlg_paso2").dialog("close");
        $("#dlg_paso1").dialog("open"); // ver esto 
        $("#dlg_paso0_cabecera").dialog("close");
        ms("Info", "No existe certificacion en estado registrado, puede iniciar una nueva solicitud");
        //if(idc > 0 ){// cundo ya existe la certificacion 
        //$("#dlg_paso1").dialog("open"); // ver esto 
        //$("#dlg_paso0_cabecera").dialog("close");
        //} else {// cuando recien es creado la certificacion
        //    $("#dlg_paso1").dialog("close"); // ver esto 
        //    $("#dlg_paso0_cabecera").dialog("open");
        //}
    }
    if (estado == 99) {
        $("#dlg_paso1_motivo").dialog("close");
        $("#dlg_paso2").dialog("close");
        // let idc = parseInt($("#ID_CERTIFICACION").val());
        // let idc = parseInt($("#ID_CERTIFICACION").val());
        let idc = parseInt(result_buscar_id[0]["SW"]);
        //console.log(idc);
        $("#id_paso0").val(result_buscar_id[0]["ID"]);
        $("#fecha_paso0").val(result_buscar_id[0]["FECHA"]);
        $("#id_usuario_paso0").val(result_buscar_id[0]["ID_USUARIO"]);
        $("#motivo_paso0").val(result_buscar_id[0]["MOTIVO"]);
        $("#dlg_paso1").dialog("close"); // ver esto 
        $("#dlg_paso0_cabecera").dialog("open");
        //if(idc > 0 ){// cundo ya existe la certificacion 
        //$("#dlg_paso1").dialog("open"); // ver esto 
        //$("#dlg_paso0_cabecera").dialog("close");
        //} else {// cuando recien es creado la certificacion
        //    $("#dlg_paso1").dialog("close"); // ver esto 
        //    $("#dlg_paso0_cabecera").dialog("open");
        //}
    }
    if (estado == 1) { // cuando existe datos 
        $("#dlg_paso1").dialog("open"); // ver esto 
        $("#dlg_paso0_cabecera").dialog("close");
        $("#dlg_paso1_motivo").dialog("close");
        $("#dlg_paso2").dialog("close");
        $(".datos_paso1_certificacion").html(result_buscar_id[0]["DATOS"]); // add datos al head de datagrid
    }
    if (estado == 2) {
        //console.log("paso2");
        $("#dlg_paso1_motivo").dialog("close");
        $("#dlg_paso1").dialog("close");
        $("#dlg_paso2").dialog("open");
        var datos = {
            "opcion": 24,
            "id_certificacion": $("#ID_CERTIFICACION").val(),
        };
        $.post("jquery/q_cliente1_jquery.php", datos, function(result) {
            //console.log(result);
            if (result.fila_afectada > 0) {
                $("#paso2_motivo").val(result.motivo);
            } else {}
        }, "json");
    }
    if (estado == 11) {
        $("#dlg_paso1_motivo").dialog("close");
        $("#dlg_paso1").dialog("open");
        $("#dlg_paso2").dialog("close");
    }
}

function open_dlg_cabecera() {
    $("#dlg_paso0_cabecera").dialog("open");
    $("#dlg_paso1").dialog("close");
    buscar_id_certificacion(1, 'nuevo');
}

function paso1(estado) {
    //add el estdo interno del inpuc 
    var id_certificacion = parseInt($("#ID_CERTIFICACION").val());
    var estado_interno = parseInt($("#ID_ESTADO_INTERNO").val());
    if (estado == 0) {
        $("#dlg_paso0_cabecera").dialog("open");
        $("#dlg_paso1").dialog("close");
        buscar_id_certificacion(1, 'nuevo');
    }
    if (estado == 1) {
        if (id_certificacion > 0) {
            // Obtener todas las filas seleccionadas
            var rows = $('.dg_PASO1').datagrid('getSelections');
            // Crear un array para almacenar los IDs
            var ids = [];
            // Recorrer cada fila seleccionada para extraer el ID
            for (var i = 0; i < rows.length; i++) {
                ids.push(rows[i].ID);
            }
            //console.log(ids);
            // Verificar si hay registros seleccionados
            if (rows.length > 0) {
                $.messager.confirm("Confirmar", "Está seguro de agregar los registros seleccionados?", function(r) {
                    if (r) {
                        var datos = {
                            "opcion": 21,
                            "estado": 'BORRADOR',
                            "rows": ids,
                            "tipo": $("#filtro_tipo_solicitud").combobox("getValue")
                        };
                        $.post("jquery/q_cliente1_jquery.php", datos, function(result) {
                            ms("Info", result.mensaje);
                            if (result.fila_afectada > 0) {
                                $(".dg_PASO1").datagrid("reload");
                            }
                            $("#ID_CERTIFICACION").val(result.id_certificacion);
                            $("#ID_ESTADO_INTERNO").val(result.id_estado_interno);
                        }, "json");
                    }
                });
                var confirmBox = $(".messager-window");
                if (confirmBox.length) {
                    confirmBox.css({
                        "top": "10px", // Posición desde la parte superior
                        "left": "50%", // Centrado horizontalmente
                        "transform": "translateX(-50%)" // Centrado exacto
                    });
                }
            } else {
                ms("Error", "DEBE SELECCIONAR UN REGISTRO");
            }
        } else {
            ma("Error", "Debe Crear la cabecera ");
        }
    }
    if (estado == 2) {
        // aqui el estado interno 
        if (estado_interno == 1) {
            $("#dlg_paso1").dialog("close");
            $("#dlg_paso1_motivo").dialog("open");
        }
        if (estado_interno == 2) {
            $("#dlg_paso1").dialog("close");
            $("#dlg_paso2").dialog("open");
        }
    }
    if (estado == -1) {
        $("#dlg_paso1").dialog("open");
        $('#dlg_paso1_motivo').dialog('close')
    }
}

function paso1_grabar_motivo() {
    var id_certificacion = parseInt($("#ID_CERTIFICACION").val());
    var estado_interno = parseInt($("#ID_ESTADO_INTERNO").val());
    if (estado_interno == 1) {
        //console.log("paso1");
        if (id_certificacion > 0) {
            $.ajax({
                url: 'jquery/q_cliente1_jquery.php?opcion=23&id_certificacion=' + id_certificacion, // Script para generar y enviar el token
                method: 'POST',
                data: {
                    motivo: $("#motivo_paso0").val()
                },
                success: function(Response) {
                    //$.messager.progress('close');
                    try {
                        var Response = JSON.parse(Response);
                        //console.log(Response);
                        //console.log(Response.fila_afectada);
                        if (parseInt(Response.fila_afectada) > 0) {
                            ms("OK", 'Procesado correctamente: ' + Response.mensaje);
                            $("#dlg_paso0_cabecera").dialog("close");
                            pasos(11);
                            buscar_id_certificacion(1, 0);
                        } else {
                            ma("Info...", 'Error : ' + Response.mensaje);
                        }
                    } catch (e) {
                        ma("Error", 'Ocurrió un error inesperado al enviar, vuelva a intentar');
                    }
                },
                error: function() {
                    $.messager.progress('close');
                    ma("Info", 'No se pudo enviar los datos. Inténtelo más tarde.');
                }
            });
        } else {
            ma("Error", "OPCION NO PERMITIDA, debe existir un numero de certificación");
        }
    }
    if (estado_interno == 2) {
        console.log("paso2")
        $("#dlg_paso1_motivo").dialog("close");
        $("#dlg_paso1").dialog("close");
        $("#dlg_paso2").dialog("open");
    }
}

function anular_certificacion() {
    var datos = {
        "opcion": 51,
        "id_certificacion": $("#ID_CERTIFICACION").val(),
    };
    $.post("jquery/q_cliente1_jquery.php", datos, function(result) {
        if (result.fila_afectada > 0) {
            $("#dg_PASO1").datagrid("reload");
            $(".datos_paso1_certificacion").html(" SIN SOLICITUD CABECERA  / Agregar para iniciar");
            ms("Info", "Solicitud anulada, debe vovler a crear la cabecera para anexar bienes/servicios");
            $("#ID_CERTIFICACION").val(-1);
            $("#ID_ESTADO_INTERNO").val(0); // aqui fin anular 
        } else {}
    }, "json");
}
/**
 * { item_description } para provesos masivos 
 */
function Masivo_Tipo(tipo) {
    if (tipo == 'sb') {
        // Obtener todas las filas seleccionadas
        var rows = $('.dg_PASO1').datagrid('getSelections');
        // Crear un array para almacenar los IDs
        var ids = [];
        // Recorrer cada fila seleccionada para extraer el ID
        for (var i = 0; i < rows.length; i++) {
            ids.push(rows[i].ID);
        }
        //console.log(ids);
        // Verificar si hay registros seleccionados
        if (rows.length > 0) {
            $.messager.confirm("Confirmar", "Está seguro de agregar los registros seleccionados para procesos bloqueados?", function(r) {
                if (r) {
                    var datos = {
                        "opcion": 101,
                        "estado": tipo,
                        "rows": ids,
                        "tipo": $("#filtro_tipo_solicitud").combobox("getValue"),
                        "masivo_tipo": tipo
                    };
                    $.post("jquery/q_cliente1_jquery.php", datos, function(result) {
                        ms("Info", result.mensaje);
                        console.log(result);
                        if (result.fila_afectada > 0) {
                            $(".dg_PASO1").datagrid("reload");
                        }
                        //$("#ID_CERTIFICACION").val(result.id_certificacion);
                        //$("#ID_ESTADO_INTERNO").val(result.id_estado_interno);
                    }, "json");
                }
            });
            var confirmBox = $(".messager-window");
            if (confirmBox.length) {
                confirmBox.css({
                    "top": "10px", // Posición desde la parte superior
                    "left": "50%", // Centrado horizontalmente
                    "transform": "translateX(-50%)" // Centrado exacto
                });
            }
        } else {
            ms("Error", "DEBE SELECCIONAR UN REGISTRO");
        }
    }
}

function firma_operador() {
    var row = $("#dg_PASO1").datagrid("getSelected");
    if (row) {
        // VER COMO CONTROLOAR Q NO SE VUELVA FIRMAR Y PASE DE ESTADO 
        //console.log(row.RUTA_FIRMADO.length);
        if ((row.RUTA_FIRMADO.length < 20) && (row.ESTADO = "FINALIZADO")) {
            let etapa = 'certi_final_operador';
            //let ruta_firma1 = 'imprimir_solicitud_certificacion_paso1_firma.php?dd=' + $("#ID_CERTIFICACION").val() + '&etapa=' + etapa;
            var url = "imprimir_solicitud_certificacion_paso1_firma.php?dd=" + row.ID + '&etapa=' + etapa;
            // Abrir la ventana hija
            var ventana = window.open(url, // URL a abrir
                "Firma", // Nombre de la ventana
                "width=600,height=400,resizable=yes,scrollbars=yes" // Configuración de la ventana
            );
            if (ventana) {
                // Monitorear el cierre de la ventana hija
                var monitor = setInterval(function() {
                    if (ventana.closed) {
                        clearInterval(monitor); // Detener el monitoreo
                        console.log("La ventana se ha cerrado.");
                        // Llamar un evento o función al cerrarse
                        //ventanaCerrada();
                        validar_firmado_estado("operador");
                    }
                }, 500); // Revisa cada 500 ms
            } else {
                console.error("No se pudo abrir la ventana.");
            }
        } else {
            ma("Info", "Proceso ya ejecutado");
        }
    } else {
        // Mostrar mensaje si no hay selección
        ms("Info", "DEBE SELECCIONAR UN REGISTRO");
    }
    // Definir la función que se ejecuta al cerrar la ventana
    function ventanaCerrada() {
        alert("La ventana hija se ha cerrado. Ahora puedes continuar.");
        // Aquí puedes agregar cualquier otra lógica necesaria
    }
}

function firma_aprobador() {
    var row = $("#dg_PASO1").datagrid("getSelected");
    if (row) {
        // VER COMO CONTROLOAR Q NO SE VUELVA FIRMAR Y PASE DE ESTADO 
        //console.log(row.RUTA_FIRMADO.length);
        if ((row.RUTA_FIRMADO.length > 20) && (row.RUTA_FIRMADO_APROBADOR.length < 20)) {
            let etapa = 'certi_final_aprobador';
            //let ruta_firma1 = 'imprimir_solicitud_certificacion_paso1_firma.php?dd=' + $("#ID_CERTIFICACION").val() + '&etapa=' + etapa;
            var url = "imprimir_solicitud_certificacion_paso1_firma.php?dd=" + row.ID + '&etapa=' + etapa;
            // Abrir la ventana hija
            var ventana = window.open(url, // URL a abrir
                "Firma", // Nombre de la ventana
                "width=600,height=400,resizable=yes,scrollbars=yes" // Configuración de la ventana
            );
            if (ventana) {
                // Monitorear el cierre de la ventana hija
                var monitor = setInterval(function() {
                    if (ventana.closed) {
                        clearInterval(monitor); // Detener el monitoreo
                        console.log("La ventana se ha cerrado.");
                        // Llamar un evento o función al cerrarse
                        //ventanaCerrada();
                        validar_firmado_estado("aprobador");
                    }
                }, 500); // Revisa cada 500 ms
            } else {
                console.error("No se pudo abrir la ventana.");
            }
        } else {
            ma("Info", "Proceso ya ejecutado por aprobador");
        }
    } else {
        // Mostrar mensaje si no hay selección
        ms("Info", "DEBE SELECCIONAR UN REGISTRO");
    }
    // Definir la función que se ejecuta al cerrar la ventana
    function ventanaCerrada() {
        alert("La ventana hija se ha cerrado. Ahora puedes continuar.");
        // Aquí puedes agregar cualquier otra lógica necesaria
    }
}

function firma_planificacion() {
    var row = $("#dg_PASO1").datagrid("getSelected");
    if (row) {
        // VER COMO CONTROLOAR Q NO SE VUELVA FIRMAR Y PASE DE ESTADO 
        //console.log(row.RUTA_FIRMADO.length);
        console.log(row.RUTA_FIRMADO_APROBADOR.length);
        console.log(row.RUTA_FIRMADO_PLANIFICACION.length);
        if ((row.RUTA_FIRMADO_APROBADOR.length > 20) && (row.RUTA_FIRMADO_PLANIFICACION.length < 20)) {
            let etapa = 'certi_final_planificacion';
            //let ruta_firma1 = 'imprimir_solicitud_certificacion_paso1_firma.php?dd=' + $("#ID_CERTIFICACION").val() + '&etapa=' + etapa;
            var url = "imprimir_solicitud_certificacion_paso1_firma.php?dd=" + row.ID + '&etapa=' + etapa;
            // Abrir la ventana hija
            var ventana = window.open(url, // URL a abrir
                "Firma", // Nombre de la ventana
                "width=600,height=400,resizable=yes,scrollbars=yes" // Configuración de la ventana
            );
            if (ventana) {
                // Monitorear el cierre de la ventana hija
                var monitor = setInterval(function() {
                    if (ventana.closed) {
                        clearInterval(monitor); // Detener el monitoreo
                        console.log("La ventana se ha cerrado.");
                        // Llamar un evento o función al cerrarse
                        //ventanaCerrada();
                        validar_firmado_estado("planificacion");
                        //validar_firmado_planificacion2();
                    }
                }, 500); // Revisa cada 500 ms
            } else {
                console.error("No se pudo abrir la ventana.");
            }
        } else {
            ma("Info", "Proceso ya ejecutado por aprobador");
        }
    } else {
        // Mostrar mensaje si no hay selección
        ms("Info", "DEBE SELECCIONAR UN REGISTRO");
    }
    // Definir la función que se ejecuta al cerrar la ventana
    function ventanaCerrada() {
        alert("La ventana hija se ha cerrado. Ahora puedes continuar.");
        // Aquí puedes agregar cualquier otra lógica necesaria
    }
}

function validar_firmado_estado(estado) {
    var row = $("#dg_PASO1").datagrid("getSelected");
    if (row) {
        var url = "imprimir_solicitud_certificacion_paso1_firma.php?dd=" + row.ID;
        // Abrir la ventana hija (descomentar estas líneas)
        $.post("jquery/pac_ejecucion_certificacion_estado.php", {
            ID: row.ID,
            opcion: 51,
            estado: estado
        }, function(result) {
            ms("Info", result.mensaje);
            if (result.fila_afectada > 0) {
                $("#dg_PASO1").datagrid("reload");
            }
        }, "json");
    } else {
        // Mostrar mensaje si no hay selección
        ms("Info", "DEBE SELECCIONAR UN REGISTRO");
    }
}

function validar_firmado_planificacion() {
    var row = $("#dg_PASO1").datagrid("getSelected");
    if (row) {
        var url = "imprimir_solicitud_certificacion_paso1_firma.php?dd=" + row.ID;
        // Abrir la ventana hija (descomentar estas líneas)
        $.post("jquery/pac_ejecucion_certificacion_estado.php", {
            ID: row.ID,
            opcion: 51,
        }, function(result) {
            ms("Info", result.mensaje);
            if (result.fila_afectada > 0) {
                $("#dg_PASO1").datagrid("reload");
            }
        }, "json");
    } else {
        // Mostrar mensaje si no hay selección
        ms("Info", "DEBE SELECCIONAR UN REGISTRO");
    }
}

function validar_firmado_planificacion2() {
    var row = $("#dg_PASO1").datagrid("getSelected");
    if (row) {
        if ((row.ESTADO_INTERNO == 5) && (row.RUTA_FIRMADO_PLANIFICACION.length > 20)) {
            var url = "imprimir_solicitud_certificacion_paso1_firma.php?dd=" + row.ID;
            // Abrir la ventana hija (descomentar estas líneas)
            $.post("jquery/pac_ejecucion_certificacion_estado.php", {
                ID: row.ID,
                opcion: 52,
            }, function(result) {
                ms("Info", result.mensaje);
                if (result.fila_afectada > 0) {
                    $("#dg_PASO1").datagrid("reload");
                }
            }, "json");
        } else {
            ms("Info", "Certificación ya APROBADA");
        }
    } else {
        // Mostrar mensaje si no hay selección
        ms("Info", "DEBE SELECCIONAR UN REGISTRO");
    }
}

function generar_reporte_compras(estado) {
    var row = $("#dg_PASO1").datagrid("getSelected");
    if (row) {
        // VER COMO CONTROLOAR Q NO SE VUELVA FIRMAR Y PASE DE ESTADO 
        //console.log(row.NUMERO_CERTIFICACION_PAC);
        if (estado == 0) { /** mandar a generar la cabecera*/
            if (row.NUMERO_CERTIFICACION_PAC == 0 && row.ESTADO == "APROBADO_PLANIFICACION") {
                let etapa = 'certi_compras_crear';
                $.post("jquery/pac_ejecucion_certificacion_estado.php", {
                    ID: row.ID,
                    opcion: 101,
                    etapa: etapa
                }, function(result) {
                    ma("Info", "Numero de certificación :" + result.iid);
                    //if (result.fila_afectada > 0) {
                    $("#dg_PASO1").datagrid("reload");
                    //}
                }, "json");
            } else {
                ma("Info", "Verfique el estado de la certificación");
            }
        }
        if (estado == 1) { // para generar 
            if (row.RUTA_GENERADO_COMPRAS.length < 20) {
                let etapa = 'certi_compras_generar';
                //let ruta_firma1 = 'imprimir_solicitud_certificacion_paso1_firma.php?dd=' + $("#ID_CERTIFICACION").val() + '&etapa=' + etapa;
                var url = "imprimir_solicitud_certificacion_paso1_compras.php?id_certificacion=" + row.ID + '&etapa=' + etapa;
                // Abrir la ventana hija
                var ventana = window.open(url, // URL a abrir
                    "Firma", // Nombre de la ventana
                    "width=600,height=400,resizable=yes,scrollbars=yes" // Configuración de la ventana
                );
                if (ventana) {
                    // Monitorear el cierre de la ventana hija
                    var monitor = setInterval(function() {
                        if (ventana.closed) {
                            clearInterval(monitor); // Detener el monitoreo
                            console.log("La ventana se ha cerrado.");
                            // Llamar un evento o función al cerrarse
                            //ventanaCerrada();
                            //validar_firmado_estado("CERTI_COMPRAS_CREAR_GENERADO");
                            //funcion para actualizar el estado al final NO AQUI TYA SE HACE EN LA GENERACION 1 DEL PDF 
                            $("#dg_PASO1").datagrid("reload");
                            //
                        }
                    }, 500); // Revisa cada 500 ms
                } else {
                    console.error("No se pudo abrir la ventana.");
                }
            } else {
                ma("Info", "Proceso ya ejecutado");
            }
        }
        if (estado == 2) { // para generar 
            console.log(row.RUTA_GENERADO_COMPRAS);
            console.log(row.RUTA_FIRMADO_COMPRAS);
            if ((row.RUTA_GENERADO_COMPRAS.length > 20) && (row.RUTA_FIRMADO_COMPRAS.length < 20)) {
                let etapa = 'certi_compras_firmado';
                //let ruta_firma1 = 'imprimir_solicitud_certificacion_paso1_firma.php?dd=' + $("#ID_CERTIFICACION").val() + '&etapa=' + etapa;
                var url = "imprimir_solicitud_certificacion_paso1_firma_compras.php?dd=" + row.ID + '&etapa=' + etapa;
                // Abrir la ventana hija
                var ventana = window.open(url, // URL a abrir
                    "Firma", // Nombre de la ventana
                    "width=600,height=400,resizable=yes,scrollbars=yes" // Configuración de la ventana
                );
                if (ventana) {
                    // Monitorear el cierre de la ventana hija
                    var monitor = setInterval(function() {
                        if (ventana.closed) {
                            clearInterval(monitor); // Detener el monitoreo
                            console.log("La ventana se ha cerrado.");
                            // Llamar un evento o función al cerrarse
                            //ventanaCerrada();
                            validar_firmado_estado(etapa);
                        }
                    }, 500); // Revisa cada 500 ms
                } else {
                    console.error("No se pudo abrir la ventana.");
                }
            } else {
                ma("Info", "Proceso ya ejecutado");
            }
        }
        // caos 2 
    } else {
        // Mostrar mensaje si no hay selección
        ms("Info", "DEBE SELECCIONAR UN REGISTRO");
    }
    // Definir la función que se ejecuta al cerrar la ventana
    function ventanaCerrada() {
        alert("La ventana hija se ha cerrado. Ahora puedes continuar.");
        // Aquí puedes agregar cualquier otra lógica necesaria
    }
}

function generar_reporte_comprasNNNN(estado) {
    var row = $("#dg_PASO1").datagrid("getSelected");
    if (row) {
        if (estado == 0) { /** mandar a generar la cabecera*/ }
        // VER COMO CONTROLOAR Q NO SE VUELVA FIRMAR Y PASE DE ESTADO 
        if (estado == 1) { // para generar 
            if (row.RUTA_GENERADO_COMPRAS.length < 20) {
                let etapa = 'certi_compras_operador';
                //let ruta_firma1 = 'imprimir_solicitud_certificacion_paso1_firma.php?dd=' + $("#ID_CERTIFICACION").val() + '&etapa=' + etapa;
                var url = "imprimir_solicitud_certificacion_paso1_compras.php?dd=" + row.ID + '&etapa=' + etapa;
                // Abrir la ventana hija
                var ventana = window.open(url, // URL a abrir
                    "Firma", // Nombre de la ventana
                    "width=600,height=400,resizable=yes,scrollbars=yes" // Configuración de la ventana
                );
                if (ventana) {
                    // Monitorear el cierre de la ventana hija
                    var monitor = setInterval(function() {
                        if (ventana.closed) {
                            clearInterval(monitor); // Detener el monitoreo
                            console.log("La ventana se ha cerrado.");
                            // Llamar un evento o función al cerrarse
                            //ventanaCerrada();
                            validar_firmado_estado("operador");
                        }
                    }, 500); // Revisa cada 500 ms
                } else {
                    console.error("No se pudo abrir la ventana.");
                }
            } else {
                ma("Info", "Proceso ya ejecutado");
            }
        }
    } else {
        // Mostrar mensaje si no hay selección
        ms("Info", "DEBE SELECCIONAR UN REGISTRO");
    }
    // Definir la función que se ejecuta al cerrar la ventana
    function ventanaCerrada() {
        alert("La ventana hija se ha cerrado. Ahora puedes continuar.");
        // Aquí puedes agregar cualquier otra lógica necesaria
    }
}

function reversar_estado(estado_actual, estado_nuevo) {
    let sw = 0;
    let cadena = "";
    // Obtener todas las filas seleccionadas
    var row = $("#dg_PASO1").datagrid("getSelected");
    if (row) {
        if (estado_actual == 2) {
            if (row.ESTADO_INTERNO != 2) {
                cadena = "NO SE PUEDE REVERDAR NO CUMPLE EL REQUERIMIENTO : DEBE ESTAR EN ESTADO FINALIZADO";
            } else {
                sw = 1;
            }
        }
        if (estado_actual == 3) {
            if (row.ESTADO_INTERNO != 3) {
                cadena = "NO SE PUEDE REVERDAR NO CUMPLE EL REQUERIMIENTO : DEBE ESTAR EN ESTADO FIRMADO_OPERADOR";
            } else {
                sw = 1;
            }
        }
        if (estado_actual == 4) {
            if (row.ESTADO_INTERNO != 4) {
                cadena = "NO SE PUEDE REVERDAR NO CUMPLE EL REQUERIMIENTO : DEBE ESTAR EN ESTADO FIRMADO APROBADOR";
            } else {
                sw = 1;
            }
        }
        if (estado_actual == 5) {
            if (row.ESTADO_INTERNO != 5) {
                cadena = "NO SE PUEDE REVERDAR NO CUMPLE EL REQUERIMIENTO : DEBE ESTAR EN ESTADO FIRMADO PLANIFICACION";
            } else {
                sw = 1;
            }
        }
        if (estado_actual == 6) {
            if (row.ESTADO_INTERNO != 6) {
                cadena = "NO SE PUEDE REVERDAR NO CUMPLE EL REQUERIMIENTO : DEBE ESTAR EN ESTADO APROBADO PLANIFICACION";
            } else {
                sw = 1;
            }
        }
        if (estado_actual == 7) {
            if (row.ESTADO_INTERNO != 7) {
                cadena = "NO SE PUEDE REVERDAR NO CUMPLE EL REQUERIMIENTO : DEBE ESTAR EN ESTADO CERTI_COMPRAS_CREAR";
            } else {
                sw = 1;
            }
        }
        if (estado_actual == 8) {
            if (row.ESTADO_INTERNO != 8) {
                cadena = "NO SE PUEDE REVERDAR NO CUMPLE EL REQUERIMIENTO : DEBE ESTAR EN ESTADO CERTIFICADO_COMPRAS_GENERADO";
            } else {
                sw = 1;
            }
        }
        if (estado_actual == 9) {
            if (row.ESTADO_INTERNO != 9) {
                cadena = "NO SE PUEDE REVERDAR NO CUMPLE EL REQUERIMIENTO : DEBE ESTAR EN ESTADO CERTI_COMPRAS_FIRMADO";
            } else {
                sw = 1;
            }
        }
        if (sw == 1) {
            // Retorna o imprime los IDs seleccionados
            $.messager.confirm("Confirmar", "Está seguro de REVERSAR el registros seleccionados ?", function(r) {
                if (r) {
                    datos = {
                        "opcion": 102
                    };
                    datos.estado_actual = estado_actual;
                    datos.estado_nuevo = estado_nuevo;
                    datos.estado = row.ESTADO;
                    datos.estado_interno = row.ESTADO_INTERNO;
                    datos.ID = row.ID;
                    $.post("jquery/pac_ejecucion_certificacion_estado.php", datos, function(result) {
                        ms("Info", result.mensaje);
                        if (result.fila_afectada > 0) {
                            $(".dg_PASO1").datagrid("reload");
                        }
                    }, "json");
                }
            });
        } else {
            ms("Info", cadena);
        }
    } else {
        ms("Info", "Debe seleccionar un registro");
    }
}

function q_open_nuevo() {
    $("#dlg_paso0_cabecera_presupuesto").dialog("open");
    $("#dlg_paso0_cabecera_presupuesto_form").form("clear");
    url = "jquery/q_cliente1_jquery.php?opcion=1";
    $("#CORREO").val("wrcp20@gmail.com");
    $("#TELEFONO").val("000000000");
    
}

function q_grabar_nuevo() {
    $("#dlg_paso0_cabecera_presupuesto_form").form("submit", {
        url: url,
        onSubmit: function() {
            // Obtener el valor del campo observación
            /**
            var observacion = $("#observacion_paso0").val().trim();
            console.log(observacion);
            if (observacion.length < 20) {
                ms("Error", "El campo de observación no puede estar vacío o menor a 20 caracteres");
                return false; // Detiene el envío del formulario
            }
            */
            return $(this).form("validate"); // Continua con la validación normal
        },
        success: function(result) {
            console.log(result);
            var result = eval('(' + result + ')');
            if (result.fila_afectada >= 0) {
                $("#dlg_paso0_cabecera_presupuesto").dialog("close")
                $("#dg_PASO1").datagrid("reload");
                ms("Info", result.mensaje);
            } else {
                ms("Info", result.mensaje)
            }
        }
    });
}

function q_edit_estado(estado) {
    var row = $("#dg_PASO1").datagrid("getSelected");
    if (row) {

        url_estado = "jquery/q_cliente1_jquery.php?opcion=11&ID=" + row.ID+"&ESTADO="+estado;
        $.post(url_estado, {param1: 'value1'}, function(data, textStatus, xhr) {

            $("#dg_PASO1").datagrid("reload");
            ms("Info", result.mensaje);

        },'json');

        
    } else {
        ms("Info", "DEBE SELECCIONAR UN REGISTRO")
    }
}
