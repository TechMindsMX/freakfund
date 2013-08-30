<?php 

jimport('trama.class');

class modCategoriasProductHelper
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

