<?php if (!isset($_SESSION)) {	session_start();}
error_reporting(E_ALL ^ E_NOTICE);
require_once 'excel_reader2.php';
require_once("../../../funciones/tools.php");

require_once('../../../Connections/contabilidad.php');
require_once('../../../jquery/model/database.php');

// A list of permitted file extensions
//$allowed = array('xls', 'jpg', 'gif','zip','doc','docx');
$allowed = array('xls');

$aux  = '../../../uploads/'.$_FILES['upl']['name'];
$nombre = $aux.".txt";
if (file_exists($nombre)) unlink($nombre);
$fp=fopen($nombre,"x");



if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){

	$extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);// extension del archivo 



	if(!in_array(strtolower($extension), $allowed)){
		$contenido="error de archivo solo tipo xls";
		fwrite($fp,$contenido);
		fclose($fp) ;

		echo '{"status":"error","f":0}';
		exit;
	}
//	print_r($_REQUEST);exit();
//	echo $aux;
	$anio = validaDatos($_REQUEST['anio'],"int");
	if(move_uploaded_file($_FILES['upl']['tmp_name'], '../../../uploads/'.$_FILES['upl']['name'])){
//	if(move_uploaded_file($_FILES['upl']['tmp_name'], '../../../uploads/'.$aux)){
		//proceso de grabado 
		$data = new Spreadsheet_Excel_Reader($aux);
		$fila =$data->value(1,A);
		$filab = $data->value(1,B);
		$filac =$data->value(1,C);
		$filad = $data->value(1,D);
		$matriz = array();
		$ESTADO =2;
					
		if ($fila =="FRACCION_BASICA" and $filab =="EXCESO_HASTA" and $filac=="IMPUESTO_FRACCION_BASICA" and $filad=="IMPUESTO_FRACCION_EXCEDENTE"){
			
			
			
			$sql ="INSERT INTO tabla_impuestos (FRACCION_BASICA, EXCESO_HASTA, IMPUESTO_FRACCION_BASICA, IMPUESTO_FRACCION_EXCEDENTE, ANIO) VALUES	";
//			print_r($data->value(3,A));
//			print_r($data->value(3,B));
//			print_r($data->value(3,C));
//			print_r($data->value(3,D));
			
			for ($i=2;$i<=$data->rowcount()-1;$i++){
				$fb = validaDatos($data->value($i,A),"double");
				$eh = validaDatos($data->value($i,B),"double");
				$ifb = validaDatos($data->value($i,C),"double");
				$ife = validaDatos($data->value($i,D),"double");
				if ($i==$data->rowcount()-1){
					$sql.="( ".$fb.",".$eh.",".$ifb.",".$ife.",".$anio.")";
				}else{
					$sql.="( ".$fb.",".$eh.",".$ifb.",".$ife.",".$anio."),";
				}
			}
//			echo $sql."<br />";
			$conexion = new database;
			$conexion->conectar($database,$hostname,$username,$password);
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
			
		}else{
			$contenido="error las cabezeras de las columasn no son correctas : FRACCION_BASICA,";
			$contenido.="EXCESO_HASTA,IMPUESTO_FRACCION_BASICA,IMPUESTO_FRACCION_EXCEDENTE";
			$contenido.=$fila.$filab.$filac.$filad;
			fwrite($fp,$contenido);
			fclose($fp) ;
			echo '{"status":"error","f":2}';
			exit;
		}
		
	}
}

$contenido="error general de parametros ";
fwrite($fp,$contenido);
fclose($fp) ;

echo '{"status":"error","f":2}';
exit;