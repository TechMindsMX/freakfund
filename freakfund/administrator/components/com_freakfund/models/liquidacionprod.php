<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
jimport('trama.class');

class liquidacionprodModelliquidacionprod extends JModelList
{
        public function getDatosProductor() {
        	$temporal = JFactory::getApplication()->input;
			$temporal = $temporal->get('id');
			
			$query = JTrama::getDatos($temporal);
        	// $query = json_decode(file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/project/get/'.$temporal));
			$query->token = JTrama::token();
			$query->callback = JURI::base().'index.php?option=com_freakfund';
			$query->CPR = '2000000';
			
			return $query;
        }
}