<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
jimport('trama.class');
jimport('trama.usuario_class');

class detalleProyectoModeldetalleProyecto extends JModelList
{
	public function getdetalleProy() {
		$idProy = JFactory::getApplication()->input;
		$idProy = $idProy->get('id');
		
		$detalleProyecto = JTrama::getDatos($idProy);
		
		self::producerIdJoomlaANDName($detalleProyecto);
		
		foreach ($detalleProyecto->providers as $key => $value) {
			self::producerIdJoomlaANDName($value, $value->providerId, $detalleProyecto->userId);
			if ($value->isProducer){
				array_unshift($detalleProyecto->providers, $value);
			}
			self::flags($value);
		}
			var_dump($detalleProyecto->providers);exit;
		
		return $detalleProyecto;
	}

	public function producerIdJoomlaANDName($obj,$id = null, $producerid = null){
		if($id == null){
			$id = $obj->userId;
		}
	
		$obj->isProducer = ( $id == $producerid) ? true : false;
		
		$obj->idJoomla = UserData::getUserJoomlaId($id);
		$obj->producerName = JFactory::getUser($obj->idJoomla)->name;
	}
	
	public function flags($obj)	{
		$obj->flags = 0;
		$obj->flagsTxt = '';
		
		if (isset($advancePaidDate) OR isset($advanceFundingDate)) {
			$obj->flagsTxt .= '<p>'.JText::_('COM_APORTACIONESCAPITAL_ADVANCE_PAID').'</p>';
			$obj->flags++;
		}
		if (isset($settlementPaidDate) OR isset($settlementFundingDate)) {
			$obj->flagsTxt .= '<p>'.JText::_('COM_APORTACIONESCAPITAL_SETTLEMENT_PAID').'</p>';
			$obj->flags++;
		}
	}
}