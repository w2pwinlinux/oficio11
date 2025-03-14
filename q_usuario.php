  <?php
/**
* @author Desarrollado por Wcunalata@2024
* ETAPAS 1 : crear la cabezera de la solicitud
*
*
*/
require_once("autoload_q.php");
//vsmedoogn($cn);
/**
* @details [long description]
*
* @param  [description]
* @return [description]
*/


//pf($_SESSION,1);

// aqui modificar el periodo
// AL INCICO CARGAR EL ID
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
  <HEAD>
    <TITLE><?php echo $site?></TITLE>
    
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" type="image/ico" href="favicon.gif" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="css/style_tooltip.css" type="text/css">
    <link rel="stylesheet" href="css/style_modal.css" type="text/css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style type="text/css">
    #motivo {
    width: 100%;           /* Ancho 100% para que ocupe todo el espacio disponible */
    height: 20vh;          /* Altura responsiva, 60% de la altura de la ventana */
    padding: 10px;         /* Espaciado interno para que el texto no esté pegado al borde */
    border: 1px solid #ccc; /* Borde del textarea */
    border-radius: 4px;    /* Esquinas redondeadas */
    resize: vertical;      /* Permitir cambiar el tamaño verticalmente */
    box-sizing: border-box; /* Incluir el padding en el cálculo del ancho */
    }
    
    </style>
    <style type="text/css">
    /* Contenedor principal del formulario para distribuir en filas */
    .form-row {
    display: flex;
    flex-wrap: wrap;  /* Permite que las columnas se acomoden en múltiples filas si es necesario */
    gap: 20px; /* Espacio entre las columnas */
    }
    /* Cada columna dentro de la fila */
    .form-column {
    flex: 1; /* Cada columna ocupa el mismo espacio */
    min-width: 300px; /* Ancho mínimo para las columnas */
    }
    /* Opcional: Estilo para los grupos de formulario */
    .form-group {
    margin-bottom: 15px; /* Espacio entre los campos */
    }
    textarea {
    width: 100%; /* Hace que el textarea ocupe todo el ancho disponible */
    height: 100px; /* Ajusta la altura del textarea */
    }
    /* Para que el formulario no se desborde en pantallas pequeñas */
    @media (max-width: 768px) {
    .form-row {
    flex-direction: column;  /* En pantallas pequeñas, cambia a una columna */
    }
    .form-column {
    width: 100%; /* Asegura que las columnas ocupen todo el ancho disponible */
    }
    }
    
    </style>
    <style type="text/css">
      /* Reset básico */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
}

/* Estilos del header */
.global {
    background-color: #333;
    color: white;
    padding: 10px 20px;
}

/* Estilo del botón hamburguesa */
#hamburger {
    font-size: 20px;
    cursor: pointer;
    display: none; /* Oculto en pantallas grandes */
    padding: 10px;
    background: #444;
    text-align: center;
    color: white;
}

/* Estilos del menú principal */
.sf-menu {
    list-style: none;
    display: flex;
    justify-content: space-around;
    background: #222;
}

.sf-menu li {
    position: relative;
}

.sf-menu li a {
    display: block;
    color: white;
    text-decoration: none;
    padding: 15px 20px;
}

.sf-menu li:hover {
    background: #555;
}

