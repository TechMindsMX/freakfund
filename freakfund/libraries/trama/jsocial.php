<?php

defined('JPATH_PLATFORM') or die ;

include_once JPATH_ROOT . '/components/com_community/libraries/core.php';
include_once JPATH_ROOT . '/components/com_community/controllers/controller.php';
include_once JPATH_ROOT . '/components/com_community/controllers/groups.php';

class JTramaSocial extends CommunityGroupsController {

	public function crearGrupoJomsocial() {
		$my = &CFactory::getUser();
		$config = &CFactory::getConfig();
		$group = &JTable::getInstance('Group', 'CTable');

		$group -> name = $this -> name;
		$group -> description = $this -> description;
		$group -> categoryid = $this -> categoryid;
		// Category Id must not be empty and will cause failure on this group if its empty.
		$group -> website = $this -> website;
		$group -> proyid = $this -> proyid;
		$group -> ownerid = $this -> ownerid;
		$group -> created = gmdate('Y-m-d H:i:s');
		$group -> approvals = 0;

		// $params	= CommunityGroupsController::getInstance();
		// $params = $params->_bindParams();

		// $params = new CParameter('');

		// Here you need some code from private _bindParams()

		// $group -> params = $params -> toString();
		$group -> published = ($config -> get('moderategroupcreation')) ? 0 : 1;
		$group -> store();
		
		$group -> load();
		

		$this -> addUserToGroup($group);
	}

	// - store the creator / admin into the groups members table
	public function addUserToGroup($group) {
			$gMembers = &JTable::getInstance('GroupMembers', 'CTable');
		if (empty($group -> userToGroup)) {
			$gMembers -> memberid = $group -> ownerid;
			$gMembers -> groupid = $group -> groupid;
		} else {
			$gMembers -> memberid = $group -> userToGroup;
			$gMembers -> groupid = $group -> groupid;
		}
		foreach ($gMembers->memberid as $key => $value) {

			$gMembers -> memberid = $value;
			$gMembers -> approved = '1';
			$gMembers -> permissions = '1';

			$gMembers -> store();
		}
			$group -> enviaEmail();
		// - add into activity stream
	}

	public function enviaEmail() {
		$mailer = JFactory::getMailer();

		$config = JFactory::getConfig();
		$sender = array($config -> getValue('config.mailfrom'), $config -> getValue('config.fromname'));

		$mailer -> setSender($sender);

		$recipient = $this->userToGroup;
		foreach ($recipient as $key => $value) {
			$emails[] = JFactory::getUser($value)->email;
		}
		$recipient = $emails;

		$mailer -> addRecipient($recipient);

		$body = '<h2>Our mail</h2>' . '<div>A message to our dear readers' . '<img src="cid:logo_id" alt="logo"/></div>';
		$mailer -> isHTML(true);
		$mailer -> Encoding = 'base64';
		$mailer -> setBody($body);
		// Optionally add embedded image
		$mailer -> AddEmbeddedImage(JPATH_COMPONENT . '/assets/logo128.jpg', 'logo_id', 'logo.jpg', 'base64', 'image/jpeg');

		$send = $mailer -> Send();
		
		if ($send !== true) {
			// echo 'Error sending email: ' . $send -> message;
		} else {
			echo 'Mail sent';
		}
	}
	
	public static function inviteToGroup($group) {

  		echo '<script src="components/com_community/assets/easytabs/jquery.easytabs.min.js" type="text/javascript"></script>';
  		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query
			->select('id')
		    ->from('#__community_groups')
		    ->where('proyid = '.$group);
		$db->setQuery($query);
 
		$results = $db->loadResult();
  		
		$enlace = '<a href="javascript:void(0);" class="community-invite" '. 
					'onclick="joms.invitation.showForm(\'\', \'groups,inviteUsers\',\''.$results.'\',\'1\',\'1\');">'.
					JText::_('INVITE_TO_JGROUP').'</a>';
		return $enlace;
		}

	public static function addFriendJS($userid, $usuario){
		include_once('components/com_community/libraries/core.php');
		include_once('components/com_community/helpers/friends.php');
		JFactory::getDocument()->addScript('components/com_community/assets/joms.jquery-1.8.1.min.js');
		JFactory::getDocument()->addScript('components/com_community/assets/script-1.2.min.js');
		JFactory::getDocument()->addScript('components/com_community/assets/window-1.0.min.js');
		JFactory::getDocument()->addScript('components/com_community/assets/minitip-1.0.js');
		JFactory::getDocument()->addScript('components/com_community/assets/joms.ajax.min.js');
		$addFriendHtml = '<link rel="stylesheet" href="components/com_community/assets/window.css" type="text/css">';
		$user				= CFactory::getUser( $userid );
		$row->profileLink	= CRoute::_('index.php?option=com_community&view=profile&userid=' . $userid );
		$row->friendsCount	= $user->getFriendCount();
		$isFriend 			=  CFriendsHelper::isConnected ( $userid, $usuario->id );
	
		$row->addFriend 	= ((! $isFriend) && ($usuario->id != 0) && $usuario->id != $userid) ? true : false;
		if($row->addFriend == true) {
			$addFriendHtml .= '<a href="javascript:void(0)" onclick="joms.friends.connect(\''. $user->id.'\')">'.
						JText::_('COM_COMMUNITY_PROFILE_ADD_AS_FRIEND').'</a>';
		} else {
			$addFriendHtml .='<i class="com-icon-tick"></i> <span>'.JText::_('COM_COMMUNITY_PROFILE_ADDED_AS_FRIEND').'</span>';
		}
	return $addFriendHtml;
	}

	public static function checkUserGroup($group, $userid){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query
			->select('id')
		    ->from('#__community_groups')
		    ->where('proyid = '.$group);
		$db->setQuery($query);
		$results = $db->loadResult();
		
		if($results != null) {
			$query2 = $db->getQuery(true);
			$query2
				->select('groupid, memberid')
				->from('#__community_groups_members')
				->where('memberid = '.$userid.' and groupid = '.$results);
			$db->setQuery($query2);
			$results2 = $db->loadResult();
			
			return $results2;
		}
	}
}
?>
