<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');
 
class errorsController extends JController{
        function display($cachable = false, $urlparams = false) {
        	$input = JFactory::getApplication()->input;
			$errorcodes 	= $input->get('error');
			$monto			= $input->get('monto');
			
			if($errorcodes != 0){
				$errors = JFactory::getApplication();
	        	$errors->redirect('index.php?option=com_admincuentas&task=traspaso', $msg=JText::_('ERROR_CODE'.$errorcodes), $msgType='warning');
			}else{
				$noErrors = JFactory::getApplication();
	        	$noErrors->redirect('index.php?option=com_admincuentas&task=traspaso&monto='.$monto.'&confirmacion=true', $msg=JText::_('TRANSFERENCIA_EXITOSA'), $msgType='message');
			}
			exit;
        }
}