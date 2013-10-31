<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
 
// Include the syndicate functions only once
require_once( dirname(__FILE__).DS.'helper.php' );
 
$categoria = modCategoriasHelper::getCategoria( $params );
$subCategorias = modCategoriasHelper::getSubCat( 'all' );
$status = '5';
require( JModuleHelper::getLayoutPath( 'mod_busqueda_cat_proy' ) );
?>
