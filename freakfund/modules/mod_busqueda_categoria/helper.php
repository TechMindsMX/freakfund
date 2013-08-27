<?php 

include_once 'libraries/trama/class.php';

class modCategoriasHelper
{
    public static function getCategoria( $params ) {
    	$categoria = JTrama::getAllCatsPadre();
		
		return $categoria;
    }
    
    public static function getSubCat( $idPadre ) { 	
    	$subCategorias = JTrama::getAllSubCats();
		
		return $subCategorias;		
    }
}
?>

