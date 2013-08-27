<?php
/********************************************************************
Product		: Flexicontact
Date		: 19 November 2012
Copyright	: Les Arbres Design 2010-2012
Contact		: http://extensions.lesarbresdesign.info
Licence		: GNU General Public License
*********************************************************************/

defined('_JEXEC') or die('Restricted Access');

jimport('joomla.application.component.controller');

// Pull in the helper file

require_once JPATH_COMPONENT.'/helpers/flexicontact_helper.php';

// set a constant for the Joomla version

Flexicontact_Utility::get_joomla_version();

if (file_exists(JPATH_ROOT.'/LA.php'))
	require_once JPATH_ROOT.'/LA.php';

// load our css

$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base().'components/'.LAFC_COMPONENT.'/assets/'.LAFC_COMPONENT.'.css');

// from Joomla 1.6.2 we need to load the Javascript framework

if (LAFC_JVERSION >= 160)
	JHtml::_('behavior.framework');	// load the Joomla Javascript framework

// create an instance of the controller and tell it to execute $task

require_once( JPATH_COMPONENT.'/controller.php' );
$controller	= new FlexicontactController( );

$task = JRequest::getVar('task');

$controller->execute($task);

$controller->redirect();

