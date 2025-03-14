<?php if (!isset($_SESSION)) {	session_start();}
error_reporting(E_ALL ^ E_NOTICE);
//require_once 'excel_reader2.php';
require_once("../../funciones/tools.php");

require_once('../../sippc2015eval/Connections/enlace.php');
require_once('../../model/database.php');

// A list of permitted file extensions
$id_poa = $_SESSION['id_poa'];
$allowed = array('pdf,rar,doc,docx,xls,xlsx,7z');
$archivo =  $id_poa;
$origen = $_FILES['upl']['tmp_name'];
$info = pathinfo($_FILES['upl']['name']);
print_r($info);
$extensionf = $info['extension'];
$extensionf = strtoupper($extensionf);
//$aux  = '../../sippc2015eval/UPLOADS/'.$id_poa.$info;
//$id_poa = $_SESSION['id_poa'];
$archivo_cargado   = "UPLOADS/".$archivo.".".$extensionf;



if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){

	$extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);// extension del archivo 
	$nombre = '../../sippc2015eval/UPLOADS/'.$info['basename'].".txt";
	if (file_exists($nombre)) unlink($nombre);
	$fp=fopen($nombre,"x");
	/*if(!in_array(strtolower($extension), $allowed)){
		$contenido="error de tipo de archivo";
		fwrite($fp,$contenido);
		fclose($fp) ;
		echo '{"status":"error","f":0}';
		exit;
	}*/
	
	$destino = '../../sippc2015eval/UPLOADS/'.$archivo.".".$extensionf;
	//$destino = strtoupper($destino);
	
	if(move_uploaded_file($origen, $destino)){
			$sql = "DELETE FROM  POA_EVIDENCIANUAL WHERE ID_POA = $id_poa";
			$conexion2 = new database;$conexion2->conectar($database,$hostname,$username,$password,$port);if ($conexion2->consultar($sql,2,1)!=-1)
			$sql = "INSERT INTO POA_EVIDENCIANUAL(ID_POA,EVIDENCIA) VALUES($id_poa,'$archivo_cargado')";
			$conexion = new database;
			$conexion->conectar($database,$hostname,$username,$password,$port);
			if ($conexion->consultar($sql,2,1)!=-1){
				$_matriz['fila_afectada']=$conexion->fila_afectada();
				$contenido="operacion exitosa";
				fwrite($fp,$contenido);
				fclose($fp) ;
				echo '{"status":"success","f":1}';
				exit;

			}else{
				$contenido=$conexion->mensaje;
				fwrite($fp,$contenido);
				fclose($fp) ;
				$_matriz['fila_afectada']=-1;
				
				echo '{"status":"error","f":4}';
				exit;
						
			}
	}
}
else{
	$contenido="error general de parametros ";
	fwrite($fp,$contenido);
	fclose($fp) ;

	echo '{"status":"error","f":2}';
	exit;
}
