<?PHP
require_once('../../../../framework/nusoap/lib/nusoap.php');
	include("get_perfil.php");
	$portal_perfil = get_perfil($_SERVER['HTTP_USER_AGENT']);
	if($portal_perfil=="smartphone") $css="portalsmartphone.css";
	if($portal_perfil=="avanzado") $css="portalavanzado.css";

	if($portal_perfil=="intermedio") $css="portalintermedio.css";
	
	if($portal_perfil=="basico") header( 'Location: basico.php' );
	
	if(isset($_SERVER['HTTP_X_UP_CALLING_LINE_ID']) && $_SERVER['HTTP_X_UP_CALLING_LINE_ID'] != "")
	{
		$str_number = $_SERVER['HTTP_X_UP_CALLING_LINE_ID'];
	}
	else
	{
		$str_number = $_GET['nu'];	

		if(strlen($str_number)<11){$str_number="51".$str_number; $validar_sms=true;}
	}

if(isset($_GET['validar_sms']) && $_GET['validar_sms']!="" )
{
	$validar_sms=$_GET['validar_sms'];
}

if( $validar_sms==true)	$val_sms=1;
else  $val_sms=0;

	
				$operadora='1';	
				$tipo="0";
				$palabrasFiltro=$_GET['tbuscado'];
				$filasxPagina="10";
				$numPagina=isset($_GET['pag_a'])?$_GET['pag_a']:1;
				$valxArray=15;
				$totalPgn=5;
				
function multicount ($array, $limit = -1)
{
   $cnt = 0;
   $limit = $limit > 0 ? (int) $limit : -1;
   $arrs[] = $array;
   for ($i=0; isset($arrs[$i]) && is_array($arrs[$i]); ++$i)
   {
      foreach ($arrs[$i] as $value)
      {
         if (!is_array($value) ) ++$cnt;
         elseif( $limit==-1 || $limit>1 )
         {
            if( $limit>1 ) --$limit;
            $arrs[] = $value;
         }
      }
   }
   return $cnt;
}
function filasAfectadas($ARRAY,$NUMITEM){
	if($NUMITEM==1){
		list(,$val) = each($ARRAY);
		list(,$val2) = each($val);
		$rows=$val2["TotalPaginas"];
	}elseif($NUMITEM>1){
		list(,$val) = each($ARRAY);
		list(,$val2) = each($val);
		list(,$val3) = each($val2);
		$rows=$val3["TotalPaginas"];
	}else{
		$rows=0;
	}
	return $rows;
}


function acentos($String)
{
    $String = ereg_replace("[äáàâãª]","a",$String);
    $String = ereg_replace("[ÁÀÂÃÄ]","A",$String);
    $String = ereg_replace("[ÍÌÎÏ]","I",$String);
    $String = ereg_replace("[íìîï]","i",$String);
    $String = ereg_replace("[éèêë]","e",$String);
    $String = ereg_replace("[ÉÈÊË]","E",$String);
    $String = ereg_replace("[óòôõöº]","o",$String);
    $String = ereg_replace("[ÓÒÔÕÖ]","O",$String);
    $String = ereg_replace("[úùûü]","u",$String);
    $String = ereg_replace("[ÚÙÛÜ]","U",$String);
    $String = str_replace("ç","c",$String);
    $String = str_replace("Ç","C",$String);
    $String = str_replace("ñ","n",$String);
    $String = str_replace("Ñ","N",$String);
    $String = str_replace("Ý","Y",$String);
    $String = str_replace("ý","y",$String);
    
	$String = ereg_replace("[^A-Za-z0-9 ]", "", $String);
				
	return $String;
}

$wsCliente='http://174.121.234.90:8080/moso/WSMultimedia/wsRBT.asmx?wsdl';
				
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

