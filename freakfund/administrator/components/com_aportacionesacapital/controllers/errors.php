<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controller library
jimport('joomla.application.component.controller');
 
/**
 * General Controller of TramaProyectos component
 */
class errorsController extends JController
{
        /**
         * display task
         *
         * @return void
         */
        function display($cachable = false, $urlparams = false) {
        	$app = JFactory::getApplication()->input;
			$enviarA = $app->get('error', null, 'int');

			if($enviarA){
				$errors = JFactory::getApplication();
	        	$errors->redirect('index.php?option=com_freakfund&task='.$enviarA, $msg=JText::_('COM_FREAKFUND_ERRORS_MSG'), $msgType='warning');
			}else{
	        	$errors = JFactory::getApplication();
	        	$errors->redirect('index.php?option=com_freakfund', $msg=JText::_('COM_FREAKFUND_ERRORS_MSG'), $msgType='warning');
			}
			
        }
}