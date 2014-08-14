<?php
require_once('nusoap/lib/nusoap.php');
$v = isset($_GET['val'])?$_GET['val']:"1";
if ($v == "1")
    header ("Location: /");
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
<?php 
$msidn =  (isset($_SERVER['HTTP_MSISDN']))?$_SERVER['HTTP_MSISDN']:'';

$wsClient = 'http://174.121.234.90/moso/WSMultimedia/wstools.asmx?wsdl';
$SoapClien = new nusoap_client($wsClient, true);

$tparam = array(
    "operadora" => "3",
    "numUser" => $msidn,    
);
$token = base64_encode($msidn);

switch ($v) {
      case "ft": 
          $tit = "Club de M&uacute;sica";          
          $img = "img/nextel/banner-musica-nextel.gif";
          $texto = "Te est&aacute;s suscribiendo al servicio de Fulltracks, donde podr&aacute;s descargar todas las canciones
     que puedas por solo US$ 0.59 diarios.";
          $ruta = "http://bip.pe/pe/ne/wap/ft/?token=".$token;
          $dir = "../ft";
          $tparam['servicio'] = "130";          
          break;
      
      case "tn": 
          $tit = "Tonos";
          $img = "img/nextel/banner-nextel-tonos.jpg";
          $texto = "Te est&aacute;s suscribiendo al servicio de Tonos, cada semana podr&aacute;s descargar el tono que desees. Costo US$ 1.80 por suscripci&oacute;n semanal.";
          $ruta = "http://bip.pe/pe/ne/wap/rt/?token=".$token;
          $dir = "../rt";
          $tparam['servicio'] = "124";
          break;
      case "de": 
          $tit = "Dedicatorias";
          $img = "img/nextel/banner_dedicatorias_nextel.gif";
          $texto = "Te est&aacute;s suscribiendo al servicio de Dedicatorias. 
Selecciona una canci&oacute;n y se la enviaremos a la persona que elijas. Costo por suscripci&oacute;n semanal US$ 1.80.";
          $dir = "../dedicatorias";
          $ruta = "http://bip.pe/pe/ne/wap/dedicatorias/?token=".$token;
          $tparam['servicio'] = "146";
          break;
      case "img": 
          $tit = "Im&aacute;genes";
          $img = "img/nextel/banner_imagenes_nextel.jpg";
          $texto = "Te est&aacute;s suscribiendo al servicio de Imagenes. 
Selecciona una imagen y se la enviaremos a la persona que elijas. Costo por suscripci&oacute;n semanal US$ 1.80.";
          $ruta = "http://bip.pe/pe/ne/wap/dedicatorias/?token=".$token;
          $dir = "../img";
          $tparam['servicio'] = "141";
          break;      
      default :           
          break;
  
      }
  if (isset($tparam['servicio']) and isset($msidn)) {
      $rptsus = $SoapClien->call("EstaSuscrito", $tparam);
      $rptsus = array_shift($rptsus);
      if ($rptsus == "1") {
          header ("Location: $dir");          
      }
  }
      
  ?>
    
  <div id="hlegal"><?php echo $tit; ?></div>  
  <div id="publicidad">
 		
                    <img width="100%" src="<?php echo $img?>">
                
  </div>  
 <div id="list-titulo-precio">      
     <?php echo $texto; ?>
 
	 <form name="frm" action="<?php echo $ruta ?>" method="GET">
             <div class="btn-ancho" style="text-align: center;color: #FFFFFF;font-weight: bold;margin: 20px auto;border-radius: 4px;padding: 3px;-moz-box-sizing: border-box;border: medium none;" >
                 <a href="<?= $ruta?>" style="color: #FFFFFF; font-size: 14px "> ACEPTAR</a>                 
             </div>
             

	<!-- <input type="submit" class="btn-ancho" value="ACEPTAR" />-->
	</form> 
  </div>  
</div>
</body>
</html>