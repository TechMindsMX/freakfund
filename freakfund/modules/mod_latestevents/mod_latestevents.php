<?php
/**
 * @package		Upcoming Events Module
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die('Restricted access');

require_once( JPATH_ROOT .'/components/com_community/libraries/core.php' );
//CFactory::load( 'helpers' , 'event' );
//CFactory::load( 'helpers' , 'string' );
//CFactory::load( 'helpers' , 'category' );

// Reuse existing language file from JomSocial
$language	= JFactory::getLanguage();
$language->load( 'com_community' , JPATH_ROOT );

$advance = array();
$type    = $params->get( 'type' , CEventHelper::ALL_TYPES );
$catid   = $params->get( 'catid', 0);
$groupid = $params->get( 'groupid', 0);
$feature = $params->get( 'feature', 0);

if ((!is_array($catid) && !$catid > 0) || (isset($catid[0]) && $catid[0] == '')) {
    $catid = null;
} else {
    // loop category's child category
    $tempcatId  = array();
    $model      = CFactory::getModel( 'Events' );
    $categories = $model->getAllCategories();
    foreach ($catid as $key => $value ) {
        $tempcatId   = array_merge($tempcatId, CCategoryHelper::getCategoryChilds($categories, $value));
        $tempcatId[] = (int) $value;
    }
    $catid = array_unique($tempcatId);
}

if ((!is_array($groupid) && !$groupid > 0) || (isset($groupid[0]) && $groupid[0] == '')) {
    $groupid = 0;
} else {
    $type = CEventHelper::GROUP_TYPE;
}

// If filter to feature event only 
if ($feature) {
    require_once( JPATH_ROOT .'/components/com_community/libraries/featured.php' );
    require_once( JPATH_ROOT .'/components/com_community/helpers/time.php' );
    $featured	    = new CFeatured( FEATURED_EVENTS );
    $featuredEvents = $featured->getItemIds();
    $advance['id']  = $featuredEvents;
}
 
$model		= CFactory::getModel( 'Events' );
$rows		= $model->getEvents( $catid , null , $params->get( 'ordering' , 'latest' ) , null , (bool) $params->get( 'past' , false ) , false , null , $advance , $type , $groupid , $params->get( 'total' , 10 ) );
$events		= array();
$config		= CFactory::getConfig();

$document	= JFactory::getDocument();
// $document->addStyleSheet( rtrim( JURI::root() , '/' ) . '/modules/mod_latestevents/style.css' );
$document->addStyleSheet(rtrim(JURI::root(), '/').'/components/com_community/assets/modules/module.css');

foreach( $rows as $event )
{
	$table		= JTable::getInstance( 'Event' , 'CTable' );
	$table->bind( $event );
	$events[]	= $table;
}


require( JModuleHelper::getLayoutPath( 'mod_latestevents' ) );
