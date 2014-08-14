<?php
//require_once('../../../../framework/nusoap/lib/nusoap.php');
require_once('../../nusoap/lib/nusoap.php');
//require_once('nusoap/lib/nusoap.php');
require_once("modulos/poo_arweb.php");
include "log/md_log.php";
//include "modulos/registro.php";
include ("get_perfil.php");

$portal = new genWeb();
$BANERs = $portal->getBaner();
$DESTACADOs = $portal->getDestacado();
$BODYs = $portal->getCuerpo();
$TituloPortal = $portal->getTituloPortal();
//print_r($baner);
//print_r($destacado);

$portal_perfil = get_perfil($_SERVER['HTTP_USER_AGENT']);
/*if($portal_perfil=="smartphone"){  $css="portalsmartphone.css";}	
if($portal_perfil=="avanzado"){ $css="portalavanzado.css";} 	
if($portal_perfil=="basico") header( 'Location: basico.php' );	
if($portal_perfil=="iphone"){  $css="portaliphone.css";}*/
if($portal_perfil=="intermedio") $css="wap.css";

function getContenido($metodo, $operadora, $album, $keyword, $filasxPagina, $numPagina){
	
	$wsCliente='http://174.121.234.90/moso/WSMultimedia/wsRT.asmx?wsdl';
	 
	$SoapClient=new nusoap_client($wsCliente,true);
        $SoapClient->decode_utf8 = false;
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
	$Respuesta = $SoapClient->call($metodo, $Parametros); 
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
	
	list($clave, $b2) = each($Respuesta);
	list($clave, $b3) = each($b2);
	if(is_vector($b3)== 0){
		$b3=$b2;
	}
	return $b3;
}


function is_vector( &$array ) { 
	if ( !is_array($array) || empty($array) ) { 
	  return -1; 
	} 
	$next = 0; 
	foreach ( $array as $k => $v ) { 
	  if ( $k !== $next ) return 0; 
	  $next++; 
	} 
	return 1; 
} 


	
/*if(isset($_SERVER['HTTP_X_UP_CALLING_LINE_ID']) && $_SERVER['HTTP_X_UP_CALLING_LINE_ID'] != "")
{
	$str_number = $_SERVER['HTTP_X_UP_CALLING_LINE_ID'];
}
else
{
	$str_number = $_GET['nu'];	
	if(strlen($str_number)<11){$str_number="51".$str_number; $validar_sms=true;}

}
$nuetxt="";*/
/*if(isset($_GET['nue']))
{
	$nue = $_GET['nue'];	$validar_sms=false;
	if(strlen($nue)<11){$nue="51".$nue; }
	$nuetxt="&amp;nue=".$nue;

}*/
if(isset($_GET['validar_sms']) && $_GET['validar_sms']!="" )
{
	$validar_sms=$_GET['validar_sms'];
}	
if( $validar_sms==true)	$val_sms=1;
else  $val_sms=0;

$nx = false; 
if(isset($_GET['nue']))
{
$nue = $_GET['nue'];
if(strlen($nue)==11)  $numx = $_GET['nue'];
if(strlen($nue)==9)   $numx = "51".$_GET['nue'];

}
				


if (isset($_GET['token']) and $_GET['token'] != '') {
$num = base64_decode($_GET['token']);
if ($num and (strlen($num) == 11) and (substr($num, 0, 2) == "51")) {

$web = "http://174.121.234.90/SVARequest/Request.aspx?nu=$num&op=3&su=1&sc=4556&k=t&o=24";    
    $result = file_get_contents($web);
    if ($result == 'OK') {
        header("Location: index.php") && die();
    }
}
}


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
if ($now > $fechaVen) {
	echo "vencio";
	header( 'Location: index.php' );
}

    
}



?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">

<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">-->
<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Nextel - M&uacute;sica</title>
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
          <div id="head"><?PHP echo $TituloPortal; ?></div>

         
          <?PHP if(count($DESTACADOs)>0) { ?>
         
           	  <?PHP foreach($DESTACADOs as $destacado){
			  $dataContenido = getContenido("wsRTConsultarAlbum","1","67","_RTWAP","1","0");
			  foreach($dataContenido as $item){	?>
            	<div id="destacado">
                    <img src="<?= $destacado["RUTAIMAGEN"]; ?>" alt="destacado" /> 
<!-- <a href="validacion.php?v=<?=$val_sms;?>&c=<?=$cd."".$nuetxt;?>&t=<?=$_GET["t"];?>&f=<?=$_GET["f"];?>&i=<?=$_GET["i"];?>" >-->
<a href="validacion.php?v=<?=$val_sms;?>&c=<?=$item["CodigoRBT"]."".$nuetxt;?>&t=<?=$_GET["t"];?>&f=<?=$_GET["f"];?>&i=<?=$_GET["i"];?>&nue=<?=$numx;?>">
                    <?=$item["Tema"];?><span><?=$item["Artista"];?></span>
                    </a>
                    <div style="clear:both"></div>
          		</div>  
                <?PHP }  ?>	
                 <div id="list-titulo-precio"><? echo  htmlspecialchars_decode  ($destacado["TEXTOENPORTAL"]);?></div>
            	<?PHP 
				 	} 
				  } ?>
				  <?php if (isset($_GET['error']) and ($_GET['error'] == "007")) {?>
				  <div id="list-titulo-precio" class="error">Estimado usuario usted no cuenta con saldo necesario o intentelo nuevamente.</div>
				  <?php }?>	
          
          
           <?PHP if(count($BODYs)>0) { ?> 
            	<?PHP foreach($BODYs as $body){ ?>		
          <div id="list-titulo"><?= $body["TITULOENPORTAL"];?></div>
           <div id="list-musica">
         <?PHP   $dataContenidoBody = getContenido("wsRTConsultarAlbum","1",$body["ALBUM"],$body["KEYWORD"],$body["FILASXPAGINA"],$body["NUMPAGINA"]);
		 $count = 1;
		  foreach($dataContenidoBody as $item){	
		  $rowalter = '';
					if ($count%2==0)
						$rowalter=" odd";
		  
		  ?>

 <div class="list-item<?=$rowalter;?>"> <span class="numero">
              <?=$count;?>.</span>
<a href="validacion.php?v=<?=$val_sms;?>&c=<?=$item["CodigoRBT"]."".$nuetxt;?>&t=<?=$_GET["t"];?>&f=<?=$_GET["f"];?>&i=<?=$_GET["i"];?>&nue=<?=$numx;?>">
              <?=$item["Tema"];?>
              <span>
              <?=$item["Artista"];?>
              </span></a><a href="validacion.php?v=<?=$val_sms;?>&c=<?=$item['CodigoRBT'].''.$nuetxt;?>&t=<?=$_GET['t'];?>&f=<?=$_GET['f'];?>&i=<?=$_GET['i'];?>&nue=<?=$numx;?>" class="descarga"></a>
              <div style="clear:both"></div>
            </div>


			 <?PHP $count = $count + 1; }  ?>	
          </div>
          <?PHP 
				 	} 
				  } ?>	
          
          
  <div style="margin:5px 10px 0 10px">
                  <a href="../ft">  <img width="100%" src="imagenes/banner-musica.gif"></a>
  </div>

          <div id="footer"><a href="http://m.tuyonextel.com.pe">&lt; Volver</a> | 
<a href="legal.php?v=<?=$val_sms;?>&t=<?=$_GET['t'];?>&f=<?=$_GET['f'];?>&i=<?=$_GET['i'];?>&nue=<?=$numx;?>">Legal</a>
</div>



        </div>

</body>
</html>
