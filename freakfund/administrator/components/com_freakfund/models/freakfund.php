<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');

class freakfundModelfreakfund extends JModelList
{
        public function getDatos()
        {
        	$query = json_decode(file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/project/status/5,6'));
			
			$query[0]->vName = 'Payments';

			return $query;
        }
}