<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');

class ventasextController extends JController{
    function display($cachable = false, $urlparams = false){
        $input = JFactory::getApplication()->input;
		$input->set('view', $input->getCmd('view', 'ventasext'));
		
        parent::display($cachable);
    }
}