<?PHP
require_once('nusoap/lib/nusoap.php');
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

$nuetxt=$_GET["nue"];

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

if (isset($_GET['i']) && strlen($_GET['i']) > 0) {
    $token = $_GET['i'];
    $url = 'http://174.121.234.90/Moso/Cript/process.aspx?d1=' . $token;
    $content = file_get_contents($url);
    $separador = "|";
    $parametros = explode($separador, $content);    

    $tnun = (is_numeric($parametros[0]) ? (int) $parametros[0] : 0);
}

if (isset($_GET['token']) and $_GET['token'] != '') {
//if ((isset($_GET['token']) and $_GET['token'] != '') || (isset($tnun) and $tnun > 0)) {
$num = base64_decode($_GET['token']);	
//$num = ($num and $num>0)?$num:$tnun;
if ($num) {
$web = "http://174.121.234.90/SVARequest/Request.aspx?nu=$num&op=3&su=1&sc=4556&k=f&o=24";    
    $result = file_get_contents($web);
    if ($result == 'OK') {
        //header("Location: index.php") && die();
    }
}

}

if (isset($_SERVER['HTTP_MSISDN']) && $_SERVER['HTTP_MSISDN'] != "") {
    $str_number = $_SERVER['HTTP_MSISDN'];
}
if (isset($_SERVER['HTTP_COOKIE']) && $_SERVER['HTTP_COOKIE'] != "") {
    $b = strpos($_SERVER['HTTP_COOKIE'], "msisdn=")+7;
if ($b != "7") {
    $num = substr($_SERVER['HTTP_COOKIE'], $b);
    $str_number = $num;
}
}
if (isset($_SERVER['HTTP_X_UP_CALLING_LINE_ID']) && $_SERVER['HTTP_X_UP_CALLING_LINE_ID'] != "") {
    $str_number = $_SERVER['HTTP_X_UP_CALLING_LINE_ID'];
}

if (isset($_GET['nue']) && $_GET['nue'] != "") {
    $str_number = $_GET['nue'];
}

$wsClient = 'http://174.121.234.90/moso/WSMultimedia/wstools.asmx?wsdl';
$SoapClien = new nusoap_client($wsClient, true);
$tparam = array(
        "operadora" => 3,
        "numUser" => $str_number,
        "servicio" => 130
    );

    $rptsus = $SoapClien->call("EstaSuscrito", $tparam);
if($rptsus['EstaSuscritoResult'] == '0') {
    header("Location: http://m.tuyonextel.com.pe/validacion.php?serv=_FTWAPNX");exit;
}
if (isset($_SERVER['HTTP_X_UP_SUBNO']) && $_SERVER['HTTP_X_UP_SUBNO'] != "") {
    $dosG = $_SERVER['HTTP_X_UP_SUBNO'];
    //$dosG = "PER0006111680_net2.nextelinternational.com";
    $url = file_get_contents("http://wsperu.multibox.pe/ws-nextel.php?nextel-2g=$dosG");
    $conteDosG = json_decode($url);
    $str_number = "51" . $conteDosG->PTN;
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
          
         <?PHP if(count($BANERs)>0) { ?>	
         	<div id="BANERs">
            <?PHP foreach($BANERs as $baner){ ?>	
				<div>
                <a href="<?=$baner["LINK"];?>">
                <img border="0" src="<?=$baner["IMG"];?>" name="baner" alt="baner" />
                </a>
                </div>
			<?PHP } ?>	
            </div>
         <?PHP } ?>	
                
         
          <?PHP if(count($DESTACADOs)>0) { ?>
         
           	  <?PHP foreach($DESTACADOs as $destacado){ 			  
                            $dataContenido = getContenido("wsRTConsultarAlbum","1",$destacado["ALBUM"],$destacado["KEYWORD"],$destacado["FILASXPAGINA"],$destacado["NUMPAGINA"]);
			  foreach($dataContenido as $item){?>
          
            	<div id="destacado">
                    <img src="<?= $destacado["RUTAIMAGEN"]; ?>" alt="destacado" />                     
                    <a href="validacion.php?v=<?=$val_sms;?>&c=<?=$item["CodigoRBT"]."&nue=".$nuetxt;?>&t=<?=$_GET["t"];?>&f=<?=$_GET["f"];?>&i=<?=$_GET["i"];?>">
                    <?=$item["Tema"];?><span><?=$item["Artista"];?></span>
                    </a>
                    <div style="clear:both"></div>
          		</div>  
                <?PHP }  ?>	
                 <div id="list-titulo-precio"><? echo  htmlspecialchars_decode  ($destacado["TEXTOENPORTAL"]);?></div>
            	<?PHP 
				 	} 
				  } ?>	
          
          
          
          
          
          
          
          
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
              <?=$count;?>
              .</span> <a href="validacion.php?v=<?=$val_sms;?>&c=<?=$item["CodigoRBT"]."&nue=".$nuetxt;?>&t=<?=$_GET["t"];?>&f=<?=$_GET["f"];?>&i=<?=$_GET["i"];?>">
              <?=$item["Tema"];?>
              <span>
              <?=$item["Artista"];?>
              </span></a><a href="validacion.php?v=<?=$val_sms;?>&c=<?=$item["CodigoRBT"]."&nue=".$nuetxt;?>&t=<?=$_GET["t"];?>&f=<?=$_GET["f"];?>&i=<?=$_GET["i"];?>" class="descarga"></a>
              <div style="clear:both"></div>
            </div>


			 <?PHP $count = $count + 1; }  ?>	
          </div>
          <?PHP 
				 	} 
				  } ?>	
          
          
          
          <div id="footer"><a href="http://m.tuyonextel.com.pe">&lt; Volver</a> | <a href="legal.php">Legal</a></div>
        </div>
</body>
</html>
