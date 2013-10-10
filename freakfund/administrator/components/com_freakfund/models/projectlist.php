<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.modellist');
jimport('trama.class');

class projectListModelprojectList extends JModelList
{
	public function getDatos() {
		$data4 = JTrama::getProyByStatus('4');
		$data5 = JTrama::getProyByStatus('5');
		$data6 = JTrama::getProyByStatus('6');
		$data7 = JTrama::getProyByStatus('7');
		$data8 = JTrama::getProyByStatus('8');
		$data10 = JTrama::getProyByStatus('10');
		$data11 = JTrama::getProyByStatus('11');

		if( !empty($data4) ){
			$query[] =$this->agrupaObj($data4, 'premiereEndDateCode');
		}
		if( !empty($data5) ){
			$query[] =$this->agrupaObj($data5, 'fundEndDateCode');
		}
		if( !empty($data6) ){
			$query[] =$this->agrupaObj($data6, 'premiereEndDateCode');
		}
		if( !empty($data7) ){
			$query[] =$this->agrupaObj($data7, 'premiereEndDateCode');
		}
		if( !empty($data10) ){
			$query[] =$this->agrupaObj($data10, 'premiereEndDateCode');
		}
		if( !empty($data11) ){
			$query[] =$this->agrupaObj($data11, 'premiereEndDateCode');
		}
		if( !empty($data8) ){
			$query[] =$this->agrupaObj($data8, 'premiereEndDateCode');
		}
		
		foreach ($query as $key => $value) {
			foreach ($value as $indice => $valor) {
				$queryResp[] = $valor;
			}
		}
		
		$queryResp[0]->vName = 'listproduct';
		$statusList = JTrama::getStatus();
		
		foreach ($statusList as $obj) {
			if(($obj->id >= 4) && ($obj->id != 9))
			$map[] = array($obj->name, $obj);
		}	
		sort($map);
		
		foreach ($map as $key => $value) {
			$statusListFinal[] = $value[1];
		}
		
		$queryResp[0]->statusList = $statusListFinal;

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
			$value->percentage 	= ($value->balance*100)/$value->breakeven;
			$value->producerName = JFactory::getUser($value->userId)->name;

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
		$fecha1 = new DateTime();
		
		$fecha2 =new DateTime($fecha);

		$value->dateDiff = date_diff($fecha1,$fecha2);
		
		if( ($value->dateDiff->invert == 1) ) {
			$value->semaphore = 'RED';
		}elseif($value->dateDiff->invert == 0 && $value->dateDiff->days <= $diasYellow){
			$value->semaphore = 'YELLOW';
		}else{
			$value->semaphore = 'FORESTGREEN';
		}
	}
}