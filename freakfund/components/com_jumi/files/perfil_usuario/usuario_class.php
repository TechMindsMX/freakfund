<?php 

class UserData {
	
	public function __construct() {
		$this->actualInvestments = 0;
	}
	
	public static function datosGr ($userid) {
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query2 = $db->getQuery(true);
		
		$query
			->select('*')
			->from('perfil_persona')
			->where('users_id = '.$userid.' && perfil_tipoContacto_idtipoContacto = 1');
			
		$db->setQuery( $query );
	
		$temporal = $db->loadObjectList();
		
		$query2->select ('avg(rating) as score')
			->from ('perfil_rating_usuario')
			->where('idUserCalificado = '.$userid);

		$db->setQuery( $query2 );
		$score = $db->loadObject();		
		
		$promedio = is_null($score->score)? 0 : $score->score; 
		
		if(empty($temporal)){
			$resultado = null;
		}else{
			$resultado = $temporal[0];
			$resultado->score = $promedio;
		}
				
		return $resultado;
	}
	
	public static function respuestasPerfilx ($campo,$userid){
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		$query
		->select($campo)
		->from("perfilx_respuestas")
		->where("users_id=".$userid);
		
		$db->setQuery( $query );
	
		$resultado = $db->loadObjectList();
	
		return $resultado;
	}
	
	public function etiquetas ($tabla,$campo,$userid){
		
		$respuestas = $this::respuestasPerfilx($campo, $userid);
		if (!empty($respuestas)){
			$arrayRespuesta = explode(',', $respuestas[0]->$campo);
		}else{
			$arrayRespuesta = "";
		}

		return $arrayRespuesta;
	}
	
	public function generacampos ($idPadre, $tabla, $columnaId, $columnaIdPadre, $descripcion, $campo, $userid) {
		$respuestas = $this->etiquetas($tabla,$campo, $userid);
		$db = JFactory::getDbo();
		$query = $db->getQuery(true); 
		
		$query->select ('*')
		->from ($tabla)
		->where($columnaIdPadre.' = '.$idPadre )
		->order ($descripcion.' ASC');
		
		$db->setQuery($query);
		$results = $db->loadObjectList();
		if(!empty($respuestas)){
		if (!empty($results)) { 
			echo "<ul>";
		}
		
		foreach ($results as $columna) {
			foreach ($respuestas as $key) {
				if($key == $columna->$columnaId) {
					$inputPadre = '<li>';
					$inputPadre .= '<span>'.$columna->$descripcion.'</span>';
					
					echo $inputPadre;
					$this->generacampos($columna->$columnaId,$tabla, $columnaId, $columnaIdPadre, $descripcion, $campo, $userid);
				
				}
			}
		}
		
		if (!empty($results)) {
			echo "</ul>";
		}
		}
	}
	
	public function scoreUser ($userid) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true); 
		
		$query->select ('avg(rating) as score')
		->from ('perfil_rating_usuario')
		->where('idUserCalificado = '.$userid);
		
		$db->setQuery($query);
		$results = $db->loadObjectList();
		
		return $results[0];
	}

	public function getUserBalance ( $userid ) {
		if( isset($userid) ) {
			$url = MIDDLE.PUERTO.'/trama-middleware/rest/user/get/'.$userid;
			$json = @file_get_contents($url);
			$respuesta = json_decode($json);
				
		} else {
	
			$respuesta = null;
		}
	
		return $respuesta;
	}
	
	public static function getUserMiddlewareId($userId) {
		$db = JFactory::getDBO();
		
		$query = $db->getQuery(true);
		$query->select('idJoomla, idMiddleware');
		$query->from($db->quoteName('#__users_middleware'));
		$query->where('idJoomla = '.$userId);
		
		$db->setQuery( $query );
		$id = $db->loadObject();
		
		return $id;
	}
}

?>