<?php
/**
 * @category	Module
 * @package		JomSocial
 * @subpackage	OnlineUsers
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die('Restricted access');

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once ( dirname(__FILE__) .'/helper.php' );
//CFactory::load( 'helpers' , 'string' );
$modOnlineUsersHelper = new modOnlineUsersHelper();
$users	= $modOnlineUsersHelper->getUsersData( $params );
$total	= $modOnlineUsersHelper->getTotalOnline( $params );

require(JModuleHelper::getLayoutPath('mod_onlineusers'));

$document = JFactory::getDocument();
$document->addStyleSheet(rtrim(JURI::root(), '/').'/components/com_community/assets/modules/module.css');