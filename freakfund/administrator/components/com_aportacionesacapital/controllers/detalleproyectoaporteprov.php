<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');
 
class detalleProyectoaporteprovController extends JController
{
        function display($cachable = false, $urlparams = false) {
		    // set default view if not set
	        $input = JFactory::getApplication()->input;
			$input->set('view', $input->getCmd('view', 'detalleProyectoaporteprov'));
			
	        parent::display($cachable);
        }
}