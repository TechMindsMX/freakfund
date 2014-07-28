<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

class detalleProyectoaporteprovViewdetalleProyectoaporteprov extends JView{
	function display($tpl = null) {
	        $items = $this->get('detalleProy');

	        if (count($errors = $this->get('Errors'))) {
	            JError::raiseError(500, implode('<br />', $errors));
	            return false;
	        }
			
	        $this->items = $items;
	        $this->addToolBar();
	        parent::display($tpl);
	}

    protected function addToolBar()	{
        JToolBarHelper::title(JText::_('COM_APORTACIONESCAPITAL_DETALLEPROYECTO_TITLE'));
		JToolBarHelper::back();
	}
}