/* Responsive: Mostrar menú hamburguesa en móviles */
@media (max-width: 768px) {
    #hamburger {
        display: block; /* Mostrar el botón hamburguesa */
    }

    .sf-menu {
        display: none; /* Ocultar menú por defecto */
        flex-direction: column;
        position: absolute;
        top: 50px;
        left: 0;
        width: 100%;
        background: #222;
    }

    .sf-menu.active {
        display: flex; /* Mostrar menú cuando tenga la clase active */
    }

    .sf-menu li {
        text-align: center;
        width: 100%;
    }
}

      
    </style>
    
    
  </HEAD>
  <BODY >
    <input type="hideen" name="ID_CERTIFICACION" id="ID_CERTIFICACION" value="-1">
    <input type="hidden" name="ID_ESTADO_INTERNO" id="ID_ESTADO_INTERNO" value="-1">
    <input type="hidden" name="ID_TIPO_SOLICITUD" id="ID_TIPO_SOLICITUD" value="BIEN">
    <input type="hidden" name="CATEGORIA" id="CATEGORIA" value="FACULTAD">

    
    <!--<div id="header"></div>-->
    <div id="banderamenu"></div>
    <div class="easyui-layout div_principal" style="width:100%;height:1000px;padding:10px;border: thin solid #E0ECFF;" >
      
      <br/>
      <!-- Tooltip personalizado -->
      <div id="tooltip" class="custom-tooltip"></div>
      <!-- INCIO PASO 1-->
      
      <div id="dlg_paso1" class="easyui-dialog"
        title="Módulo Ejecución Plan Anual de Compras"
        data-options="iconCls:'icon-add',
        shadow:true,
        closed:true,
        modal:true,
        top:15,
        width:'99%',
        height: 'auto', minHeight: 800,
        

        "
        style="padding:10px;">
        
        <DIV>
          <a target="_blank" style="color:red" href="https://serviciosdf.uta.edu.ec/diplev/apps/ayudas/ayudaparte1.mp4?v=1">
            <img src="images/ayuda.png" alt="ayuda certificacion planificacion" width="30px" height="30px">
          </a>
      </DIV>

        <div id="hh" style="font-weight: bold;font-size: 18px;">
          Certificación Detalle Paso1: Selección de Bienes/Servicios individuales o masivos
          
          
          <p class="datos_paso1_certificacion" style="color: red;"> SIN SOLICITUD CABECERA / Clic en Iniciar Certificación-</p>
        </div>
        <table id="dg_PASO1" class="easyui-datagrid dg_PASO1" title="--" data-options="
          header:'#hh',singleSelect:false,border:true,fit:true,fitColumns:true,scrollbarSize:0,pagination:true,rownumbers:true,nowrap:false,onLoadSuccess: function() {}" toolbar="#toolbar_PAC_REVISION"   idField:"ID" loadMsg="Cargando Sistema"  url="#" >
          <thead>
            <tr>
              <th field="ID" width="5%" >IDPAC</th>
              <th field="DATO_DEPENDENCIA" width="25%" >Dependencia</th>
              <!--<th field="DATO_PLANIFICACION" width="35%"  >Datos Planificación</th>-->
              <th field="DATO_FINANCIERO_MIN" width="50%" formatter="detalleFormatter_bien" >Detalle</th>
              <!--<th field="DATO_EJE" width="10%"  >EJE</th>-->
              
              <!--<th field="DATO_DISTRIBUCION" width="30%" formatter="dato_size_min" >Programa</th>-->
              
              <!--<th field="EJECUCION_ESTADO_REVISION" width="5%"  >EstadoPAC</th>-->
              <th field="EJECUCION_ESTADO" width="20%" >Estado Ejecución</th>
              
              
            </tr>
          </thead>
        </table>
        <!-- PARA TOOLBAR -->
        <div id="toolbar_PAC_REVISION">
          <div id="filtros">
            <form id="form1" name="form1" method="get" action="#">
              <div id="hfiltro">Filtros<img src="images/add.png" name="addFiltro" width="24" height="24" id="addFiltro" onClick="fAddFiltro();">
              </div>
              <input type="button" id="buscar" value="Buscar" name="buscar" onclick="clic_buscar();" >
            </form>
          </div>
          <div>Opciones :  
            <!--<a href="#" class="easyui-linkbutton abrir_menu" iconCls="icon-add" plain="true" onclick="menu_open(1)" >Abrir Menu</a>-->
            <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="open_dlg_cabecera()" >Paso1.1: Iniciar Certificación</a>
            
            <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="paso1(1)" >Paso 1.2: Agregar a Detalle Certificación</a>
            <!--<a href="#" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="pasos(2)" >Visualizar Requerimientos Seleccionados</a>-->
            
            <!---<H3>PASO A DETALLE EN PROCESO DE REVISION</H3> -->
            



            <a href="#" class="easyui-linkbutton" iconCls="icon-ok" plain="true" onclick="paso1(3)" >Continua a Paso2 Mostrar Detalle Certificación </a>


            
            
            <a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="anular_certificacion(2)" >Anular Certificación en Curso  </a>

             <!--<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick='generar_reportes("html","jquery/pac_ejecucion_certificacion_reporte.php",99,"Reporte Detallado ",29)'> Exportar WEB</a>-->
            


            <a href="home.php" class="easyui-linkbutton" iconCls="icon-cancel" plain="true" onclick="#" >Cerrar Modulo</a>
          </div>
          <div>Exportar Datos Filtros:
           <!-- <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick='generar_reportes("html","jquery/pac_ejecucion_certificacion_reporte.php",99,"Reporte Detallado ",29)'>Html</a>-->
                -
            <!--<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick='generar_reportes("Excel","jquery/pac_ejecucion_certificacion.php",99,"Reporte Detallado ",29)'>excel</a>-->


            <a href="javascript:void(0)" class="easyui-linkbutton" plain="true"  onclick='generar_reportes_certificacion("html","jquery/pac_ejecucion_certificacion.php",99,"Reporte Filtrado",16)'>
              <i class="fa-solid fa-file fa-2x" style="color: green;"></i> Html
            </a>

            <a href="javascript:void(0)" class="easyui-linkbutton" plain="true"  onclick='generar_reportes_certificacion("excel","jquery/pac_ejecucion_certificacion.php",99,"Reporte Filtrado ",16)'>
              <i class="fa-solid fa-file-excel fa-2x" style="color: green;"></i> Excel
            </a>

          </div>
            
            
          <div class="opciones" >Opciones
            
            <a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-ok" plain="true" onclick="aprobar_individual()" >Aprobar </a>
            <a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-ok" plain="true" onclick="aprobar_por_filtro()" >Aprobar por filtro</a>
            <a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="reverso_individual()" >Reversar</a>
            <a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="open_noaprobar_individual()" >Rechazar</a>
            
            <div>Menu :
              <a href="#" class="easyui-linkbutton cerrar_menu" iconCls="icon-remove" plain="true" onclick="menu_open(0)" >Cerrar</a>
            </div>
            <div>Filtro Global :
              <select id="filtro_global_estado" class="easyui-combobox" name="filtro_global_estado" style="width:300px;"
                data-options="
                valueField: 'value',
                textField: 'label',
                multiple: false,
                panelHeight: 'auto',
                formatter: function(row) {
                var opts = $(this).combobox('options');
                return '<input type=\'checkbox\' class=\'combobox-checkbox\'>' + row[opts.textField];
                },
                onSelect: function(row) {
                var opts = $(this).combobox('options');
                var el = opts.finder.getEl(this, row[opts.valueField]);
                el.find('.combobox-checkbox').prop('checked', true);
                },
                onUnselect: function(row) {
                var opts = $(this).combobox('options');
                var el = opts.finder.getEl(this, row[opts.valueField]);
                el.find('.combobox-checkbox').prop('checked', false);
                }
                ">
                <!-- Opciones definidas en HTML -->
                <option value="%">Todos</option>
                <option value="APROBADO" selected="selected">Aprobado</option>
                <option value="PENDIENTE">Pendiente</option>
                
              </select>
              
            </div>
            
          </div>
          
        </div>
      </div>
      
      </div><!-- FIN PASO 1-->
      
      
      <div id="dlg_paso2" class="easyui-dialog"
        title="Módulo Ejecución Plan Anual de Compras PASO2"
        data-options="iconCls:'icon-add',
        shadow:true,
        closed:true,
        modal:true,
        top:10,
        width:'95%',
        height:'95%'"
        style="padding:10px;">
        <div id="hh2" style="font-weight: bold;font-size: 18px;">
          Certificación Paso2: Revisión detalle y requerimientos.
          
          <p class="datos_paso2_certificacion" style="color: red;"> SIN SOLICITUD CABECERA / Clic en Iniciar Certificación-</p>
        </div>
        
        <table id="dg_PASO2" class="easyui-datagrid dg_PASO2" title="--" data-options="
          header:'#hh2',singleSelect:true,border:true,fit:true,fitColumns:true,scrollbarSize:0,pagination:true,rownumbers:true,nowrap:false,onLoadSuccess: function() {}" toolbar="#toolbar_PAC_REVISION2"   idField:"ID" loadMsg="Cargando Sistema"  url="#" >
          <thead>
            <tr>
              <th field="ID" width="5%"  >ID</th>
              <th field="ID_PAC" width="5%"  >IdPac</th>
              <th field="DATO_DEPENDENCIA" width="20%"  >Dependencia</th>
              <th field="DATO_FINANCIERO_MIN" width="30%"  >Bien/Servicio</th>
              <th field="CODIFICADO_CANTIDAD" width="5%"  >Cantidad</th>
              <th field="SOLICITADO_CANTIDAD" width="5%"  >Cant.Solicitada</th>
              
              <th field="CODIFICADO" width="10%"  >VT</th>
              
              <th field="SOLICITADO" width="10%"  >VT Solicitada</th>
              
              
              <!--<th field="OBSERVACION" width="10%"  >Observación</th>-->
              <!--<th field="DATO_DISTRIBUCION" width="30%" formatter="dato_size_min" >Programa</th>-->
              
              <th field="ESTADO" width="5%"  >Estado</th>
              <!--<th field="EJECUCION_ESTADO" width="20%"  >Estado Ejecución</th>-->
              <th field="OPCIONES" width="5%">Opciones</th>
              
            </tr>
          </thead>
        </table>
        <!-- PARA TOOLBAR -->
        <div id="toolbar_PAC_REVISION2">
          
          <!--
          <div id="filtros">
            <form id="form1" name="form1" method="get" action="#">
              <div id="hfiltro">Filtros<img src="images/add.png" name="addFiltro" width="24" height="24" id="addFiltro" onClick="fAddFiltro();">
              </div>
              <input type="button" id="buscar" value="Buscar" name="buscar" onclick="clic_buscar();" >
            </form>
          </div>
          -->
          <div>
            <!--<a href="#" class="easyui-linkbutton abrir_menu" iconCls="icon-add" plain="true" onclick="menu_open(1)" >Abrir Menu</a>-->
            <!--<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="paso1(1)" >Agregar a Solicitud</a>-->
            <a href="#" class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="pasos(0)" >Regresar a Paso1</a>
            <a href="#" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="verificar_detalle_paso2()" >Verificar/Validar Detalle</a>
            
            <a href="#" class="easyui-linkbutton" plain="true" onclick="mostrar_auxiliar_presupuestos()" >
              <i class="fa fa-print"></i>Auxiliar Presupuestario</a>
            <a href="#" class="easyui-linkbutton" iconCls="icon-ok" plain="true" onclick="finalizar_solicitur_certificacion()" >Finalizar Solicitud Certificación Operador </a>
            <a href="home.php" class="easyui-linkbutton" iconCls="icon-cancel" plain="true" onclick="#" >Cerrar Modulo</a>
          </div>
          <div class="opciones" >Opciones
            
            <a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-ok" plain="true" onclick="aprobar_individual()" >Aprobar </a>
            <a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-ok" plain="true" onclick="aprobar_por_filtro()" >Aprobar por filtro</a>
            <a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="reverso_individual()" >Reversar</a>
            <a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="open_noaprobar_individual()" >Rechazar</a>
            
            <div>Menu :
              <a href="#" class="easyui-linkbutton cerrar_menu" iconCls="icon-remove" plain="true" onclick="menu_open(0)" >Cerrar</a>
            </div>
            
            
          </div>
          
        </div>
      </div>
      <!-- BOTONES DE DIALOG-->
      
      <div id="dlg_paso1_motivo" class="easyui-dialog"
        title="Motivo de la Solicitud"
        data-options="iconCls:'icon-add',
        shadow:true,
        closed:true,
        modal:true,
        top:10,
        width:'48%',
        height:'70%'"
        style="padding:10px;">
        
        <form id="validarCorreoForm0" method="post" class="easyui-form" action="#">
          <div class="modal-content2">
            <h2>Motivo: </h2>
            <div class="form-group">
              <!-- <input type="text" id="observacion" name="observacion" maxlength="100">-->
              <textarea id="motivo" name="motivo" maxlength="500" rows="10" cols="105" placeholder="Ingrese el motivo aquí..."></textarea>
            </div>
            
            <!--<button class="btn-submit" id="Aceptar" onclick="noaprobado_individual()">Grabar</button>-->
            <!--<button class="btn-submit" id="Cerrar" onclick="javascript:$('#datos-modal0').dialog('close');">Cerrar</button>-->
            
            
          </div>
          <div class="form-group"><br><br><br>
            <a href="javascript:void(0);" class="easyui-linkbutton btn-submit" iconCls="icon-ok" onclick="paso1_grabar_motivo()">Grabar</a>
          </div>
          <div class="form-group">
            <a href="javascript:void(0);" class="easyui-linkbutton btn-submit" iconCls="icon-cancel" onclick="paso1(-1)">Cancelar</a>
          </div>
          
        </form>
      </div>
      <div id="dlg_paso0_cabecera" class="easyui-dialog"
        title="Cabecera Certificación"
        data-options="iconCls:'icon-add',
        shadow:true,
        closed:true,
        modal:true,
        top:10,
        width:'95%'"
        style="padding:10px;">
        <form id="dlg_paso0_cabecera_form" method="post" class="easyui-form" action="#">
          <div class="modal-content2">
            <!-- Contenedor de filas para las columnas -->
            <div class="form-row">
              <!-- Columna 1 -->
              <div class="form-column">
                <div class="form-group">
                  <label for="id">Número de Certificación:</label>
                  <input type="text" id="id_paso0" name="id_paso0" maxlength="50" placeholder="Ingrese el ID" style="width: 100%;" readonly="readonly" />
                </div>
                <div class="form-group">
                  <label for="fecha">Fecha:</label>
                  <input type="date" id="fecha_paso0" name="fecha_paso0" style="width: 100%;" readonly="readonly"/>
                </div>
              </div>
              <!-- Columna 2 -->
              <div class="form-column">
                <div class="form-group">
                  <label for="id_usuario">Usuario:</label>
                  <input type="text" id="id_usuario_paso0" name="id_usuario_paso0" maxlength="50" placeholder="Ingrese el ID de usuario" style="width: 100%;" readonly="readonly"/>
                </div>
                <div class="form-group">
                  <label for="tipo1">Tipo Solicitud:</label>
                  <select id="filtro_tipo_solicitud" class="easyui-combobox" name="filtro_tipo_solicitud" style="width:300px;"
                    data-options="
                    valueField: 'value',
                    textField: 'label',
                    multiple: false,
                    panelHeight: 'auto',
                    
                    editable: false, 
                    formatter: function(row) {
                    var opts = $(this).combobox('options');
                    return '<input type=\'checkbox\' class=\'combobox-checkbox\'>' + row[opts.textField];
                    },
                    onSelect: function(row) {
                    var opts = $(this).combobox('options');
                    var el = opts.finder.getEl(this, row[opts.valueField]);
                    el.find('.combobox-checkbox').prop('checked', true);
                    },
                    onUnselect: function(row) {
                    var opts = $(this).combobox('options');
                    var el = opts.finder.getEl(this, row[opts.valueField]);
                    el.find('.combobox-checkbox').prop('checked', false);
                    }
                    ">
                    <!-- Opciones definidas en HTML -->
                    
                    <option value="BIEN" selected="selected">BIEN</option>
                    <option value="SERVICIO">SERVICIO</option>
                    <option value="OBRA">OBRA</option>
                    <option value="CONSULTORIA">CONSULTORIA</option>
                    <option value="HONORARIOS">HONORARIOS</option>
                    
                  </select>
                  
                  <label for="tipo1">Categoria:</label>
                  <select id="filtro_tipo_categoria" class="easyui-combobox" name="filtro_tipo_categoria" style="width:300px;"
                    data-options="
                    valueField: 'value',
                    textField: 'label',
                    multiple: false,
                    panelHeight: 'auto',
                    editable: false, 
                    formatter: function(row) {
                    var opts = $(this).combobox('options');
                    return '<input type=\'checkbox\' class=\'combobox-checkbox\'>' + row[opts.textField];
                    },
                    onSelect: function(row) {
                    var opts = $(this).combobox('options');
                    var el = opts.finder.getEl(this, row[opts.valueField]);
                    el.find('.combobox-checkbox').prop('checked', true);
                    },
                    onUnselect: function(row) {
                    var opts = $(this).combobox('options');
                    var el = opts.finder.getEl(this, row[opts.valueField]);
                    el.find('.combobox-checkbox').prop('checked', false);
                    }
                    ">
                    <!-- Opciones definidas en HTML -->
                    
                    <option value="FACULTAD" selected="selected">Facultad/Dirección</option>
                    <option value="POSGRADO">Posgrado</option>

                    
                  </select>
                  
                </div>
              </div>
            </div>
            <div class="form-column">
              <div class="form-group">
                <label for="motivo">Justificación :</label>
                <textarea id="motivo_paso0" name="motivo_paso0" maxlength="500" rows="10" cols="50" placeholder="Ingrese el motivo aquí..."></textarea>
                
              </div>
              <div class="form-group"></div>
            </div>
            <!-- Botones de acción -->
            <div class="form-group">
              <a href="javascript:void(0);" class="easyui-linkbutton btn-submit" iconCls="icon-ok" onclick="paso1_grabar_motivo()">Continuar</a>
            </div>
            <div class="form-group">
              
              <a href="javascript:void(0);" class="easyui-linkbutton btn-submit" iconCls="icon-cancel" onclick="paso1_grabar_cancelar()">Cancelar</a>
              
            </div>
          </div>
        </form>
      </div>
      <!-- DIALLOG EDIT DEL REQUERIMEINTO-->
      <div id="dlg_paso2_edit" class="easyui-dialog"
        title="Editar detalle Certificación"
        data-options="iconCls:'icon-add',
        shadow:true,
        closed:true,
        modal:true,
        top:10,
        width:'95%'"
        style="padding:10px;">
        <form id="dlg_paso2_edit_form" method="post" class="easyui-form" action="#">
          <div class="modal-content2">
            <p class="datos_paso2_certificacion" style="color: red;"> SIN SOLICITUD CABECERA / Clic en Iniciar Certificación-</p>
            <!-- Contenedor de filas para las columnas -->
            <div class="form-row">
              <!-- Columna 1 -->
              <div class="form-column">
                <div class="form-group">
                  <label for="id">Id : </label>
                  <input type="text" id="id_paso2" name="id_paso2" maxlength="50" placeholder="Ingrese el ID" style="width: 100%;" readonly="readonly" />
                  <!--<label for="fecha">Item:</label>
                  <input type="text" id="item_presupuestario_paso2" name="item_presupuestario_paso2" style="width: 100%;" readonly="readonly"/>
                  -->
                  
                </div>
                <div class="form-group">
                  <label for="id">Descripción: </label>
                  <input type="text" id="descripcion_paso2" name="descripcion_paso2" maxlength="50" placeholder="Ingrese Descripcion" style="width: 100%;" readonly="readonly" />
                </div>
              </div>
              <!-- Columna 2 -->
              <div class="form-column">
                <div class="form-group">
                  <label for="id_usuario">Cantidad Solicitada :</label>
                  <input type="text" id="cantidad_anual_paso2" name="cantidad_anual_paso2" maxlength="50" placeholder="Ingrese valor" style="width: 100%;" readonly="readonly" required />
                </div>
                <div class="form-group">
                  <label for="id_usuario">Valor Solicitado :</label>
                  <input type="text" id="valor_anual_paso2" name="valor_anual_paso2" maxlength="50" placeholder="Ingrese valor" style="width: 100%;" readonly="readonly" required/>
                  
                </div>
              </div>
            </div>
            <!-- Botones de acción -->
            <div class="form-group">
              <a href="javascript:void(0);" class="easyui-linkbutton btn-submit" iconCls="icon-ok" onclick="paso2_grabar_edit()">Continuar</a>
            </div>
            <div class="form-group">
              
              <a href="javascript:void(0);" class="easyui-linkbutton btn-submit" iconCls="icon-cancel" onclick="$('#dlg_paso2_edit').dialog('close')">Cancelar</a>
              
            </div>
          </div>
        </form>
      </div>
      <!-- FIN DIALOG EDIT PARA REQUERIMEITN -->
      <!--  div para mensajes del sistrema -->
      <div id="dlg_message" class="easyui-dialog"
        title="Mensaje sistema"
        data-options="iconCls:'icon-add',
        shadow:true,
        closed:true,
        modal:true,
        top:10,
        width:'48%',
        height:'70%'"
        style="padding:10px;">
        
        <div class="modal-content2">
          <h2>Mensaje</h2>
          <div class="form-group dlg_message_detalle">
            
          </div>
        </div>
        <div class="form-group">
          <a href="javascript:void(0);" class="easyui-linkbutton btn-submit" iconCls="icon-cancel" onclick="$('#dlg_message').dialog('close')">Cerrar</a>
        </div>
      </div>
      
      
    </body>
    <script  language="javascript" src="js/pac_ejecucion_certificacion.js?<?php echo r_v_2024();?>" ></script>
  </html>