<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');

class aportacionesacapitalViewaportacionesacapital extends JView
{
	function display($tpl = null) {
	        // Get data from the model
	        $items = $this->get('listadoProyectos');

	        // Check for errors.
	        if (count($errors = $this->get('Errors'))) {
	            JError::raiseError(500, implode('<br />', $errors));
	            return false;
	        }
			
	        // Assign data to the view
	        $this->items = $items;
		
	        // Display the template
	        $this->addToolBar();
			
	        parent::display($tpl);
	}
    protected function addToolBar()	{
            JToolBarHelper::title(JText::_('COM_CUENTASADMIN_ADMINCUENTAS_TITLE'));
			JToolBarHelper::back();
			
	}

}