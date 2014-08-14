<?php
$categ=isset($_GET['categoria'])?strtolower($_GET['categoria']):false;
$funcion=isset($_GET['funcion'])?strtolower($_GET['funcion']):false;
if($categ===false || $funcion===false){header("Location: index.php");die();}
$bool=false;
function obtener($CATEG){
	$pathCfg=dirname(__FILE__) . "/xml/cfg.xml";
	$dom=new DOMDocument;
	$dom->load($pathCfg);
	$xml=simplexml_import_dom($dom);
	$fileName=$xml->categorias->$CATEG;
	return $fileName;
}
function cambiar($CATEG){
	$pathCfg=dirname(__FILE__) . "/xml/cfg.xml";
	$xmlName=$CATEG.".xml";
	$dom=new DOMDocument;
	$dom->load($pathCfg);
	$xml=simplexml_import_dom($dom);
	
	if(strpos($CATEG,"arrival")!==false){$xml->categorias->arrival=$xmlName;}
	if(strpos($CATEG,"departure")!==false){$xml->categorias->departure=$xmlName;}
	$xml->asXML($pathCfg);
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
		case "arrival":$bool=true;break;
		case "departure":$bool=true;break;
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
		case ("arrival1"):
		case("arrival2"):$bool=true;break;
		case ("departure1"):
		case ("departure2"):$bool=true;break;
		default:$bool=false;break;
	}
	$bool===false?header("Location: index.php"):false;

	$retorno=cambiar($categ);
	echo "Se ha cambiado al archivo: " . $retorno;
	//header("Refresh: 10,URL=index.php");
	//die();
}
?>