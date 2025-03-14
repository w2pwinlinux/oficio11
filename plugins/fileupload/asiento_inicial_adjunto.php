<?php if (!isset($_SESSION)) {	session_start();}
//echo "<pre>";	print_r($_SESSION);
error_reporting(E_ALL ^ E_NOTICE);
require_once 'excel_reader2.php';
require_once('../../administracion/Connections/sistema.php');
require_once('../../administracion/jquery/model/class.medoo.php');
require_once("../../administracion/jquery/funcion/tools.php");
require_once("../../administracion/jquery/funcion/parametros.php");


// A list of permitted file extensions
//$allowed = array('xls', 'jpg', 'gif','zip','doc','docx');
$allowed = array('xls');
//echo "<pre>";print_r($_FILES);
$aux  = '../../administracion/UPLOADS/'.$_FILES['upl']['name'];
$nombre = $aux.".txt";
$user = $_SESSION['users'];
$ff = $_SESSION['fecha_ingreso'];
$cuenta_cargar= $_SESSION['cuenta_cargar'];
$nombre_parcial = base64_encode($ff);
//echo "<pre>";print_r($_SESSION);exit();
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

	//echo $aux;
	//echo "<pre>";
	//print_r($_FILES);//informacion sobre el archivo
//	if(move_uploaded_file($_FILES['upl']['tmp_name'], '../../administracion/UPLOADS/'.$id.$_FILES['upl']['name'])){
//	$nombre_completo = strtoupper($nombre_parcial.$_FILES['upl']['name']);
	$nombre_completo = strtoupper($nombre_parcial.".".$extension);
	
	$direccion = '../../administracion/UPLOADS/'.$nombre_completo;
	if(move_uploaded_file($_FILES['upl']['tmp_name'], $direccion)){
		$data = new Spreadsheet_Excel_Reader($direccion);
		$fila =$data->value(1,A);
		$filab = $data->value(1,B);
		if (1==1){
			$cuenta = $_SESSION['cuenta_cargar'];
			$cuenta = valida_datos($cuenta,"text");
			$tt =0;
			$descripcioni ="ASIENTO.INICIAL DE LA CUENTA :".$cuenta_cargar;
			$descripcion = valida_datos($descripcioni,"text");
			
			$debe = 0;
			$haber = 0;
			$saldo = 0;
			$tipo = valida_datos("ASIENTO.INICIAL","text");
			$id_empresa = $_SESSION['ID_EMPRESA'];
			$id_usuario  = valida_datos($_SESSION['USUARIO'],"text");;
			$cerrado = 0;
			$estado =2;
			$fecha_sistema = valida_datos($_SESSION['FECHA_SISTEMA_USUARIO'],"text");
			$procesar = 0;
			$insertar_diario = 0;
			if ($cuenta_cargar == "1.1.2.4.1.1"){//inversionsitas
				//echo "inversionistas";echo $tt."<br />";
				for ($i=2;$i<=$data->rowcount();$i++){
					$ced = valida_datos($data->value($i,A),"text");
					$mon = valida_datos($data->value($i,B),"double");
					$tt += $mon;
					//echo $tt."<br />";
				}
				$debe = 0;
				$haber = $tt;
				$procesar = 1;
				$insertar_diario = 1;
			}
			if ($cuenta_cargar=="1.1.1.3"){//bancos
				for ($i=2;$i<=$data->rowcount();$i++){
					$ced = valida_datos($data->value($i,A),"text");
					$mon = valida_datos($data->value($i,B),"double");
					$tt += $mon;
				}
				$debe = 0;
				$haber = $tt;
				$procesar = 1;
				$insertar_diario = 1;
			}
			if ($cuenta_cargar=="1.1.2.1.1.1"){//cuentas por cobrar 
				$cnc = new consumomedoo($hostname,$database,$username,$password,$port);
				$cnd = new consumomedoo($hostname,$database,$username,$password,$port);
				$cnf = new consumomedoo($hostname,$database,$username,$password,$port);
				$cn = new consumomedoo($hostname,$database,$username,$password,$port);
				$rr = "MENSAJE AL IMPORTAR DATOS :";
				$descripcioni = "POR ASIENTO INICIAL";
				$numero_factura = 1;
				$sql  = "CALL SP_SELECT_ID_AUTORIZACION_AI($id_empresa)";
				$cn->execute($sql,0,0);
				if($cn->filas_afectada()>0){
					$mm1 = $cn->datos();
					$id_autorizacion = $mm1[0]['ID'];
				}else{
					echo '{"status":"error:".$cn->mensaje(),"f":-1}';exit();
				}
				//echo $id_autorizacion."<br />";exit();
					
				for ($i=2;$i<=$data->rowcount();$i++){
					$tipo_documento = valida_datos($data->value($i,A),"text");
					$documento = valida_datos($data->value($i,B),"text");
					$nombre = valida_datos($data->value($i,C),"text");
					$apellido = valida_datos($data->value($i,D),"text");
					
					$nombre2 = $data->value($i,C);
					$apellido2 = $data->value($i,D);
					
					$valor = valida_datos($data->value($i,E),"double");
					$descripcion_interna = $data->value($i,F);
					$correo =valida_datos("ejemplo@bioimageneslab.com","text");//ISERCIONDE CLIENTES 
					$sql="CALL SP_SELECT_CLIENTE_INSERT_CLIENTE_AI($documento,$tipo_documento,$nombre,$apellido,$correo,1,1,$id_empresa)";
					$cnc->execute($sql,0,0);
					if ($cnc->filas_afectada()>=1){
						$matriz = $cnc->datos();			
						$rr.='<br>Con datos tipo:'.$tipo." documento:".$documento." se obtuvo de resultado :".$matriz[0][1];
					}else{
						echo '{"status":"error".$cnc->mensaje(),"f":-1}';
					}
					if ($matriz[0]['FILA_AFECTADA']>=0){
						//echo $rr."<br />";exit();
						$descripcion=$descripcioni." con datos : ".$descripcion_interna." de la persona : ".$nombre2." ".$apellido2;
						$descripcion = valida_datos($descripcion,"text");
						$tt+=$valor;
						$debe = $valor;
						$haber = 0;
						$saldo = $debe-$haber;
						$saldo =abs($saldo);
						if ($saldo>0){
							//INSERT EN EL DIARIO DE LAS DEUDAS 
							$sql = "CALL SP_INSERT_DIARIO_AI($cuenta,$descripcion,$debe,$haber,$saldo,$tipo,$id_empresa,$id_usuario,$cerrado,$fecha_sistema,$estado)";
							$cnd->execute($sql,1,0);
							$fechai = fecha();
							$horai = hora();
							$estadoi =2;
							//INSERCION DE LAS FACUTRAS 
							
							$sql = "CALL SP_SELECT_NUMERO_FACTURA_AI($id_empresa)";
							$desci = valida_datos('ASIENTO.INICIAL',"text");
							$sql="CALL SP_SELECT_FACTURA_VENTA_INSERT_AI(1,$id_autorizacion,$id_usuario,$documento,";
							$sql.="$fechai,$horai,0,0,0,0,0,$valor,$estadoi,$fecha_sistema,$desci,$id_empresa)";
							$cnf->execute($sql,1,0);
							sleep(1);
						}else{
							$rr .= "DATOS SIN VALOR DE ";
						}
					}else{
						$rr = "ERROR POR FAVOR VERIQUE LOS DATOS DE :".$documento." CON TIPO :".$tipo_documento;
						break;
						
					}
				}
				$procesar=1;
				$insertar_diario =0;
				//echo '{"status":"success".$rr,"f":1}';
				//echo $tt."<br />";
				
			}
			//para material de oficina y mercaderias
			if (($cuenta_cargar=="1.2.1.3.1") or ($cuenta_cargar=="1.1.3.1.1.1")){
				echo $cuenta_cargar."<br />";
				$tt=0;
				$cnp = new consumomedoo($hostname,$database,$username,$password,$port);

				for ($i=2;$i<=$data->rowcount();$i++){
					$id = valida_datos($data->value($i,A),"text");
					$nombre = valida_datos($data->value($i,B),"text");
					
					$descripcion = valida_datos($data->value($i,C),"text");
					$stock = valida_datos($data->value($i,D),"int");
					$valor_unitario = valida_datos($data->value($i,E),"double");
					$medida =valida_datos($data->value($i,F),"text");
					$icuenta_cargar = valida_datos($cuenta_cargar,"text");
					$tt += $valor_unitario*$stock;
					$sql = "CALL SP_INSERT_PRODUCTO_AI($id,$nombre,$descripcion,$stock,$valor_unitario,$medida,$id_empresa,$icuenta_cargar)";
					$cnp->execute($sql,0,0);
					if ($cnp->filas_afectada()>=1){
						$matriz = $cnp->datos();			
						$rr.='<br>Con datos de biens:'.$nombre." stock:".$stock." se obtuvo de resultado :".$matriz[0][1];
					}else{
						echo '{"status":"error"'.$cnp->mensaje().',"f":-1}';
					}
					
					$tt += $vu;
					
					
					
				}
				$debe = $tt;
				$haber = 0;
				$procesar =1;
				$insertar_diario = 1;
				$descripcion = valida_datos($descripcioni,"text");
			}
			//echo $procesar."<br />";echo $insertar_diario."<br />";exit();
			if ($procesar==1){// si procesada en alguna opcion
				if ($insertar_diario ==1){//si se debe o no hacer el asiento inicial
					$saldo = $debe-$haber;
					$saldo =abs($saldo);
					if ($saldo>0){
						$sql = "CALL SP_INSERT_DIARIO_AI($cuenta,$descripcion,$debe,$haber,$saldo,$tipo,$id_empresa,$id_usuario,$cerrado,$fecha_sistema,$estado)";
						$cn = new consumomedoo($hostname,$database,$username,$password,$port);
						$matriz = $cn->execute($sql,0,0);
						if ($cn->filas_afectada()>=1){
							$_SESSION['upload']="UPLOADS/".$nombre_completo;
							$contenido="ARCHIVO SUBIDO EXITOSAMENTE";
							//echo $contenido."<br />";
							echo '{"status":"success","f":1}';
						}else{
							echo $cn->mensaje()."<br />";
							echo '{"status":"error","f":-1}';
						}
					}else{
						$contenido="DATOS SIN VALOR POR FAVOR VERIFIQUE";
						echo '{"status":"error","f":1}';
					}
				}else{
					$contenido="ARCHIVO SUBIDO , RESULTADOS :".$rr;
					echo '{"status":"success","f":1,"resultados":'.$contenido.'}';
					
					
				}
				//echo $nombre_completo."<br />";
				$nombre_completo = valida_datos($direccion,"text");//conq archivo se cargo los datos
				$sql = "CALL SP_INSERT_ASIENTO_INICIAL($cuenta,$nombre_completo,$id_empresa)";
				$cn = new consumomedoo($hostname,$database,$username,$password,$port);
				$matriz = $cn->execute($sql,0,0);
				
			}else{
				echo '{"status":"error","f":-2}';
			}
			fwrite($fp,$contenido);
			fclose($fp) ;
			exit;
		}else{
			$contenido="error las cabezeras de las columasn no son correctas";
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