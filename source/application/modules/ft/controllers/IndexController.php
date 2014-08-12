<?php

class Ft_IndexController extends Zend_Controller_Action {

    public function init() {
        $this->_helper->layout->setLayout('layout-ft');
        $ua = $_SERVER['HTTP_USER_AGENT'];
        $model = new Application_Model_Ft_ConfigPerfil();
        $controller = $this->getParam('controller');
        $model->getPerfil($ua, $controller);
    }

    public function indexAction() {

        $t = $this->_getParam('t',"");
        $f = $this->_getParam('f',"");
        $i = $this->_getParam('i',"");
        $token = $this->_getParam('token',"");
        $nuetxt = $this->_getParam('nuetxt',"");
        $portal = $this->_getParam('portal',"");
//        $t = isset($_GET["t"]) ? $_GET["t"] : "";
//        $f = isset($_GET["f"]) ? $_GET["f"] : "";
//        $i = isset($_GET["i"]) ? $_GET["i"] : "";
//        $token = isset($_GET["token"]) ? $_GET["token"] : "";
//        $nuetxt = isset($_GET["nue"]) ? $_GET["nue"] : "";
        $portal = new Application_Entity_PooArweb();
        $nusoap = new Application_Entity_Nusoap();
        $DESTACADOs = $portal->getDestacado();
        $BODYs = $portal->getCuerpo();
        $TituloPortal = $portal->getTituloPortal();
        $BANERs = $portal->getBaner();
        $dataContenido = $nusoap->getContenido("wsRTConsultarAlbum", "1", $DESTACADOs[0]["ALBUM"], $DESTACADOs[0]["KEYWORD"], $DESTACADOs[0]["FILASXPAGINA"], $DESTACADOs[0]["NUMPAGINA"]);
        $dataContenidoBody = $nusoap->getContenido("wsRTConsultarAlbum", "1", $BODYs[0]["ALBUM"], $BODYs[0]["KEYWORD"], $BODYs[0]["FILASXPAGINA"], $BODYs[0]["NUMPAGINA"]);


        if (isset($i) && strlen($i) > 0) {
            $url = 'http://174.121.234.90/Moso/Cript/process.aspx?d1=' . $i;
            $content = file_get_contents($url);
            $separador = "|";
            $parametros = explode($separador, $content);

            $tnun = (is_numeric($parametros[0]) ? (int) $parametros[0] : 0);
        }

        if (isset($token) and $token != '') {
            $num = base64_decode($token);
            if ($num) {
                $web = "http://174.121.234.90/SVARequest/Request.aspx?nu=$num&op=3&su=1&sc=4556&k=f&o=24";
                $result = file_get_contents($web);
                if ($result == 'OK') {
                    //header("Location: index.php") && die();
                }
            }
        }

        if (isset($_SERVER['HTTP_MSISDN']) && $_SERVER['HTTP_MSISDN'] != "") {
            $str_number = $_SERVER['HTTP_MSISDN'];
        }
        if (isset($_SERVER['HTTP_COOKIE']) && $_SERVER['HTTP_COOKIE'] != "") {
            $b = strpos($_SERVER['HTTP_COOKIE'], "msisdn=") + 7;
            if ($b != "7") {
                $num = substr($_SERVER['HTTP_COOKIE'], $b);
                $str_number = $num;
            }
        }
        if (isset($_SERVER['HTTP_X_UP_CALLING_LINE_ID']) && $_SERVER['HTTP_X_UP_CALLING_LINE_ID'] != "") {
            $str_number = $_SERVER['HTTP_X_UP_CALLING_LINE_ID'];
        }

        if (isset($_GET['nue']) && $_GET['nue'] != "") {
            $str_number = $_GET['nue'];
        }
        if (isset($_SERVER['HTTP_X_UP_SUBNO']) && $_SERVER['HTTP_X_UP_SUBNO'] != "") {
            $dosG = $_SERVER['HTTP_X_UP_SUBNO'];
            //$dosG = "PER0006111680_net2.nextelinternational.com";
            $url = file_get_contents("http://wsperu.multibox.pe/ws-nextel.php?nextel-2g=$dosG");
            $conteDosG = json_decode($url);
            $str_number = "51" . $conteDosG->PTN;
        }
//        if (!isset($str_number)) {
//            header("Location: http://m.tuyonextel.com.pe/validacion.php?serv=_FTWAPNX");
//            exit;
//        } else {
//            $CobroShootLink = new Application_Entity_CobroShootLink();
//            $EstaSuscritoResult = $CobroShootLink->EstaSuscrito($str_number, 130);
//            if ($EstaSuscritoResult == '0' and ! isset($str_number)) {
//                header("Location: http://m.tuyonextel.com.pe/validacion.php?serv=_FTWAPNX");
//            }
//            exit;
//        }

        $this->view->nuetxt = $nuetxt;
        $this->view->DESTACADOs = $DESTACADOs;
        $this->view->TituloPortal = $TituloPortal;
        $this->view->dataContenido = $dataContenido;
        $this->view->dataContenidoBody = $dataContenidoBody;
        $this->view->BANERs = $BANERs;
        $this->view->BODYs = $BODYs;
        $this->view->t = $t;
        $this->view->f = $f;
        $this->view->i = $i;
    }

