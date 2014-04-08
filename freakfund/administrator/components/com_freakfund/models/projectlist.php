<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.modellist');
jimport('trama.class');
jimport('trama.usuario_class');

class projectListModelprojectList extends JModelList
{
	public function getDatos() {
		$datos = JTrama::getProyByStatus('4,5,6,7,8,10,11');

		foreach ($datos as $key => $value) {
			$status = $value->status;
			
			$data[$status][] = $value;
		}

		if(!empty($data['4']) || !empty($data['5']) || !empty($data['6']) || !empty($data['7']) || !empty($data['8']) || !empty($data['10']) || !empty($data['11'])) {
		
			if( !empty($data['4']) ){
				$query[] =$this->agrupaObj($data['4'], 'premiereEndDateCode');
			}
			if( !empty($data['5']) ){
				$query[] =$this->agrupaObj($data['5'], 'fundEndDateCode');
			}
			if( !empty($data['6']) ){
				$query[] =$this->agrupaObj($data['6'], 'premiereEndDateCode');
			}
			if( !empty($data['7']) ){
				$query[] =$this->agrupaObj($data['7'], 'premiereEndDateCode');
			}
			if( !empty($data['10']) ){
				$query[] =$this->agrupaObj($data['10'], 'premiereEndDateCode');
			}
			if( !empty($data['11']) ){
				$query[] =$this->agrupaObj($data['11'], 'premiereEndDateCode');
			}
			if( !empty($data['8']) ){
				$query[] =$this->agrupaObj($data['8'], 'premiereEndDateCode');
			}
			
			foreach ($query as $key => $value) {
				foreach ($value as $indice => $valor) {
					$queryResp[] = $valor;
				}
			}
		}
		
		$queryResp[0]->vName = 'listproduct';
		$queryResp[0]->statusList = JTrama::getStatus();

		//agregar el nombre del usuario y el idJoomla
		foreach ($queryResp as $key => $value) {
			self::producerIdJoomlaANDName($value,$value->userId);
		}

		return $queryResp;
	}


	public function agrupaObj($data, $fechaOrden) {
		$sinCode = str_replace('Code', '', $fechaOrden);
		foreach($data as $obj){
			$map[] = array($obj->$fechaOrden, $obj);
		}
		sort($map);
		
		foreach ($map as $key) {
			$nuevo[] = $key[1];			
		}
		
		foreach ($nuevo as $key => $value) {
			$value->percentage 	= round((($value->balance*100)/$value->breakeven),2);
			$value->producerName = JFactory::getUser(UserData::getUserJoomlaId($value->userId))->name;

			switch ($value->status) {
				case '4':
					$value->semaphore = 'DarkRed';
					$value->FechaApintar = $value->$sinCode.' '.JText::_('COM_FREAKFUND_PROJECTLIST_'.strtoupper($sinCode));
					break;
				case '5':
					$this->semaforo(5, $value->fundEndDate, $value);
					$value->FechaApintar = $value->$sinCode.' '.JText::_('COM_FREAKFUND_PROJECTLIST_'.strtoupper($sinCode));
					break;
				case '6':
					$this->semaforo(15, $value->premiereStartDate, $value);
					$value->FechaApintar = $value->$sinCode.' '.JText::_('COM_FREAKFUND_PROJECTLIST_'.strtoupper($sinCode));
					break;
				case '7':
					$this->semaforo(15, $value->premiereEndDate, $value);
					$value->FechaApintar = $value->$sinCode.' '.JText::_('COM_FREAKFUND_PROJECTLIST_'.strtoupper($sinCode));
					break;
				case '8':
					$value->semaphore = 'DarkGreen';
					$value->FechaApintar = $value->$sinCode.' '.JText::_('COM_FREAKFUND_PROJECTLIST_'.strtoupper($sinCode));
					break;
				case '10':
					$this->semaforo(15, $value->premiereStartDate, $value);
					$value->FechaApintar = $value->$sinCode.' '.JText::_('COM_FREAKFUND_PROJECTLIST_'.strtoupper($sinCode));
					break;
				case '11':
					$this->semaforo(5, $value->premiereEndDate, $value);
					$value->FechaApintar = $value->$sinCode.' '.JText::_('COM_FREAKFUND_PROJECTLIST_'.strtoupper($sinCode));
					break;
					
				default:
					
					break;
			}
			
			$query[] = $value;
		}
		
		return $query;
	}

	public function semaforo($diasYellow, $fecha, $value) {
		$value->dateDiff = JTrama::dateDiff($fecha);
				
		if( ($value->dateDiff->invert == 1) ) {
			$value->semaphore = 'RED';
		}elseif($value->dateDiff->invert == 0 && $value->dateDiff->days <= $diasYellow){
			$value->semaphore = 'YELLOW';
		}else{
			$value->semaphore = 'FORESTGREEN';
		}
	}
	
	public function producerIdJoomlaANDName($obj,$id=null){
			if($id == null){
				$id = $obj->userId;
			}
			
			$obj->idJoomla = UserData::getUserJoomlaId($id);
			$obj->producerName = JFactory::getUser($obj->idJoomla)->name;
	}
}