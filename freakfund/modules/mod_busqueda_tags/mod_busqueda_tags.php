<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
 
// Include the syndicate functions only once
require_once( dirname(__FILE__).DS.'helper.php' );
 
$url = modBusquedaTagsHelper::accionForm();

require( JModuleHelper::getLayoutPath( 'mod_busqueda_tags' ) );
?>
