<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controller library
jimport('joomla.application.component.controller');
 
/**
 * General Controller of TramaProyectos component
 */
class aportacionesacapitalController extends JController
{
        function display($cachable = false, $urlparams = false) {
        	    // set default view if not set
                $input = JFactory::getApplication()->input;
				$input->set('view', $input->getCmd('view', 'aportacionesacapital'));
				
                // call parent behavior
                parent::display($cachable);
        }
}