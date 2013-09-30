<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.modellist');
jimport('trama.class');

class projectListModelprojectList extends JModelList
{
	public function getDatos() {
		//$query = json_decode(file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/project/all'));
		$query1 = JTrama::getProyByStatus('5');
		$query2 = JTrama::getProyByStatus('6');
		$query3 = JTrama::getProyByStatus('7');
		
		foreach ($query1 as $key => $value) {
			$value->percentage 	= ($value->balance*100)/$value->breakeven;
			$value->producerName = JFactory::getUser($value->userId)->name;
			
			switch ($value->status) {
				case '5':
					$value->semaphore = 'GREEN';
					break;
				
				case '6':
					$value->semaphore = 'YELLOW';
					break;
					
				case '7':
					$value->semaphore = 'RED';
					break;
					
				default:
					
					break;
			}
			
			$query[] = $value;
		}
		
		foreach ($query2 as $key => $value) {
			$value->percentage 	= ($value->balance*100)/$value->breakeven;
			$value->producerName = JFactory::getUser($value->userId)->name;
			
			switch ($value->status) {
				case '5':
					$value->semaphore = 'GREEN';
					break;
				
				case '6':
					$value->semaphore = 'YELLOW';
					break;
					
				case '7':
					$value->semaphore = 'RED';
					break;
					
				default:
					
					break;
			}
			
			$query[] = $value;
		}
		
		foreach ($query3 as $key => $value) {
			$value->percentage 	= ($value->balance*100)/$value->breakeven;
			$value->producerName = JFactory::getUser($value->userId)->name;
			
			switch ($value->status) {
				case '5':
					$value->semaphore = 'GREEN';
					break;
				
				case '6':
					$value->semaphore = 'YELLOW';
					break;
					
				case '7':
					$value->semaphore = 'RED';
					break;
					
				default:
					
					break;
			}
			$query[] = $value;
		}
		
		$query[0]->vName = 'listproduct';
		
		return $query;
	}
}