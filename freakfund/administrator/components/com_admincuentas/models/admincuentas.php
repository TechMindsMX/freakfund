<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
jimport('trama.class');
jimport('trama.usuario_class');

class admincuentasModeladmincuentas extends JModelList
{
	public function getlistadoCuentas() {
		$db 	= JFactory::getDbo();
		$query 	= $db->getQuery(true); 
		
		$query->select ('c3rn2_users.name, c3rn2_users_middleware.idJoomla, c3rn2_users_middleware.idMiddleware')
			  ->from ('c3rn2_users')
			  ->join('INNER', 'c3rn2_users_middleware ON c3rn2_users_middleware.idJoomla = c3rn2_users.id');
		
		$db->setQuery($query);
		
		$results = $db->loadObjectList();
		
		foreach ($results as $key => $value) {
			//simulacion del numero de cuenta
			$balance = json_decode(file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/user/get/'.$value->idMiddleware));
			$value->balance = $balance->balance;
			
			$num = microtime();
			$test = str_replace(' ', '', $num);
			$test2 = str_replace('.', '', $test);
			$num = (int) $test2;
					
			$value->numCuenta = $num;
			$value->cuentaOrigen = 783016001383946222;
			sleep(.5);
			//Fin simulacion de numeros de cuenta
		}

		return $results;
	}

	public function producerIdJoomlaANDName($obj,$id=null){
		if($id == null){
			$id = $obj->userId;
		}
		
		$obj->idJoomla = UserData::getUserJoomlaId($id);
		$obj->producerName = JFactory::getUser($obj->idJoomla)->name;
	}
}