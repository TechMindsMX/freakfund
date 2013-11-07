<?php 
defined('JPATH_PLATFORM') or die ;

class errorClass {
	
	public static function manejoError($errorCode = null,$origen = null,$id = null) {
		$app = JFactory::getApplication();
		switch ($origen) {
			case 32:
				$url = JURI::base().'index.php?option=com_jumi&view=application&fileid='.$origen;				
				break;
		
			case 29:
				if($errorCode == 1 || $errorCode == 4) {
					$url = JURI::base().'index.php?option=com_jumi&view=application&fileid='.$origen;
				} elseif( $errorCode == 2) {
					$url = JURI::base().'index.php?option=com_jumi&view=application&fileid=32';
				}
				break;
			case 27:
				$url = JURI::base().'index.php?option=com_jumi&view=application&fileid='.$origen.'&proyid='.$id;				
				break;
				
			default:
				$url = JURI::base().'index.php?option=com_jumi&view=application&fileid=24';
				break;
		}
		
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
			case 4:
				$msg = JText::_('ERROR_USERNOFOUND');
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