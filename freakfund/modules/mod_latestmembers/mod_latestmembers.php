<?php
/**
 * @category	Modules
 * @package		JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die('Restricted access');

include_once( JPATH_ROOT .'/components/com_community/defines.community.php' );
require_once( JPATH_ROOT .'/components/com_community/libraries/core.php' );
//require_once( JPATH_ROOT .'/components/com_community/libraries/tooltip.php' );
//require_once( JPATH_ROOT .'/components/com_community/helpers/string.php' );
require_once (dirname(__FILE__).'/helper.php');


//JPlugin::loadLanguage('mod_latestmembers', JPATH_ROOT);
//JPlugin::loadLanguage( 'com_community', JPATH_ROOT );

$document = JFactory::getDocument();
$document->addStyleSheet(rtrim(JURI::root(), '/').'/components/com_community/assets/modules/module.css');

$usermodel 				= CFactory::getModel('user');
$display_limit 			= $params->get('count',10);
$updated_avatar_only	= $params->get('updated_avatar_only', 0);
$tooltips 				= $params->get('tooltips', 1);
$config					= CFactory::getConfig();

$row = getLatestMember($display_limit, $updated_avatar_only);

// preload users
$CFactoryMethod = get_class_methods('CFactory');					
if(in_array('loadUsers', $CFactoryMethod))
{
	$uids = array();
	foreach($row as $m)
	{
		$uids[] = $m->id;
	}
	CFactory::loadUsers($uids);
}

$js	= '/assets/script-1.2.min.js';
CAssets::attach($js, 'js');

	
require(JModuleHelper::getLayoutPath('mod_latestmembers'));