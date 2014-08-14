<?php

class Rt_IndexController extends Zend_Controller_Action {

    public function init() {
        $this->_helper->layout->setLayout('layout-rt');
        $ua = $_SERVER['HTTP_USER_AGENT'];
        $model = new Application_Model_Rt_ConfigPerfil();
        $controller = $this->getParam('controller');
        $model->getPerfil($ua, $controller);
    }

    public function indexAction() {

        //  phpinfo();exit;
//        $t = isset($_GET["t"]) ? $_GET["t"] : "";
//        $f = isset($_GET["f"]) ? $_GET["f"] : "";
//        $i = isset($_GET["i"]) ? $_GET["i"] : "";
        $t = $this->_getParam('t', NULL);
        $f = $this->_getParam('f', NULL);
        $i = $this->_getParam('i', NULL);
        $error = $this->_getParam('error', NULL);
        $nue = $this->_getParam('nue', NULL);
        $num = $this->_getParam('num', NULL);
        $nuetxt = $this->_getParam('nuetxt', NULL);

        $validar_sms = $this->_getParam('validar_sms', NULL);
        $token = $this->_getParam('token', NULL);
        $portal = new Application_Entity_PooArwebRt();
        $nusoap = new Application_Entity_Nusoap();
        $DESTACADOs = $portal->getDestacado();
        $BODYs = $portal->getCuerpo();
        $TituloPortal = $portal->getTituloPortal();
        $BANERs = $portal->getBaner();
        $dataContenido = $nusoap->getContenido("wsRTConsultarAlbum", "1", "67", "_RTWAP", "1", "0");
        $dataContenidoBody = $nusoap->getContenido("wsRTConsultarAlbum", "1", $BODYs[0]["ALBUM"], $BODYs[0]["KEYWORD"], $BODYs[0]["FILASXPAGINA"], $BODYs[0]["NUMPAGINA"]);

        if (isset($validar_sms) && $validar_sms != "") {
            $validar_smsT = $validar_sms;
            if ($validar_smsT == true)
                $val_sms = 1;
            else
                $val_sms = 0;
            $this->view->val_sms = $val_sms;
        }


        $nx = false;
        if (isset($nue) && $nue != "") {
            if (strlen($nue) == 11)
                $numx = $nue;
            if (strlen($_GET['nue']) == 9)
                $numx = "51" . $nue;
        }

        if (isset($token) and $token != '') {
            $num = base64_decode($token);
            if ($num and ( strlen($num) == 11) and ( substr($num, 0, 2) == "51")) {

                $web = "http://174.121.234.90/SVARequest/Request.aspx?nu=$num&op=3&su=1&sc=4556&k=t&o=24";
                $result = file_get_contents($web);
                if ($result == 'OK') {
                    header("Location: /pe/ne/wap/rt-devel/") && die();
                }
            }
        }
        if (isset($i) && strlen($i) > 0) {
            $url = 'http://174.121.234.90/Moso/Cript/process.aspx?d1=' . $i;
            $content = file_get_contents($url);
            $separador = "|";
            $parametros = explode($separador, $content);
            $tnun = (is_numeric($parametros[0]) ? (int) $parametros[0] : 0);
            $fecha = (is_numeric($parametros[1]) ? (int) $parametros[1] : 0);
            $tcad = (is_numeric($parametros[3]) ? (int) $parametros[3] : 0);
            $now = date("Y-m-d");
            $fechaVen = date("Y-m-d", strtotime("$fecha + $tcad day"));
            if ($now > $fechaVen) {
                echo "vencio";
                header('Location: /pe/ne/wap/rt-devel/');
            }
        }

        if (isset($nue)) {
            
        } else {
            if (!isset($num)) {
                header("Location: http://m.tuyonextel.com.pe/validacion.php?serv=_RTWAPNX");
                exit;
            } else {
                $CobroShootLink = new Application_Entity_CobroShootLink();
                $EstaSuscritoResult = $CobroShootLink->EstaSuscrito($num, 124);
                if ($EstaSuscritoResult == '0') {
                    header("Location: http://m.tuyonextel.com.pe/validacion.php?serv=_RTWAPNX");
                }
                
            }
        }
 
        $this->view->DESTACADOs = $DESTACADOs;
        $this->view->TituloPortal = $TituloPortal;
        $this->view->dataContenido = $dataContenido;
        $this->view->dataContenidoBody = $dataContenidoBody;
        $this->view->BANERs = $BANERs;
        $this->view->BODYs = $BODYs;
        $this->view->error = $error;
        $this->view->t = $t;
        $this->view->num = $num;
        $this->view->nue = $nue;
        $this->view->nuetxt = $nuetxt;
        $this->view->f = $f;
        $this->view->i = $i;
    }

