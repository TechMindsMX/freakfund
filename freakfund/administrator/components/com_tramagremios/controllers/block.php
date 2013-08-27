<?php
defined('_JEXEC') or die ;

jimport('joomla.application.component.controlleradmin');

class TramaGremiosControllerBlock extends JControllerAdmin {

	public function __construct($config = array()) {
		parent::__construct($config);

		$this -> registerTask('block', 'changeBlock');
		$this -> registerTask('unblock', 'changeBlock');

	}

	public function getModel($name = 'Block', $prefix = 'TramaGremiosModel') {
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		
		return $model;
	}

	public function Block() {
		// Check for request forgeries.
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		// Initialise variables.
		$ids	= JRequest::getVar('cid', array(), '', 'array');
		$values	= array('block' => 1, 'unblock' => 0);
		$task	= $this->getTask();
		$value	= JArrayHelper::getValue($values, $task, 1, 'int');
		

		if (empty($ids))
		{
			JError::raiseWarning(500, JText::_('COM_TRAMAGREMIOS_NO_ITEM_SELECTED'));
		}
		else
		{
			// Get the model.
			$model = $this->getModel();

			// Change the state of the records.
			if (!$model->block($ids, $value))
			{
				JError::raiseWarning(500, $model->getError());
			}
			else
			{
				if ($value == 1)
				{
					$this->setMessage(JText::plural('COM_TRAMAGREMIOS_BLOCKED', count($ids)));
				}
				elseif ($value == 0)
				{
					$this->setMessage(JText::plural('COM_TRAMAGREMIOS_UNBLOCKED', count($ids)));
				}
			}
		}

		$this->setRedirect('index.php?option=com_tramagremios');
	}
	public function unBlock() {
		// Check for request forgeries.
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		// Initialise variables.
		$ids	= JRequest::getVar('cid', array(), '', 'array');
		$values	= array('block' => 1, 'unblock' => 0);
		$task	= $this->getTask();
		$value	= JArrayHelper::getValue($values, $task, 0, 'int');
		

		if (empty($ids))
		{
			JError::raiseWarning(500, JText::_('COM_TRAMAGREMIOS_NO_ITEM_SELECTED'));
		}
		else
		{
			// Get the model.
			$model = $this->getModel();

			// Change the state of the records.
			if (!$model->block($ids, $value))
			{
				JError::raiseWarning(500, $model->getError());
			}
			else
			{
				if ($value == 1)
				{
					$this->setMessage('metodo unblock'.JText::plural('COM_TRAMAGREMIOS_BLOCKED', count($ids)));
				}
				elseif ($value == 0)
				{
					$this->setMessage('metodo unblock'.JText::plural('COM_TRAMAGREMIOS_UNBLOCKED', count($ids)));
				}
			}
		}

		$this->setRedirect('index.php?option=com_tramagremios');
	}

}
