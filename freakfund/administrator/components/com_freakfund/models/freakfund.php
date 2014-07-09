<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.modellist');
jimport('trama.usuario_class');

class freakfundModelfreakfund extends JModelList{
	
	// listado de estatus separado por comas
	public $statusIds = '6';
	
	public function getDatos(){
		$query = json_decode(file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/project/status/'.$this->statusIds));
		$query =UserData::getusersData($query, 'freakfundPagos');
		
		return $query;
	}
}