<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

JFactory::getDocument()->addStyleSheet('components/com_freakfund/css/com_freakfund.css');

$jinput = JFactory::getApplication()->input;
$controllerName = $jinput->get('task', "freakfund", 'STR' );

require_once( JPATH_COMPONENT.DS.'controllers'.DS.$controllerName.'.php' );

$controllerName = $controllerName.'controller';

$controller = new $controllerName();

$controller->execute( JRequest::getCmd('task') );

$controller->redirect();