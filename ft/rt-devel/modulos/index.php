<?PHP
require_once('../../../../../framework/nusoap/lib/nusoap.php');
require_once("modulos/poo_arweb.php");
include "log/md_log.php";
//include "modulos/registro.php";
include ("get_perfil.php");



$portal = new genWeb();
$baner = $portal->getBaner();
$destacado = $portal->getDestacado();
print_r($baner);
print_r($destacado);

$portal_perfil = get_perfil($_SERVER['HTTP_USER_AGENT']);
/*if($portal_perfil=="smartphone"){  $css="portalsmartphone.css";}	
if($portal_perfil=="avanzado"){ $css="portalavanzado.css";} 	
if($portal_perfil=="basico") header( 'Location: basico.php' );	
if($portal_perfil=="iphone"){  $css="portaliphone.css";}*/
if($portal_perfil=="intermedio") $css="wap.css";
	
	
if(isset($_SERVER['HTTP_X_UP_CALLING_LINE_ID']) && $_SERVER['HTTP_X_UP_CALLING_LINE_ID'] != "")
{
	$str_number = $_SERVER['HTTP_X_UP_CALLING_LINE_ID'];
}
else
{
	$str_number = $_GET['nu'];	
	if(strlen($str_number)<11){$str_number="51".$str_number; $validar_sms=true;}

}
$nuetxt="";
if(isset($_GET['nue']))
{
	$nue = $_GET['nue'];	$validar_sms=false;
	if(strlen($nue)<11){$nue="51".$nue; }
	$nuetxt="&amp;nue=".$nue;

}

if(isset($_GET['validar_sms']) && $_GET['validar_sms']!="" )
{
	$validar_sms=$_GET['validar_sms'];
}
	
if( $validar_sms==true)	$val_sms=1;
else  $val_sms=0;
				$wsCliente='http://174.121.234.90/moso/WSMultimedia/wsRT.asmx?wsdl';
				$operadora='1';	
				$album="41";
				$keyword="_FTWAP";
				$filasxPagina="11";
				$numPagina="0";
				
				$SoapClient=new nusoap_client($wsCliente,true);
				if ($Error = $SoapClient->getError()) {
				   echo "No se pudo realizar la operaci&oacute;n de conexi&oacute;n[" . $Error . "]"; 
				   die(); 
				}
				if ($SoapClient->fault) { // Si
					echo 'No se pudo completar la operaci&oacute;n ...';
					die();
				} else { // No
					$aError = $SoapClient->getError();
					// Hay algun error ?
					if ($Error) { // Si
					echo 'Error:' . $Error;
					die();
					}
				}

$Parametros = array('operadora'=>$operadora,'album'=>$album,'keyword'=>$keyword,'filasxPagina'=>$filasxPagina,'numPagina'=>$numPagina); 
				//print_r( $Parametros);
				$Respuesta = $SoapClient->call("wsRTConsultarAlbum", $Parametros); 
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

?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">


<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">-->
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Movistar - M&uacute;sica</title>
<link rel="shortcut icon" href="img/favicon.ico">	
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
<meta name="description" content="Portal WAP - Movistar  M&uacute;sica" />
<meta property="og:site_name" content="Portal WAP - Movistar  M&uacute;sica" />
<meta property="og:image" content="http://www.moso.pe/img/moso-logo.png" />
<!--<meta property='fb:app_id' content='196218137082996' />-->

<!-- CSS -->
<link rel="stylesheet" media="screen" href="css/main.css" />
<!--[if IE 6]><link rel="stylesheet" media="screen" href="css/ie6.css" /><![endif]-->
<!--[if IE 7]><link rel="stylesheet" media="screen" href="css/ie7.css" /><![endif]-->

<!-- Media Queries -->
<link rel="stylesheet" media="screen and (max-width: 900px)" href="css/pad.css" />
<link rel="stylesheet" media="handheld and (max-width: 400px), screen and (max-device-width: 400px),screen and (max-width: 400px)" href="css/mobile.css" />
<? if($css!=''){?>
<link rel='stylesheet' type='text/css' href='css/<?=$css;?>' />
<? } ?>
<!-- google analytics - NO BORRAR -->	
		<script type="text/javascript">
		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-18739622-1']);
		  _gaq.push(['_trackPageview']);
	
		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();

		</script>
<!-- fin de google analytics -->	

</head>
<body>
<div id="page">
  <div id="head">Club de M&uacute;sica</div>
  <div id="destacado">
  
   <?PHP
				list($clave, $b2) = each($Respuesta);
				list($clave, $b3) = each($b2);
				$secuence = 1;
				foreach($b3 as &$valora){
					if($valora["Sequence"]==1 || $valora["Sequence"]==2)
					{	
					$secuence = $valora["Sequence"];
					//echo $secuence;
					$cd=$valora["CodigoRBT"];

					
					?>	
  
  <img src="img/destacado.jpg"   height="59" alt="destacado_movistar_fulltrack" /> 
  
  
  
  <a href="http://bip.pe/pe/mo/wap/ft/validacion.php?v=<?=$val_sms;?>&c=<?=$cd."".$nuetxt;?>&t=<?=$_GET["t"];?>&f=<?=$_GET["f"];?>&i=<?=$_GET["i"];?>" ><?=$valora["Tema"];?><span><?=$valora["Artista"];?></span></a>
  
  
  	 <?PHP
						break; 	 	
					}
				}
				

?>	

    <div style="clear:both"></div>
  </div>
  <div id="list-titulo-precio">Suscr&iacute;bete para bajar todas las canciones que quieras de principio a fin por solo S/.3.30 a la semana. El tr&aacute;fico de datos de este portal no tiene costo y no descontar&aacute; tu saldo prepago.</div>
  <div id="list-titulo">Top 10</div>
  <div id="list-musica">
  
  
     <?PHP
				 $count = 1;
				foreach($b3 as &$valora){

					if($valora["Sequence"]!= $secuence && $count < 11)
					{	
					$rowalter = '';
					if ($count%2==0)
						$rowalter=" odd";
					?>	
  
  
    <div class="list-item<?=$rowalter;?>"> <span class="numero"><?=$count;?>.</span> <a href="http://bip.pe/pe/mo/wap/ft/validacion.php?v=<?=$val_sms;?>&c=<?=$valora["CodigoRBT"]."".$nuetxt;?>&t=<?=$_GET["t"];?>&f=<?=$_GET["f"];?>&i=<?=$_GET["i"];?>"><?=$valora["Tema"];?> <span><?=$valora["Artista"];?></span></a><a href="http://bip.pe/pe/mo/wap/ft/validacion.php?v=<?=$val_sms;?>&c=<?=$valora["CodigoRBT"]."".$nuetxt;?>&t=<?=$_GET["t"];?>&f=<?=$_GET["f"];?>&i=<?=$_GET["i"];?>" class="descarga"></a>
      <div style="clear:both"></div>
    </div>
    
    	
					 <?PHP
						$count = $count + 1; 	
					}
				}
				

?>	
  
   
     
  </div>
  <div id="footer"><!--<a href="http://myHomePage">&lt; Volver</a> |--> <a href="legal.php">Legal</a></div>
</div>
</body>
</html>


<!--      
</div> 
    <div class="verde"></div>
	<div class="verde"></div>
	<div class="link bg-c">
    <div class="esp10">
	<a href="http://myHomePage">&lt; Volver</a>
    </div>
	</div>
			
 
<div class="item_legal">
	<a href="legal.php">Legal</a>
</div> 

</div>
  			
  		
	
</div></body></html>-->