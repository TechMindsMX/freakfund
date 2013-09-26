<?php
defined('_JEXEC') or die ;

jimport('joomla.application.component.controlleradmin');

class RedemptioncodesControllerUploadcodes extends JControllerAdmin 
{
	
    function display($cachable = false, $urlparams = false) 
    {
	    // set default view if not set
		$doc = JFactory::getApplication();
	    $input = $doc->input;
		$input->set('view', $input->getCmd('view', 'uploadcodes'));
		
        // call parent behavior
        parent::display($cachable);
	}

}

?>