<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');
 
class projectListController extends JController{
	function display($cachable = false, $urlparams = false) {
        $input = JFactory::getApplication()->input;
		$input->set('view', $input->getCmd('view', 'projectList'));
		
        parent::display($cachable);
	}
}