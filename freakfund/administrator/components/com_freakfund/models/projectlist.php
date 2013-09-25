<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.modellist');
jimport('trama.class');

class projectListModelprojectList extends JModelList
{
	public function getDatos() {
		//$query = json_decode(file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/project/all'));
		$query = JTrama::allProjects();
		$query[0]->vName = 'listproduct';
		
		//Dato de porcentaje alcanzado simulado
		foreach ($query as $key => $value) {
			$value->percentage = '10%';
			$value->semaphore = 'verde';
		}
		return $query;
	}
}