<?php

/**
 * Description of User
 *
 * @author Josmel
 */
class Application_Model_Rt_Cdr extends App_Db_Table_Abstract {

	protected $_name = 'cdrRt';
	const TABLA_CDR = 'cdrRt';
        
	public function saveCdr($datos) {
		try {
			$db = $this->getDefaultAdapter();
			$db->insert($this->_name, $datos);
			$id = $db->lastInsertId($this->_name, "codigo");
			
			$this->saveCdrText($datos, $id);

			return $id;

		} catch (Exception $e){
			echo $e->getMessage();exit;
			return false;
		}
		 
	}

	private function saveCdrText($datos, $id) {
		
		$name = date('YmdH');		 
		$writer = new Zend_Log_Writer_Stream(APPLICATION_PATH . '/../logs/cdr/rt/'.$name.".moso");
		//$writer = new Zend_Log_Writer_Stream('/var/log/portalwap/'.$name.".moso");
                $formatter = new Zend_Log_Formatter_Simple('%message%' . PHP_EOL);
		$writer->setFormatter($formatter);
		$log = new Zend_Log($writer);
		
		$mensaje = $datos['fecha'] . "," . $datos['hora'] . "," . $id . "," . $_SERVER['REMOTE_ADDR'] 
		. "," . $_SERVER['SERVER_ADDR'] . "," . $datos['telefono'] . ",perfil:".$datos['perfil'] 
		. "," . $datos['url'] . "," . $datos['user_agent'];
		
		$log->info($mensaje);

	}


}