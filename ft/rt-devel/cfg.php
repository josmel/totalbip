<?php
$categ=isset($_GET['categoria'])?strtolower($_GET['categoria']):false;
$funcion=isset($_GET['funcion'])?strtolower($_GET['funcion']):false;
if($categ===false || $funcion===false){header("Location: index.php");die();}
$bool=false;

function obtener($CATEG){
	$dom=new DOMDocument;
	$dom->load("xml/cfg.xml");
	$xml=simplexml_import_dom($dom);
	$fileName=$xml->categorias->$CATEG;
	return $fileName;
}
function cambiar($CATEG){
	$xmlName=ucfirst($CATEG.".xml");
//	$xmlName=$CATEG.".xml";
	$dom=new DOMDocument;
	$dom->load("xml/cfg.xml");
	$xml=simplexml_import_dom($dom);
	
	if(strpos($CATEG,"portal")!==false){$xml->categorias->portal=$xmlName;}

	$xml->asXML("xml/cfg.xml");
	return $xmlName;
}

switch($funcion){
	case "cambiar":$bool=true;break;
	case "obtener":$bool=true;break;
	default:$bool=false;break;
}
$bool===false?header("Location: index.php"):false;

if($funcion=="obtener"){
	switch($categ){
		case "portal":$bool=true;break;
		default:$bool=false;break;
	}
	$bool===false?header("Location: index.php"):false;
	
	$retorno=obtener($categ);
	echo $retorno;
	//header("Refresh: 10,URL=index.php");
	//die();
}
if($funcion=="cambiar"){
	switch($categ){
		case ("PortalFT1"):
		case("PortalFT2"):$bool=true;break;
		default:$bool=false;break;
	}
	$bool===false?header("Location: index.php"):false;

	$retorno=cambiar($categ);
	echo "Se ha cambiado al archivo: " . $retorno;
	//header("Refresh: 10,URL=index.php");
	//die();
}
?>