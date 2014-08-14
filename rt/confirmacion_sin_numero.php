<?PHP

static $http = array (
       100 => "HTTP/1.1 100 Continue",
       101 => "HTTP/1.1 101 Switching Protocols",
       200 => "HTTP/1.1 200 OK",
       201 => "HTTP/1.1 201 Created",
       202 => "HTTP/1.1 202 Accepted",
       203 => "HTTP/1.1 203 Non-Authoritative Information",
       204 => "HTTP/1.1 204 No Content",
       205 => "HTTP/1.1 205 Reset Content",
       206 => "HTTP/1.1 206 Partial Content",
       300 => "HTTP/1.1 300 Multiple Choices",
       301 => "HTTP/1.1 301 Moved Permanently",
       302 => "HTTP/1.1 302 Found",
       303 => "HTTP/1.1 303 See Other",
       304 => "HTTP/1.1 304 Not Modified",
       305 => "HTTP/1.1 305 Use Proxy",
       307 => "HTTP/1.1 307 Temporary Redirect",
       400 => "HTTP/1.1 400 Bad Request",
       401 => "HTTP/1.1 401 Unauthorized",
       402 => "HTTP/1.1 402 Payment Required",
       403 => "HTTP/1.1 403 Forbidden",
       404 => "HTTP/1.1 404 Not Found",
       405 => "HTTP/1.1 405 Method Not Allowed",
       406 => "HTTP/1.1 406 Not Acceptable",
       407 => "HTTP/1.1 407 Proxy Authentication Required",
       408 => "HTTP/1.1 408 Request Time-out",
       409 => "HTTP/1.1 409 Conflict",
       410 => "HTTP/1.1 410 Gone",
       411 => "HTTP/1.1 411 Length Required",
       412 => "HTTP/1.1 412 Precondition Failed",
       413 => "HTTP/1.1 413 Request Entity Too Large",
       414 => "HTTP/1.1 414 Request-URI Too Large",
       415 => "HTTP/1.1 415 Unsupported Media Type",
       416 => "HTTP/1.1 416 Requested range not satisfiable",
       417 => "HTTP/1.1 417 Expectation Failed",
       500 => "HTTP/1.1 500 Internal Server Error",
       501 => "HTTP/1.1 501 Not Implemented",
       502 => "HTTP/1.1 502 Bad Gateway",
       503 => "HTTP/1.1 503 Service Unavailable",
       504 => "HTTP/1.1 504 Gateway Time-out"
   );
	
	 include("get_perfil.php");
	$portal_perfil = get_perfil($_SERVER['HTTP_USER_AGENT']);
	
	if($portal_perfil=="smartphone") $css="portalsmartphone.css";
	
	if($portal_perfil=="avanzado") $css="portalavanzado.css";

	if($portal_perfil=="intermedio") $css="portalintermedio.css";
	
	if($portal_perfil=="basico") header( 'Location: confirmacion_basico.php' );
	
	if($portal_perfil=="iphone") $css="portaliphone.css";

	
	if(isset($_SERVER['HTTP_X_UP_CALLING_LINE_ID']) && $_SERVER['HTTP_X_UP_CALLING_LINE_ID'] != "")
	{
		$str_number = $_SERVER['HTTP_X_UP_CALLING_LINE_ID'];
	}
	else
	{
		$str_number = $_GET['nu'];	
	}
	
?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>M&uacute;sica</title>
	<link rel='stylesheet' type='text/css' href='css/<?=$css;?>' />
</head>

<body>
	
	<div id="cabecera">
	<!-- logo -->
    <img src='images/logo_movistar.gif' alt='tonos de espera' >
    </div>	
	
	<div id="publicidad">
    
    </div>
	

<!-- fecha -->
   <div class="titulo_categoria" align="center">
	<div class="titulo_item_a">
	<?php
						setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
						$timezone  = 1; //(GMT -5:00) EST (U.S. & Canada) 						
						echo strftime("%d/%b/%Y ", time() + 3600*($timezone));
					?> 
	</div>
	</div>
	
   <div id="publicidad">
	<!-- box de informaci?n -->	
	<div class="titulo_verde" align="Center">
	<strong>M&uacute;sica </strong><br /> 
			      	<div class="txt_filtro" >Tu solicitud est&aacute; en proceso. Recibir&aacute;s una confirmaci&oacute;n<br />  por SMS.<br /> 
			      	
			      	<div class="costo_verde">Costo S/4.75xSem inc. IGV  </div></div>
	</div>
    <div class="verde"></div>					
			
    </div>
	 <div id="publicidad">
	 </div>
<!-- contenido -->	
	

	  <!-- pie de pagina -->	
	  <div class="item_legal">
        	<div class="text_item" align="center">
          <a href="index.php" style="color:white">Atr&aacute;s</a>  |  <a href="legal.php" style="color:white">Legal</a>
            </div> 
        </div>
	
	</body>
</html>
