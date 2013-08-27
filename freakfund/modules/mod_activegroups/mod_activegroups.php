<?php
/**
 * @category	Modules
 * @package		JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
// no direct access
defined('_JEXEC') or die('Restricted access');

require_once ( dirname(__FILE__) .'/helper.php' );

//CFactory::load( 'helpers' , 'string' );

$modActiveGroupsHelper =  new modActiveGroupsHelper();
$groups	= $modActiveGroupsHelper->getGroupsData( $params );

require(JModuleHelper::getLayoutPath('mod_activegroups'));

$document = JFactory::getDocument();
$document->addStyleSheet(rtrim(JURI::root(), '/').'/components/com_community/assets/modules/module.css');
