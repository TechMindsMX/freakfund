<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
jimport('trama.class');
jimport('trama.usuario_class');

class traspasocuentasModeltraspasocuentas extends JModelList
{
	public function getlistadoCuentas() {
		$datos					= array();
		$app					= JFactory::getApplication()->input;
		$datos['idCuenta']		= $app->get('idAccount',		null, 'string');
		$cuentasAdmin 			= json_decode(file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/bank/listAdministrativeAccounts'));
		
		foreach ($cuentasAdmin as $key => $value) {
			if($value->id == $datos['idCuenta']){
				$datos['cuentaOrigen'] 	= $value->account;
				$datos['balance']		= $value->balance;
				$datos['tipo']			= $value->type;
			}
		}
		
		$datos['accountDest']	= $app->get('cuentaDestino',	null, 'string');
		$datos['amount']		= $app->get('amount', 			null, 'string');
		$datos['name']			= $app->get('name', 			null, 'string');
		$datos['error']			= $app->get('error', 			null, 'string');
		$datos['callback']		= JURI::base().'index.php?option=com_admincuentas&task=traspasocuentas';
		
		if( is_null($datos['accountDest']) && is_null($datos['amount']) ){
			$datos['resumen'] = 'false';
		}else{
			$datos['resumen'] = 'true';
		}
		
		return $datos;
	}

	public function producerIdJoomlaANDName($obj,$id=null){
		if($id == null){
			$id = $obj->userId;
		}
		
		$obj->idJoomla = UserData::getUserJoomlaId($id);
		$obj->producerName = JFactory::getUser($obj->idJoomla)->name;
	}
}