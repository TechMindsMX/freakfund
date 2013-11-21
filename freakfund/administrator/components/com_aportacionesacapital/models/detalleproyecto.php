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
				unset($detalleProyecto->providers[$key]);
				array_unshift($detalleProyecto->providers, $value);
			}
		}
		foreach ($detalleProyecto->providers as $key => $value) {
			self::flags($value);
		}
		
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
		if (($obj->isProducer) OR !$obj->isProducer AND isset($this->ProductorAporto)) {
			$obj->flags = 0;
			$obj->flagsTxt = '';
		
			if (isset($obj->advancePaidDate) OR isset($obj->advanceFundingDate)) {
				if(isset($obj->advancePaidDate)) $obj->flagsTxt .= '<p>'.JText::_('COM_APORTACIONESCAPITAL_ADVANCE_PAID').'</p>';
				if(isset($obj->advanceFundingDate)) $obj->flagsTxt .= '<p>'.JText::_('COM_APORTACIONESCAPITAL_ADVANCE_WAIVED').'</p>';
				$obj->flags++;
			}
			if (isset($obj->settlementPaidDate) OR isset($obj->settlementFundingDate)) {
				if(isset($obj->settlementPaidDate)) $obj->flagsTxt .= '<p>'.JText::_('COM_APORTACIONESCAPITAL_SETTLEMENT_PAID').'</p>';
				if(isset($obj->settlementFundingDate)) $obj->flagsTxt .= '<p>'.JText::_('COM_APORTACIONESCAPITAL_SETTLEMENT_WAIVED').'</p>';
				$obj->flags++;
			}
			if ($obj->isProducer AND $obj->flags >= 1) {
				$this->ProductorAporto = true;
			}
		} else {
			$obj->flags = 3;
			$obj->flagsTxt = '<p>'.JText::_('COM_APORTACIONESCAPITAL_PRODUCTOR_PRIMERO').'</p>';
		}
	}
}