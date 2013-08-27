<?php
defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );
/**
 * 
 */
class claseTraerDatos 
{	
	public static function getDatos ( $tipo, $id ) {
		
		if( isset($id) ) {	
			$url = MIDDLE.PUERTO.'/trama-middleware/rest/project/get/'.$id;
			$json = file_get_contents($url);
			$jsonDecode = json_decode($json); 
			
			$respuesta = $jsonDecode;
		} else {
				
			$respuesta = null;
		}

		return $respuesta;
	}
	
	public static function token(){
		
		$url = MIDDLE.':7171/trama-middleware/rest/security/getKey';
		$token = file_get_contents($url);
		
		return $token;
	}
}

?>