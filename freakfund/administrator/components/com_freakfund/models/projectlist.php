<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.modellist');
jimport('trama.class');

class projectListModelprojectList extends JModelList
{
	public function getDatos() {
		$data = JTrama::getProyByStatus('4,5,6,7,8,10,11');
		!empty($data)? $query = $this->agrupaObj($data):$query = null;
		
		$query[0]->vName = 'listproduct';
		
		return $query;
	}


	public function agrupaObj($data) {
		foreach($data as $obj){
			$map[] = array($obj->premiereEndDate, $obj);
		}
		rsort($map);
		
		foreach ($map as $key) {
			foreach ($key as $indice => $valor) {
				if($indice != 0 ) {
					$nuevo[] = $valor;
				}
			}			
		}
		
		foreach ($nuevo as $key => $value) {
			$value->percentage 	= ($value->balance*100)/$value->breakeven;
			$value->producerName = JFactory::getUser($value->userId)->name;
		
			switch ($value->status) {
				case '4':
					$value->semaphore = 'RED';
					break;
				case '5':
					$value->semaphore = 'YELLOW';
					break;
				case '6':
					$value->semaphore = 'YELLOW';
					break;
				case '7':
					$value->semaphore = 'GREEN';
					break;
				case '8':
					$value->semaphore = 'GREEN';
					break;
				case '9':
					$value->semaphore = 'RED';
					break;
				case '10':
					$value->semaphore = 'YELLOW';
					break;
				case '11':
					$value->semaphore = 'GREEN';
					break;
					
				default:
					
					break;
			}
			$query[] = $value;
		}
		
		return $query;
	}
}