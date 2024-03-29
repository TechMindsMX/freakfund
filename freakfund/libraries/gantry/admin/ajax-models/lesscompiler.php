<?php
/**
 * @version   $Id: lesscompiler.php 6306 2013-01-05 05:39:57Z btowles $
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2013 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Gantry uses the Joomla Framework (http://www.joomla.org), a GNU/GPLv2 content management system
 *
 */
defined('JPATH_BASE') or die();

/** @var $gantry Gantry */
global $gantry;

$action = JFactory::getApplication()->input->getString('action');
gantry_import('core.gantryjson');


switch ($action) {
	case 'clear':
		echo gantryAjaxClearLessCache();
		break;
	default:
		echo "error";
}

function gantryAjaxClearLessCache()
{
	/** @var $gantry Gantry */
	global $gantry;
	$cache_handler = GantryCache::getCache(Gantry::LESS_SITE_CACHE_GROUP, null, true);
	$cache_handler->clearGroupCache();
	return JText::_('Less complier cache files cleared');
}
