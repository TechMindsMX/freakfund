<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');

class liquidacionprodModelliquidacionprod extends JModelList
{
        public function getDatosProductor() {
        	$temporal = JFactory::getApplication()->input;
			$temporal = $temporal->get('userId');
			
        	$query = json_decode(file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/user/get/'.$temporal));
			$query->userId = $temporal;
			$query->saldoProy = '4000000';
			
			return $query;
        }
}