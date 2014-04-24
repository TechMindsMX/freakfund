<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

JFactory::getDocument()->addStyleSheet('components/com_aportacionesacapital/css/com_aportacionesacapital.css');
JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_slave'.DS.'tables');

$jinput = JFactory::getApplication()->input;
$controllerName = $jinput->get('task', "projectlist", 'STR' );

require_once( JPATH_COMPONENT.DS.'controllers'.DS.$controllerName.'.php' );

$controllerName = $controllerName.'controller';

$controller = new $controllerName();

$controller->execute( JRequest::getCmd('task') );

$controller->redirect();