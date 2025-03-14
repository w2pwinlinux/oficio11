<?php
/*
require_once('autoload.php'); 



if (!isset($_SESSION)) { session_start();}

$mensaje = "SALIDA EXITOSA DEL SISTEMA DE USUARIO ".$_SESSION['user']." con nivel de permisos  : ".$_SESSION['level'];

//pf($_SESSION,1);
grabar_auditoria($mensaje,$conexion);

unset($_SESSION['user']);

unset($_SESSION['level']);
unset($_SESSION['nombrecompleto']);
unset($_SESSION['codigosp']);
unset($_SESSION['app']);

header("Location: ../index.php");
*/

?>

<?php 

require_once('autoload.php');  
  


$mensaje = "SALIDA EXITOSA DEL SISTEMA DE USUARIO ".$_SESSION['user']." con nivel de permisos  : ".$_SESSION['level'];


grabar_auditoria($mensaje,$cn);
//cambiar datos de la sesion 
$user = vd($_SESSION['user'],"text");
//pf($_SESSION,1);
#$SQL= "SP_LOGOUT(".$user.")";

//$cn->execute($SQL,0);

unset($_SESSION['user']);
unset($_SESSION['level']);
unset($_SESSION['nombrecompleto']);

//pf($_SESSION,1);


if (isset($_SESSION['tmp_clave'])){
	unset($_SESSION['tmp_user']);
	unset($_SESSION['tmp_pass']);
	unset($_SESSION['tmp_cedula']);
	unset($_SESSION['tmp_clave']);

//	cargar_cerrar_ventana();
//	echo "existe";
	echo '<script language="javascript" >';
	echo 'window.close()';
	echo '</script>';

}else{
//	pf($_SESSION);
	echo "no existe";

	header("Location: ../index.php"  );
}





?>