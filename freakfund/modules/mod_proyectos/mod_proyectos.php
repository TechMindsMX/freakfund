<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
 
// Include the syndicate functions only once
require_once( dirname(__FILE__).DS.'helper.php' );

$cantidad = $params->get('cantidad');

switch ($params->get('tipodepro')) {
	case 'cerrar':
		$datos = modProyectosHelper::closestEnd();
		
		break;
	
	case 'apoyados':
		$datos = modProyectosHelper::profitables($cantidad);
		
		break;

	case 'rentables':
		$datos = modProyectosHelper::profitables( $cantidad );
		
		break;
}

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require( JModuleHelper::getLayoutPath( 'mod_proyectos', $params->get('layout', 'default') ) );
?>
