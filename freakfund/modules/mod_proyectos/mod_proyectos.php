<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
 
// Include the syndicate functions only once
require_once( dirname(__FILE__).DS.'helper.php' );
 
$datos = modProyectosHelper::getClosestEnd();

foreach ($datos as $key => $value) {
	$value = modProyectosHelper::getFundPercentage($value);
}

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require( JModuleHelper::getLayoutPath( 'mod_proyectos', $params->get('layout', 'default') ) );
?>
