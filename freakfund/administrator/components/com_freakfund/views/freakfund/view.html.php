<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 *  View
 */
class freakfundViewfreakfund extends JView
{
        function display($tpl = null) {
                // Get data from the model
                $items = $this->get('Datos');

                 // Check for errors.
                if (count($errors = $this->get('Errors'))) 
                {
                        JError::raiseError(500, implode('<br />', $errors));
                        return false;
                }
                // Assign data to the view
                $this->items = $items;
				
                // Display the template
                parent::display($tpl);
        }
}