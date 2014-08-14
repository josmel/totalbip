


<?PHP
	include("get_perfil.php");
	$portal_perfil = get_perfil($_SERVER['HTTP_USER_AGENT']);
	
	if($portal_perfil=="smartphone") $css="portalsmartphone.css";
	
	if($portal_perfil=="avanzado") $css="portalavanzado.css";

	if($portal_perfil=="intermedio") $css="portalintermedio.css";
	
	if($portal_perfil=="basico") header( 'Location: basico.php' );
	
	if($portal_perfil=="iphone") header( 'Location: iphone/index.php' );
	//if($portal_perfil=="iphone") $css="portaliphone.css";
	
	if(isset($_SERVER['HTTP_X_UP_CALLING_LINE_ID']) && $_SERVER['HTTP_X_UP_CALLING_LINE_ID'] != "")
	{
		$str_number = $_SERVER['HTTP_X_UP_CALLING_LINE_ID'];
	}
	else
	{
		$str_number = $_GET['nu'];	
	
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<!-- titulo -->	
	<title>Tonos de espera</title>
<?   echo "<link rel='stylesheet' type='text/css' href='css/".$css."' />";?>

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
    <img src='images/logo_movistar.gif' alt='tonos de espera' >
    </div>
	 
	 <div id="publicidad">
	<!-- box de informaci?n -->	
	<div class="titulo_verde" align="Center">
	<br />Tonos de espera<br /> 
	</div>
    <div class="verde"></div>	
		
  
        	<div class="titulo_item_a" >
            Por favor ingresa tu numero de Tel&eacute;fono:
			  <form name="form1" method="get" action="index.php">
	
		<input type="text" name="nu" value="Tel&eacute;fono" id="nu_id" maxlength="9" /> 
	
		<input type="hidden" name="validar_sms" value="true" />
		<input type="submit" name="button" id="button" value="Enviar" class="button white">
	
</form>
             <br/>
		
    </div>
    </div>
    
    
   
   
  		
			
			
<!-- pie de pagina -->	
<div class="item_legal">
        	<div class="text_item" align="center">
           <a href="http://myhomepage/">Atrás</a>  |  <a href="legal.php">Legal</a>
            </div> 
        </div>
  			
  		
	
</div></body></html>