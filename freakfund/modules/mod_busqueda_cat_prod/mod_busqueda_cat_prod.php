<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
 
// Include the syndicate functions only once
require_once( dirname(__FILE__).DS.'helper.php' );
 
$categoria = modCategoriasProductHelper::getCategoria( $params );
$subCategorias = modCategoriasProductHelper::getSubCat( 'all' );
$status = '6,7';
require( JModuleHelper::getLayoutPath( 'mod_busqueda_cat_prod' ) );
?>
