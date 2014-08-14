<?php
include "log/md_log.php";
require_once('../../../../framework/nusoap/lib/nusoap.php');

$v=isset($_GET['v'])?$_GET['v']:"1";
$c=isset($_GET['c'])?$_GET['c']:header("Location: http://bip.pe/pe/ne/wap/ft/")&&die();

$t=isset($_GET['t'])?$_GET['t']:header("Location: http://bip.pe/pe/ne/wap/ft/")&&die();
$f=isset($_GET['f'])?$_GET['f']:header("Location: http://bip.pe/pe/ne/wap/ft/")&&die();

function shootLink($NUMBER,$CODIGO,$VERIFICATION){

        if ((strlen($NUMBER) == 11) and (substr($NUMBER, 0, 2) == "51")) {

	$xml = file_get_contents("http://174.121.234.90/Moso/WSMultimedia/wsTOOLS.asmx/RegistrarDescarga?operadora=3&numUser=" . $NUMBER . "&idContenido=0&catalogo=" . $CODIGO . "&esGratis=False");
		$x = new SimpleXMLElement($xml);
		$ID=$x;
		getPutsDescargaLOG("http://174.121.234.90/mvpe/Baja.aspx",$ID,$NUMBER,$CODIGO );
		
		$f= $_GET['f'];
		$c= $_GET['c'];
		if(is_numeric($f) &&  $f==0){
			$t= $_GET['t'];
			$i= $_GET['i'];
			if(is_numeric($t) &&  $t!=0)
				validarTarifa(3, '4556', $c, $t, $i);
		}
		
		
		header("Location: http://174.121.234.90/nxpe/Baja.aspx?id=". $ID);	
} else {
    header("Location: index.php");exit;
}
		
}
	if(isset($_SERVER['HTTP_X_UP_CALLING_LINE_ID']) && $_SERVER['HTTP_X_UP_CALLING_LINE_ID'] != ""){
			$str_number = $_SERVER['HTTP_X_UP_CALLING_LINE_ID'];
			shootLink($str_number,$c,"0");
	}
	if(isset($_SERVER['HTTP_MSISDN']) && $_SERVER['HTTP_MSISDN'] != ""){
			$str_number = $_SERVER['HTTP_MSISDN'];
			shootLink($str_number,$c,"0");
	}  
	if (isset($_SERVER['HTTP_X_UP_SUBNO']) && $_SERVER['HTTP_X_UP_SUBNO'] != "") {
    	            $dosG = $_SERVER['HTTP_X_UP_SUBNO'];
		    $url = file_get_contents("http://wsperu.multibox.pe/ws-nextel.php?nextel-2g=$dosG");
		    $conteDosG = json_decode($url);
		    $str_number = "51" . $conteDosG->PTN;
		    shootLink($str_number, $c, "0");
	}
	if (isset($_SERVER['HTTP_COOKIE']) && $_SERVER['HTTP_COOKIE'] != "") {
	    $b = strpos($_SERVER['HTTP_COOKIE'], "msisdn=")+7;
	if ($b != "7") {
	    $num = substr($_SERVER['HTTP_COOKIE'], $b);
	    $str_number = $num;
	    shootLink($str_number, $c, "0");
	}
	}

/* Numero con el I*/      
if (isset($_GET['i']) && strlen($_GET['i']) > 0) {
    $token = $_GET['i'];
    $url = 'http://174.121.234.90/Moso/Cript/process.aspx?d1=' . $token;
    $content = file_get_contents($url);
    $separador = "|";
    $parametros = explode($separador, $content);    

    $tnun = (is_numeric($parametros[0]) ? (int) $parametros[0] : 0);
    $fecha = (is_numeric($parametros[1]) ? (int) $parametros[1] : 0);
    $tcad = (is_numeric($parametros[3]) ? (int) $parametros[3] : 0);    

$now= date("Y-m-d");
$fechaVen = date("Y-m-d", strtotime("$fecha + $tcad day"));
if ($now > $fechaVen)
    header( 'Location: index.php' );
else 
    shootLink($tnun, $c, "0");    
}

