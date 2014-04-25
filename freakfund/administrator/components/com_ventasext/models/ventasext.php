<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.modellist');
jimport('trama.class');
jimport('trama.usuario_class');

class ventasextModelventasext extends JModelList
{
	public function getDatos() {
		$queryResp = JTrama::getProyByStatus('6,7');

		$queryResp[0]->statusList = JTrama::getStatus();

		//agregar el nombre del usuario, el idJoomla y la liga a la captura de las ventas
		foreach ($queryResp as $key => $value) {
			self::producerIdJoomlaANDName($value,$value->userId);
			$value->name = '<a href="index.php?option=com_ventasext&task=capturaventas&id='.$value->id.'">'.$value->name.'</a>';
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