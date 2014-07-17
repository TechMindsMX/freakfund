<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');
class errorsController extends JController{
	function display($cachable = false, $urlparams = false) {
		$app = JFactory::getApplication()->input;
		$proyId = $app->get('id');
		$error	= $app->get('error', null, 'int');
		
		if( is_null($error) ){
			$noErrors = JFactory::getApplication();
	    	$noErrors->redirect('index.php?option=com_aportacionesacapital&task=detalleproyecto&id='.$proyId, $msg=JText::_('COM_APORTACIONESCAPITAL_SAVE'), $msgType='message');
		}else{
	    	$errors = JFactory::getApplication();
	    	$errors->redirect('index.php?option=com_aportacionesacapital&task=detalleproyecto&id='.$proyId, $msg=JText::_('ERROR_CODE'.$error), $msgType='warning');
		}
		
	}
}