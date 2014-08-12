<?php

require_once('nusoap/lib/nusoap.php');

class Application_Entity_CobroShootLink {

    function shootLink($NUMBER, $CODIGO, $VERIFICATION, $f, $c, $t, $i) {

        if ((strlen($NUMBER) == 11) and ( substr($NUMBER, 0, 2) == "51")) {
            $xml = file_get_contents("http://174.121.234.90/Moso/WSMultimedia/wsTOOLS.asmx/RegistrarDescarga?operadora=3&numUser=" . $NUMBER . "&idContenido=0&catalogo=" . $CODIGO . "&esGratis=False");
            $x = new SimpleXMLElement($xml);
            $ID = $x;
            getPutsDescargaLOG("http://174.121.234.90/mvpe/Baja.aspx", $ID, $NUMBER, $CODIGO);
            if (is_numeric($f) && $f == 0) {
                if (is_numeric($t) && $t != 0)
                    $this->validarTarifa(3, '4556', $c, $t, $i);
            }
            header("Location: http://174.121.234.90/nxpe/Baja.aspx?id=" . $ID);
        } else {
            header("Location: /pe/ne/wap/ft/");
            exit;
        }
    }

    function validarTarifa($operadora, $numServ, $catalogo, $tarifa, $codigoEncriptado) {

        $wsCliente = 'http://174.121.234.90/moso/WSMultimedia/wstools.asmx?wsdl';

        $SoapClient = new nusoap_client($wsCliente, true);
        if ($Error = $SoapClient->getError()) {
            echo "No se pudo realizar la operaci&oacute;n de conexi&oacute;n[" . $Error . "]";
            echo "<body></body></html>";
            die();
        }
        if ($SoapClient->fault) { // Si
            echo 'No se pudo completar la operaci&oacute;n ...';
            echo "<body></body></html>";
            die();
        } else { // No
            $aError = $SoapClient->getError();
            // Hay algun error ?
            if ($Error) { // Si
                echo 'Error:' . $Error;
                echo "<body></body></html>";
                die();
            }
        }

        $Parametros = array('operadora' => $operadora, 'numServ' => $numServ, 'catalogo' => $catalogo, 'tarifa' => $tarifa, 'codigoEncriptado' => $codigoEncriptado);
        //print_r( $Parametros);
        $Respuesta = $SoapClient->call("RegistrarLicenciaMultimedia", $Parametros);
        //print_r($Respuesta);
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
    }

    function EstaSuscrito($NUMBER, $codigo) {
        $tparam = array(
            "operadora" => 3,
            "numUser" => $NUMBER,
            "servicio" => $codigo
        );
        $wsClient = 'http://174.121.234.90/moso/WSMultimedia/wstools.asmx?wsdl';
        $SoapClien = new nusoap_client($wsClient, true);
        $rptsus = $SoapClien->call("EstaSuscrito", $tparam);
        return $rptsus['EstaSuscritoResult'];
    }

    function WSCobrosXBI($NUMBER, $idSrv) {
        $params = array(
            'token' => "M0b1l3.",
            'idSrv' => $idSrv,
            'desSrv' => 'RealTone',
            'iv' => 11,
            'sc' => 70,
            'ssc' => '00000',
            'nu' => $NUMBER,
            'sqn' => 50
        );
        $wsClienteXBI = 'http://174.121.234.90/Moso/WSCobrosXBI/PE_Nextel.asmx?wsdl';
        $SoapClientXBI = new nusoap_client($wsClienteXBI, true);
        $tarifas = array('01530', '00840', '00420');
        for ($i = 0; $i < count($tarifas); $i++) {
            $params['ssc'] = $tarifas[$i];
            $RespuestaXBI = $SoapClientXBI->call("CobroXBI", $params);
            if ($RespuestaXBI['CobroXBIResult'] == "0")
                break;
        }
        return $RespuestaXBI['CobroXBIResult'];
    }

    function EstaSuscritoFree($NUMBER) {

        $wsEsFreeUser = 'http://174.121.234.90/moso/WSMultimedia/wstools.asmx?wsdl';
        $SoapEsFreeUser = new nusoap_client($wsEsFreeUser, true);
        $parametros = array(
            'pais' => "51",
            'numuser' => $NUMBER,
        );
        $resultado = $SoapEsFreeUser->call('EsFreeUser', $parametros);
        return $resultado['EsFreeUserResult'];
    }

    ///////////////// RT//////////////////////////////////////

    function shootLink2($NUMBER, $CODIGO, $VERIFICATION, $serv = "_RTWAPNX") {

        $parmorigen = '&o=7';
        $ruta = "http://174.121.234.90/SVARequest/Request.aspx?op=3&nu=" . $NUMBER . "&sc=4556&su=1&k=" . $serv . "&v=" . $VERIFICATION . $parmorigen . "&re=17";

        header("Location: $ruta");
        exit;
    }

    function shootLinkRT($NUMBER, $CODIGO, $VERIFICATION) {

        if ((strlen($NUMBER) == 11) and ( substr($NUMBER, 0, 2) == "51")) {

            $EstaSuscritoResult = $this->EstaSuscrito($NUMBER, 124);
            if ($EstaSuscritoResult == '0') {
                header("Location: http://m.tuyonextel.com.pe/suscribete.php?serv=_RTWAPNX");
                exit;
            }

            //respuestas 
            //"4241";//saldo insuficiente
            //"5241";//No esta provisionado en ALU y ATS
            //"5004";//Falta parametro en request
            $EstaSuscritoFree = $this->EstaSuscritoFree($NUMBER, 124);
            if ($EstaSuscritoFree == '1') {
                $this->file_get_contents($NUMBER, $CODIGO);
            } else {
                $CobroXBIResult = $this->WSCobrosXBI($NUMBER, 124);
                if ($CobroXBIResult == "0") {
                    $this->file_get_contents($NUMBER, $CODIGO);
                } else {
                    $cadena = '&nue=' . $NUMBER;
                    header('Location: /pe/ne/wap/rt-devel/?error=007' . $cadena);
                    exit;
                }
            }
        } else {
            header("Location: /pe/ne/wap/rt-devel/");
            exit;
        }
    }

    function file_get_contents($NUMBER, $CODIGO) {
        $xml = file_get_contents("http://174.121.234.90/Moso/WSMultimedia/wsTOOLS.asmx/RegistrarDescarga?operadora=3&numUser=" . $NUMBER . "&idContenido=0&catalogo=" . $CODIGO . "&esGratis=True");
        $x = new SimpleXMLElement($xml);
        $ID = $x;
        header("Location: http://174.121.234.90/nxpe/Baja.aspx?id=" . $ID);
    }

}
