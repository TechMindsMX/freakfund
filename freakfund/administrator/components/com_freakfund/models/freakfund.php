<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
jimport('trama.usuario_class');


class freakfundModelfreakfund extends JModelList
{
        public function getDatos()
        {
        	$query = json_decode(file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/project/status/5,6'));

			if(!empty($query)) {
				self::producerIdJoomlaANDName($query);
			}
			return $query;
        }
		
		public function producerIdJoomlaANDName($obj){
			foreach($obj as $key => $value) {
				$value->idJoomla = UserData::getUserJoomlaId($value->userId);
				$value->producerName = JFactory::getUser($value->idJoomla)->name;
			}
			
		}
		
		
}