<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.modellist');
jimport('trama.usuario_class');

class freakfundModelfreakfund extends JModelList{
	public function getDatos(){
		$query = json_decode(file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/project/status/5,6'));
		$query =UserData::getusersData($query, 'freakfundPagos');
		
		return $query;
	}
}