<?php
/**
 * Main Admin file
 *
 * @package         ReReplacer
 * @version         5.7.1
 *
 * @author          Peter van Westen <peter@nonumber.nl>
 * @link            http://www.nonumber.nl
 * @copyright       Copyright © 2013 NoNumber All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_rereplacer')) {
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

$lang = JFactory::getLanguage();
if ($lang->getTag() != 'en-GB') {
	// Loads English language file as fallback (for undefined stuff in other language file)
	$lang->load('com_rereplacer', JPATH_ADMINISTRATOR, 'en-GB');
}
$lang->load('com_rereplacer', JPATH_ADMINISTRATOR, null, 1);

jimport('joomla.filesystem.file');

// return if NoNumber Framework plugin is not installed
if (!JFile::exists(JPATH_PLUGINS . '/system/nnframework/nnframework.php')) {
	JFactory::getApplication()->set('_messageQueue', '');
	$msg = JText::_('RR_NONUMBER_FRAMEWORK_NOT_INSTALLED')
		. ' ' . JText::sprintf('RR_EXTENSION_CAN_NOT_FUNCTION', JText::_('COM_REREPLACER'));
	JFactory::getApplication()->enqueueMessage($msg, 'error');
	return;
}

// give notice if NoNumber Framework plugin is not enabled
$nnep = JPluginHelper::getPlugin('system', 'nnframework');
if (!isset($nnep->name)) {
	JFactory::getApplication()->set('_messageQueue', '');
	$msg = JText::_('RR_NONUMBER_FRAMEWORK_NOT_ENABLED')
		. ' ' . JText::sprintf('RR_EXTENSION_MAY_NOT_FUNCTION', JText::_('COM_REREPLACER'));
	JFactory::getApplication()->enqueueMessage($msg, 'notice');
}

// load the NoNumber Framework language file
if ($lang->getTag() != 'en-GB') {
	// Loads English language file as fallback (for undefined stuff in other language file)
	$lang->load('plg_system_nnframework', JPATH_ADMINISTRATOR, 'en-GB');
}
$lang->load('plg_system_nnframework', JPATH_ADMINISTRATOR, null, 1);

// Include dependancies
jimport('joomla.application.component.controller');

$controller = JController::getInstance('ReReplacer');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
