<?php
defined('_JEXEC') or die ;

jimport('joomla.application.component.controlleradmin');

class RedemptioncodesControllerRedemptioncodes extends JControllerAdmin {

        /**
         * display task
         *
         * @return void
         */
        function display($cachable = false, $urlparams = false) 
        {
        	    // set default view if not set
                $input = JFactory::getApplication()->input;
				$input->set('view', $input->getCmd('view', 'redemptioncodes'));
				
                // call parent behavior
                parent::display($cachable);
        }

}
