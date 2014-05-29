<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.modellist');
jimport('trama.class');
jimport('trama.usuario_class');

class ventasextModelventasext extends JModelList{
	public function getDatos() {
		$queryResp = JTrama::getProyByStatus('6,7');
		$queryResp[0]->statusList = JTrama::getStatus();
		$queryResp = UserData::getusersData($queryResp, 'ventasExternas');
		return $queryResp;
	}
}