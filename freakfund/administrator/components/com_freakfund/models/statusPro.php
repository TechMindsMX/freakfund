<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');

class statusproModelstatuspro extends JModelList
{
	public function getProducto() {
		$temporal = JFactory::getApplication()->input;
		$temporal = $temporal->get('proyid');
	
		$query = json_decode(file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/project/get/'.$temporal));

		return $query;
	}
}