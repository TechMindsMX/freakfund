<?php 

jimport('trama.class');

class modCarreteHelper
{
	public static function closestEnd( $cantidad, $tipoDePro ) {
		$obj->validStatus = isset($obj->validStatus) ? $obj->validStatus : array(5);
		$obj->viewAllUrl = 'index.php?option=com_jumi&view=application&fileid=8&status='.implode(",",$obj->validStatus).'&categoria=all';
		$result = JTrama::getClosestEnd();

		self::masDatos($obj, $result, $cantidad, $tipoDePro);

		return $obj;
    }
    
    public static function profitables( $cantidad, $tipoDePro ) {
		$obj->validStatus = isset($obj->validStatus) ? $obj->validStatus : array(6,7,8);
		$obj->viewAllUrl = 'index.php?option=com_jumi&view=application&fileid=8&status='.implode(",",$obj->validStatus).'&categoria=all';
		$result = JTrama::getMostProfitables();
		
		self::masDatos($obj, $result, $cantidad, $tipoDePro);
		
		return $obj;
	}
	
	public static function masDatos($obj, $result, $cantidad, $tipoDePro) {
		if (!is_array($result) && count($result) == 1) {
			$obj->items[] = $result;
		} else {
			$obj->items = $result;
		}
		if (!empty($obj->items)) {
			foreach ($obj->items as $key => $value) {
				if (in_array($value->status, $obj->validStatus)) {
					$longitudName = 36;
					$value->name = (strlen($value->name) > $longitudName) ? substr($value->name, 0, $longitudName)."..." : $value->name;
					$dataFilterStatus[] = $value;
				}
				if ($tipoDePro == 'cerrar') {
					$value->dateDiff = JTrama::dateDiff ($value->fundEndDate);
					JTrama::fundPercentage($value);
				}
			}
			$obj->items = @array_splice($dataFilterStatus, 0, $cantidad);
			$obj->items = @modCarreteHelper::getCatNames($obj->items);
		}
		return $obj;
    }

	public static function getCatNames( $datos ) {
		foreach ($datos as $key => $value) {
			$value->categoryName = JTrama::getCatName($value->subcategory);
			$value->subcategoryName = JTrama::getSubCatName($value->subcategory);
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

