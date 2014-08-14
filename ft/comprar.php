<?PHP
	$codigo = $_GET['c'];
	$numero_cliente = $_GET['nu'];
		
	if($numero_cliente != "") {
		$link = "http://174.121.234.90/SVARequest/Request.aspx?op=1&nu=".$numero_cliente."&sc=4556&su=1&k=_RBTWAPPORTAL&v=0&c=".$codigo."&o=7&re=15";
		header( "Location: http://174.121.234.90/SVARequest/Request.aspx?op=1&nu=".$numero_cliente."&sc=4556&su=1&k=_RBTWAPPORTAL&v=0&c=".$codigo."&o=7&re=15" ) ;
	}
	else
	{
		$link = "confirmar_numero.php?c=".$codigo;
		header( "Location: confirmar_numero.php?c=".$codigo ) ;
	}
?>
