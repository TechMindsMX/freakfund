<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 *  View
 */
class RedemptioncodesViewRedemptioncodes extends JView
{
        /**
         *  view display method
         * @return void
         */
        function display($tpl = null) 
        {
                // Get data from the model
                $items = $this->get('Datos');
				$pagination = 10;
 
                 // Check for errors.
                if (count($errors = $this->get('Errors'))) 
                {
                        JError::raiseError(500, implode('<br />', $errors));
                        return false;
                }
                // Assign data to the view
                $this->items = $items;
                $this->pagination = $pagination;
 
				$this->addToolBar();
 
                // Display the template
                parent::display($tpl);
        }
        protected function addToolBar() 
        {
                JToolBarHelper::title(JText::_('COM_REDEMPTIONCODES_MANAGER_REDEMPTIONCODES'));
                JToolBarHelper::preferences('com_redemptioncodes');
				
		}
}