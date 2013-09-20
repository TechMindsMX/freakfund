<?php 

jimport('trama.class');

class modProyectosHelper
{
	
    public static function closestEnd() {
    	$datosTmp = JTrama::getClosestEnd();

		if (!empty($datosTmp)) {
			foreach ($datosTmp as $key => $value) {
				$datos = modProyectosHelper::fundPercentage($value);
			}
		}
		else {
			$datos = '';
		}
		return $datos;
    }
    
    public static function profitables( $cantidad ) {
		$datosTmp = JTrama::getMostProfitables();
		
		if (!empty($datosTmp)) {
			$datos = array_splice($datosTmp, 0, $cantidad);
		}
		else {
			$datos = '';
		}
		return $datos;
		
    }

    public static function fundPercentage( $datos ) {
		$datos = JTrama::fundPercentage($datos);

		return $datos;
    }
    
}
?>

