<?php
/**
* @author Desarrollado por Wcunalata@2025*
*/
require_once "autoload_q.php";
vsmedoogn($cn);
/**
* @details [long description]
*/
// AL INCICO CARGAR EL ID
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
  <HEAD>
    <TITLE><?php echo $site ?></TITLE>
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
  </HEAD>
  <BODY >
    <input type="hidden" name="ID_CERTIFICACION" id="ID_CERTIFICACION" value="-1">
    <input type="hidden" name="ID_ESTADO_INTERNO" id="ID_ESTADO_INTERNO" value="-1">
    <input type="hidden" name="ID_TIPO_SOLICITUD" id="ID_TIPO_SOLICITUD" value="BIEN">
    <input type="hidden" name="CATEGORIA" id="CATEGORIA" value="FACULTAD">
    <!--<div id="header"></div>-->
    <div id="banderamenu2"></div>
    <div class="easyui-layout div_principal" style="width:100%;height:1000px;padding:10px;border: thin solid #E0ECFF;" >
      <br/>
      <div id="hh" style="font-weight: bold;font-size: 18px;color:#002b5c">
        <h2>Bienvenido al Sitema</h2>
        <h2>Oficio11Denim</h2>
      </div>
      <!-- PARA TOOLBAR -->
    </div>
    </div><!-- FIN PASO 1-->
  </body>
  <!-- <script  language="javascript" src="js/pac_ejecucion_certificacion.js?<?php echo r_v_2024(); ?>" ></script>-->
</html>