<?php
/**
 * @category	Modules
 * @package		JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die('Restricted access');

require_once( dirname(__FILE__).'/helper.php' );
require_once( JPATH_ROOT .'/components/com_community/helpers/string.php' );
require_once( JPATH_BASE .'/components/com_community/libraries/core.php');		
//CFactory::load( 'models' , 'groups' );
//CFactory::load( 'helpers' , 'string' );

$showavatar 			= $params->get('show_avatar', '1');
$repeatAvatar			= $params->get('repeat_avatar', '1');
$showPrivateDiscussion 	= $params->get('show_private_discussion', '1');
$done_group 			= array();
$groupstr 				= array();

$document = JFactory::getDocument();
$document->addStyleSheet(rtrim(JURI::root(), '/').'/components/com_community/assets/modules/module.css');

$dis = new modLatestDiscussionHelper($params);
$latest = $dis->getLatestDiscussion($showPrivateDiscussion);

require(JModuleHelper::getLayoutPath('mod_latestdiscussion'));
