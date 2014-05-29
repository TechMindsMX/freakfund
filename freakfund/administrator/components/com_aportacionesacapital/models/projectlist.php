<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.modellist');
jimport('trama.class');
jimport('trama.usuario_class');

class projectListModelprojectList extends JModelList{
	public function getDatos() {
		$queryResp = JTrama::getProyByStatus('6,7,11');

		$queryResp[0]->statusList = JTrama::getStatus();
		
		$queryResp = UserData::getusersData($queryResp, 'aporteCapital');

		return $queryResp;
	}
}