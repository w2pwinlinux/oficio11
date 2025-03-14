<?php 
if (isset($_SESSION)){}else{session_start();} 

require_once('lib_autoload.php');

//pf($_REQUEST,1);// text_body,title,tipo

$header="";
$body = "";
$footer ="";
$htmli = "";
$htmlf="";

$body = isset($_REQUEST['text_body']) ? $_REQUEST['text_body'] : "ADD DETALLES";
$body = str_replace(" ","+",$body);

$body = b64d($body);
//echo $body;


$body = str_replace("<table>",'<table id="tabla_reporte" border="1" cellpadding="1" cellspacing="1" width="100%" align="left">',$body);

//pf($_REQUEST,1);

$title = isset($_REQUEST['title']) ? $_REQUEST['title'] : "REPORTE";
$firma = isset($_REQUEST['firma']) ? intval($_REQUEST['firma']) : 0;
$extra = isset($_REQUEST['extra']) ? intval($_REQUEST['extra']) : 0;
$tipo = isset($_REQUEST['tipo']) ? $_REQUEST['tipo'] : "pdf";

//exit($title);

$htmli.='
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><BODY ><br><br>';
$header='<table width="100%" border="0" cellspacing="5" cellpadding="5">';
if ($tipo=="pdf"){
	$header.='<tr>
	<td width="50px" colspan="2" style="text-align:left;"></td>
	<td colspan="11" style="text-align:center;font-family:sans-serif;font-size:24px; font-weight:bold">SISTEMA</td>
	<td width="50px" colspan="2" style="text-align:right;"></td>
	</tr>';
}
	
$header.='
<tr>
<td colspan="15" style="text-align:center;	font-family: sans-serif;font-size: 12px; font-weight:bold">'.utf8_encode($title).'</td>
</tr></table>';	
$footer ='<pagebreak />
<table width="100%" border="0" cellspacing="5" cellpadding="0">
<tr >
<td  colspan="15" style="font-weight:bold;text-align:CENTER;font-size:15px"><br /><br />FIRMAS<br /><br /><br /></td>
</tr>
<tr>
<td  colspan="6" style="font-weight:bold;text-align:CENTER">_________________________</td>
<td></td>
<td></td>
<td></td>
<td colspan="6" style="font-weight:bold;text-align:CENTER">__________________________</td>
</tr>
<tr >
<td  colspan="6"  style="font-weight:bold;text-align:CENTER;font-size:15px "></td>
<td></td>
<td></td>
<td></td>
<td colspan="6"  style="font-weight:bold;text-align:CENTER;font-size:15px">
</td></table>';
$htmlf.= '</BODY></HTML>';
	
if ($firma==1){
	$html = $htmli.$header.$body.$footer.$htmlf;
}else{
	$html = $htmli.$header.$body.$htmlf;
}

//$tipo = "html";

tipo_reportes($tipo,$html,0,0);

