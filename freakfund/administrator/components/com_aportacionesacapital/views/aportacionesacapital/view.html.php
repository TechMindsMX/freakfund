<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

class aportacionesacapitalViewaportacionesacapital extends JView{
	function display($tpl = null) {
        $items = $this->get('listadoProyectos');

        if (count($errors = $this->get('Errors'))) {
            JError::raiseError(500, implode('<br />', $errors));
            return false;
        }
		
        $this->items = $items;
	
        $this->addToolBar();
		
        parent::display($tpl);
	}

    protected function addToolBar()	{
	    JToolBarHelper::title(JText::_('COM_APORTACIONESCAPITAL_LISTADOPROYECTOS_TITLE'));
		JToolBarHelper::preferences('com_freakfund');
	}

}