$Parametros = array('operadora'=>$operadora,'tipo'=>$tipo,'palabrasFiltro'=>$palabrasFiltro,'filasxPagina'=>$filasxPagina,'numPagina'=>$numPagina); 
				//print_r( $Parametros);
				$bRespuesta = $SoapClient->call("wsRBTConsultarContenidos", $Parametros); 
				//print_r($bRespuesta);
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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
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
    <table width="100%" cellspacing="0"><tr ><td align="left"><img src="images/header_title.gif" /></td><td align="right"><img src="images/header_logo.gif" /></td></tr></table>
    </div>
	 <div class="separador"></div>
	<!-- box de informaci?n -->	
	<div class="titulo_verde">
    <div class="esp10">
	Esc&uacute;chame
    </div>
	</div>
    <div class="verde"></div>
		<div class="separador"></div>
	<div class="esp10">
    	<div class="text_alert">
        <div class="separador"></div>
    Costo por tono adicional S/. 4.75
		<div class="separador"></div>
    	</div>
    </div>
    <div class="celeste"></div>
    <br/>
	<div class="esp10">
	<div class="titulo_verde">Que cuando te llamen escuchen m&uacute;sica.</div>
	</div>
	<div class="verde"></div>
	<div class="separador"></div>
    <div class="esp10">
	<div class="txt_filtro">
        Buscador de Tonos
	</div>
	<div>
		<form name="fbuscador" action="buscar.php" method="get">
        <div style="float:left;width:85%">
        <div style="padding-right:5px">
        <!--input type="hidden" name="nu" value="" /-->
        <input name="tbuscado" type="text" class="c-filtro" id="tbuscado" size="15" maxlength="100">
        </div>
        </div>
        <div style="float:right;width:15%;text-align:right">
        <input type="image" src="images/btn_buscar.jpg">
        </div></form>
        <div style="clear:both"></div>
        <div>
		<div class="separador"></div>
        
        </div>
        </div>
	</div>
<div class="celeste"></div>
<br />
<div class="esp10">
	<div class="titulo_verde">Resultados</div>
	</div>
	<div class="verde"></div>
	<div class="separador"></div>
    <div id="resultados"> 

			
<?					
				//print_r( $bParametros);
				//echo "Operadora: ".$bParametros['operadora']."<br/>"; ?>
                
				<div class="esp10"><div class="txt_filtro">
	Texto Buscado: <?=$_GET['tbuscado'];?></div></div>
