<?php

require_once 'Connections/enlace.php';
require_once '../funciones/tools.php';
require_once '../model/class.medoogn.php';

$cn = new consumomedoo($cnq);
//ok
metadata();
// OK
//cargar_css();
//OK
cargar_favicon();
//ok
cargar_php_min();
//ok
cargar_funciones();
//ok
cargar_tools();
//ok



//if (($ip_sesion!=$ip_actual)  or ($info['browser']!=$navegador_sesion)){
$ll = explode("/", $_SERVER['PHP_SELF']);

$pagina = $ll[count($ll) - 1];

//$array = array(0 => 'azul', 1 => 'rojo', 2 => 'verde', 3 => 'rojo');
$array = array(0 => "registro.php", 1 => "resetear.php");

$clave = array_search($pagina, $array); // $clave = 2;"DOCUMENT



$gancho  = "1200px";
$gancho2 = "1400px";
$gancho3 = "1080px"; //para login
$gancho4 = "200px"; //para login INFORMATICO
$gancho5 = "600px"; //para nuevo bien

$galto  = "400px";
$galto3 = "800px";
$galto4 = "200px";
$galto5 = "500px";

//para pie de pagina global REVISAR PARA VER SI CARGA
//cargar_pie_pagina_global();


//$ll = split("/",$_SERVER['PHP_SELF']);
$_SESSION["EN_PAGINA"] = $pagina;

if ($en_produccion == 1) {
    //carga para valiacion de sesiones
    echo '<script  language="javascript" src="js/validacion_sesiones.js"></script>';
}

// jquery 3.3.1
function cargar_jquery_331()
{
    echo '<script type="text/javascript" src="../plugins/jquery-easyui-1.11.1/jquery.min.js"></script>';
}
function cargar_jeasyui_1111()
{
    $cadena = "";
    $cadena .= '<link rel="stylesheet" type="text/css" href="../plugins/jquery-easyui-1.11.1/themes/material-teal/easyui.css">';
    $cadena .= '<link rel="stylesheet" type="text/css" href="../plugins/jquery-easyui-1.11.1/themes/mobile.css">';
    $cadena .= '<link rel="stylesheet" type="text/css" href="../plugins/jquery-easyui-1.11.1/themes/icon.css">';
    $cadena .= '<link rel="stylesheet" type="text/css" href="../plugins/jquery-easyui-1.11.1/themes/color.css">  ';
    /*$cadena .= '<link rel="stylesheet" type="text/css" href="../plugins/jquery-easyui-1.9.12/demo/demo.css">';*/
    $cadena .= '<script type="text/javascript" src="../plugins/jquery-easyui-1.11.1/jquery.easyui.min.js"></script>';
    $cadena .= '<script type="text/javascript" src="../plugins/jquery-easyui-1.11.1/jquery.easyui.mobile.js"></script>';
    //$cadena .= '<link href="http://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css">';
    //$cadena .= '<link rel="stylesheet" type="text/css" href="css/2023L.css">';

    echo $cadena;
}


function uta_ran()
{
    $hash = base64_encode(openssl_random_pseudo_bytes(30));
    $v    = $hash . '=' . uniqid();
    echo $v;
    //return $v;
}

//2023
//cargar_jquery_jeasyui_uta2023();
//cargar_jeasyui_uta2023();

cargar_jquery_331();
cargar_jeasyui_1111();

//extension
//cargar_jeasyui_entension();

//cargar_jeasyui_entension_dg_options();


//cargar_blockui();

cargar_numeric();

//global $bdp_javascript;

function random_version_2024()
{
    $hash = base64_encode(openssl_random_pseudo_bytes(30));
    $v    = $hash . '=' . uniqid();
    return $v;
}
function r_v_2024()
{
    $hash = base64_encode(openssl_random_pseudo_bytes(30));
    $v    = $hash . '=' . uniqid();
    return $v;
}
function df_ran_2024()
{
    $hash = base64_encode(openssl_random_pseudo_bytes(30));
    $v    = $hash . '=' . uniqid();
    return $v;
}

function rv_()
{
    $hash = base64_encode(openssl_random_pseudo_bytes(30));
    $v    = $hash . '=' . uniqid();
    return $v;
}

//para pie de pagina global
//cargar_pie_pagina_global();

echo "<input type='hidden' id='url_sitio' name='url_sitio' value='" . $purl_sitio . "'>";
if (isset($_SESSION['level'])) {
    echo '<input type="hidden" id="user" value="' . $_SESSION['user'] . '">';

    echo '<input type="hidden" id="level" value="' . $_SESSION['level'] . '">';

    echo '<input type="hidden" id="codigosp" value="' . $_SESSION['codigosp'] . '">';
}
echo '<script language="javascript">';
echo '  $(document).ready(function(){
            $(".no_visible").remove();
            $(".novisible").hide();
        });';
echo '</script>';
#pf($_SESSION);
if ($opciones_poa == 0) {
    echo '<script language="javascript">';
    echo '$(document).ready(function(){
        $("#detalle,.no_visible_opciones").remove();


    });';

    echo '</script>';
} else {
}
//    $( "#header").load( "header.php", function() {alert( "Load was performed." );});

/**
 * metodos para cargar el header,footer , bandera menu en cada pagina
 */
echo '<script language="javascript">';
echo '$(document).ready(function(){

    $( "#header").load( "header.php");
    $( "#footer").load( "footer.php");
    $( "#banderamenu2").load( "banderamenu.php");

    });';

echo '</script>';

$site = "Oficio11denim";
