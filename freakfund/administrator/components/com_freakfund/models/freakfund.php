<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');

class freakfundModelfreakfund extends JModelList
{
        public function getDatos()
        {
        	$query = json_decode(file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/project/all'));
			var_dump($query);
			exit;
			return $query;
        }
}