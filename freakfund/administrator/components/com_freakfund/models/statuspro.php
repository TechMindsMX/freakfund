<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
jimport('trama.class');

class statusproModelstatuspro extends JModelList
{
	public function getProd() {
		$temporal = JFactory::getApplication()->input;
		$temporal = $temporal->get('proyid');
		
		//$query = json_decode(file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/project/get/'.$temporal));
		$query = JTrama::getDatos( $temporal );
		$query->finantialCash = 20000;
		$query->percentage = '20%';
		$query->statusVenta = 1;

		return $query;
	}
}