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
		$input				= JFactory::getApplication()->input;
		$projectId 			= $input->get('projectId', null, 'str');
		$providerId 		= $input->get('providerId', null, 'str');
		$producer			= $input->get('producer', 0, 'str');
		$advance			= $input->get('anticipo', null, 'str');
		$settlement			= $input->get('liquidacion', null, 'str');
		$detalleProveedor 	= JTrama::getDatos($projectId);
		$nombreProducto 	= $detalleProveedor->name;

		foreach ($detalleProveedor->providers as $key => $value) {
			if($value->providerId == $providerId){
				self::producerIdJoomlaANDName($value, $providerId);
				$detalleProveedor = $value;
			}
		}
		
		$anticipo		= isset($advance) 		? (int) $detalleProveedor->advanceQuantity 		: null;
		$liquidacion	= isset($settlement)	? (int) $detalleProveedor->settlementQuantity 	: null;
		
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
		$detalleProveedor->callback		= JURI::base().'index.php?option=com_aportacionesacapital&task=errors&proyId='.$projectId;
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