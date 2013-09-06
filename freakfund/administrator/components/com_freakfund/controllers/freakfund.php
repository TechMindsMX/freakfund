<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controller library
jimport('joomla.application.component.controller');
 
/**
 * General Controller of TramaProyectos component
 */
class freakfundController extends JController
{
        /**
         * display task
         *
         * @return void
         */
        function display($cachable = false, $urlparams = false) 
        {
        	    // set default view if not set
                $input = JFactory::getApplication()->input;
				$input->set('view', $input->getCmd('view', 'freakfund'));
				
                // call parent behavior
                parent::display($cachable);
        }
}