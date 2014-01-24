<?php
defined('_JEXEC') OR defined('_VALID_MOS') OR die("Direct Access Is Not Allowed");

function participar($json,$botonContactar) {
	
	$usuario = JFactory::getUser();
	
	include_once JPATH_ROOT.'/components/com_community/libraries/core.php';
	include_once JPATH_ROOT.'/components/com_community/libraries/messaging.php';

	$id = isset($json->userIdJoomla) ? $json->userIdJoomla : $usuario->id;;
	
	// Add a onclick action to any link to send a message
	// Here, we assume $usrid contain the id of the user we want to send message to
	$onclick = CMessaging::getPopup($id);
	$html = '<a class="button" onclick="'.$onclick.'" href="#">'.$botonContactar.'</a>';	
	
	return $html;
}
?>