    public function validacionAction() {
     $CobroShootLink = new Application_Entity_CobroShootLink();
        $v = isset($_GET['v']) ? $_GET['v'] : "1";
        $c = isset($_GET['c']) ? $_GET['c'] : header("Location: ../rt/") && die();
        if (isset($_SERVER['HTTP_MSISDN']) && $_SERVER['HTTP_MSISDN'] != "") {
            $str_number = $_SERVER['HTTP_MSISDN'];
            $CobroShootLink->shootLinkRT($str_number, $c, "0");
        }

        if (isset($_GET['nue'])) {
            $number = $_GET['nue'];
            if (( strlen($number) == 11)) {
                if (substr($number, 0, 2) == "51") {
                    $CobroShootLink->shootLink2($number, $c, "0");
                }
            } elseif (strlen($number) == 9) {
                if (substr($number, 0, 2) !== "51") {
                    $CobroShootLink->shootLink2("51" . $number, $c, "0");
                }
            }
        }


        if (isset($_GET['num'])) {
            $number = $_GET['num'];
            if (( strlen($number) == 11)) {
                if (substr($number, 0, 2) == "51") {
                    $CobroShootLink->shootLinkRT($number, $c, "1");
                }
            } elseif (strlen($number) == 9) {
                if (substr($number, 0, 2) !== "51") {
                    $CobroShootLink->shootLinkRT("51" . $number, $c, "1");
                }
            }
        }

        if (isset($_SERVER['HTTP_X_UP_CALLING_LINE_ID']) && $_SERVER['HTTP_X_UP_CALLING_LINE_ID'] != "") {
            $str_number = $_SERVER['HTTP_X_UP_CALLING_LINE_ID'];
            $CobroShootLink->shootLinkRT($str_number, $c, "0");
        }

        if (isset($_SERVER['HTTP_MSISDN']) && $_SERVER['HTTP_MSISDN'] != "") {
            $str_number = $_SERVER['HTTP_MSISDN'];
            $CobroShootLink->shootLinkRT($str_number, $c, "0");
        }

        if (isset($_SERVER['HTTP_COOKIE']) && $_SERVER['HTTP_COOKIE'] != "") {
            $b = strpos($_SERVER['HTTP_COOKIE'], "msisdn=") + 7;
            if ($b != "7") {
                $num = substr($_SERVER['HTTP_COOKIE'], $b);
                $str_number = $num;
                $CobroShootLink->shootLinkRT($str_number, $c, "0");
            }
        }
        if (isset($_SERVER['HTTP_X_UP_SUBNO']) && $_SERVER['HTTP_X_UP_SUBNO'] != "") {
            $dosG = $_SERVER['HTTP_X_UP_SUBNO'];
            //$dosG = "PER0006111680_net2.nextelinternational.com";
            $url = file_get_contents("http://wsperu.multibox.pe/ws-nextel.php?nextel-2g=$dosG");
            $conteDosG = json_decode($url);
            $str_number = "51" . $conteDosG->PTN;
            $CobroShootLink->shootLinkRT($str_number, $c, "0");
        }


        //   $this->view->serv = $serv;
        $this->view->c = $c;
        $this->view->v = $v;
    }

    public function goAction() {

        $_getVars = $_GET;
        $_key = array_keys($_getVars);
        $_valor = array_values($_getVars);
        $link = '';
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
        $model = new Application_Model_Rt_ConfigPerfil();
        $controller = $this->getParam('controller');
        $model->getPerfil($ua, $controller, $link);
        header("Location: " . $link);
        exit;
    }

    public function alertaAction() {

        $_getVars = $_GET;

        $_key = array_keys($_getVars);
        $_valor = array_values($_getVars);
        $link = '';
        $numGet = count($_getVars);
        $bucleGet = $numGet - 1;
        for ($x = 0; $x <= $bucleGet; $x++) {
            if ($x == 0) {
                $link.=$_valor[$x];
            } else {
                $link.="&" . $_key[$x] . "=" . $_valor[$x];
            }
        }
        $this->view->link = $link;
    }

    public function legalAction() {
        $_GET['nu'] = isset($_GET['nu']) ? $_GET['nu'] : NULL;
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
