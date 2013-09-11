<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
 
// Include the syndicate functions only once
require_once( dirname(__FILE__).DS.'helper.php' );

switch ($params->get('tipodepro')) {
	case 'cerrar':
		$datos = modProyectosHelper::closestEnd();
		
		break;
	
	case 'apoyados':
		$datos = modProyectosHelper::closestEnd();
		
		break;

	case 'rentables':
		$datos = modProyectosHelper::profitables();
		
		break;
}


$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require( JModuleHelper::getLayoutPath( 'mod_proyectos', $params->get('layout', 'default') ) );
?>
