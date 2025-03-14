<?php if (!isset($_SESSION)) {	session_start();}
error_reporting(E_ALL ^ E_NOTICE);
//require_once 'excel_reader2.php';
require_once('../../administracion/Connections/sistema.php');
require_once('../../administracion/jquery/model/database.php');
require_once("../../administracion/jquery/funcion/tools.php");
require_once("../../administracion/jquery/funciones/parametros.php");


// A list of permitted file extensions
//$allowed = array('xls', 'jpg', 'gif','zip','doc','docx');
//$allowed = array('xls','pdf','txt','doc','docx','xls','xlsx');
echo "<pre>";
print_r($_FILES);
$aux  = '../../administracion/UPLOADS/'.$_FILES['upl']['name'];
$nombre = $aux.".txt";
$user = $_SESSION['users'];
$ff = $_SESSION['fecha_ingreso'];
$nombre_parcial = base64_encode($ff);
if (file_exists($nombre)) unlink($nombre);
$fp=fopen($nombre,"x");



if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){

	$extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);// extension del archivo 
	//echo $extension."<br />";
	

/*
	if(!in_array(strtolower($extension), $allowed)){
		$contenido="error de archivo solo tipo xls";
		fwrite($fp,$contenido);
		fclose($fp) ;

		echo '{"status":"error","f":0}';
		exit;
	}*/

	//echo $aux;
	//echo "<pre>";
	//print_r($_FILES);//informacion sobre el archivo
//	if(move_uploaded_file($_FILES['upl']['tmp_name'], '../../administracion/UPLOADS/'.$id.$_FILES['upl']['name'])){
//	$nombre_completo = strtoupper($nombre_parcial.$_FILES['upl']['name']);
	$nombre_completo = strtoupper($nombre_parcial.".".$extension);
	
	$direccion = '../../administracion/UPLOADS/'.$nombre_completo;
	if(move_uploaded_file($_FILES['upl']['tmp_name'], $direccion)){
//	if(move_uploaded_file($_FILES['upl']['tmp_name'], '../../../uploads/'.$aux)){
		//proceso de grabado 
		//$ff = $_SESSION['ff'];
		if (1==1){
			//$ff = "'".$ff."'";
			//$user = "'".$user."'";
			$_SESSION['upload']="UPLOADS/".$nombre_completo;
				//echo $_SESSION['upload'];
			//$sql ="INSERT INTO  tmp_adjunto(FECHA,ID_USUARIO,ARCHIVO)	VALUES	(";
			//$sql.=" $ff,$user,$archivo);";
			//echo $sql."<br />";
			//$conexion = new database;
			//$conexion->conectar($database,$hostname,$username,$password);
			//if ($conexion->consultar($sql,2,1)!=-1){
			//	$_matriz['fila_afectada']=$conexion->fila_afectada();
			$contenido="ARCHIVO SUBIDO EXITOSAMENTE";
			fwrite($fp,$contenido);
			fclose($fp) ;
			
				echo '{"status":"success","f":1}';
				exit;

			//}else{
			//	$_matriz['fila_afectada']=-1;
			//	echo '{"status":"error","f":4}';
			//	exit;
						
			//}	
			
		}else{
			$contenido="error las cabezeras de las columasn no son correctas : NUMERO_FACTURA , RUC, TIPO_GASTO,FECHA,TOTAL_GASTO,NOMBRE_PROVEEDOR";
			fwrite($fp,$contenido);
			fclose($fp) ;
			echo '{"status":"success","f":3}';
			exit;
		}
		
	}
}

$contenido="error general de parametros ";
fwrite($fp,$contenido);
fclose($fp) ;

echo '{"status":"error","f":2}';
exit;