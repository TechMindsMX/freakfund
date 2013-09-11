<?php 

jimport('trama.class');

class modCarreteHelper
{

    public static function latestProductsByROI( $cantidad ) {
		$datosTmp = JTrama::allProjects();

		$datos = array_splice($datosTmp, 0, $cantidad);
		
		foreach ($datos as $key => $value) {
			$value->categoryName = JTrama::getCatName($value->subcategory);
			$value->subcategoryName = JTrama::getSubCatName($value->subcategory);
			JTrama::getTRI($value);
			JTrama::getTRF($value);
		}
		
		return $datos;
    }

}
?>

