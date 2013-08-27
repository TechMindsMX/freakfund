<?php
defined('_JEXEC') OR defined('_VALID_MOS') OR die("Direct Access Is Not Allowed");
?>

<?php
function participar($json) {
	
	$usuario = JFactory::getUser();
	
	include_once JPATH_ROOT.'/components/com_community/libraries/core.php';
	include_once JPATH_ROOT.'/components/com_community/libraries/messaging.php';
	
	$id = isset($json->userId) ? $json->userId : $json->users_id;
	
	// Add a onclick action to any link to send a message
	// Here, we assume $usrid contain the id of the user we want to send message to
	$onclick = CMessaging::getPopup($id);
	$html = '<a class="button" onclick="'.$onclick.'" href="#">'.JText::_('SOLICITA_PARTICIPAR').'</a>';	
	
		return $html;
}
?>
