<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');

class listadoViewlistado extends JView
{
	function display($tpl = null) {
	        // Get data from the model
	        $items = $this->get('listadoproyectos');

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
            JToolBarHelper::title(JText::_('COM_ESTADO_RESULTADOS_TITLE'));
			JToolBarHelper::back();
			
	}

}