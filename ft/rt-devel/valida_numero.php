<?PHP
	$codigo = $_GET['c'];
	$numero_cliente = $_GET['nu'];
	if(is_numeric($numero_cliente) && $numero_cliente != "")
		{ if(strlen($numero_cliente)==9 && $cadena{0}=="9" )
			{$numero_cliente="51".$numero_cliente;}
		$link = "http://174.121.234.90/SVARequest/Request.aspx?op=1&nu=".$numero_cliente."&sc=4556&su=1&k=_RBTWAPPORTAL&v=1&c=".$codigo."&o=7&re=15";
		header( "index.php?nu=".$numero_cliente ) ;	
		}

	else
	{
		$link = "get_number.php?c=".$codigo;
		header( "Location: get_number.php?c=".$codigo ) ;
	}
?>