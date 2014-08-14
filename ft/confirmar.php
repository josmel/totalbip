<?PHP
	$codigo = $_GET['c'];
	
	
	if(isset($_SERVER['HTTP_X_UP_CALLING_LINE_ID']) && $_SERVER['HTTP_X_UP_CALLING_LINE_ID'] != "")
	{
		$str_number = $_SERVER['HTTP_X_UP_CALLING_LINE_ID'];
	}
	else
	{
		$str_number = $_GET['nu'];	
	}
	
	function comprar($codigo, $numero_cliente) {
		if($numero_cliente != "") {
			$link = "http://174.121.234.90/SVARequest/Request.aspx?op=1&nu=".$numero_cliente."&sc=4556&su=1&k=_RBTWAPPORTAL&v=0&c=".$codigo."&o=7&re=15";
			echo htmlentities($link);
		}
		else
		{
			$link = "confirmar_numero.php?c=".$codigo;
			echo htmlentities($link);			
		}
	}
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta id="viewport" name="viewport" content="width=320; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
	<title>escuchame</title>
	<link rel="stylesheet" href="stylesheets/iphone.css" />
	<link rel="apple-touch-icon" href="images/moso.png" />
	
	<script type="text/javascript"> 
	function clickclear(thisfield, defaulttext) {
	if (thisfield.value == defaulttext) {
	thisfield.value = "";
	}
	}
	function clickrecall(thisfield, defaulttext) {
	if (thisfield.value == "") {
	thisfield.value = defaulttext;
	}
	}
	
	</script> 
	
	<script type="text/javascript" charset="utf-8">
		window.onload = function() {
		  setTimeout(function(){window.scrollTo(0, 1);}, 100);
		}
	</script>
	<style type="text/css" media="screen">
		ul.minibanner li.one { background: url(images/banner-1.png) no-repeat; }
		ul.minibanner li.two { background: url(images/banner-2.png) no-repeat; }
		ul.bigbanner li.one { background: url(images/onpe.jpg) no-repeat; }
	</style>
</head>
<body id="plastic">
		
	<div id="header"> 
		<h1>esc&uacute;chame</h1> 
		<a href="index.php" id="backButton">Back</a> 
	</div> 
 
 	<h1>Tu transacci&oacute;n est&aacute; en proceso.</h1> 
	<ul class="bigbanner">
		<li class="one"><a href="#">1</a></li>
	</ul>
	<h1>Elige otro tono de espera:</h1> 
	
	
	<ul>		     
		<li class="arrow"><small>S/.5.05</small><a href="<?php comprar(178,$str_number); ?>">A Labio Dulce</a> (Iskander)</li>
		<li class="arrow"><small>S/.5.05</small><a href="<?php comprar(160,$str_number); ?>">Te eche al olvido</a> (Tony Rosado)</li>
        <li class="arrow"><small>S/.5.05</small><a href="<?php comprar(172,$str_number); ?>">Amor Urbano</a> (Franco&Oscarcito)</li>
		<li class="arrow"><small>S/.5.05</small><a href="<?php comprar(164,$str_number); ?>">Loco por Ti</a> (Franco&Oscarcito)</li>
        <li class="arrow"><small>S/.5.05</small><a href="<?php comprar(162,$str_number); ?>">No Juegue con el Diablo</a> (Ruta89)</li>
		<li class="arrow"><small>S/.5.05</small><a href="<?php comprar(166,$str_number); ?>">30 segundos</a> (Marisol)</li>
        <li class="arrow"><small>S/.5.05</small><a href="<?php comprar(163,$str_number); ?>">Agonia de Amor</a> (Dilbert Aguilar)</li>
		<li class="arrow"><small>S/.5.05</small><a href="<?php comprar(170,$str_number); ?>">El Arbolito</a> (Nectar)</li>
        <li class="arrow"><small>S/.5.05</small><a href="<?php comprar(167,$str_number); ?>">El Embrujo</a> (Kaliente)</li>
		<li class="arrow"><small>S/.5.05</small><a href="<?php comprar(179,$str_number); ?>">El Hacha</a> (Franco&Oscarcito)</li>
        <li class="arrow"><small>S/.5.05</small><a href="<?php comprar(168,$str_number); ?>">Hasta las 6 de la ma&ntilde;ana</a> (Armonia10)</li>
		<li class="arrow"><small>S/.5.05</small><a href="<?php comprar(169,$str_number); ?>">Juramentos ya no</a> (Kaliente)</li>
        <li class="arrow"><small>S/.5.05</small><a href="<?php comprar(177,$str_number); ?>">Mala Conducta</a> (Franco&Oscarcito)</li>
		<li class="arrow"><small>S/.5.05</small><a href="<?php comprar(161,$str_number); ?>">Solo muy Solo</a> (Caribe&ntilde;os)</li>
        <li class="arrow"><small>S/.5.05</small><a href="<?php comprar(180,$str_number); ?>">Tengo</a> (Lenny)</li>
    </ul>
						
<p><a href="http://www.gnu.org/licenses/agpl.html">Legal</a><br />
   Powered by <strong>Mobile Solutions</strong><br /></p>
	
</body>
</html>