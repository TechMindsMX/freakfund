<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
jimport('trama.class');
jimport('trama.usuario_class');

class confirmtxModelconfirmtx extends JModelList
{
	public function getconfirmTx() {
		$idProy = JFactory::getApplication()->input;
		$idProy = $idProy->get('id');
		
		$idProv = JFactory::getApplication()->input;
		$idProv = $idProv->get('providerId');
		
		$detalleProveedor = JTrama::getDatos($idProy)->providers;
		
		foreach ($detalleProveedor as $key => $value) {
			if($value->providerId == $idProv){
				self::producerIdJoomlaANDName($value, $idProv);
				$detalleProveedor = $value;
			}
		}		
		
		return $detalleProveedor;
	}

	public function producerIdJoomlaANDName($obj,$id=null){
		if($id == null){
			$id = $obj->userId;
		}
		
		$obj->idJoomla = UserData::getUserJoomlaId($id);
		$obj->producerName = JFactory::getUser($obj->idJoomla)->name;
	}
}