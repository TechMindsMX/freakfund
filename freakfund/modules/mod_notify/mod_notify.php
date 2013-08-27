<?php
/**
 * @category	Module
 * @package		JomSocial
 * @subpackage	Notification
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die('Restricted access');

// Include the syndicate functions only once
require_once (dirname(__FILE__).'/helper.php');
require_once( JPATH_BASE .'/components/com_community/libraries/core.php');
//CFactory::load( 'libraries' , 'userpoints' );
//CFactory::load( 'libraries' , 'window' );
//CFactory::load( 'helpers' , 'owner' );
//CFactory::load( 'libraries' , 'facebook' );
CWindow::load();

$document = JFactory::getDocument();
$document->addStyleSheet(rtrim(JURI::root(), '/').'/components/com_community/assets/modules/module.css');

$config	= CFactory::getConfig();
$my		= CFactory::getUser();
$js		= 'assets/script-1.2.min.js';
CAssets::attach($js, 'js');


require(JModuleHelper::getLayoutPath('mod_notify'));