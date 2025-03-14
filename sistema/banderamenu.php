<?php 
if (!isset($_SESSION)) {
	session_start();
}

require_once('Connections/enlace.php');
require_once('../funciones/tools.php');
require_once('../model/class.medoogn.php');

$cn = new consumomedoo($cnq);


//echo $_SESSION['level'];

if (isset($_SESSION['level'])){
	menuta2018v1($cn,$_SESSION['level'],1);
}else{

	echo "alert('<H1>SIN ACCESO AL SISTEMA ')";
    header("Location: " . "index.php");
    exit();
    
}


