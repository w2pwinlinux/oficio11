<?php

require_once 'Connections/enlace.php';
require_once '../funciones/tools.php';
require_once '../model/class.medoogn.php';

$cn = new consumomedoo($cnq);

//pf($_SESSION);
//if (count($cn) == -1) {
    //llamada vara volver

//}

//valida_sesiones_activas($cn);


echo title();
cargar_jquery1_7_1();
cargar_cssuta();
cargar_favicon();
cargar_blockui();
cargar_funciones();
cargar_php_min();
cargar_vtip();
cargar_smoke();
cargar_tools();
cargar_jeasyui();
cargar_jeasyui_cssuta();
cargar_ejeasyuiw1();
//cargar_ejeasyui2015();
cargar_jeasyui_entension();
cargar_jeasyui_entension_dg_options();

//para pie de pagina global
//cargar_pie_pagina_global();

echo "<input type='hidden' id='url_sitio' name='url_sitio' value='" . $purl_sitio . "'>";
if (isset($_SESSION['level'])) {
    echo '<input type="hidden" id="user" value="' . $_SESSION['user'] . '">';

    echo '<input type="hidden" id="level" value="' . $_SESSION['level'] . '">';

    echo '<input type="hidden" id="codigosp" value="' . $_SESSION['codigosp'] . '">';
}
echo '<script language="javascript">';
echo '	$(document).ready(function(){
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
	$( "#banderamenu").load( "banderamenu.php");



	});';

echo '</script>';

/**
 * [sql para validar el edit poa pac]
 */
$sql = "SELECT EDIT_POA_PAC FROM EMPRESA";
$cn->execute($sql, 2);
$nn              = $cn->datos();
$sw_edit_poa_pac = 0;
if ($cn->filas_afectada() > 0) {
    $edit_poa_pac = $nn[0]["EDIT_POA_PAC"];
    if (es_administrador($_SESSION["level"]) == 1 && $edit_poa_pac == 1) {
        $sw_edit_poa_pac = 1;
    } else {
        $sw_edit_poa_pac = 0;
    }
}

if (isset($_REQUEST["id_componente"])) {
    $_SESSION["tmp_id_componente2020"] = $_REQUEST["id_componente"];

}

function administrador_sppc2020($level)
{

    $retorno = -1;
    switch ($level) {
        case "'Z'":
            $retorno = 1;
            break;
        case "'9'":
            $retorno = 1;
            break;
        default:
            $retorno = 0;
            break;
    }

    //   echo $level."<br>";
    //   echo $retorno."<br>";

    return $retorno;
}

function random_version(){
$hash =  base64_encode(openssl_random_pseudo_bytes(30));
$v = $hash.'='.uniqid();
return $v;
}
function r_v(){
$hash =  base64_encode(openssl_random_pseudo_bytes(30));
$v = $hash.'='.uniqid();
return $v;
}
function df_ran(){
$hash =  base64_encode(openssl_random_pseudo_bytes(30));
$v = $hash.'='.uniqid();
return $v;
}