/*fin */
        
        
	if(isset($_GET['nue'])){
		$number=$_GET['nue'];
		if( ( strlen($number)==11 ) ){
			if( substr($number,0,2) =="51" ){
				shootLink($number,$c,"0");
				
			}
		}elseif( strlen( $number ) == 9 ){
			if( substr($number,0,2) !=="51" ){
				shootLink("51" . $number,$c,"0");
			}
		}
	}
	
	
	if(isset($_GET['num'])){
		$number=$_GET['num'];
		if( ( strlen($number)==11 ) ){
			if( substr($number,0,2) =="51" ){
				shootLink($number,$c,"1");
			}
		}elseif( strlen( $number ) == 9 ){
			if( substr($number,0,2) !=="51" ){
				shootLink("51" . $number,$c,"1");
			}
		}
	}
	/*include("get_perfil.php");
	$portal_perfil = get_perfil($_SERVER['HTTP_USER_AGENT']);
	
	if($portal_perfil=="smartphone") $css="portalsmartphone.css";
	
	if($portal_perfil=="avanzado") $css="portalavanzado.css";

	if($portal_perfil=="intermedio") $css="portalintermedio.css";

	if($portal_perfil=="iphone") $css="portaliphone.css";*/
	function validarTarifa($operadora, $numServ, $catalogo, $tarifa, $codigoEncriptado){
				
			$wsCliente='http://174.121.234.90/moso/WSMultimedia/wstools.asmx?wsdl';

			$SoapClient=new nusoap_client($wsCliente,true);
			if ($Error = $SoapClient->getError()) {
			   echo "No se pudo realizar la operaci&oacute;n de conexi&oacute;n[" . $Error . "]"; 
			   echo "<body></body></html>"; 
			   die(); 
			}
			if ($SoapClient->fault) { // Si
				echo 'No se pudo completar la operaci&oacute;n ...';
				echo "<body></body></html>"; 
				die();
			} else { // No
				$aError = $SoapClient->getError();
				// Hay algun error ?
				if ($Error) { // Si
				echo 'Error:' . $Error;
				echo "<body></body></html>"; 
				die();
				}
			}

			$Parametros = array('operadora'=>$operadora,'numServ'=>$numServ,'catalogo'=>$catalogo,'tarifa'=>$tarifa,'codigoEncriptado'=>$codigoEncriptado); 
			//print_r( $Parametros);
			$Respuesta = $SoapClient->call("RegistrarLicenciaMultimedia", $Parametros); 
			//print_r($Respuesta);
			if ($SoapClient->fault) { // Si
				echo 'No se pudo completar la operaci&oacute;n, por favor ingrese un texto a buscar.';
				die();
			} else { // No
				$Error = $SoapClient->getError();
				// Hay algun error ?
				if ($Error) { // Si
				echo 'Error:' . $Error;
				die();
				}
			}
	}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Nextel - M&uacute;sica</title>
<link type="image/x-icon" rel="shortcut icon"  href="img/favicon.ico">	
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
<meta name="description" content="Portal WAP - Nextel  M&uacute;sica" />
<meta property="og:site_name" content="Portal WAP - Nextel  M&uacute;sica" />
<meta property="og:image" content="http://www.moso.pe/img/moso-logo.png" />
<!--<meta property='fb:app_id' content='196218137082996' />-->

<!-- CSS -->
<link rel="stylesheet" media="screen" href="css/main.css" />
<!--[if IE 6]><link rel="stylesheet" media="screen" href="css/ie6.css" /><![endif]-->
<!--[if IE 7]><link rel="stylesheet" media="screen" href="css/ie7.css" /><![endif]-->

<!-- Media Queries -->
<link rel="stylesheet" media="screen and (max-width: 900px)" href="css/pad.css" />
<link rel="stylesheet" media="handheld and (max-width: 400px), screen and (max-device-width: 400px),screen and (max-width: 400px)" href="css/mobile.css" />
</head><body>
<div id="page">
  <div id="head">Club de M&uacute;sica</div>
  
 <div id="list-titulo-precio"> Introduce tu n&uacute;mero de nextel y haz clic en &quot;Enviar&quot;</div>
  <div id="list-musica" style="padding:20px; border:solid 0px red;">
	 <form name="frm" action="http://bip.pe/pe/ne/wap/ft/validacion.php" method="GET">
	<div style=""><input id="id_num" type="text" name="num" class="c-filtro" /><input type="hidden" name="c" value="<?=$c;?>" /><input type="hidden" name="v" value="<?=$v;?>" /></div>
<?php
	echo $body;
?>
	<input type="submit" class="btn-ancho" value="Enviar" />
	</form> 
  </div>
  <div id="footer"><a href="legal.php">Legal</a></div>
</div>
</body>
</html>
