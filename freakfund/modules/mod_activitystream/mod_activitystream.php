<?php
/**
 * @category	Model
 * @package		JomSocial
 * @subpackage	Groups 
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die('Restricted access');

include_once(JPATH_BASE.'/components/com_community/defines.community.php');	
require_once(JPATH_BASE .'/components/com_community/libraries/core.php');
include_once(COMMUNITY_COM_PATH.'/libraries/activities.php');
include_once(COMMUNITY_COM_PATH.'/helpers/time.php');

$document = JFactory::getDocument();
$document->addStyleSheet(rtrim(JURI::root(), '/').'/components/com_community/assets/modules/module.css');

$config	= CFactory::getConfig();
$js		= 'assets/script-1.2.min.js';
CAssets::attach($js, 'js');

$cwindow = '/assets/window-1.0.min.js';
CAssets::attach($cwindow, 'js');

$cwindowcss = '/assets/window.css';
CAssets::attach($cwindowcss, 'css');

$activities = new CActivityStream();
$maxEntry = $params->get('max_entry', 10);

$stream = $activities->getHTML('', '', null, $maxEntry, '', 'mod_', $params->get('show_content' , false ) );

require( JModuleHelper::getLayoutPath('mod_activitystream') );
