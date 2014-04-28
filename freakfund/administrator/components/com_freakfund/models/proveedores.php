<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.modellist');
jimport('trama.class');
jimport('trama.usuario_class');

class proveedoresModelproveedores extends JModelList
{		
		public function getproveedores(){
			$temporal = JFactory::getApplication()->input;
			$temporal = $temporal->get('id');
			
			$datos = JTrama::getDatos($temporal);
			$datos->status = JTrama::getStatusName($datos->status, JTrama::getStatus());
			self::producerIdJoomlaANDName($datos);
			
			foreach ($datos->providers as $key => $value) {
				self::producerIdJoomlaANDName($value, $value->providerId);
				$value->advanceDif = JTrama::dateDiff(date('d-m-Y',$value->advanceDateCode/1000));
				$value->settlemDif = JTrama::dateDiff(date('d-m-Y',$value->settlementDateCode/1000));
			}
				
			return $datos;
		}
		
		public function producerIdJoomlaANDName($obj,$id=null){
			if($id == null){
				$id = $obj->userId;
			}
			
			$obj->idJoomla = UserData::getUserJoomlaId($id);
			$obj->producerName = JFactory::getUser($obj->idJoomla)->name;
		}
}