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

//	echo $aux;
	if(move_uploaded_file($_FILES['upl']['tmp_name'], '../../../uploads/'.$_FILES['upl']['name'])){
//	if(move_uploaded_file($_FILES['upl']['tmp_name'], '../../../uploads/'.$aux)){
		//proceso de grabado 
		$data = new Spreadsheet_Excel_Reader($aux);
		$fila =$data->value(1,A);
		$filab = $data->value(1,B);
		$filac =$data->value(1,C);
		$filad = $data->value(1,D);
		$filae =$data->value(1,E);
		$filaf = $data->value(1,F);
		$matriz = array();
		$IDGP = $_SESSION['IDGP'];
		$ESTADO =2;
		if ($fila =="NUMERO_FACTURA" and $filab =="RUC" and $filac=="TIPO_GASTO" and $filad=="FECHA" and $filae== "TOTAL_GASTO" and $filaf=="NOMBRE_PROVEEDOR"){
			$sql ="INSERT INTO FACTURAS (NUMERO_FACTURA, RUC, TIPO_GASTO, FECHA,TOTAL_GASTO,  IDGP, ESTADO, NOMBRE_PROVEEDOR	)	VALUES	";
			for ($i=2;$i<=$data->rowcount();$i++){
				$numero_factura = validaDatos($data->value($i,A),"text");
				$ruc = validaDatos($data->value($i,B),"text");
				$tipo_gasto = validaDatos($data->value($i,C),"text");
				$fecha = validaDatos($data->value($i,D),"date");
				$total = validaDatos($data->value($i,E),"double");
				$nombre_proveedor = validaDatos($data->value($i,F),"text");
				if ($i==$data->rowcount()){
					$sql.="( ".$numero_factura.",".$ruc.",".$tipo_gasto.",".$fecha.",".$total.",".$IDGP.",".$ESTADO.",".$nombre_proveedor.")";
				}else{
					$sql.="( ".$numero_factura.",".$ruc.",".$tipo_gasto.",".$fecha.",".$total.",".$IDGP.",".$ESTADO.",".$nombre_proveedor."),";
				}
			}
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