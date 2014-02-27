<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');

class traspasocuentasViewtraspasocuentas extends JView
{
	function display($tpl = null) {
	        // Get data from the model
	        $items = $this->get('listadoCuentas');

	        // Check for errors.
	        if (count($errors = $this->get('Errors'))) {
	            JError::raiseError(500, implode('<br />', $errors));
	            return false;
	        }
			
	        // Assign data to the view
	        $this->items = $items;

	        // Display the template
	        $this->addToolBar($items['tipo']);
			
	        parent::display($tpl);
	}
    protected function addToolBar($tipo)	{
            JToolBarHelper::title(JText::_('COM_ADMINCUENTAS_TRASPASO_TITLE_'.$tipo));
			JToolBarHelper::back('Listado', 'index.php?option=com_admincuentas');
			
	}

}