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
		
		$query = JTrama::getDatos( $temporal );
		$query->finantialCash = 20000;
		$query->percentage = '20%';
		
		$query->motivosBaja = JTrama::getMotivosDeBaja();
		
		return $query;
	}
}