<?php

class Application_Entity_MdLog {

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


//LOG DE DESCARGAS

    function getPutsDescargaLOG($url, $id, $numero, $codigo_catalogo) {
        if (isset($_SERVER['HTTP_X_UP_CALLING_LINE_ID']) && $_SERVER['HTTP_X_UP_CALLING_LINE_ID'] != "") {
            $str_number = $_SERVER['HTTP_X_UP_CALLING_LINE_ID'];
        } else {
            $str_number = $_GET['nu'];
        }
        
        $datos = array(
            'fecha' => date("Y-m-d"),
            'hora' => date("H:i:s"),
            'url' => $url,
            'id' => $id,
            'codigo_catalogo' => $codigo_catalogo,
            'numero' => $numero,
        );
        $id = $this->saveCdrDescargas($datos);
        return $id;
    }

    private function saveCdrDescargas($datos) {

        $name = date('YmdH');
        $writer = new Zend_Log_Writer_Stream(APPLICATION_PATH . '/../logs/cdr/rt/descargas/' . $name . ".descarga");
        //$writer = new Zend_Log_Writer_Stream('/var/log/portalwap/'.$name.".moso");
        $formatter = new Zend_Log_Formatter_Simple('%message%' . PHP_EOL);
        $writer->setFormatter($formatter);
        $log = new Zend_Log($writer);

        $mensaje = $datos['fecha'] . "," . $datos['hora'] . "," . $datos['url'] . "," . $datos['id']
                . "," . $datos['codigo_catalogo'] . "," . $datos['numero'];
        $log->info($mensaje);
    }

}
