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
		$projectId 			= $_POST['projectId'];
		$providerId 		= $_POST['providerId'];
		$detalleProveedor 	= JTrama::getDatos($projectId);
		$nombreProducto 	= $detalleProveedor->name;
		
		foreach ($detalleProveedor->providers as $key => $value) {
			if($value->providerId == $providerId){
				self::producerIdJoomlaANDName($value, $providerId);
				$detalleProveedor = $value;
			}
		}
		
		$liquidacion		= isset($_POST['liquidacion']) 	? (int) $detalleProveedor->settlementQuantity 	: null;
		$anticipo			= isset($_POST['anticipo']) 	? (int) $detalleProveedor->advanceQuantity 		: null;
		
		if( !is_null($anticipo) && !is_null($liquidacion) ){
			$detalleProveedor->type 	= 2;
			$detalleProveedor->monto 	= $anticipo + $liquidacion;
		}elseif( is_null($anticipo) && !is_null($liquidacion) ){
			$detalleProveedor->type 	= 1;
			$detalleProveedor->monto 	= $liquidacion;
		}elseif( !is_null($anticipo) && is_null($liquidacion) ){
			$detalleProveedor->type 	= 0;
			$detalleProveedor->monto 	= $anticipo;
		}
		
		
		$detalleProveedor->token		= JTrama::token();
		$detalleProveedor->ProductName	= $nombreProducto;
		
		return $detalleProveedor;
	}

	public function producerIdJoomlaANDName($obj,$id=null){
		if($id == null){
			$id = $obj->userId;
		}
		
		$obj->idJoomla = (int) UserData::getUserJoomlaId($id);
		$obj->producerName = JFactory::getUser($obj->idJoomla)->name;
	}
}