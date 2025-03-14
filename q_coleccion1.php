<?php
/**
* @author Desarrollado por Wcunalata@2024
* PARA CONSULTA GLOBAL O DETALLADO
*/
require_once("autoload_q.php");
vsmedoogn($cn);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
  <HEAD>
    <TITLE><?php echo $site?></TITLE>
    
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" type="image/ico" href="favicon.gif" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="css/style_tooltip.css?dd=2" type="text/css">
    <link rel="stylesheet" href="css/style_modal.css?dd=2" type="text/css">
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
    
    
  </HEAD>
  <BODY >
    
    <input type="hidden" name="ID_NIVEL" id="ID_NIVEL" value="<?php echo $_SESSION["level"]?>">
    <input type="hidden" name="ID_USUARIO" id="ID_USUARIO" value="<?php echo $_SESSION["user"]?>">
    <input type="hidden" name="input_title" id="input_title" value="Reporte Coleccion">
    
    
    <!--<div id="header"></div>-->
    <!--<div id="banderamenu"></div>-->
    <div class="easyui-layout div_principal" style="width:100%;height:1000px;padding:10px;border: thin solid #E0ECFF;" >
      
      <br/>
      <!-- Tooltip personalizado -->
      <div id="tooltip" class="custom-tooltip"></div>
      <!-- INCIO PASO 1-->
      
      <div id="dlg_paso1" class="easyui-dialog"
        title="Sistema:  Coleccion"
        data-options="iconCls:'icon-edit',
        shadow:true,
        closed:true,
        modal:true,
        top:10,
        width:'100%',
        height: 'auto', minHeight: 800,
        
        "
        style="padding:10px;">
        
        <div id="hh" style="font-weight: bold;font-size: 18px;">
          Detalle Colecciones del sistema
          
          <p class="datos_paso1_certificacion"> </p>
        </div>
        
        <table id="dg_PASO1" class="easyui-datagrid dg_PASO1" title="--"
          data-options="
          header:'#hh',singleSelect:true,border:true,fit:true,fitColumns:true,scrollbarSize:0,pagination:true,rownumbers:true,nowrap:false,
          pageSize:20,pageList:[10,20,30,50],
          onLoadSuccess: function() {}"
          toolbar="#toolbar_PAC_REVISION"   idField:"ID" loadMsg="Cargando Sistema"  url="#" >
          <thead>
            <tr>
              
              <!--<th field="ID" width="10%"  >Id</th>-->
              <th field="REFERENCIA" width="5%" >Referencia</th>
              <th field="CATEGORIA" width="10%" >Categoria</th>
              <th field="DESCRIPCION" width="35%" >Descripción</th>
              
              <th field="VALOR" width="10%" >Valor</th>
              <th field="VALOR_MAYORISTA" width="10%" >V.Mayorista</th>
              <th field="ESTADO" width="10%" >Estado</th>
              
              <th field="ANEXO1" width="10%" formatter="imagenFormatter">Imagen</th>
              <th field="CREATED" width="10%"  >F.Creado</th>
              
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
          <div>
            
            <?php if ($_SESSION['level']=="Z" OR $_SERVER['level']=="9" ){ ?>
            Opciones:
            <a href="javascript:void(0);" target="" class="easyui-linkbutton" iconCls="icon-ok" plain="true" onclick="q_open_nuevo()" >Nuevo</a>
            <a href="javascript:void(0);" target="" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="q_open_dialog_edit()" >Editar</a>
            <a href="javascript:void(0);" target="" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="q_edit_estado(0)" >Desactivar</a>
            <a href="javascript:void(0);" target="" class="easyui-linkbutton" iconCls="icon-ok" plain="true" onclick="q_edit_estado(1)" >Activar</a>
            <?php } ?>
            <a href="home.php" class="easyui-linkbutton" iconCls="icon-cancel" plain="true" onclick="#" >Cerrar Modulo</a>
          </div>
          <div class="opciones" >Opciones
            
            
            <div>Menu :
              <a href="#" class="easyui-linkbutton cerrar_menu" iconCls="icon-remove" plain="true" onclick="menu_open(0)" >Cerrar</a>
            </div>
          </div>
          <div>Reporte :
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick='generar_reportes("pdf","jquery/q_coleccion1_jquery.php",99,$("#input_title").val(),6)'> PDF </a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick='generar_reportes("excel","jquery/q_coleccion1_jquery.php",99,$("#input_title").val(),6)'> EXCEL </a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick='generar_reportes("html","jquery/q_coleccion1_jquery.php",99,$("#input_title").val(),6)'> WEB </a> </div>
            
          </div>
          
        </div>
      </div>
      
      </div><!-- FIN PASO 1-->
      
      <!-- BOTONES DE DIALOG-->
      
      <!-- INCIO PARA APROBAR PRESUPUESTOS -->
      <div id="dlg_paso0_cabecera_presupuesto" class="easyui-dialog"
        title="Datos Colecciones "
        data-options="iconCls:'icon-add',
        shadow:true,
        closed:true,
        modal:true,
        top:20,
        width:'100%'"
        style="padding:10px;background: #ffffff;">
        <!--<form id="dlg_paso0_cabecera_presupuesto_form" method="post" class="easyui-form" action="#">-->
        <form id="dlg_paso0_cabecera_presupuesto_form" class="easyui-form" method="post" novalidate enctype="multipart/form-data">
          
          <div class="modal-content2">
            <!-- Contenedor de filas para las columnas -->
            <div class="form-row">
              <!-- Columna 1 -->
              
              <!-- Columna 2 -->
              <div class="form-column">
                <div class="form-group">
                  <label for="fecha">Categoria :</label>
                  <input id="CATEGORIA" style="width:100%" class="easyui-combobox texto" name="CATEGORIA"
                  data-options="
                  valueField:'NOMBRE',
                  textField:'NOMBRE',
                  url:'jquery/q_categoria.php?opcion=5',
                  required:true,
                  " required>
                  
                  <label for="motivo">Referencia: </label>
                  <input type="text" id="REFERENCIA" name="REFERENCIA" maxlength="50" style="width: 100%;" class="easyui-validatebox texto" data-options="required:true" />
                  
                  <label for="motivo">Descripción: </label>
                  <input type="text" id="DESCRIPCION" name="DESCRIPCION" maxlength="50" style="width: 100%;" class="easyui-validatebox texto" data-options="required:true" />
                  <label for="motivo">Color: </label>
                  <input type="text" id="COLOR" name="COLOR" maxlength="50" style="width: 100%;" class="easyui-validatebox texto" data-options="required:true" />
                  
                </div>
                <div class="form-group">
                  <label for="motivo">TALLA 26(XS): </label>
                  <input type="text" id="TALLA26" name="TALLA26" maxlength="50" style="width: 100%;" class="easyui-validatebox texto" data-options="required:true" />
                  <label for="motivo">TALLA 28(S):</label>
                  <input type="text" id="TALLA28" name="TALLA28" maxlength="50" style="width: 100%;" class="easyui-validatebox texto" data-options="required:true" />
                  <label for="motivo">TALLA 30(M):</label>
                  <input type="text" id="TALLA30" name="TALLA30" maxlength="50" style="width: 100%;" class="easyui-validatebox texto" data-options="required:true" />
                  <label for="motivo">TALLA 32(L):</label>
                  <input type="text" id="TALLA32" name="TALLA32" maxlength="50" style="width: 100%;" class="easyui-validatebox texto" data-options="required:true" />
                  <label for="motivo">TALLA 34(XL):</label>
                  <input type="text" id="TALLA34" name="TALLA34" maxlength="50" style="width: 100%;" class="easyui-validatebox texto" data-options="required:true" />
                  <label for="motivo">TALLA 36:</label>
                  <input type="text" id="TALLA36" name="TALLA36" maxlength="50" style="width: 100%;" class="easyui-validatebox texto" data-options="required:true" />
                  <label for="motivo">TALLA 38:</label>
                  <input type="text" id="TALLA38" name="TALLA38" maxlength="50" style="width: 100%;" class="easyui-validatebox texto" data-options="required:true" />
                  <label for="motivo">TALLA 40:</label>
                  <input type="text" id="TALLA40" name="TALLA40" maxlength="50" style="width: 100%;" class="easyui-validatebox texto" data-options="required:true" />
                  <label for="motivo">TALLA 42:</label>
                  <input type="text" id="TALLA42" name="TALLA42" maxlength="50" style="width: 100%;" class="easyui-validatebox texto" data-options="required:true" />
                  <label for="motivo">TALLA 44:</label>
                  <input type="text" id="TALLA44" name="TALLA44" maxlength="50" style="width: 100%;" class="easyui-validatebox texto" data-options="required:true" />
                  <label for="motivo">TALLA 46:</label>
                  <input type="text" id="TALLA46" name="TALLA46" maxlength="50" style="width: 100%;" class="easyui-validatebox texto" data-options="required:true" />
                  
                  
                </div>
                <div class="form-group">
                  <label for="motivo">Valor Normal: </label>
                  <input type="text" id="VALOR" name="VALOR" maxlength="50" style="width: 100%;" class="easyui-validatebox texto" data-options="required:true" />
                  <label for="motivo">Valor Mayorista:</label>
                  <input type="text" id="VALOR_MAYORISTA" name="VALOR_MAYORISTA" maxlength="50" style="width: 100%;" class="easyui-validatebox texto" data-options="required:true" />
                  
                  
                </div>
                <div class="form-group">
                  <input class="easyui-filebox"
                  style="width:100%"
                  label="Imagen: "
                  labelPosition="top"
                  data-options="required:false, buttonIcon:'icon-large-upload', buttonText: 'Seleccione Archivo'"
                  name="ANEXO1" id="ANEXO1"
                  accept="image/*"
                  capture="filesystem">
                </div>
                
              </div>
            </div>
            <div class="form-row">
              <div class="form-column">
                <div class="form-group">
                  
                  
                  
                </div>
                <div class="form-group">
                  
                </div>
              </div>
            </div>
            
            <div class="form-row">
              <!-- Botones de acción -->
              <div class="form-group">
                <a href="javascript:void(0);" class="easyui-linkbutton btn-submit" iconCls="icon-ok" onclick="q_grabar_nuevo()">Continuar</a>
                
              </div>
              <div class="form-group">
                <a href="javascript:void(0);" class="easyui-linkbutton btn-submit" iconCls="icon-cancel" onclick='$("#dlg_paso0_cabecera_presupuesto").dialog("close");''>Cancelar</a>
                
                
              </div>
            </div>
          </div>
        </form>
      </div>
      <!-- -FIN DE APROBAR PRESUPUESTOS-->
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
      
      <!-- dialgo para mostrar imagen -->
      <div id="dlgImagen" class="easyui-dialog"
        title="Datos Colecciones "
        data-options="iconCls:'icon-add',
        shadow:true,
        closed:true,
        closable:true,
        modal:true,
        top:20,
        width:'80%',
        onOpen: function() {
        $(document).on('keydown', function(e) {
        if (e.key === 'Escape') {
        $('#dlgImagen').dialog('close');
        }
        });
        },
        "
        style="padding:10px;background: #ffffff;" >
        <!--<a href="javascript:void(0);" class="easyui-linkbutton btn-submit" iconCls="icon-cancel" onclick='$("#dlgImagen").dialog("close");''>Cerrar</a>-->
        <img id="imgVistaPrevia" src="" style="width: 100%; height: auto;">
        
        
      </div>
      
    </body>
    <script  language="javascript" src="js/q_coleccion1_js.js?<?php echo r_v_2024();?>" ></script>
  </html>