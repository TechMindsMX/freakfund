<?php
defined('_JEXEC') or die('Restricted access');
 
jimport('joomla.application.component.controller');
 
// Get an instance of the controller prefixed by HelloWorld
$controller = JController::getInstance('TramaProyectos');

// Get the task
$jinput = JFactory::getApplication()->input;
$task = $jinput->get('task', "", 'STR' );
 
// Perform the Request task
$controller->execute($task);
 
// Redirect if set by the controller
$controller->redirect();