<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
jimport('trama.class');
jimport('trama.usuario_class');

class statusproModelstatuspro extends JModelList
{
	public function getProd() {
		$temporal = JFactory::getApplication()->input;
		$temporal = $temporal->get('proyid');
		
		$query = JTrama::getDatos( $temporal );
		$query->percentage 	= round((($query->balance*100)/$query->breakeven),2);
		
		switch ($query->status) {
			case '5':
				$query->FechaApintar = JText::_('COM_FREAKFUND_PROJECTLIST_'.strtoupper('fundEndDate')).': '.$query->fundEndDate;
				break;
			case '6':
				$query->FechaApintar = JText::_('COM_FREAKFUND_PROJECTLIST_'.strtoupper('premiereEndDate')).': '.$query->premiereEndDate;
				break;
			case '7':
				$query->FechaApintar = JText::_('COM_FREAKFUND_PROJECTLIST_'.strtoupper('premiereEndDate')).': '.$query->premiereEndDate;
				break;
			case '8':
				$query->FechaApintar = JText::_('COM_FREAKFUND_PROJECTLIST_'.strtoupper('premiereEndDate')).': '.$query->premiereEndDate;
				break;
			case '10':
				$query->FechaApintar = JText::_('COM_FREAKFUND_PROJECTLIST_'.strtoupper('premiereEndDate')).': '.$query->premiereEndDate;
				break;
			case '11':
				$query->FechaApintar = JText::_('COM_FREAKFUND_PROJECTLIST_'.strtoupper('premiereEndDate')).': '.$query->premiereEndDate;
				break;
			
			default:
				
				break;
		}
		$query->motivosBaja = JTrama::getMotivosDeBaja();
		self::producerIdJoomlaANDName($query);

		return $query;
	}

	public function producerIdJoomlaANDName($obj,$id=null){
		if($id == null){
			$id = $obj->userId;
		}
		
		$obj->idJoomla = UserData::getUserJoomlaId($id);
		$obj->producerName = JFactory::getUser($obj->idJoomla)->name;
	}
}