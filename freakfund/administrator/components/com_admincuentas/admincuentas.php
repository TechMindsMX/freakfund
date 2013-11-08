<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

JFactory::getDocument()->addStyleSheet('components/com_admincuentas/css/com_admincuentas.css');
JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_slave'.DS.'tables');

$jinput = JFactory::getApplication()->input;
$controllerName = $jinput->get('task', "admincuentas", 'STR' );

require_once( JPATH_COMPONENT.DS.'controllers'.DS.$controllerName.'.php' );

$controllerName = $controllerName.'controller';

$controller = new $controllerName();

$controller->execute( JRequest::getCmd('task') );

$controller->redirect();