    public function validacionAction() {
     $v = $this->_getParam('v',"1");
     $c = $this->_getParam('c',header("Location: http://bip.pe/pe/ne/wap/ft/") && die());
     $t = $this->_getParam('t',header("Location: http://bip.pe/pe/ne/wap/ft/") && die());
     $f = $this->_getParam('f',header("Location: http://bip.pe/pe/ne/wap/ft/") && die());
     $i = $this->_getParam('i',"");
     $nue = $this->_getParam('nue',"");
     $num = $this->_getParam('num',"");
     $CobroShootLink = new Application_Entity_CobroShootLink();
        if (isset($_SERVER['HTTP_X_UP_CALLING_LINE_ID']) && $_SERVER['HTTP_X_UP_CALLING_LINE_ID'] != "") {
            $str_number = $_SERVER['HTTP_X_UP_CALLING_LINE_ID'];
            $CobroShootLink->shootLink($str_number, $c, "0",$f,$c,$t,$i);
        }
        if (isset($_SERVER['HTTP_MSISDN']) && $_SERVER['HTTP_MSISDN'] != "") {
            $str_number = $_SERVER['HTTP_MSISDN'];
            $CobroShootLink->shootLink($str_number, $c, "0",$f,$c,$t,$i);
        }
        if (isset($_SERVER['HTTP_X_UP_SUBNO']) && $_SERVER['HTTP_X_UP_SUBNO'] != "") {
            $dosG = $_SERVER['HTTP_X_UP_SUBNO'];
            $url = file_get_contents("http://wsperu.multibox.pe/ws-nextel.php?nextel-2g=$dosG");
            $conteDosG = json_decode($url);
            $str_number = "51" . $conteDosG->PTN;
            $CobroShootLink->shootLink($str_number, $c, "0",$f,$c,$t,$i);
        }
        if (isset($_SERVER['HTTP_COOKIE']) && $_SERVER['HTTP_COOKIE'] != "") {
            $b = strpos($_SERVER['HTTP_COOKIE'], "msisdn=") + 7;
            if ($b != "7") {
                $num = substr($_SERVER['HTTP_COOKIE'], $b);
                $str_number = $num;
                $CobroShootLink->shootLink($str_number, $c, "0",$f,$c,$t,$i);
            }
        }
        /* Numero con el I */
        if (isset($i) && strlen($i) > 0) {
            $token = $_GET['i'];
            $url = 'http://174.121.234.90/Moso/Cript/process.aspx?d1=' . $token;
            $content = file_get_contents($url);
            $separador = "|";
            $parametros = explode($separador, $content);

            $tnun = (is_numeric($parametros[0]) ? (int) $parametros[0] : 0);
            $fecha = (is_numeric($parametros[1]) ? (int) $parametros[1] : 0);
            $tcad = (is_numeric($parametros[3]) ? (int) $parametros[3] : 0);

            $now = date("Y-m-d");
            $fechaVen = date("Y-m-d", strtotime("$fecha + $tcad day"));
            if ($now > $fechaVen)
                header('Location: /pe/ne/wap/ft/');
            else
                $CobroShootLink->shootLink($tnun, $c, "0",$f,$c,$t,$i);
        }

        /* fin */


        if (isset($nue)) {
            $number = $nue;
            if (( strlen($number) == 11)) {
                if (substr($number, 0, 2) == "51") {
                    $CobroShootLink->shootLink3($number, $c, "0",$f,$c,$t,$i);
                }
            } elseif (strlen($number) == 9) {
                if (substr($number, 0, 2) !== "51") {
                    $CobroShootLink->shootLink3("51" . $number, $c, "0",$f,$c,$t,$i);
                }
            }
        }


        if (isset($num)) {
            $number = $num;
            if (( strlen($number) == 11)) {
                if (substr($number, 0, 2) == "51") {
                    $CobroShootLink->shootLink($number, $c, "1",$f,$c,$t,$i);
                }
            } elseif (strlen($number) == 9) {
                if (substr($number, 0, 2) !== "51") {
                    $CobroShootLink->shootLink("51" . $number, $c, "1",$f,$c,$t,$i);
                }
            }
        }
        $this->view->serv = $serv;
        $this->view->c = $c;
        $this->view->v = $v;
    }

    public function goAction() {
        $_getVars = $_GET;
        $_key = array_keys($_getVars);
        $_valor = array_values($_getVars);

        $numGet = count($_getVars);
        $bucleGet = $numGet - 1;
        for ($x = 0; $x <= $bucleGet; $x++) {
            if ($x == 0) {
                $link.=$_valor[$x];
            } else {
                $link.="&" . $_key[$x] . "=" . $_valor[$x];
            }
        }
        $ua = $_SERVER['HTTP_USER_AGENT'];
        $model = new Application_Model_Ft_ConfigPerfil();
        $controller = $this->getParam('controller');
        $model->getPerfil($ua, $controller, $link);
        header("Location: " . $link);
        exit;
    }

    public function legalAction() {

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
            $nue = $_GET['nue'];
            $validar_sms = false;
            if (strlen($nue) < 11) {
                $nue = "51" . $nue;
            }
            $nuetxt = "&amp;nue=" . $nue;
        }

        if (isset($_GET['validar_sms']) && $_GET['validar_sms'] != "") {
            $validar_sms = $_GET['validar_sms'];
        }

        if ($validar_sms == true)
            $val_sms = 1;
        else
            $val_sms = 0;
    }

}
