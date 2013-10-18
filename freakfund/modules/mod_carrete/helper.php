<?php 

jimport('trama.class');

class modCarreteHelper
{
    public static function latestProductsByROI( $cantidad ) {
		$datosTmp = JTrama::allProjects();

		$datos = array_splice($datosTmp, 0, $cantidad);
		$datos = modCarreteHelper::getCatNames($datos);
	}

	public static function closestEnd() {
    	$datosTmp = JTrama::getClosestEnd();
		if (!empty($datosTmp)) {
			foreach ($datosTmp as $key => $value) {
				$datos[] = JTrama::fundPercentage($value);
				$value = JTrama::dateDiff ($value->fundEndDate, $value);
			}
			$datos = modCarreteHelper::getCatNames($datos);
		}
		else {
			$datos[] = '';
		}
		return $datos;
    }
    
    public static function profitables( $cantidad ) {
		$datosTmp = JTrama::getMostProfitables();
		
		if (!empty($datosTmp)) {
			foreach ($datosTmp as $key => $value) {
				$status = array(0,5,6,7,8,9,10,11); 
				if (in_array($value->status, $status)) {
					$dataFilterStatus[] = $value;
				}
			}
			$datos = array_splice($dataFilterStatus, 0, $cantidad);
			$datos = modCarreteHelper::getCatNames($datos);
		}
		else {
			$datos = '';
		}
		return $datos;
		
    }

	public static function getCatNames( $datos ) {
		foreach ($datos as $key => $value) {
			$value->categoryName = JTrama::getCatName($value->subcategory);
			$value->subcategoryName = JTrama::getSubCatName($value->subcategory);
			JTrama::getTRI($value);
			JTrama::getTRF($value);
		}
		
		return $datos;
    }
	public static function activePro ( $datos ) {
		foreach ($datos as $key => $value) {
		}
		return $datos;
	}

}
?>

