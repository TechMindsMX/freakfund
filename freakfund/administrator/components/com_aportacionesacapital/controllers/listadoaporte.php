<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');
 
class listadoaporteController extends JController{
	function display($cachable = false, $urlparams = false) {
        $input = JFactory::getApplication()->input;
		$input->set('view', $input->getCmd('view', 'listadoaporte'));
		
        parent::display($cachable);
	}
}