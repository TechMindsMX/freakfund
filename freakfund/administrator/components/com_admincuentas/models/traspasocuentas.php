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
		$datos['cuentaOrigen']	= $app->get('numCuenta',		null, 'string');
		$datos['balance']		= $app->get('balance',			null, 'string');
		$datos['accountDest']	= $app->get('cuentaDestino',	null, 'string');
		$datos['amount']		= $app->get('amount', 			null, 'string');
		$datos['name']			= $app->get('name', 			null, 'string');
		$datos['error']			= $app->get('error', 			null, 'string');
		$datos['callback']		= JURI::base().'index.php?option=com_admincuentas&task=traspasocuentas&numCuenta='.$datos['cuentaOrigen'];
		
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