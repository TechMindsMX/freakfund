<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
jimport('trama.class');
jimport('trama.usuario_class');

class aporteproveedorModelaporteproveedor extends JModelList
{
	public function getdetalleProv() {
		$input				= JFactory::getApplication()->input;
		$idProy				= $input->get('id');
		$idProveedor		= $input->get('providerId');
		$producer 			= $input->get('producer','false','bool');
		$balance 			= JTrama::getDatos($idProy);
		$detalleProveedor 	= JTrama::getDatos($idProy)->providers;
		
		foreach ($detalleProveedor as $key => $value) {
			if($value->providerId == $idProveedor){
				self::producerIdJoomlaANDName($value, $idProveedor);
				$detalleProveedor = $value;
			}
		}
		if($producer){
			$detalleProveedor->comtitle = 'COM_APORTACIONESCAPITAL_DETALLEPRODUCTOR_TITLE';
		} else {
			$detalleProveedor->comtitle = 'COM_APORTACIONESCAPITAL_DETALLEPROVEEDOR_TITLE';
		}

		$detalleProveedor->producer = ($producer == 'true') ? true : false;
		$detalleProveedor->balance	= $balance->breakeven - $balance->balance;
		
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