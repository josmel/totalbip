<?PHP
include "log/md_log.php";
include "modulos/registro.php";
include ("get_perfil.php");

require_once('../../../../framework/nusoap/lib/nusoap.php');
	$portal_perfil = get_perfil($_SERVER['HTTP_USER_AGENT']);
	
	if($portal_perfil=="smartphone") $css="portalsmartphone.css";
	
	if($portal_perfil=="avanzado") $css="portalavanzado.css";

	if($portal_perfil=="intermedio") $css="portalintermedio.css";
	
	if($portal_perfil=="basico") header( 'Location: basico.php' );
	
	if($portal_perfil=="iphone") $css="portaliphone.css";
	
	if(isset($_SERVER['HTTP_X_UP_CALLING_LINE_ID']) && $_SERVER['HTTP_X_UP_CALLING_LINE_ID'] != "")
	{
		$str_number = $_SERVER['HTTP_X_UP_CALLING_LINE_ID'];
	}
	else
	{
		$str_number = $_GET['nu'];	
		
		//if (!isset($str_number) || $str_number=="") {  header( 'Location: confirmar_numero.php' );}
		
		if(strlen($str_number)<11){$str_number="51".$str_number; $validar_sms=true;}
	
	}

if(isset($_GET['validar_sms']) && $_GET['validar_sms']!="" )
{
	$validar_sms=$_GET['validar_sms'];
}
	
if( $validar_sms==true)	$val_sms=1;
else  $val_sms=0;
				$wsCliente='http://174.121.234.90:8080/moso/WSMultimedia/wsRBT.asmx?wsdl';
				$operadora='1';	
				$album="24";
				$keyword="_RBTWAPPORTAL";
				$filasxPagina="10";
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
				$Respuesta = $SoapClient->call("wsRBTConsultarAlbum", $Parametros); 
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

if(isset($_GET['cod']) && $_GET['cod']!=""){
	$codigoRbt=$_GET['cod'];
	$cancion=$_GET['cancion'];
	$artista=$_GET['artista'];
}

?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>	
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<!-- titulo -->	
	<title>Tonos de espera</title>
<link rel='stylesheet' type='text/css' href='css/<?=$css;?>' />

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
<body >


    <div id="cabecera">
	<!-- logo -->
    <table width="100%" cellpadding="0" cellspacing="0"><tr ><td align="left"><img src="images/header_title.gif" /></td><td align="right"><img src="images/header_logo.gif" /></td></tr></table>
    </div>
	 <div class="separador"></div>
	<!-- box de informaci?n -->	
	<div class="titulo_verde">
    <div class="esp10">
	Esc&uacute;chame
    </div>
	</div>
    <div class="verde"></div>
	<!--div class="bg-li-f">
    <table width="100%">
    <tr>
    <td width="85%" align="left">
    <?
				list($clave, $b2) = each($Respuesta);
				list($clave, $b3) = each($b2);
				foreach($b3 as &$valora){
					if($valora["Album"]==0)
					{
					$cd=$valora["CodigoRBT"];/*<br /><span class=\"txt_filtro\">&iexcl;GRATIS!</span>*/
					$Destacado.="<a class=\"cancion\" href=\"http://bip.pe/pe/mo/wap/rbt/validacion.php?v=".$val_sms."&amp;c=".$cd."\">".$valora["Tema"]."</a><br /> <span class=\"artista\">(".$valora["Artista"].")</span><br/>";		 	
					}
				}
				//echo $Destacado;
				$RBT= "<a class=\"cancion\" href=\"http://bip.pe/pe/mo/wap/rbt/validacion.php?v=1&amp;c=" . $codigoRbt . "\">" . $cancion . "</a><br /> <span class=\"artista\">(".$artista.")</span><br/><button style=\"width:\"";

?>		
    </td>
    <td width="6%" align="right"><a href="http://bip.pe/pe/mo/wap/rbt/validacion.php?v=1>&c=<?=$codigo;?>"><img src="images/ico_carrito_h.gif" /></a></td>
    </tr>
    </table>
    
    </div-->
    <div class="esp10">
    <br />
	<div class="text_alert">
        	 Haz clic en el bot&oacute;n "Aceptar" para que tus amigos escuchen &quot;<?=$cancion;?> de <?=$artista;?>&quot; cuando te llamen.
        </div>
	</div>
    <br />
    <div class="esp10">
        	<div class="txt_filtro" >
            Suscripci&oacute;n para recibir un tono de espera cada semana. Costo por tono S/.4.75, costo del Servicio S/.1.60 x Mes. Valido para comprar con recargas prepago.
            </div>
	</div>
    
    <div class="separador"></div>
    <div class="esp10">
    <form name="frm" action="http://bip.pe/pe/mo/wap/rbt/validacion.php" method="GET">
    <input type="hidden" name="c" value="<?=$codigoRbt;?>" />
    <input type="hidden" name="v" value="1" />
	<input type="submit" class="btn-ancho" value="Aceptar" />
	</form>
	</div>
    
            <div class="separador"></div>
            <div class="celeste"></div>
	<br />
    <div class="verde"></div>
	<div class="link bg-c">
    <div class="esp10">
	<a href="http://myHomePage">&lt; Volver</a>
    </div>
	</div>
			
<!-- pie de pagina -->	
<div class="item_legal">
	<a href="legal.php">Legal</a>
</div> 

</div>
  			
  		
	
</div></body></html>