<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_slave'.DS.'tables');

$jinput = JFactory::getApplication()->input;
$controllerName = $jinput->get('task', "freakfund", 'STR' );

require_once( JPATH_COMPONENT.DS.'controllers'.DS.$controllerName.'.php' );

$controllerName = $controllerName.'controller';

$controller = new $controllerName();

$controller->execute( JRequest::getCmd('task') );

$controller->redirect();


// defined('_JEXEC') or die('Restricted access');
//  
// jimport('joomla.application.component.controller');
// 
// // Get an instance of the controller prefixed by freakfund
// $controller = JController::getInstance('freakfund');
// var_dump($controller);
// exit;
// // Get the task
// $jinput = JFactory::getApplication()->input;
// $task = $jinput->get('task', "", 'STR' );
//  
// // Perform the Request task
// $controller->execute($task);
//  
// // Redirect if set by the controller
// $controller->redirect();