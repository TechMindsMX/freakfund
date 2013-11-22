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
		$data 				= JTrama::getDatos($idProy)->providers;
		
		foreach ($data as $key => $value) {
			if($value->providerId == $idProveedor){
				self::producerIdJoomlaANDName($value, $idProveedor);
				$data = $value;
			}
		}

		$data->proyecto 	= JTrama::getDatos($idProy);

		if($producer){
			$data->comtitle = 'COM_APORTACIONESCAPITAL_DETALLEPRODUCTOR_TITLE';
		} else {
			$data->comtitle = 'COM_APORTACIONESCAPITAL_DETALLEPROVEEDOR_TITLE';
		}

		$data->producer 				= ($producer == 'true') ? true : false;
		$data->proyecto->balanceToBE	= $data->proyecto->breakeven - $data->proyecto->balance;

		$data->disabled = ($data->advancePaidDate OR $data->advanceFundingDate) ? true : false;
		$data->disabledAdvance = ($data->advanceQuantity > $data->proyecto->balanceToBE ) ? true : false;
		$data->disabledSettlement = ($data->settlementQuantity > $data->proyecto->balanceToBE ) ? true : false;
		
		return $data;
	}

	public function producerIdJoomlaANDName($obj,$id=null){
		if($id == null){
			$id = $obj->userId;
		}
		
		$obj->idJoomla = UserData::getUserJoomlaId($id);
		$obj->producerName = JFactory::getUser($obj->idJoomla)->name;
	}

}