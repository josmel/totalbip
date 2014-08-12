<?php

class App_Entity_MdLog {

    function curPageURL() {
        $pageURL = 'http';
        if ($_SERVER["HTTPS"] == "on") {
            $pageURL .= "s";
        }
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }

    function fileName() {
        $path = "log/";
        $name = date("Ymd");
        $ext = ".moso";
        return $path . $name . $ext;
    }

    function getPuts() {

        if (isset($_SERVER['HTTP_X_UP_CALLING_LINE_ID']) && $_SERVER['HTTP_X_UP_CALLING_LINE_ID'] != "") {
            $str_number = $_SERVER['HTTP_X_UP_CALLING_LINE_ID'];
        } else {
            $str_number = $_GET['nu'];
            if (strlen($str_number) < 11) {
                $str_number = "51" . $str_number;
                $validar_sms = true;
            }
        }
        $nuetxt = "";
        if (isset($_GET['nue'])) {
            $str_number = $_GET['nue'];
            if (strlen($nue) < 11) {
                $str_number = "51" . $nue;
            }
        }

        $var_ .= $fecha = date("Y-m-d") . ",";
        $var_ .= $hora = date("H:i:s") . ",";
        $var_ .= $id . ",";
        $var_ .= $_SERVER['REMOTE_ADDR'] . ",";
        $var_ .= $_SERVER['HTTP_X_FORWARDED_FOR'] . ",";
        $var_ .= $str_number . ",";
        $var_ .= "perfil" . ",";
        $var_ .= curPageURL() . ",";
        $var_ .= $_SERVER['HTTP_USER_AGENT'] . ",";


        return $var_;
    }

//$file_name=fileName();
//$bool=false;
//$str_put=getPuts();
//@ $fp=fopen($file_name,"a");
//	if( $fp ){
//		flock($fp,2);
//		fputs($fp,$str_put . "\n");
//		flock($fp,3);
//	fclose($fp);
//	$bool=true;
//	}
//return $bool;
//LOG DE DESCARGAS

    function getPutsDescargaLOG($url, $id, $numero, $codigo_catalogo) {
        if (isset($_SERVER['HTTP_X_UP_CALLING_LINE_ID']) && $_SERVER['HTTP_X_UP_CALLING_LINE_ID'] != "") {
            $str_number = $_SERVER['HTTP_X_UP_CALLING_LINE_ID'];
        } else {
            $str_number = $_GET['nu'];
        }
        $var_ .= $fecha = date("Y-m-d") . ",";
        $var_ .= $hora = date("H:i:s") . ",";
        $var_ .= $url . ",";
        $var_ .= $id . ",";
        $var_ .= $codigo_catalogo . ",";
        $var_ .= $numero;
        $file_name = $this->fileNameLogDescarga();
        $bool = false;
        $str_put = $var_;
        @ $fp = fopen($file_name, "a");
        if ($fp) {
            flock($fp, 2);
            fputs($fp, $str_put . "\n");
            flock($fp, 3);
            fclose($fp);
            $bool = true;
        }
        return $bool;
    }

    function fileNameLogDescarga() {
        $path = "log/";
        $name = date("Ymd");
        $ext = ".descarga";
        return $path . $name . $ext;
    }

}
