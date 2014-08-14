<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Nextel - M&uacute;sica</title>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
<link type="image/x-icon" rel="shortcut icon"  href="img/favicon.ico">	
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
</head>

<?
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
/*******************************************************************************************/				
/*				$wsCliente='http://174.121.234.90/moso/WSMultimedia/wsIMG.asmx?wsdl';
				$operadora='3';	
				$album="43";
				$keyword="_WAPIMAGENES";
				$filasxPagina="5";
				$numPagina="0";
				
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

*/
?>


<body>
<div id="page">
  <div id="head">Tonos</div>
  <div id="list-titulo" class="legal">Legal</div>
  <div id="list-musica">
    
    <div class="list-item marco">
    
    	<p><b>1. Aceptaci&oacute;n de Condiciones</b><br/>
La utilizaci&oacute;n del servicio aqu&iacute; ofrecido atribuye la condición de Usuario e implica la aceptación de las Condiciones Legales aquí indicadas.
		</p>
    	<p><b>2. El Servicio</b><br/>
El servicio RINGTONE permite a los usuarios contar con diferentes tonos de timbrado y poder personalizarlo de acuerdo a la persona que lo llame.
Este servicio permite al usuario cambiar de un tono de timbrado cl&aacute;sico a un tono musical, como por ejemplo una canci&oacute;n, sonidos de animales, bromas, voces, etc.

		</p>
    	<p><b>3. Modalidad</b><br/>

El servicio se ofrece en modalidad de suscripci&oacute;n. 
El usuario se suscribe al servicio haciendo clic en Aceptary todas las semanas se le enviar&aacute; un link para que ingrese al portal de tonos y elija el tono que desee descargar. Haciendo clic en el tono se realiza la descarga autom&aacute;tica de la misma.
Para cancelar el servicio el usuario debe enviar un mensaje de texto con la palabra SALIR al 4556.
		</p>
    	<p><b>4. Tarifas</b><br/>
Costo por tono semanal: USD 1.80 inc. IGV.
El usuario puede descargarse el tono que desee cada semana.
		</p>
    	<p><b>5. Celulares Soportados</b><br/>
Todos los equipos 3G de Nextel y planes Nextel + a nivel nacional.
		</p>
    	<p><b>6. Forma de Pago</b><br/>
Para productos contrato los montos se facturan de manera adicional al cargo fijo mensual del Usuario. Para productos prepago, los precios por la suscripción le serán debitados al Usuario por el operador telefónico directamente del saldo de su tarjeta prepago.
		</p>
    	<p><b>7. Contacto</b><br/>
<a href="mailto:servicioalcliente@mobilesolutions.pe">servicioalcliente@mobilesolutions.pe</a>
		</p>
       
    <div style="clear:both"></div>
    </div>
    
  </div>
  
  <div id="footer"><a href="index.php">Volver</a></div>
</div>
</body>
</html>
