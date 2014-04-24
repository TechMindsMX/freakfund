<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.modellist');
jimport('trama.class');
jimport('trama.usuario_class');

class projectListModelprojectList extends JModelList
{
	public function getDatos() {
		$queryResp = JTrama::getProyByStatus('6,7,11');

		$queryResp[0]->statusList = JTrama::getStatus();

		//agregar el nombre del usuario y el idJoomla
		foreach ($queryResp as $key => $value) {
			self::producerIdJoomlaANDName($value,$value->userId);
			$value->urlcambio = '<a href="index.php?option=com_aportacionesacapital&task=detalleproyecto&id='.$value->id.'">'.JText::_('COM_APORTACIONESCAPITAL_PROJECTLIST_CHANGESTATUS').'</a>';
		}

		return $queryResp;
	}
	
	public function producerIdJoomlaANDName($obj,$id=null){
			if($id == null){
				$id = $obj->userId;
			}
			
			$obj->idJoomla = UserData::getUserJoomlaId($id);
			$obj->producerName = JFactory::getUser($obj->idJoomla)->name;
	}
}