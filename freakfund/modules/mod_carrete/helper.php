<?php 

jimport('trama.class');

class modCarreteHelper
{
	public static function closestEnd() {
		$obj->validStatus = isset($obj->validStatus) ? $obj->validStatus : array(5);
		$obj->viewAllUrl = base64_encode('index.php?option=com_jumi&view=application&fileid=8&status='.implode(",",$obj->validStatus).'&categoria=all');
    	$obj->items = JTrama::getClosestEnd();

		if (!empty($obj->items)) {
			foreach ($obj->items as $key => $value) {
				JTrama::dateDiff ($value->fundEndDate, $value);
				$datos[] = JTrama::fundPercentage($value);
			}
			$obj->items = modCarreteHelper::getCatNames($datos);
		}
		else {
			$obj->items[] = '';
		}
		return $obj;
    }
    
    public static function profitables( $cantidad ) {
		$obj->validStatus = array(6,7,8,10,11);
		$obj->viewAllUrl = 'index.php?option=com_jumi&view=application&fileid=8&status='.implode(",",$obj->validStatus).'&categoria=all';
		$obj->items = JTrama::getMostProfitables();
		
		if (!empty($obj->items)) {
			foreach ($obj->items as $key => $value) {
				if (in_array($value->status, $obj->validStatus)) {
					$dataFilterStatus[] = $value;
				}
				$value = JTrama::dateDiff ($value->fundEndDate, $value);
			}
			$obj->items = @array_splice($dataFilterStatus, 0, $cantidad);
			$obj->items = @modCarreteHelper::getCatNames($obj->items);
		}
		else {
			$obj->items = '';
		}
		return $obj;
		
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

