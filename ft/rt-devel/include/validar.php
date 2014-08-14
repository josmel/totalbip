<?php

	if(isset($_SERVER['HTTP_X_UP_CALLING_LINE_ID']) && $_SERVER['HTTP_X_UP_CALLING_LINE_ID'] != "")
	{
		$str_number = $_SERVER['HTTP_X_UP_CALLING_LINE_ID'];
		//echo "1";
	}
	else if(isset($_GET['nu']))
	{
		$str_number = $_GET['nu'];	
		if(strlen($str_number)<11){
			$str_number="51".$str_number;
		}
		else
			header("Location: index.php")&&die();
		
		//echo "2";
	}	
	else if(isset($_GET['nue']))
	{
		$str_number = $_GET['nue'];	
		if(strlen($str_number)<11){
			$str_number="51".$str_number; 
		}
		else if(strlen($str_number)==11){
			 
		}
		else
			header("Location: index.php?op=1")&&die();
		//echo "3";
	}
	else if(isset($_POST['token']) and !empty($_POST['token'])){
		
		$token=$_POST['token'];
		$url = 'http://174.121.234.90/Moso/Cript/process.aspx?d1='.$token;
		$content=file_get_contents($url);
			
		$separador="|";
		$parametros = explode($separador,$content);	
		$number=$parametros[0];
		$flagdescarga = (is_numeric($parametros[4]) ? (int)$parametros[4] : -1);		
		
		if( ( strlen($number)==11 ) ){
			if( substr($number,0,2) =="51" ){
				$str_number=$number;
			}
		}
		else
			header("Location: index.php?op=2")&&die();
	}
	else if(isset($_POST['tokenNum'])){

		$number=base64_decode($_POST['tokenNum']);

		if( ( strlen($number)==11 ) ){
			if( substr($number,0,2) =="51" ){
				$str_number=$number;
			}
		}
		else
			header("Location: index.php?op=3")&&die();
	}
	else 
		header("Location: index.php?op=3")&&die();
 
	
 
	
?>
