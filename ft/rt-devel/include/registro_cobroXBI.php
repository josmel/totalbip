<?php	
	class cobroNextel
	{
		var $host="localhost";  
		var	$userdb="mobiles8_dev"; 
		var	$passbd="m0s0#dev.";  
		var	$bdname="mobiles8_xbiweb";

		function setRegistrarIntentoCobro($sqn, $token, $idSrv, $desSrv, $iv, $sc, $ssc, $nu, $idcontenido, $descontenido)
		{
			 
			$conn = mysql_connect($this->host,$this->userdb,$this->passbd);					
			if (!$conn) {
				echo "Conexión Erronea - "; 
				echo("ERROR: " . mysql_error() . "\n");
				//die('{"jsonrpc" : "2.0", "code": 101, "message": "'. mysql_error() .'"}');				
				exit;				
			}
			else
			{
				mysql_select_db($this->bdname, $conn);
				$desSrv = mysql_real_escape_string($desSrv);
				$descontenido = mysql_real_escape_string($descontenido); 
				$SQL = "INSERT INTO cobroxbi (sqn, token, idSrv, desSrv, iv, sc, ssc, nu, idcontenido, descontenido, resultxbi, fecha) VALUES ( $sqn, '$token', $idSrv, '$desSrv', '$iv', '$sc', '$ssc', '$nu', $idcontenido, '$descontenido', '0', NOW() ) ";
  				$result = mysql_query( $SQL, $conn);
				$id = 0;
  				if (!$result) { 
					echo("ERROR: " . mysql_error() . "\n");	
					$id = 1;
					//die('{"jsonrpc" : "2.0", "code": 102, "message": "'. mysql_error() .'"}');			
					exit;
				}
				//$id = mysql_insert_id();	
			}
			mysql_close($conn);
			return $id;
		}
		
		function getConfirmarCobro($sqn, $idSrv, $nu, $idcontenido, $resultxbi)
		{
			 
			$conn = mysql_connect($this->host,$this->userdb,$this->passbd);					
			if (!$conn) {
				echo "Conexión Erronea - "; 
				echo("ERROR: " . mysql_error() . "\n");
				//die('{"jsonrpc" : "2.0", "code": 101, "message": "'. mysql_error() .'"}');				
				exit;				
			}
			else
			{
				mysql_select_db($this->bdname, $conn);	
				$contenido = mysql_real_escape_string($contenido);
				$nomSeccion = mysql_real_escape_string($nomSeccion);
				$SQL = "UPDATE cobroxbi SET resultxbi = '$resultxbi' WHERE idSrv = $idSrv AND nu = '$nu' AND idcontenido = $idcontenido AND sqn = $sqn";
  				$result = mysql_query( $SQL, $conn);
				$id = 0;
  				if (!$result) { 
					echo("ERROR: " . mysql_error() . "\n");	
					//die('{"jsonrpc" : "2.0", "code": 102, "message": "'. mysql_error() .'"}');
					$id = 1;			
					exit;
				}
					
			}
			mysql_close($conn);
			return $id;
		}
		
		 
		
				//EDITAR SLIDER
		/*
		function setEditar($idSeccion)
		{
			 
			$conn = mysql_connect($this->host,$this->userdb,$this->passbd);					
			if (!$conn) {
				die('{"jsonrpc" : "2.0", "code": 101, "message": "'. mysql_error() .'"}');				
				exit;				
			}
			else
			{
				mysql_select_db($this->bdname, $conn);
				$SQL = " SELECT idSeccion, nomSeccion, contenido, estado, publicar, orden, codsubseccion, idRegion FROM seccion WHERE idSeccion = $idSeccion";
  				$result = mysql_query( $SQL, $conn);
				
  				if (!$result) { 
					die('{"jsonrpc" : "2.0", "code": 102, "message": "'. mysql_error() .'"}');			
					exit;
				}
				while ($row = mysql_fetch_array($result)) { 
					$rows[0] = $row["nomSeccion"];	
					$rows[1] = $row["contenido"];	
					$rows[2] = $row["publicar"];
					$rows[3] = $row["orden"];
					$rows[4] = $row["codsubseccion"];
					$rows[5] = $row["idRegion"];
					$rows[6] = $row["idSeccion"];
				}	
			}
			mysql_close($conn);
			return $rows;
		}
		*/
		//ELIMINAR SLIDER
		/*
		function setEliminar($idSeccion)
		{
			 
			$conn = mysql_connect($this->host,$this->userdb,$this->passbd);					
			if (!$conn) {
				die('{"jsonrpc" : "2.0", "code": 101, "message": "'. mysql_error() .'"}');				
				exit;				
			}
			else
			{
				mysql_select_db($this->bdname, $conn);
				$SQL = " UPDATE seccion SET Estado = 0 WHERE idSeccion = $idSeccion";
  				$result = mysql_query( $SQL, $conn);
				
  				if (!$result) { 
					die('{"jsonrpc" : "2.0", "code": 102, "message": "'. mysql_error() .'"}');			
					exit;
				}
				$id = 'OK';	
			}
			mysql_close($conn);
			return $id;
		}
		*/		
		function getSecuenciaCobroXBI($idSrv, $nu, $idcontenido,$desSrv)
		{
			 
			$conn = mysql_connect($this->host,$this->userdb,$this->passbd);					
			if (!$conn) {
				echo "Conexión Erronea - "; 
				echo("ERROR: " . mysql_error() . "\n");
				//die('{"jsonrpc" : "2.0", "code": 101, "message": "'. mysql_error() .'"}');				
				exit;				
			}
			else
			{
				mysql_select_db($this->bdname, $conn);				
				$SQL = "SELECT sqn FROM cobroxbi WHERE idSrv = $idSrv AND nu = '$nu' AND desSrv = '$desSrv' AND idcontenido = $idcontenido ORDER BY sqn DESC LIMIT 1";
  				$result = mysql_query( $SQL, $conn);
				
  				if (!$result) { 
					echo("ERROR: " . $SQL . "\n");	
					//die('{"jsonrpc" : "2.0", "code": 102, "message": "'. mysql_error() .'"}');			
					exit;
				}
				$sqn = -1;
				while ($row = mysql_fetch_array($result)) { 
					$sqn = $row['sqn']; 
					if(is_numeric($sqn)) {
						$i++;
					}
					else
						$i=-1;
				}	
				$sqn = $sqn + 1;	
			}
			mysql_close($conn);
			return $sqn;
		}
		 
		
	}
?>