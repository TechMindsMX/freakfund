<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

class freakfundViewfreakfund extends JView{
    function display($tpl = null) {
	    $items = $this->get('Datos');
	
	    if (count($errors = $this->get('Errors'))) 
	    {
            JError::raiseError(500, implode('<br />', $errors));
            return false;
	    }
	    $this->items = $items;
		
	    $this->addToolbar();
		
	    parent::display($tpl);
    }

    protected function addToolBar() {
        JToolBarHelper::title(JText::_('COM_FREAKFUND_FREAKFUND_TITLE'));
        JToolBarHelper::preferences('com_freakfund');
	}

}