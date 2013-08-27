<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 *  View
 */
class TramaProyectosViewDetalleProyecto extends JView
{
        /**
         *  view display method
         * @return void
         */
        function display($tpl = null) {
    	    // Get data from the model
            $items = $this->get('DetalleProyecto');
 
                 // Check for errors.
            if (count($errors = $this->get('Errors'))) 
            {
                    JError::raiseError(500, implode('<br />', $errors));
                    return false;
            }
            // Assign data to the view
            $this->items = $items;
			
			$this->addToolBar();
			
            // Display the template
            parent::display($tpl);
        }
		
		protected function addToolBar() {
                JToolBarHelper::title(JText::_('COM_TRAMPROYECTOS_MANAGER_TRAMA_DETALLE'));
                JToolBarHelper::back('Cancelar');
		}
}