<?					
				list(, $rb2) = each($bRespuesta);
				/*print_r($bRespuesta);
				print_r($rb2);
				list(, $rb3) = each($rb2);
				echo "<br/>R2: <br/>"; print_r($bRespuesta);
				print_r($rb3);*/
				$items=multicount($bRespuesta)/$valxArray;
				$paginas=isset($_GET['mxp'])?$_GET['mxp']:filasAfectadas($bRespuesta,$items);
				//print_r("items: " . $items. "; páginas" . $paginas . ";");
				/*echo $items=count($rb3);
				$re=0;*/
				if( $items>=1 ){
				
				
					if($paginas>=2) 
					{
						echo "<div class=\"esp10\"><div class=\"txt_filtro\">Total de Resultados: ".$paginas."<br/>Para un mejor resultado afine la b&uacute;squeda.</div></div>";
					}
					else 
					{
						echo "<div class=\"esp10\"><div class=\"txt_filtro\">Total de Resultados: ".$paginas."</div></div>";
					}


					if ($items==1)
					{
						$n=$numPagina>1?($numPagina-1)*10:0;
						$num=$n+1;
						$itNum=$num<10?"0".$num:$num;
						foreach($rb2 as &$valorb){ 
							$encontrado.="
							<div class=\"bg-li-f\">
<div class=\"separador\"></div>
<div class=\"esp10\">
<div class=\"lib num\">" . $itNum . ".</div><div class=\"lib\"><div class=\"a-lnk\"><a href=\"http://174.121.234.90/SVARequest/Request.aspx?op=1&amp;nu=".$str_number."&amp;sc=4556&amp;su=1&amp;k=_RBTWAPPORTAL&amp;v=".$val_sms."&amp;c=".$valorb["CodigoRBT"]."&amp;o=7&amp;re=15\" class=\"cancion\">".$valorb["Tema"]."</a></div><div class=\"artista\">".$valorb["Artista"]."</div></div><div class=\"rib ico\"><a href=\"http://174.121.234.90/SVARequest/Request.aspx?op=1&amp;nu=".$str_number."&amp;sc=4556&amp;su=1&amp;k=_RBTWAPPORTAL&amp;v=".$val_sms."&amp;c=".$valorb["CodigoRBT"]."&amp;o=7&amp;re=15\"><img src=\"images/ico_carrito_h.gif\" /></a></div>
<div style=\"clear:both\"></div>
</div>
<div class=\"separador\"></div>
</div>";
$totalPgn=$valorb["TotalPaginas"];
							$pag_a=1;
						}
						
					}
					else
					{
					
					//$items=round($items/12);
					$ib=0;
					$n=$numPagina>1?($numPagina-1)*10:0;
					while($ib < $items){
							
							foreach($rb2 as &$valorb){ 
								//if($ib%2 != 0){$par="i";}else{$par="p";}
								if($ib%2==0){$bg="bg-li-f";$img="h";}else{$bg="bg-li-s";$img="n";}
								

								$num=$ib+$n+1;
								$itNum=$num<10?"0".$num:$num;
									$encontrados.=
									
									"<div class=\"" . $bg . "\">
<div class=\"separador\"></div>
<div class=\"esp10\">
<div class=\"lib num\">" . $itNum . ".</div><div class=\"lib\"><div class=\"a-lnk\"><a href=\"http://174.121.234.90/SVARequest/Request.aspx?op=1&amp;nu=".$str_number."&amp;sc=4556&amp;su=1&amp;k=_RBTWAPPORTAL&amp;v=".$val_sms."&amp;c=".$valorb[$ib]["CodigoRBT"]."&amp;o=7&amp;re=15\" class=\"cancion\">".$valorb[$ib]["Tema"]."</a></div><div class=\"artista\">".$valorb[$ib]["Artista"]."</div></div><div class=\"rib ico\"><img src=\"images/ico_carrito_".$img.".gif\" /></div>
<div style=\"clear:both\"></div>
</div>
<div class=\"separador\"></div>
</div>";
$totalPgn=$valorb[$ib]["TotalPaginas"];

							}
						$ib++;
						}
					}
				echo $encontrado;
				echo $encontrados;
				echo "<div class=\"esp10\"><div class=\"link-inline\">P&aacute;gina: "; $pg_t=$paginas;
				$i_p=1;
				
				$paginaActual=$numPagina;
				$totalPaginas=ceil($totalPgn/$filasxPagina);
				for($x=1;$x<=$totalPaginas;$x+=1){
					if($x==$paginaActual) $htmlPaginado.= $x . "&nbsp;";
					else $htmlPaginado.= "<a href='buscar.php?pag_a=" . $x . "&tbuscado=" . $palabrasFiltro . "'>".$x."</a>&nbsp;";
				}
				echo $htmlPaginado;
				echo "</div></div>";
				}else{
					echo "<div class=\"esp10\"><div class=\"txt_filtro\">Total de Resultados: ".$paginas."<br/>Para un mejor resultado afine la b&uacute;squeda.</div></div>";
				}
		
			?>   
    
      </div> 

	      <div class="verde"></div>
	<div class="link bg-c" style="text-align:center">
	<a href="../siono/">&iquest;Si o No?</a>
	</div>
	<br />
    <div class="verde"></div>
	<div class="link bg-c">
    <div class="esp10">
	<a href="index.php">&lt; Volver</a>
    </div>
	</div>
			
<!-- pie de pagina -->	
<div class="item_legal">
	<a href="legal.php">Legal</a>
</div> 

</div>
  			
  		
	
</div></body></html>