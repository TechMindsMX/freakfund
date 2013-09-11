<?php 

jimport('trama.class');

class modProyectosHelper
{
    public static function closestEnd() {
    	$datos = JTrama::getClosestEnd();
		
		foreach ($datos as $key => $value) {
			$value = modProyectosHelper::fundPercentage($value);
		}
	
		return $datos;
    }
    
    public static function fundPercentage( $datos ) {
		$datos = JTrama::fundPercentage($datos);

		return $datos;
    }
    
    public static function profitables() {
		$datos = JTrama::getMostProfitables();

		return $datos;
    }

}
?>

