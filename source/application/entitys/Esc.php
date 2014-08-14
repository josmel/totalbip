<?php
sleep(2);
   $xml = file_get_contents("http://174.121.234.90/Moso/WSMultimedia/wsTOOLS.asmx/RegistrarDescarga?operadora=3&numUser=" . $argv[1] . "&idContenido=0&catalogo=" . $argv[2] . "&esGratis=True");
        $x = new SimpleXMLElement($xml);
        $ID = $x;
        $logDescarga = new Application_Entity_MdLog();
        $logDescarga->getPutsDescargaLOG("http://174.121.234.90/mvpe/Baja.aspx", $ID, $argv[1], $argv[2]);
        header("Location: http://174.121.234.90/nxpe/Baja.aspx?id=" . $ID);
      echo  "mama";

exit;