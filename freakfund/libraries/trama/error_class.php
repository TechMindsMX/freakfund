<?php 
defined('JPATH_PLATFORM') or die ;

class errorClass {
	
	public static function manejoError($errorCode = null,$origen = null,$proyid = null) {
		$app = JFactory::getApplication();
		$url = JURI::base().'index.php?option=com_jumi&view=appliction&fileid='.$origen.'&proyid='.$proyid;
		
		switch ($errorCode) {
			case 1:
				$msg = JText::_('ERROR_TOKEN');
				$redirect = true;
				break;
			case 2:
				$msg = JText::_('ERROR_NOFUNDS');
				$redirect = true;
				break;
			case 3:
				$msg = JText::_('ERROR_NOUNITS');
				$redirect = true;
				break;
				
			default:
				$redirect = false;
				break;
		}
		
		if($redirect) {
			$app->redirect($url, $msg, 'error');
		}
	}
}


?>