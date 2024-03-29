<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controller library
jimport('joomla.application.component.controller');
 
class RedemptioncodesController extends JController
{
	function display($cachable = false, $urlparams = false) 
	{
		// set default view if not set
		$input = JFactory::getApplication()->input;
		$input->set('view', $input->getCmd('view', 'Redemptioncodes'));
		
		// call parent behavior
		parent::display($cachable);
	}
	
	function errors($cachable = false, $urlparams = false) {
		
		$input = JFactory::getApplication()->input;
		$id = $input->get('proyid', '', 'INT');
		$error = $input->get('error', null, 'INT');
		
		if( is_null($error) ) {
			$this->success();
		}else{
    		$errors = JFactory::getApplication();
    		$errors->redirect('index.php?option=com_redemptioncodes&view=uploadcodes&proyid='.$id, $msg=JText::_('COM_REDEMPTIONCODES_ERRORS_MSG'), $msgType='error');
		}
		
    }
	
	function success($cachable = false, $urlparams = false) {
		JFactory::getApplication()->enqueueMessage(JText::_('COM_REDEMPTIONCODES_SUCCESS_MSG'), 'message');

		parent::display($cachable);
	}
}