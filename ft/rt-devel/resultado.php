<?PHP
require_once('../../../../framework/nusoap/lib/nusoap.php');
//require_once('nusoap/lib/nusoap.php');
require_once("modulos/poo_arweb.php");
include "log/md_log.php";
//include "modulos/registro.php";
include ("get_perfil.php");
$busqueda = $_GET['busqueda'];

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
?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">

<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">-->
<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Nextel - <?php echo $TituloPortal; ?></title>
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
          <img width="100%" src="img/banner-nextel-tonos.jpg" />
                    <?PHP if(count($DESTACADOs)>0) { ?>
         
           	  <?php foreach($DESTACADOs as $destacado){
                      $dataContenido = getContenido("wsRTConsultarAlbum","1","67","_RTWAP","1","0");
		  ?>
                 <div id="list-titulo-precio">
                     <? echo  htmlspecialchars_decode  ($destacado["TEXTOENPORTAL"]);?>
                 </div>
            	<?php } } ?>	

          <div style="padding-top: 20px">
              <p style="position: relative; left: auto">Buscador de tonos</p>
          </div>
          <div style="position: relative; margin-bottom: 15px;">
              <form action="resultado.php" method="get">
                  <input type='text' name='busqueda' id='busqueda' required="required" value='<?php echo $busqueda?>'/>
                  <input id='boton' type='submit' name='buscar' value=''/>
              </form>
          </div>

           <?php if(count($BODYs)>0) { ?>
            	<?PHP foreach($BODYs as $body){ ?>		
          <div id="list-titulo">Resultados</div>
<!-- Resultados de web service -->
<?php
$wsCliente = 'http://174.121.234.90/moso/WSMultimedia/wsrt.asmx?wsdl';
$SoapClient = new nusoap_client($wsCliente, true);

$Parametros = array(
    'operadora' => "1", 
    'tipo' => '50', 
    'palabrasFiltro' => $busqueda, 
    'filasxPagina' => "10", 
    'numPagina' => "0"
);

$Respuesta = $SoapClient->call("wsRTConsultarContenidos", $Parametros);
list($clave, $b2) = each($Respuesta);
list($clave, $b3) = each($b2);
if(is_vector($b3)== 0){
    $b3=$b2;    
}
$Respuesta = $b3;
if (!$Respuesta) {
    $Mensaje = TRUE; // no se encontraron resultados pero te sugerimos los siguientes temas
    
}
?>
<!-- fin consumo resultados-->
          <?php if ($Mensaje) {?>
<div style="padding-top: 14px; padding-bottom: 14px;text-align: center">
    <span>
        No se encontraron resultados para tu b&uacute;squeda pero encontramos esto para ti
    </span>
</div>

               <?PHP if(count($BODYs)>0) { ?>
            	<?PHP foreach($BODYs as $body){ ?>		          
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
              .</span> <a href="validacion.php?v=<?=$val_sms;?>&c=<?=$item["CodigoRBT"]."".$nuetxt;?>&t=<?=$_GET["t"];?>&f=<?=$_GET["f"];?>&i=<?=$_GET["i"];?>">
              <?=$item["Tema"];?>
              <span>
              <?=$item["Artista"];?>
              </span></a><a href="validacion.php?v=<?=$val_sms;?>&c=<?=$item["CodigoRBT"]."".$nuetxt;?>&t=<?=$_GET["t"];?>&f=<?=$_GET["f"];?>&i=<?=$_GET["i"];?>" class="descarga"></a>
              <div style="clear:both"></div>
            </div>


			 <?PHP $count = $count + 1; }  ?>	
          </div>
          <?PHP 
				 	} 
				  } ?>	
    

          <?php } ?>
           <div id="list-musica">
         <?PHP   $dataContenidoBody = $Respuesta;
		 $count = 1;
		  foreach($dataContenidoBody as $item){	
		  $rowalter = '';
					if ($count%2==0)
						$rowalter=" odd";
		  
		  ?>

 <div class="list-item<?=$rowalter;?>"> <span class="numero">
              <?=$count;?>
              .</span> <a href="validacion.php?v=<?=$val_sms;?>&c=<?=$item["CodigoRBT"]."".$nuetxt;?>&t=<?=$_GET["t"];?>&f=<?=$_GET["f"];?>&i=<?=$_GET["i"];?>">
              <?=$item["Tema"];?>
              <span>
              <?=$item["Artista"];?>
              </span></a><a href="validacion.php?v=<?=$val_sms;?>&c=<?=$item["CodigoRBT"]."".$nuetxt;?>&t=<?=$_GET["t"];?>&f=<?=$_GET["f"];?>&i=<?=$_GET["i"];?>" class="descarga"></a>
              <div style="clear:both"></div>
            </div>


			 <?PHP $count = $count + 1; }  ?>	
          </div>
          <?PHP 
				 	} 
				  } ?>	
<div style="position: relative; margin-bottom: 15px;">
          <a href="../tuyo"><div id="volver"> Volver</div></a>
          <a href="../rt"><div id="masmusica" class='vermas'> Ver + M&uacute;sica</div></a>
</div>
          <div id="footer"><a href="legal.php">Legal</a></div>
        </div>
</body>
</html>