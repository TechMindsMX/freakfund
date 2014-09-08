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
				if( $errorCode == 2) {
					$url = JURI::base().'index.php?option=com_jumi&view=application&fileid=32';
				} else {
					$url = JURI::base().'index.php?option=com_jumi&view=application&fileid='.$origen;
				}
				break;
			case 27:
				$url = JURI::base().'index.php?option=com_jumi&view=application&fileid='.$origen.'&proyid='.$id;				
				break;
			
			case 31:
				$url = JURI::base().'index.php?option=com_jumi&view=application&fileid='.$origen;				
				break;
			
			case 36:
				$url = JURI::base().'index.php?option=com_jumi&view=application&fileid='.$origen;				
				break;
				
			case 37:
				if($errorCode == 1 || $errorCode == 4) {
					$url = JURI::base().'index.php?option=com_jumi&view=application&fileid='.$origen;
				} elseif( $errorCode == 2) {
					$url = JURI::base().'index.php?option=com_jumi&view=application&fileid=32';
				}				
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
			case 11:
				$msg = JText::_('ERROR_REDEPTIONCODE_NOEXITS');
				$redirect = true;
				break;
			case 12:
				$msg = JText::_('ERROR_REDEPTIONCODE_EXITS');
				$redirect = true;
				break;
			case 13:
				$msg = JText::_('ERROR_REDEPTIONCODE_SECTION_NOEXITS');
				$redirect = true;
				break;
			case 24:
				$msg = JText::_('ERROR_MONTO_TRASPASO_EXEDIDO');
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