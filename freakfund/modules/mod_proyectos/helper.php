<?php 

jimport('trama.class');

class modProyectosHelper
{
    public static function getClosestEnd() {
    	$datos = JTrama::getProdClosestEnd();
		
		return $datos;
    }
    public static function getFundPercentage( $datos ) {
		$datos = JTrama::fundPercentage($datos);

		return $datos;
    }

}
?>

